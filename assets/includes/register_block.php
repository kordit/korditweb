<?php
add_action('acf/init', 'my_acf_blocks_init');

function my_acf_blocks_init()
{
	if (function_exists('acf_register_block_type')) {
		$myargs = array(
			'post_type' => 'acf-field-group',
			'post_status' => array('publish'),
			'posts_per_page' => -1
		);
		$type = new WP_Query($myargs);
		$webinfo = 'block-templates';
		$current_dir = get_template_directory() . '/blocks/' . $webinfo . '/';
		if (file_exists($current_dir)) {
			$current_dir = scandir($current_dir);
		}
		$currentblockacf = [];
		foreach ($type->posts as $singleacf) {
			$title = $singleacf->post_title;
			$slug = $singleacf->post_excerpt;
			$array = $singleacf->post_content;
			$array = unserialize($array);
			$my_post_type = $array['location'][0][0]['param'];
			$render_template_create = get_template_directory() . '/blocks/' . $webinfo . '/' . $slug;
			if ($my_post_type == 'block') {

				if (!file_exists($render_template_create)) {
					mkdir($render_template_create, 0755, true);
					mkdir($render_template_create . '/assets', 0755, true);
				}
				acf_register_block_type(array(
					'name'              => $slug,
					'title'             => __($title),
					'description'       => __($array['description']),
					'render_template'   => $render_template_create . '/block.php',
					'category'          => 'kordit',
					'mode'              => 'preview',
					'icon' => 'book-alt',
					'supports'          => array(
						'align' => true,
						'mode' => true,
						'jsx' => true
					),
				));
				$srcjson = get_template_directory() . '/acf-json/' . $singleacf->post_name . '.json';
				if (file_exists($srcjson)) {
					$stringjson = json_decode(file_get_contents($srcjson), true);
					$type_field = '';
					$css = '';
					$fields = $stringjson['fields'];
					$all_code_js = '';
					if (!isset($active_num_library)) {
						$active_num_library = [];
					}
					foreach ($fields as $single_acf) {
						$type_field .= et_get_fields_acf($single_acf, 1, $slug);
						if (return_all_repeater($single_acf)) {
							$all_js = return_all_repeater($single_acf);
							foreach ($all_js as $single_js) {
								$name = $single_js['name'];
								$type = $single_js['type'];
								$all_code_js .= et_get_fields_js($type, 'splide_' . $name, $slug);
								array_push($active_num_library, $type);
							}
						}
					}
					$active_num_library = array_unique($active_num_library);
					$css = et_get_fields_css($slug);
					$srctemplate = $render_template_create . '/assets/template.php';
					$srccss = $render_template_create . '/assets/style.scss';
					$srcss = $render_template_create . '/assets/style.css';
					$srcjs = $render_template_create . '/assets/script.js';
					if ($fields) {
						if (!file_exists($render_template_create . '/block.php')) {
							include('file_configurator/template-block.php');
							et_write($render_template_create . '/block.php', $datablock);
						}
						if (!file_exists($srctemplate)) {
							$datatemplate = '<h1>' . $title . '</h1>' . PHP_EOL . 'Plik można edytować w <b>"' . $render_template_create . '/assets/template.php"</b>' . PHP_EOL . PHP_EOL;
							$datatemplate .= $type_field;
							et_write($srctemplate, $datatemplate);
						}
						if (!file_exists($srccss)) {
							$templatecss = fopen($srccss, 'w');
							et_write($srccss, $css);
						}
						if (!file_exists($srcss)) {
							$templatecss = fopen($srcss, 'w');
							et_write($srcss);
						}
						if (!file_exists($srcjs)) {

							if (!empty($all_code_js)) {
								et_write($srcjs, $all_code_js);
							} else {
								$slugrp = str_replace('-', '_', $slug);
								$slugrpCap = ucfirst($slugrp);
								$all_code_js .= '/* eslint-disable no-unused-vars */' . PHP_EOL;
								$all_code_js .= 'function init' . $slugrpCap . '(element = document) {' . PHP_EOL;
								$all_code_js .= '' . PHP_EOL;
								$all_code_js .= '};' . PHP_EOL;
								$all_code_js .= '' . PHP_EOL;
								$all_code_js .= 'document.addEventListener("DOMContentLoaded", () => {' . PHP_EOL;
								$all_code_js .= 'init' . $slugrpCap . '();' . PHP_EOL;
								$all_code_js .= '});' . PHP_EOL;
								$all_code_js .= '' . PHP_EOL;
								$all_code_js .= '/* -- Admin JS START -- */' . PHP_EOL;
								$all_code_js .= 'if(window.acf){' . PHP_EOL;
								$all_code_js .= 'window.acf.addAction("render_block_preview/type=' . $slug . '", (el) => {' . PHP_EOL;
								$all_code_js .= 'if(!!el[0].querySelector(".' . $slug . '") && !el[0].querySelector(".' . $slug . '").classList.contains("block-js-added")){' . PHP_EOL;
								$all_code_js .= 'init' . $slugrpCap . '(el[0]);' . PHP_EOL;
								$all_code_js .= 'el[0].querySelector(".' . $slug . '").classList.add("block-js-added");' . PHP_EOL;
								$all_code_js .= '}' . PHP_EOL;
								$all_code_js .= '});' . PHP_EOL;
								$all_code_js .= '}' . PHP_EOL;
								$all_code_js .= '/* -- Admin JS END -- */' . PHP_EOL;
								et_write($srcjs, $all_code_js);
							}
						}
					}
				}
			}
		}
	}
}
