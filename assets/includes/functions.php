<?php

/////////////////////////////////////
///////   CORE FUNCTIONS   //////////
/////////////////////////////////////

function et_bg($et_image_setter, $et_opacity_setter)
{
	if ($et_image_setter) {
		echo 'style="background-image:url(' . $et_image_setter . ');opacity:' . $et_opacity_setter . '"';
	} else {
	}
}

function et_site_url()
{
	if (function_exists('pll_the_languages')) {
		$url = pll_home_url();
	} else {
		$url = get_home_url();
	}
	return $url;
}

function et_thumbnail($thumbnail_id, $size)
{
	if (get_the_post_thumbnail($thumbnail_id, $size)) {
		the_post_thumbnail($thumbnail_id, $size);
	} else {
		if (wp_get_attachment_image($thumbnail_id, $size)) {
			echo wp_get_attachment_image($thumbnail_id, $size);
		} elseif (get_field('domyslny_placeholder', 'options')) {
			echo wp_get_attachment_image(get_field('domyslny_placeholder', 'options'), $size);
		} else {
			echo '<img width="800px" height="600px" class="img-fluid" src="' . get_stylesheet_directory_uri() . '/assets/img/placeholder.png">';
		}
	}
}

function et_link($link, $class = "", $title = "")
{
	if (get_field($link) || get_sub_field($link) || get_sub_field($link, "options") || get_field($link, "options")) {
		if (get_field($link)) {
			$button = get_field($link);
		} elseif (get_sub_field($link)) {
			$button = get_sub_field($link);
		} elseif (get_sub_field($link, "options")) {
			$button = get_field($link, "options");
		} elseif (get_field($link, "options")) {
			$button = get_field($link, "options");
		}

		if ($button['target'] == "_blank") {
			$blank = 'target="_blank"';
		} else {
			$blank = " ";
		}
		if ($class) {
			$classname = ' class="' . $class . '"';
		} else {
			$classname = "";
		}
		$title = 'title="' . $title . '" ';
		echo '<a ' . $title . ' ' . $blank . $classname . ' href="' . $button["url"] . '">' . $button["title"] . '</a>';
	}
}

function et_lottie($json, $x, $type)
{
	et_lib_lottie(true);
	if ($json) {
		echo '<div id="json_image' . $x . '"></div>';
		$container_lottie = '#json_image' . $x;
?>
		<script type="text/javascript">
			var logsEnabled = true

			function waitFor(namespace, timeout, callback, interval) {
				var defaultInterval = interval >= 0 ? interval : 100;
				if (window[namespace]) {
					callback();
				} else if (timeout <= 0) {
					return;
				} else {
					setTimeout(function() {
						waitFor(namespace, timeout - defaultInterval, callback, interval);
					}, defaultInterval);
				}
			}
			waitFor('et_lottie', 1000 * 60, function() {
				var type_lottie = '<?php echo $type; ?>';
				var container_lottie = document.querySelector('<?php echo $container_lottie; ?>');
				var x_lottie = <?php echo $x; ?>;
				var path_lottie = '<?php echo $json; ?>';
				var icon_lottie = 'iconMenu' + x_lottie;
				et_lottie(container_lottie, x_lottie, path_lottie, icon_lottie, type_lottie);
			})
		</script>
<?php }
}

function et_theme_pagination_query($post_query)
{
	echo paginate_links(array(
		'base' => str_replace(999999999, '%#%', get_pagenum_link(999999999)),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $post_query->max_num_pages
	));
}

function et_svg($linksvg, $type = 0)
{
	if ($type == 1) {
		$link = $linksvg;
	} elseif ($type == 2) {
		$link = get_site_url() . $linksvg;
	} else {
		$link = $linksvg;
	}
	$link = preg_replace('/https?\:\/\/[^\/]*\//', '', $link);
	if (file_exists($link)) {
		$svg_file = file_get_contents($link);
		$find_string = "<svg";
		$position = strpos($svg_file, $find_string);
		$svg_file_new = substr($svg_file, $position);
		echo $svg_file_new;
	} else {
		if (is_admin()) {
			$link = "/" . $link;
			if (file_exists($_SERVER['DOCUMENT_ROOT'] . $link)) {
				$svg_file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $link);
				$find_string = "<svg";
				$position = strpos($svg_file, $find_string);
				$svg_file_new = substr($svg_file, $position);
				echo $svg_file_new;
			}
		} else {
			echo "plik nie istnieje!";
		}
	}
}

function et_get_svg($linksvg, $type = 0)
{
	if ($type == 1) {
		$link = $linksvg;
	} elseif ($type == 2) {
		$link = get_site_url() . $linksvg;
	} else {
		$link = $linksvg;
	}
	$link = preg_replace('/https?\:\/\/[^\/]*\//', '', $link);
	if (file_exists($link)) {
		$svg_file = file_get_contents($link);
		$find_string = "<svg";
		$position = strpos($svg_file, $find_string);
		$svg_file_new = substr($svg_file, $position);
		return $svg_file_new;
	} else {
		if (is_admin()) {
			$link = "/" . $link;
			if (file_exists($_SERVER['DOCUMENT_ROOT'] . $link)) {
				$svg_file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $link);
				$find_string = "<svg";
				$position = strpos($svg_file, $find_string);
				$svg_file_new = substr($svg_file, $position);
				return $svg_file_new;
			}
		} else {
			return "plik nie istnieje!";
		}
	}
}

function et_image($acffield, $size = "full", $url = false, $class = '')
{

	if (get_sub_field($acffield)) {
		$typeacf = get_sub_field($acffield);
	} elseif (get_field($acffield)) {
		$typeacf = get_field($acffield);
	} elseif (get_sub_field($acffield, "options")) {
		$typeacf = get_sub_field($acffield, "options");
	} elseif (get_field($acffield, "options")) {
		$typeacf = get_field($acffield, "options");
	} else {
		$webimage = NULL;
	}
	if (is_array($typeacf)) {
		$typeacf = $typeacf['ID'];
	}
	$webimage = wp_get_attachment_image_url($typeacf, $size);

	if ($url == true) {
		return $webimage;
	} else {
		$pieces = explode("/", $webimage);
		$pathend = end($pieces);
		$newstring = substr($pathend, -3);
		$newstring4 = substr($pathend, -4);
		if ($newstring == 'jpg' || $newstring == 'png' || $newstring4 == 'jpeg' || $newstring4 == 'webp') {
			echo wp_get_attachment_image($typeacf, $size, false, array("class" => $class));
		} elseif ($newstring == 'svg') {
			$webimage = preg_replace('/https?\:\/\/[^\/]*\//', '', $webimage);
			echo et_get_svg($webimage);
		} else {
			echo "Nieprawidłowy format pliku";
		}
	}
}

function et_get_image($acffield, $size = "full", $url = false)
{
	if (get_sub_field($acffield)) {
		$typeacf = get_sub_field($acffield);
		$webimage = wp_get_attachment_image_url($typeacf, $size);
	} elseif (get_field($acffield)) {
		$typeacf = get_field($acffield);
		$webimage = wp_get_attachment_image_url($typeacf, $size);
	} elseif (get_sub_field($acffield, "options")) {
		$typeacf = get_sub_field($acffield, "options");
		$webimage = wp_get_attachment_image_url($typeacf, $size);
	} elseif (get_field($acffield, "options")) {
		$typeacf = get_field($acffield, "options");
		$webimage = wp_get_attachment_image_url($typeacf, $size);
	} else {
		$webimage = NULL;
	}

	if ($url == true) {
		return $webimage;
	} else {
		$pieces = explode("/", $webimage);
		$pathend = end($pieces);
		$newstring = substr($pathend, -3);
		$newstring4 = substr($pathend, -4);
		if ($newstring == 'jpg' || $newstring == 'png' || $newstring4 == 'jpeg' || $newstring4 == 'webp') {
			return wp_get_attachment_image($typeacf, $size);
		} elseif ($newstring == 'svg') {
			return et_get_svg($webimage);
		} else {
			return "Nieprawidłowy format pliku";
		}
	}
}

function et_the_logo($width = "350px", $height = "100px", $class = "header")
{
	$custom_logo_id = get_theme_mod('custom_logo');
	$logo = wp_get_attachment_image_src($custom_logo_id, 'small-logo');
	$logo = $logo[0];
	if (has_custom_logo()) {
		$pieces = explode("/", $logo);
		$pathend = end($pieces);
		$newstring = substr($pathend, -3);
		$newstring4 = substr($pathend, -4);
		if ($newstring == 'jpg' || $newstring == 'png' || $newstring4 == 'jpeg' || $newstring4 == 'webp') {
			echo '<img alt="logo" class="img-fluid" width="' . $width . '" height="' . $height . '" src="' . esc_url($logo) . '">';
		} elseif ($newstring == 'svg') {
			et_svg($logo);
			echo '
			<style>'
				. $class . ' .logo svg {
				width: ' . $width . ';
				height: auto;
			}
			</style>
			';
		} else {
			echo 'Nieprawidłowy format pliku';
		}
	} else {
		echo '<h1>' . get_bloginfo('name') . '</h1>';
		echo '<p>' . get_bloginfo('description') . '</p>';
	}
}

function et_form($id_form)
{
	$shortcut = '[contact-form-7 id="' . $id_form . '"]';
	return do_shortcode($shortcut);
}

function et_start_section($et_blockname, $srctemplate, $vars = [1], $et_id = '', $bg = '', $hex = '', $sectionid, $container = '')
{
	foreach ($vars as $var => $val) {
		$$var = $val;
	}
	if ($et_id) {
		$et_id = 'id="' . $et_id . '" ';
	} else {
		$et_id = "";
	}
	if ($hex) {
		$hex = 'style="background-color:' . $hex . ';"';
	} else {
		$hex = "";
	}
	if ($bg) {
		$bg = 'style="background-image:url(' . $bg . ');"';
	} else {
		$bg = "";
	}
	if (isset($block['className'])) {
		$additional_class = ' ';
		$additional_class .= $block['className'];
	} else {
		$additional_class = "";
	}
	echo '<section class="' . $et_blockname . '__' . $sectionid . ' ' . $et_blockname . $additional_class . '" ' . $et_id . '>';
	if ($bg || $hex) {
		echo '<div class="background-wrapper" ' . $bg . '><div ' . $hex . '></div>' .
			'</div>';
	}
	if (!empty($container)) {
		echo '<div class="' . $container . '">';
	}
	include($srctemplate);
	if (!empty($container)) {
		echo '</div>';
	}
	echo "</section>";
}

function et_r($var, $is_admin = false)
{
	if (!is_admin()) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	} else {
		if ($is_admin == true) {
			echo '<pre>';
			if ($var) {
				print_r($var);
			} else {
				echo 'Nie znaleziono wartości dla wskazanej zmiennej';
			}
			echo '</pre>';
		}
	}
}

function add_css_theme($name, $linkcss)
{
	return wp_enqueue_style($name, get_template_directory_uri() . $linkcss);
}

function add_js_theme($name, $linkjs)
{
	return wp_enqueue_script($name, get_template_directory_uri() . $linkjs, array(), '1.0.0', true);
}

function et_the_list_term($allterm, $current = NULL)
{
	$current_list = [];
	if ($current) {
		if (is_array($current)) {
			foreach ($current as $value) {
				$current_list[] = $value->slug;
			}
		} else {
			$current_list[] = $current->slug;
		}
	} else {
		$current_list = [];
	}
	echo '<ul>';
	foreach ($allterm as $value) {
		$name = $value->name;
		$slug = $value->slug;
		$term_id = $value->term_id;
		$link = get_term_link($term_id);
		if (in_array($slug, $current_list)) {
			$active = "active";
		} else {
			$active = "";
		}

		echo '<li class="' . $active . '">';
		echo '<a href="' . $link . '">' . $name . '</a>';
		echo '</li>';
	}
	echo '</ul>';
}

function et_get_cpt()
{
	$args = array(
		'public'   => true,
		'_builtin' => false,
	);
	$output = 'names';
	$operator = 'and';
	$array_global_cpt = [];
	$post_types = get_post_types($args, $output, $operator);
	$default_types = array('post' => 'post');
	$post_types = $post_types + $default_types;
	$array_post_type = [];
	foreach ($post_types as $post_type) {
		if ($post_type !== 'predefinition-cpt') {
			$array_post_type[$post_type] = $post_type;
		}
	}
	$array_post_type = array_reverse($array_post_type);
	return $array_post_type;
}

function et_load_more_button($attr)
{

	add_js_theme('et-alm', '/assets/js/et-ajax-load-more.js');

	$args = shortcode_atts(array(
		'offset' 			=> 0,
		'per_load' 			=> 3,
		'post_type' 		=> get_post_type(),
		'search' 			=> isset($GLOBALS["search_query"]) ? $GLOBALS["search_query"] : "",
		'taxonomy_name'		=> isset($GLOBALS["tax_name"]) ? $GLOBALS["tax_name"] : "",
		'taxonomy_field'	=> 'slug',
		'taxonomy_term'		=> isset($GLOBALS["term_name"]) ? $GLOBALS["term_name"] : "",
		'order' 			=> 'DESC',
		'orderby' 			=> 'date',
		'template_path' 	=> $GLOBALS["post_template_src"],
		'label_text' 		=> 'Load more',
		'loading_text' 		=> 'loading...',
		'button_class' 		=> 'btn-theme',
		'container_class' 	=> 'wrapper-posts',
	), $attr);

	$taxonomy = '';

	if ($args['taxonomy_name'] != '' && $args['taxonomy_field'] != '' && $args['taxonomy_term'] != '') {
		$taxonomy = array(
			'taxonomy'	=> $args['taxonomy_name'],
			'field'		=> $args['taxonomy_field'],
			'terms'		=> $args['taxonomy_term'],
		);
	}

	$query_args = array(
		'post_type'      	=> $args['post_type'],
		'posts_per_page' 	=> $args['per_load'],
		'offset'         	=> $args['offset'],
		's'              	=> $args['search'],
		'tax_query'			=> array($taxonomy),
	);

	$obj_name = new WP_Query($query_args);

	$output = '';
	$output .= '<div';
	$output .= ' data-allposts=' . $obj_name->found_posts . ' data-offset="' . $args['offset'] . '"';
	$output .= ' data-perload="' . $args['per_load'] . '" data-posttype="' . $args['post_type'] . '"';
	$output .= ' data-templatepath="' . $args['template_path'] . '" data-loadingtext="' . $args['loading_text'] . '"';
	$output .= ' data-labeltext="' . $args['label_text'] . '" data-order="' . $args['order'] . '"';
	$output .= ' data-search="' . $args['search'] . '" data-containerclass="' . $args['container_class'] . '"';
	$output .= ' data-orderby="' . $args['orderby'] . '" data-taxonomyname="' . $args['taxonomy_name'] . '"';
	$output .= ' data-taxonomyfield="' . $args['taxonomy_field'] . '" data-taxonomyterm="' . $args['taxonomy_term'] . '"';
	$output .= ' class="load-more-button ' . $args['button_class'] . '">' . $args['label_text'];
	$output .= '</div>';

	if (!file_exists(get_template_directory() . $args['template_path'])) {
		return "Nie podano ścieżki do post template bądź podany plik nie istnieje.";
	} elseif ($obj_name->found_posts > 0) {
		return $output;
	}
}

add_shortcode('et_load_more_button', 'et_load_more_button');

add_action('wp_ajax_et_load_more_posts', 'et_load_more_posts');
add_action('wp_ajax_nopriv_et_load_more_posts', 'et_load_more_posts');

function et_load_more_posts()
{

	if ($_POST['taxonomy_name'] != '' && $_POST['taxonomy_field'] != '' && $_POST['taxonomy_term'] != '') {
		$taxonomy = array(
			'taxonomy'	=> $_POST['taxonomy_name'],
			'field'		=> $_POST['taxonomy_field'],
			'terms'		=> $_POST['taxonomy_term'],
		);
	}

	$args = array(
		'post_type'      	=> 	array($_POST['post_type']),
		'posts_per_page' 	=> 	$_POST['per_load'],
		'offset'         	=> 	$_POST['offset'],
		's'             	=> 	$_POST['search'],
		'order'				=> 	$_POST['order'],
		'orderby'			=> 	$_POST['orderby'],
		'tax_query'			=> 	array($taxonomy),
	);

	$templatePath = preg_replace("/(.+)\.php$/", "$1", $_POST['template_path']);;

	query_posts($args);

	if (have_posts()) :

		while (have_posts()) : the_post();

			get_template_part($templatePath);

		endwhile;

	endif;

	die();
}
