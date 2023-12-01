<?php
function et_write($srctemplate, $datatemplate = '')
{
	$template = fopen($srctemplate, 'w');
	fwrite($template, $datatemplate);
	fclose($template);
}

function et_get_fields_acf($single_acf, $depth = 1, $classname = '', $randomizer_class = '')
{
	$type_field = '';
	if ($depth == 1) {
		$field = 'the_field';
		$get_field = 'get_field';
	} else {
		$field = 'the_sub_field';
		$get_field = 'get_sub_field';
	}
	$type = $single_acf['type'];
	$name = $single_acf['name'];

	if ($single_acf['wrapper']['class']) {
		$classa = $single_acf['wrapper']['class'];
	} else {
		$classa = $classname . '--' . $name;
	}
	if ($type == 'repeater' || $type == 'group') {
		$repeater = $single_acf['sub_fields'];
		$namerepeater = $single_acf['name'];
		if (array_key_exists('library_type', $single_acf)) {
			$library = $single_acf['library_type'];
		} else {
			$library = 0;
		}
		/* START REPEATER */
		if ($library == 1) {
			include(get_template_directory() . '/assets/includes/file_configurator/splide-repeater.php');
		} elseif ($library == 2) {
			include(get_template_directory() . '/assets/includes/file_configurator/accordion-repeater.php');
		} elseif ($library == 3) {
			include(get_template_directory() . '/assets/includes/file_configurator/default-repeater.php');
		} elseif ($library == 4) {
			include(get_template_directory() . '/assets/includes/file_configurator/default-repeater.php');
		} else {
			include(get_template_directory() . '/assets/includes/file_configurator/default-repeater.php');
		}
		/* END REPEATER */
	} else {
		/* Tutaj dopisujemy pola */
		if ($type == 'text' || $type == 'textarea') {
			$type_field .= '<div class="' . $classa . '">' . PHP_EOL . '<?php ' . $field . "('" . $name . "');" . '?>' . PHP_EOL . '</div>' . PHP_EOL;
		} elseif ($type == 'image') {
			$type_field .= '<?php et_image("' . $name . '","full",false,"' . $classa . '"); ?>' . PHP_EOL;
		} elseif ($type == 'link') {
			$type_field .= '<div class="btn-wrapper">' . PHP_EOL . '<?php et_link("' . $name . '", "' . $classa . '"); ?>' . PHP_EOL . '</div>' . PHP_EOL;
		} elseif ($type == 'gallery') {
			$type_field .= '<?php $images = ' . $get_field . '("' . $name . '");$size = "full"; if( $images ): ?>' . PHP_EOL;
			$type_field .= '<?php foreach( $images as $image_id ): ?>' . PHP_EOL;
			$type_field .= '<?php echo wp_get_attachment_image( $image_id, $size ); ?>' . PHP_EOL;
			$type_field .= '<?php endforeach;  endif; ?>' . PHP_EOL;
		} elseif ($type == 'relationship') {
			if (!isset($single_acf['post_type']) && $single_acf['post_type'][0] == 'wpcf7_contact_form') {
				$type_field .= '<?php $formid = ' . $get_field . '("' . $name . '")[0]->ID; ?>' . PHP_EOL;
				$type_field .= '<?= et_form($formid); ?>' . PHP_EOL;
			} else {
				$type_field .= '<?php $featured_posts = ' . $get_field . '("' . $name . '"); if( $featured_posts ): ?>' . PHP_EOL;
				$type_field .= '<?php foreach( $featured_posts as $post ): setup_postdata($post); ?>' . PHP_EOL;
				$type_field .= '<?php the_title(); ?>' . PHP_EOL;
				$type_field .= '<?php endforeach; wp_reset_postdata(); endif; ?>' . PHP_EOL;
			}
		} else {
			$type_field .= '<div class="' . $classa . '">' . PHP_EOL . '<?php ' . $field . "('" . $name . "');" . '?>' . PHP_EOL . '</div>' . PHP_EOL;
		}
	}
	return $type_field;
}

function et_get_fields_css($single_acf)
{
	$css = 'body:not(.wp-core-ui),html:not(.wp-toolbar),.acf-block-preview { ' . PHP_EOL . '.' . $single_acf . ' {' . PHP_EOL . PHP_EOL;
	$css .= '}' . PHP_EOL . '}';
	return $css;
}
function return_all_repeater($acf)
{
	$myreturn = [];
	if (array_key_exists('library_type', $acf)) {
		$name = $acf['name'];
		array_push($myreturn, ['name' => $name, 'type' => $acf['library_type']]);
	}
	if (array_key_exists('sub_fields', $acf)) {
		$acf = $acf['sub_fields'];
		foreach ($acf as $value) {
			if (array_key_exists('library_type', $value)) {
				$name = $value['name'];
				array_push($myreturn, ['name' => $name, 'type' => $value['library_type']]);
			}
		}
	}
	if ($myreturn) {
		return $myreturn;
	}
}
function et_get_fields_js($typejs, $classname = '', $slug = '')
{
	$datajs = '';
	if ($typejs == 1) {
		$slugrp = str_replace('-', '_', $slug);
		$slugrpCap = ucfirst($slugrp);
		$datajs .= '/* eslint-disable no-unused-vars */' . PHP_EOL;
		$datajs .= '/* eslint-disable no-shadow */' . PHP_EOL;
		$datajs .= '/* eslint-disable no-undef */' . PHP_EOL;
		$datajs .= 'function init' . $slugrpCap . '(element = document) {' . PHP_EOL;
		$datajs .= 'const ' . $slugrp . ' = element.querySelectorAll( ".' . $classname . '" );' . PHP_EOL;
		$datajs .= $slugrp . '.forEach(item => {' . PHP_EOL;
		$datajs .= 'const slider = new Splide(item, {' . PHP_EOL;
		$datajs .= 'rewind:true,' . PHP_EOL;
		$datajs .= 'type:"loop",' . PHP_EOL;
		$datajs .= '});' . PHP_EOL;
		$datajs .= 'slider.mount();' . PHP_EOL;
		$datajs .= '});' . PHP_EOL;
		$datajs .= '};' . PHP_EOL;
		$datajs .= '' . PHP_EOL;
		$datajs .= 'document.addEventListener("DOMContentLoaded", () => {' . PHP_EOL;
		$datajs .= 'init' . $slugrpCap . '();' . PHP_EOL;
		$datajs .= '});' . PHP_EOL;
		$datajs .= '' . PHP_EOL;
		$datajs .= '/* -- Admin JS START -- */' . PHP_EOL;
		$datajs .= 'if(window.acf){' . PHP_EOL;
		$datajs .= 'window.acf.addAction("render_block_preview/type=' . $slug . '", (el) => {' . PHP_EOL;
		$datajs .= 'if(!!el[0].querySelector(".' . $slug . '") && !el[0].querySelector(".' . $slug . '").classList.contains("block-js-added")){' . PHP_EOL;
		$datajs .= 'init' . $slugrpCap . '(el[0]);' . PHP_EOL;
		$datajs .= 'el[0].querySelector(".' . $slug . '").classList.add("block-js-added");' . PHP_EOL;
		$datajs .= '}' . PHP_EOL;
		$datajs .= '});' . PHP_EOL;
		$datajs .= '}' . PHP_EOL;
		$datajs .= '/* -- Admin JS END -- */' . PHP_EOL;
	}
	return $datajs;
}
