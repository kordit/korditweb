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
		'icon' => '<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 245 435" width="245" height="435"><g id="Logo"><path id="Layer" class="s0" d="m102.7 18.7c-3 9.2-8 24.6-11 34.3-8.4 26.7-14.5 46.3-15.2 48.8l-0.6 2.2h37.9 37.9l-14.8-46.2c-8.2-25.5-15.4-48.4-16.2-50.8l-1.2-4.5-5.7-0.3-5.6-0.3z"/><path id="Layer" class="s0" d="m1 252v160.1l18.3-0.3c10-0.2 18.1-0.7 17.9-1-0.1-0.4-0.2-72.4-0.2-159.8v-159h-18-18z"/><path id="Layer" class="s0" d="m205.4 106.8c0.1 25.6-6 46.5-19.3 66.7-4.4 6.8-21.5 25.5-23.2 25.5-0.5 0-0.9-14.2-0.9-31.5v-31.5h-3.6c-8.8 0-19 8.8-22.3 19.4-1.1 3.4-2 5.2-2 4-0.1-3.5-5.5-10.8-9.8-13.1l-4.1-2.3-0.5 3.3c-0.3 1.7-0.5 19.6-0.4 39.7l0.2 36.5-3.5 1.6c-3.2 1.5-16.8 5.5-25.2 7.3l-2.7 0.6-0.3-39.8c-0.4-48.4-1.4-51.7-16.9-56.4-5.6-1.6-5.3-4-5.5 48.2v47.9l23 24.5c12.7 13.5 35.5 37.5 50.6 53.3 51.6 54.2 59.1 65.2 63.1 90.8 0.6 4.4 1.3 8.6 1.5 9.2 0.3 1 5 1.3 19.5 1.3h19.2l-0.6-9.8c-2.3-40.3-31.3-85.1-82-126.7-11.3-9.3-11-8.4-5-11.5 36.2-18.9 67.1-56.1 80.2-96.2 6-18.5 7.3-27 7.8-53l0.5-22.8h-18.9-18.9z"/><path id="Layer" class="s0" d="m66 352.3v66.4l2.3 3.4c2.4 3.5 7.7 6 15.4 7.3l4.3 0.8v-60.3-60.2l-3.7-4.1c-2-2.2-6.9-7.6-11-12l-7.3-7.7z"/><path id="Layer" class="s0" d="m119.4 388.2l0.1 44.2 5.5-0.3c30.1-1.3 37-6.5 37-28v-13.6l-4.8-5.6c-6-7-36.3-40.3-37.2-40.7-0.4-0.2-0.6 19.7-0.6 44z"/></g></svg>',
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
				if ($type == 1) {
					$temp = 'splide_';
				} else {
					$temp = 'tab_';
				}
				$all_code_js .= et_get_fields_js($type, $temp . $name, $slug);
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
