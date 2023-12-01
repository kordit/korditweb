<?php
if (class_exists('ACF')) {
  get_template_part('/assets/includes/register_functions');
  get_template_part('/assets/includes/register_block');
  get_template_part('/assets/includes/security');
  get_template_part('/assets/includes/functions');
  get_template_part('/assets/includes/support');
  get_template_part('/assets/includes/register');
  get_template_part('/assets/includes/cpt');
  get_template_part('/assets/includes/widget');
} else {
  echo '<div class="popup-admin-panel" id="popup-admin-panel"><div onclick="removeerdiv("#popup-admin-panel")" class="popup-admin-panel-close" id="popup-admin-panel-close">x</div><div class="title">Zainstaluj ACF PRO</div></div>';
}

add_action('admin_notices', 'general_admin_notice');

include('assets/library/functions.php');

if (is_admin()) {
  get_template_part('/assets/includes/admin');
}

get_template_part('/assets/includes/optimize');

function theme_enqueue_scripts()
{
  if (!is_admin()) {
    include('assets/library/active.php');
  }
  wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('global', get_template_directory_uri() . '/assets/css/global.css');
  if (get_field('select_header', 'option') == 'basic') {
    wp_enqueue_style('header', get_template_directory_uri() . '/templates/header/scss/style.css');
  } elseif (get_field('select_header', 'option') == 'cascade') {
    wp_enqueue_style('header', get_template_directory_uri() . '/templates/header-cascade/scss/style.css');
  }
  wp_enqueue_style('footer', get_template_directory_uri() . '/templates/footer/scss/style.css');
  wp_enqueue_style('theme-style', get_template_directory_uri() . '/theme-style.css');
  wp_enqueue_script('global', get_template_directory_uri() . '/assets/js/global.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

/* Dodanie globalnych plików styli w edytorze */
if (is_admin()) {
  add_action('enqueue_block_editor_assets', function () {
    include('assets/library/active.php');

    /* Dodanie kolorów z theme settings oraz załadowanie czcionek */
    function my_colors_and_fonts()
    {
      echo '<style>';
      include('templates/header/config.php');
      include 'assets/fonts/fonts.css';
      echo '</style>';
    }
    add_action('admin_head', 'my_colors_and_fonts');

    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/theme-style.css');
  });
}

/* Usunięcie reset styli z panelu admina, 
/* przez co zachowujemy odpowiednie wartości 
/* css dla nagłówków(font-size, margin, color, line-height, font-weight)*/
add_action('enqueue_block_editor_assets', function () {
  wp_enqueue_script('gutenberg.js', get_template_directory_uri() . '/assets/js/gutenberg.js', ['wp-blocks'], null, true);
});

/* Rewrite oddzielający cpt w widoku pojedynczego 
terma taksonomii przypisanej do min. 2 cpt. 
Przykład: /cpt/taksonomia/term/
*/
function et_rewrite_rules()
{
  $post_types = get_post_types();
  $taxonomies = get_taxonomies();

  foreach ($post_types as $post_type) {
    foreach ($taxonomies as $taxonomy) {
      if (!taxonomy_exists($taxonomy, $post_type)) {
        continue;
      }

      add_rewrite_rule(
        '^' . $post_type . '/' . $taxonomy . '/([^/]+)/?$',
        'index.php?taxonomy=' . $taxonomy . '&post_type=' . $post_type . '&term=$matches[1]',
        'top'
      );

      add_rewrite_rule(
        '^' . $post_type . '/' . $taxonomy . '/([^/]+)/page/([0-9]+)?$',
        'index.php?post_type=' . $post_type . '&' . $taxonomy . '=$matches[1]&paged=$matches[2]',
        'top'
      );
    }
  }
}

add_action('init', 'et_rewrite_rules', 10, 0);

/* Kod zmieniający url termów taksonomii w panelu admina.
Teraz po wyświetleniu danego termu z poziomu panelu admina,
link do tego termu będzie wyglądał tak: /cpt/taksonomia/term/
gdzie cpt to post type z ktorego zostal wybrany term
*/
function et_term_link($term_link, $term, $taxonomy)
{
  if (!is_admin()) {
    return $term_link;
  }

  $post_type = get_current_screen()->post_type;
  return home_url($post_type . '/' . $taxonomy . '/' . $term->slug);
}
add_filter('term_link', 'et_term_link', 10, 3);
add_filter('wpcf7_autop_or_not', '__return_false');

function acf_orphans($value, $post_id, $field) {
  if ( class_exists( 'iworks_orphan' ) ) {
    $orphan = new \iworks_orphan();
    $value = $orphan->replace( $value );
  }
  return $value;
}
add_filter('acf/format_value/type=textarea', 'acf_orphans', 10, 3);
add_filter('acf/format_value/type=wysiwyg', 'acf_orphans', 10, 3);
add_filter('acf/format_value/type=text', 'acf_orphans', 10, 3);