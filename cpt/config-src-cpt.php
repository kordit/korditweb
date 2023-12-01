<?php
$re = '/wp_posts\.post_type = \'([^\']*)\'/m';
$str = $wp_query->request;
preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
$source_cpt = $matches[0][1];

if (is_search()) {
	$search_query = get_query_var('s');
	$get_src_taxonomy = get_template_directory() . '/cpt/cpt-templates/' . $source_cpt . '/search';
	$post_template_src = '/cpt/cpt-templates/' . $source_cpt . '/search/post-template.php';
	add_css_theme('search-' . $source_cpt, '/cpt/cpt-templates/' . $source_cpt . '/search/style.css');
	add_js_theme('search-' . $source_cpt, '/cpt/cpt-templates/' . $source_cpt . '/search/script.js');
} elseif (is_object(get_queried_object()) && property_exists(get_queried_object(), 'taxonomy') && taxonomy_exists(get_queried_object()->taxonomy)) {
	$term = get_queried_object();
	$term_name = $term->slug;
	$tax_name = $term->taxonomy;
	$archive_name = $tax_name;
	$get_src_taxonomy = get_template_directory() . '/cpt/cpt-templates/' . $source_cpt . '/tax-' . $tax_name;
	$post_template_src = '/cpt/cpt-templates/' . $source_cpt . '/tax-' . $tax_name . '/post-template.php';
	add_css_theme('main-' . $tax_name, '/cpt/cpt-templates/' . $source_cpt . '/tax-' . $tax_name . '/style.css');
	add_js_theme('main-' . $tax_name, '/cpt/cpt-templates/' . $source_cpt . '/tax-' . $tax_name . '/script.js');
} elseif (is_home()) {
	$archive_name = 'blog';
	$get_src_taxonomy = get_template_directory() . '/cpt/cpt-templates/post/main';
	$post_template_src = '/cpt/cpt-templates/' . $source_cpt . '/main/post-template.php';
	add_css_theme('main-' . $source_cpt, '/cpt/cpt-templates/' . $source_cpt . '/main/style.css');
	add_js_theme('main-' . $source_cpt, '/cpt/cpt-templates/' . $source_cpt . '/main/script.js');
} elseif (is_archive()) {
	$term = get_queried_object();
	$term_name = $term->name;
	$archive_name = $source_cpt;
	$get_src_taxonomy = get_template_directory() . '/cpt/cpt-templates/' . $source_cpt . '/main';
	$post_template_src = '/cpt/cpt-templates/' . $source_cpt . '/main/post-template.php';
	add_css_theme('main-' . $source_cpt, '/cpt/cpt-templates/' . $source_cpt . '/main/style.css');
	add_js_theme('main-' . $source_cpt, '/cpt/cpt-templates/' . $source_cpt . '/main/script.js');
} elseif (is_single()) {
	$post_type = get_post_type($post->ID);
	add_css_theme('single-' . $post_type, '/cpt/cpt-templates/' . $source_cpt . '/single/style.css');
	add_js_theme('single-' . $post_type, '/cpt/cpt-templates/' . $source_cpt . '/single/script.js');
}
