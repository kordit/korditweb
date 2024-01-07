<?php
$args = array(
    'post_type' => 'cpt2',
    'posts_per_page' => -1,
);

$moj_cpt_query = new WP_Query($args);

if ($moj_cpt_query->have_posts()) :
    while ($moj_cpt_query->have_posts()) : $moj_cpt_query->the_post();
        // Pobieranie danych ACF dla bieżącego posta
        $fields = get_fields(get_the_ID());
        if ($fields) {
            acf_setup_meta($fields, get_the_ID(), true);
        }

        the_post_thumbnail();
        the_title();
?>
        <div class="blok-cpt--cena">
            <?= get_field('cena'); ?>
        </div>
        <?php et_image('grafika', 'full', false, 'blok-cpt--grafika'); ?>
        <div class="btn-wrapper">
            <?php et_link('link', 'blok-cpt--link'); ?>
        </div>
<?php
        // Resetowanie danych ACF po użyciu
        acf_reset_meta(get_the_ID());

    endwhile;
    wp_reset_postdata();
else :
    echo 'Nie znaleziono postów.';
endif;
?>