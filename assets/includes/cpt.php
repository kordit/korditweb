<?php

function generate_cpt_files()
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
	foreach ($post_types as $single_cpt) {
		$src_dir_cpt = get_template_directory() . '/cpt/cpt-templates/' . $single_cpt;
		$src_dir_cpt_single = $src_dir_cpt . '/single';
		$src_dir_cpt_main = $src_dir_cpt . '/main';
		if (!file_exists($src_dir_cpt)) {
			/* main dir */
			mkdir($src_dir_cpt, 0755, true);
			mkdir($src_dir_cpt . '/single', 0755, true);
			mkdir($src_dir_cpt . '/main', 0755, true);
			mkdir($src_dir_cpt . '/search', 0755, true);

			include('file_configurator/cpt-loop.php');

			/* Create template */
			$template = fopen($src_dir_cpt . '/main/template.php', 'w');
			fwrite($template, $dataloop);
			fclose($template);

			/* Create post template */
			$templatepost = fopen($src_dir_cpt . '/main/post-template.php', 'w');
			fwrite($templatepost, $postloop);
			fclose($templatepost);

			/* Create scss template */
			$templatecss = fopen($src_dir_cpt . '/main/style.scss', 'w');
			fwrite($templatecss, "");
			fclose($templatecss);

			/* Create css template */
			$templatecss = fopen($src_dir_cpt . '/main/style.css', 'w');
			fwrite($templatecss, "");
			fclose($templatecss);

			/* Create script template */
			$templatejs = fopen($src_dir_cpt . '/main/script.js', 'w');
			fwrite($templatejs, "");
			fclose($templatejs);

			/* Create search template */
			$template = fopen($src_dir_cpt . '/search/template.php', 'w');
			fwrite($template, $searchloop);
			fclose($template);

			/* Create search post template */
			$templatepost = fopen($src_dir_cpt . '/search/post-template.php', 'w');
			fwrite($templatepost, $postloop);
			fclose($templatepost);

			/* Create search scss template */
			$templatecss = fopen($src_dir_cpt . '/search/style.scss', 'w');
			fwrite($templatecss, "");
			fclose($templatecss);

			/* Create search css template */
			$templatecss = fopen($src_dir_cpt . '/search/style.css', 'w');
			fwrite($templatecss, "");
			fclose($templatecss);

			/* Create search script template */
			$templatejs = fopen($src_dir_cpt . '/search/script.js', 'w');
			fwrite($templatejs, "");
			fclose($templatejs);
		}
		$taxonomies = get_object_taxonomies($single_cpt, 'objects');
		$stack_cpt[$single_cpt] = [];
		foreach ($taxonomies as $taxonomy) {
			$stack_cpt[$single_cpt][] = $taxonomy->name;
			$taxonomiesurl = $src_dir_cpt . '/tax-' . $taxonomy->name;
			include('file_configurator/cpt-loop.php');
			$contenttaxonomies = '';
			$contenttaxonomies .= $taxonomiesurl;
			$contenttaxonomies .= $dataloop;
			if (!file_exists($taxonomiesurl) && $taxonomy->name != 'post_format') {
				mkdir($src_dir_cpt . '/tax-' . $taxonomy->name, 0755, true);
				$taxtemplate = fopen($taxonomiesurl . '/template.php', 'w');
				fwrite($taxtemplate, $contenttaxonomies);
				fclose($taxtemplate);

				$taxtemplatepost = fopen($taxonomiesurl . '/post-template.php', 'w');
				fwrite($taxtemplatepost, $postloop);
				fclose($taxtemplatepost);

				$taxscss = fopen($src_dir_cpt . '/tax-' . $taxonomy->name . '/style.scss', 'w');
				fwrite($taxscss, "");
				fclose($taxscss);

				$taxcss = fopen($src_dir_cpt . '/tax-' . $taxonomy->name . '/style.css', 'w');
				fwrite($taxcss, "");
				fclose($taxcss);

				$taxjs = fopen($src_dir_cpt . '/tax-' . $taxonomy->name . '/script.js', 'w');
				fwrite($taxjs, "");
				fclose($taxjs);
			}
		}
	}
	$myargs = array(
		'post_type' => 'acf-field-group',
		'post_status' => array('publish'),
		'posts_per_page' => -1
	);
	$typeacf = new WP_Query($myargs);
	$alltypecpt = $typeacf->posts;
	$acf_cpt = [];
	foreach ($alltypecpt as $single_json_acf) {
		$unserialized = unserialize($single_json_acf->post_content);
		$param = $unserialized['location'][0][0]['param'];
		$namecpt = $unserialized['location'][0][0]['value'];
		if (in_array($namecpt, $post_types)) {
			if ($param == 'post_type') {
				$acf_cpt[] = $namecpt;
				$singleJSON = $single_json_acf->post_name;
				$slug = $single_json_acf->post_excerpt;
				$urlJSON = get_template_directory() . '/acf-json/' . $singleJSON . '.json';
				$contentJSON = json_decode(file_get_contents($urlJSON), true);
				$type_field = '';
				$css = '';
				$fields = $contentJSON['fields'];
				$all_code_js = '';
				foreach ($fields as $single_acf) {
					$type_field .= et_get_fields_acf($single_acf, 1, $slug);
					if (return_all_repeater($single_acf)) {
						$all_js = return_all_repeater($single_acf);
						foreach ($all_js as $single_js) {
							$name = $single_js['name'];
							$type = $single_js['type'];
							$all_code_js .= et_get_fields_js($type, 'splide_' . $name);
							$active_library = ['namelibrary' => $name, 'type' => $type];
						}
					} else {
						$active_library['namelibrary'] = false;
					}
				}
				$srctemplate = get_template_directory() . '/cpt/cpt-templates/' . $namecpt . '/single/';
				$srccss = $srctemplate . 'style.scss';
				$srcss = $srctemplate . 'style.css';
				$srcjs = $srctemplate . 'script.js';
				$single_name_cpt = $namecpt;
				include('file_configurator/default-single.php');
				if (!file_exists($srctemplate . 'template.php')) {
					$datatemplate = $singletemplate;
					$datatemplate .= $type_field;
					$template = fopen($srctemplate . 'template.php', 'w');
					fwrite($template, $datatemplate);
					fclose($template);
				}
				if (!file_exists($srctemplate . 'config.php')) {
					$templateconfig = fopen($srctemplate . 'config.php', 'w');
					if ($active_library['namelibrary'] == true) {
						$singletemplateconfig .= '<?php et_lib_splide(true); ?>';
					}
					fwrite($templateconfig, $singletemplateconfig);
					fclose($templateconfig);
				}
				if (!file_exists($srccss)) {
					$templatecss = fopen($srccss, 'w');
					fwrite($templatecss, $css);
					fclose($templatecss);
				}
				if (!file_exists($srcss)) {
					$templatecss = fopen($srcss, 'w');
					fwrite($templatecss, $css);
					fclose($templatecss);
				}
				if (!file_exists($srcjs)) {
					$templatecjs = fopen($srcjs, 'w');
					fwrite($templatecjs, $all_code_js);
					fclose($templatecjs);
				}
			}
		}
	}
	$not_acf = array_diff($post_types, $acf_cpt);
	if (!empty($not_acf)) {
		foreach ($not_acf as $single_name_cpt) {
			include('file_configurator/default-single.php');
			$srctemplate = get_template_directory() . '/cpt/cpt-templates/' . $single_name_cpt . '/single/';
			$srccss = $srctemplate . 'style.scss';
			$srcss = $srctemplate . 'style.css';
			$srcjs = $srctemplate . 'script.js';
			$all_code_js = '';
			$css = '';
			if (!file_exists($srctemplate . 'template.php')) {
				include('file_configurator/default-single.php');
				$template = fopen($srctemplate . 'template.php', 'w');
				fwrite($template, $singletemplate);
				fclose($template);
			}
			if (!file_exists($srctemplate . 'config.php')) {
				$templateconfig = fopen($srctemplate . 'config.php', 'w');
				fwrite($templateconfig, $singletemplateconfig);
				fclose($templateconfig);
			}
			if (!file_exists($srccss)) {
				$templatecss = fopen($srccss, 'w');
				fwrite($templatecss, $css);
				fclose($templatecss);
			}
			if (!file_exists($srcss)) {
				$templatecss = fopen($srcss, 'w');
				fwrite($templatecss, $css);
				fclose($templatecss);
			}
			if (!file_exists($srcjs)) {
				$templatecjs = fopen($srcjs, 'w');
				fwrite($templatecjs, $all_code_js);
				fclose($templatecjs);
			}
		}
	}
}

add_action('init', 'generate_cpt_files');

function create_posttype()
{
	$singular = 'predefinition-cpt';
	register_post_type(
		$singular,
		array(
			'labels' => array(
				'name' => __('Szablony CPT'),
				'singular_name' => __($singular)
			),
			'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields',),
			'hierarchical'        => false,
			'public'              => true,
			'publicly_queryable' 	=> true,
			'query_var' 					=> true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_icon'   				=> 'dashicons-welcome-view-site',
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'rewrite' => array('slug' => $singular, 'with_front' => true),
			'show_in_rest' => true
		)
	);
}
// add_action('init', 'create_posttype');

function creat_post_theme_cpt()
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
	foreach ($post_types as $value) {
		$new = array(
			'post_title' => $value . "-szablon",
			'post_status' => 'publish',
			'post_type' => 'predefinition-cpt'
		);
		if (!function_exists('post_exists')) {
			require_once(ABSPATH . 'wp-admin/includes/post.php');
		}
		if (!post_exists($value . "-szablon") && post_exists("predefinition-cpt-szablon")) {
			wp_insert_post($new);
		}
	}
	$args = array(
		'post_type' => 'predefinition-cpt',
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);

	$loop = new WP_Query($args);
	foreach ($loop->posts as $value) {
		$datapost = '<?php' . PHP_EOL;
		$datapost .= '/**' . PHP_EOL;
		$datapost .= '* Title: Domyślny widok dla ' . $value->post_title . PHP_EOL;
		$datapost .= '* Slug: wp-ergotree/pattern-' . $value->post_title . PHP_EOL;
		$datapost .= '* Categories: ergotree-patterns' . PHP_EOL;
		$datapost .= '* Description: A description of the pattern' . PHP_EOL;
		$datapost .= '* Keywords: footer, links, copyright, keywords used in the search' . PHP_EOL;
		$datapost .= '*/' . PHP_EOL;
		$datapost .= '?>' . PHP_EOL;
		$datapost .= $value->post_content;
		$srctemplate = get_template_directory() . '/patterns/pattern-' . $value->post_title . '.php';

		$template = fopen($srctemplate, 'w');
		fwrite($template, $datapost);
		fclose($template);
	}
}

// add_action('init', 'creat_post_theme_cpt');

if (function_exists('register_block_pattern_category')) {
	register_block_pattern_category(
		'ergotree-patterns',
		array('label' => __('Układy ergotree', 'ergotree'))
	);
}

add_action('init', function () {
	remove_theme_support('core-block-patterns');
});
