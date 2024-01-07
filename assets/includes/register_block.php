<?php
add_action('acf/init', 'my_acf_blocks_init');

function my_acf_blocks_init()
{
	if (!function_exists('acf_register_block_type')) {
		return;
	}

	$type = new WP_Query(array(
		'post_type' => 'acf-field-group',
		'post_status' => array('publish'),
		'posts_per_page' => -1
	));

	$current_dir = get_template_directory() . '/blocks/block-templates/';
	create_directories_if_not_exist($current_dir);

	foreach ($type->posts as $singleacf) {
		process_single_acf_block($singleacf, $current_dir);
	}
}

function create_directories_if_not_exist($directory)
{
	if (file_exists($directory)) {
		return;
	}

	mkdir($directory, 0755, true);
}

function process_single_acf_block($singleacf, $current_dir)
{
	$title = $singleacf->post_title;
	$slug = $singleacf->post_excerpt;
	$array = unserialize($singleacf->post_content);

	if ($array['location'][0][0]['param'] != 'block') {
		return;
	}

	$render_template_create = get_template_directory() . '/blocks/block-templates/' . $slug;
	create_directories_if_not_exist($render_template_create . '/assets');

	register_acf_blocks($title, $slug, $array, $render_template_create);
	process_acf_fields($singleacf, $render_template_create, $slug);
}

function register_acf_blocks($title, $slug, $array, $render_template_create)
{
	acf_register_block_type(array(
		'name'              => $slug,
		'title'             => __($title),
		'description'       => __($array['description']),
		'render_template'   => $render_template_create . '/block.php',
		'category'          => 'ergotree',
		'mode'              => 'preview',
		'icon'              => 'book-alt',
		'supports'          => array(
			'align' => true,
			'mode' => true,
			'jsx' => true
		),
	));
}

function process_acf_fields($singleacf, $render_template_create, $slug)
{
	write_acf_template_files($singleacf, $render_template_create, $slug);
}

function write_acf_template_files($singleacf, $render_template_create, $slug)
{
	$active_num_library = [];

	$srcjson = get_template_directory() . '/acf-json/' . $singleacf->post_name . '.json';
	if (!file_exists($srcjson)) {
		return;
	}

	$stringjson = json_decode(file_get_contents($srcjson), true);
	$fields = $stringjson['fields'];

	$css = et_get_fields_css($slug);
	$type_field = '';
	$all_code_js = '';

	foreach ($fields as $single_acf) {
		$type_field .= et_get_fields_acf($single_acf, 1, $slug);

		if (return_all_repeater($single_acf)) {
			$all_js = return_all_repeater($single_acf);
			foreach ($all_js as $single_js) {
				$name = $single_js['name'];
				$type = $single_js['type'];
				$all_code_js .= et_get_fields_js($type, 'splide_' . $name, $slug);
				if (!in_array($type, $active_num_library)) {
					$active_num_library[] = $type;
				}
			}
		}
	}

	$active_num_library = array_unique($active_num_library);
	$block_file = $render_template_create . '/block.php';
	if (!file_exists($block_file)) {
		include('file_configurator/template-block.php');
		et_write($block_file, $datablock);
	}

	$srctemplate = $render_template_create . '/assets/template.php';
	if (!file_exists($srctemplate)) {
		$datatemplate = $type_field;
		et_write($srctemplate, $datatemplate);
	}

	$srcss = $render_template_create . '/assets/style.css';
	if (!file_exists($srcss)) {
		et_write($srcss, $css);
	}
	$srscss = $render_template_create . '/assets/style.scss';
	if (!file_exists($srscss)) {
		et_write($srscss, $css);
	}

	$srcjs = $render_template_create . '/assets/script.js';
	if (!file_exists($srcjs) && !empty($all_code_js)) {
		et_write($srcjs, $all_code_js);
	} else if (!file_exists($srcjs)) {
		include('file_configurator/template-js.php');
		et_write($srcjs, $all_code_js);
	}
}
