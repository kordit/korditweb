<?php
class acf_field_ulepszony_naglowek extends acf_field {

	function __construct() {
		$this->name = 'seo_title';
		$this->label = __('Ulepszony Nagłówek', 'acf');
		$this->category = 'basic';
		$this->defaults = array(

		);

		parent::__construct();
	}
	function render_field( $field ) {
		$heading = isset($field['value']['heading']) ? $field['value']['heading'] : '';
		$value = isset($field['value']['value']) ? $field['value']['value'] : '';
		$default_title = isset($field['value']['default_title']) ? $field['value']['default_title'] : 'Domyślny Tytuł'; 

		echo '<div class="acf-field-ulepszony-naglowek-select">';
		echo '<select name="' . esc_attr($field['name']) . '[heading]">';
		$options = ['div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'];
		foreach ($options as $option) {
			$selected = ($heading === $option) ? 'selected' : '';
			echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="acf-field-ulepszony-naglowek-text">';
		echo '<input type="text" name="' . esc_attr($field['name']) . '[value]" value="' . $value . '">';
		echo '</div>';

	}



	function load_value( $value, $post_id, $field ) {
		return $value;
	}

	function update_value( $value, $post_id, $field ) {
		return $value;
	}

	function format_value( $value, $post_id, $field ) {
		if( empty($value) || !is_array($value) || !isset($value['heading']) || !isset($value['value']) ) {
			return '';
		}
		$h = esc_html($value['heading']);
		$c = $value['value'];
		return "<{$h}>{$c}</{$h}>";
	}
}

add_action('acf/include_field_types', function() {
	new acf_field_ulepszony_naglowek();
});

class My_Custom_ACF_Field extends acf_field {

	function __construct() {
		$this->name = 'get_cpt_fields';
		$this->label = 'Wygeneruj CPT';
		$this->category = 'choice'; 
		parent::__construct();
	}
	function get_acf_fields_for_cpt($cpt) {
		$fields = [];
		$field_groups = acf_get_field_groups();

		foreach ($field_groups as $field_group) {
			foreach ($field_group['location'] as $locations) {
				foreach ($locations as $location) {
					if ($location['param'] == 'post_type' && $location['value'] == $cpt) {
						$group_fields = acf_get_fields($field_group['key']);
						foreach ($group_fields as $group_field) {
							$fields[] = ['key' => $group_field['key'], 'label' => $group_field['label']];
						}
						break 2; 
					}
				}
			}
		}

		return $fields;
	}
	function render_field_settings($field) {
		acf_render_field_setting($field, [
			'label' => 'Wybierz Custom Post Type',
			'instructions' => '',
			'type' => 'select',
			'name' => 'custom_post_type',
			'choices' => $this->get_custom_post_types_choices(),
		]);

		if (isset($field['custom_post_type'])) {
			$acf_fields = $this->get_acf_fields_for_cpt($field['custom_post_type']);

			$choices = [];
			foreach ($acf_fields as $acf_field) {
				$choices[$acf_field['key']] = $acf_field['label'];
			}

			acf_render_field_setting($field, [
				'label' => 'Wybierz pola, które ma wygenerować dla danego bloku',
				'type' => 'checkbox',
				'name' => 'selected_acf_fields',
				'choices' => $choices,
				'layout' => 'vertical',
			]);
		}
	}

	function get_custom_post_types_choices() {
		$choices = [];
		$post_types = get_post_types(['public' => true], 'objects');

		foreach ($post_types as $post_type) {
			$choices[$post_type->name] = $post_type->label;
		}

		return $choices;
	}


}

add_action('acf/include_field_types', function($version) {
	new My_Custom_ACF_Field();
});



function et_write($srctemplate, $datatemplate = '') {
	$template = fopen($srctemplate, 'w');
	fwrite($template, $datatemplate);
	fclose($template);
}

function et_get_fields_acf($single_acf, $depth = 1, $classname = '', $randomizer_class = '') {
	$type_field = '';
	$field = $depth == 1 ? 'the_field' : 'the_sub_field';
	$get_field = $depth == 1 ? 'get_field' : 'get_sub_field';
	$type = $single_acf['type'];
	$name = $single_acf['name'];
	$classa = isset($single_acf['wrapper']['class']) && !empty($single_acf['wrapper']['class']) 
	? $single_acf['wrapper']['class'] 
	: (!empty($name) ? $classname . '--' . $name : '');

	if ($type == 'repeater' || $type == 'group') {
		$repeater = $single_acf['sub_fields'];
		$namerepeater = $single_acf['name'];
		$library = $single_acf['library_type'] ?? 0;
		$repeaterFile = get_repeater_file($library);
		include(get_template_directory() . $repeaterFile);
	}
	else {
		switch ($type) {
			case 'text':
			case 'textarea':
			$type_field .= "<div class=\"$classa\">" . PHP_EOL . "<?php $field('$name'); ?>" . PHP_EOL . '</div>' . PHP_EOL;
			break;
			case 'image':
			$type_field .= "<?php et_image('$name', 'full', false, '$classa'); ?>" . PHP_EOL;
			break;
			case 'link':
			$type_field .= "<div class=\"btn-wrapper\">" . PHP_EOL . "<?php et_link('$name', '$classa'); ?>" . PHP_EOL . '</div>' . PHP_EOL;
			break;
			case 'email':
			$type_field .= "<a href=\"mailto:<?php $field('$name'); ?>\" class=\"$classa\">" . PHP_EOL . "<?php $field('$name'); ?>" . PHP_EOL . '</a>' . PHP_EOL;
			break;
			case 'gallery':
			$type_field .= "<?php \$images = $get_field('$name'); \$size = 'full'; if( \$images ): ?>" . PHP_EOL;
			$type_field .= "<?php foreach( \$images as \$image_id ): ?>" . PHP_EOL;
			$type_field .= "<?php echo wp_get_attachment_image( \$image_id, \$size ); ?>" . PHP_EOL;
			$type_field .= "<?php endforeach; endif; ?>" . PHP_EOL;
			break;
			case 'relationship':
			if (!isset($single_acf['post_type']) || $single_acf['post_type'][0] == 'wpcf7_contact_form') {
				$type_field .= "<?php \$formid = $get_field('$name')[0]->ID; ?>" . PHP_EOL;
				$type_field .= "<?= et_form(\$formid); ?>" . PHP_EOL;
			} else {
				$type_field .= "<?php \$featured_posts = $get_field('$name'); if( \$featured_posts ): ?>" . PHP_EOL;
				$type_field .= "<?php foreach( \$featured_posts as \$post ): setup_postdata(\$post); ?>" . PHP_EOL;
				$type_field .= "<?php the_title(); ?>" . PHP_EOL;
				$type_field .= "<?php endforeach; wp_reset_postdata(); endif; ?>" . PHP_EOL;
			}
			break;
			default:
			$type_field .= "<div class=\"$classa\">" . PHP_EOL . "<?php $field('$name'); ?>" . PHP_EOL . '</div>' . PHP_EOL;
		}
	}

	return $type_field;
}

function get_repeater_file($library) {
	switch ($library) {
		case 1: return '/assets/includes/file_configurator/splide-repeater.php';
		case 2: return '/assets/includes/file_configurator/accordion-repeater.php';
		default: return '/assets/includes/file_configurator/default-repeater.php';
	}
}


function et_get_fields_css($single_acf) {
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

function et_get_fields_js($typejs, $classname = '', $slug = '') {
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
		$datajs .= 'perPage:"2",' . PHP_EOL;
		$datajs .= 'padding: { left: 10, right: 20 },' . PHP_EOL;
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
