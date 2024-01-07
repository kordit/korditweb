<?php
class acf_field_ulepszony_naglowek extends acf_field
{

	function __construct()
	{
		$this->name = 'seo_title';
		$this->label = __('Ulepszony Nagłówek', 'acf');
		$this->category = 'basic';
		$this->defaults = array();

		parent::__construct();
	}
	function render_field($field)
	{
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



	function load_value($value, $post_id, $field)
	{
		return $value;
	}

	function update_value($value, $post_id, $field)
	{
		return $value;
	}

	function format_value($value, $post_id, $field)
	{
		if (empty($value) || !is_array($value) || !isset($value['heading']) || !isset($value['value'])) {
			return '';
		}
		$h = esc_html($value['heading']);
		$c = $value['value'];
		return "<{$h}>{$c}</{$h}>";
	}
}

add_action('acf/include_field_types', function () {
	new acf_field_ulepszony_naglowek();
});

class My_Custom_ACF_Field extends acf_field
{

	function __construct()
	{
		$this->name = 'get_cpt_fields';
		$this->label = 'Wygeneruj CPT';
		$this->category = 'choice';
		parent::__construct();
	}
	function get_acf_fields_for_cpt($cpt)
	{
		$fields = [];
		$field_groups = acf_get_field_groups();

		foreach ($field_groups as $field_group) {
			foreach ($field_group['location'] as $locations) {
				foreach ($locations as $location) {
					if ($location['param'] == 'post_type' && $location['value'] == $cpt) {
						$group_fields = acf_get_fields($field_group['key']);
						foreach ($group_fields as $group_field) {
							$fields[] = [
								'name' => $group_field['name'],
								'label' => $group_field['label'],
								'type' => $group_field['type'],
								'group_id' => $field_group['key'] // Dodano identyfikator grupy pól
							];
						}
						break;
					}
				}
			}
		}

		return $fields;
	}

	function render_field_settings($field)
	{
		// Załóżmy, że get_custom_post_types_choices zwraca listę typów postów
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
				$choices[$acf_field['name']] = $acf_field['label'];
			}
			$group_ids = [];
			foreach ($acf_fields as $acf_field) {
				if (!in_array($acf_field['group_id'], $group_ids)) {
					$url = acf_get_field_group($acf_field['group_id']);
					$group_ids[] = $acf_field['group_id'];
				}
			}

			// Wyświetlanie identyfikatorów grup pól
			acf_render_field_setting($field, [
				'label' => 'ID Grup Pól',
				'type' => 'textarea',
				'name' => 'field_group_ids',
				'value' => implode(', ', $group_ids),
				'readonly' => true,
				// 'disabled' => true,
			]);

			acf_render_field_setting($field, [
				'label' => 'Wybierz pola, które ma wygenerować dla danego bloku',
				'instructions' => 'Wybierz pola z odpowiednich grup pól ACF.',
				'type' => 'checkbox',
				'name' => 'selected_acf_fields',
				'choices' => $choices,
				'layout' => 'vertical',
			]);
		}
	}


	function get_custom_post_types_choices()
	{
		$choices = [];
		$post_types = get_post_types(['public' => true], 'objects');

		foreach ($post_types as $post_type) {
			$choices[$post_type->name] = $post_type->label;
		}

		return $choices;
	}
}

add_action('acf/include_field_types', function ($version) {
	new My_Custom_ACF_Field();
});



function et_write($srctemplate, $datatemplate = '')
{
	$template = fopen($srctemplate, 'w');
	fwrite($template, $datatemplate);
	fclose($template);
}

function generate_field_html($type, $name, $classa, $single_acf, $get_field, $field)
{
	$type_field = "";
	switch ($type) {
		case 'text':
		case 'number':
		case 'textarea':
			$type_field .= "<div class=\"$classa\">" . PHP_EOL . "<?php $field('$name'); ?>" . PHP_EOL . '</div>' . PHP_EOL;
			break;
		case 'url':
			$type_field .= "<a href=\"<?php $field('$name'); ?>\" class=\"$classa\">" . PHP_EOL . "<?php $field('$name'); ?>" . PHP_EOL . '</a>' . PHP_EOL;
			break;
		case 'image':
			$type_field .= "<?php et_image('$name', 'full', false, '$classa'); ?>" . PHP_EOL;
			break;
		case 'link':
			$type_field .= "<div class=\"btn-wrapper\">" . PHP_EOL . "<?php et_link('$name', '$classa'); ?>" . PHP_EOL . '</div>' . PHP_EOL;
			break;
		case 'message':
			break;
		case 'email':
			$type_field .= "<a href=\"mailto:<?php $field('$name'); ?>\" class=\"$classa\">" . PHP_EOL . "<?php $field('$name'); ?>" . PHP_EOL . '</a>' . PHP_EOL;
			break;
		case 'gallery':
			$type_field = "";
			$type_field .= "<?php" . PHP_EOL;
			$type_field .= "\$images = get_field('galeria_zdjec');" . PHP_EOL;
			$type_field .= "\$size = 'full';" . PHP_EOL;
			$type_field .= "if (\$images) :" . PHP_EOL;
			$type_field .= "foreach (\$images as \$image_id) :" . PHP_EOL;
			$type_field .= "\$image = wp_get_attachment_image(\$image_id, \$size);" . PHP_EOL;
			$type_field .= "\$image_url = wp_get_attachment_image_src(\$image_id, \$size)[0];" . PHP_EOL;
			$type_field .= "?>" . PHP_EOL;
			$type_field .= "<a class=\"name_library\" href=\"<?= esc_url(\$image_url); ?>\"><?= \$image; ?></a>" . PHP_EOL;
			$type_field .= "<?php" . PHP_EOL;
			$type_field .= "endforeach;" . PHP_EOL;
			$type_field .= "endif;" . PHP_EOL;
			$type_field .= "?>" . PHP_EOL;
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
	return $type_field;
}

function et_get_fields_acf($single_acf, $depth = 1, $classname = '')
{
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
	} elseif ($type == 'get_cpt_fields') {
		$custom_post_type = $single_acf['custom_post_type'];
		$group_ids = $single_acf['field_group_ids'];
		$group_ids = str_replace(' ', '', $group_ids);
		$group_ids_array = explode(",", $group_ids);

		$type_field = '';
		$type_field = '<?php' . PHP_EOL;
		$type_field .= '$args = array(' . PHP_EOL;
		$type_field .= "    'post_type' => '" . $custom_post_type . "'," . PHP_EOL;
		$type_field .= "    'posts_per_page' => -1," . PHP_EOL;
		$type_field .= ');' . PHP_EOL;
		$type_field .= '' . PHP_EOL;
		$type_field .= '$moj_cpt_query = new WP_Query($args);' . PHP_EOL;
		$type_field .= '' . PHP_EOL;
		$type_field .= 'if ($moj_cpt_query->have_posts()) :' . PHP_EOL;
		$type_field .= '    while ($moj_cpt_query->have_posts()) : $moj_cpt_query->the_post();' . PHP_EOL;
		$type_field .= ' $fields = get_fields(get_the_ID());' . PHP_EOL;
		$type_field .= '  if ($fields) {' . PHP_EOL;
		$type_field .= '     acf_setup_meta($fields, get_the_ID(), true); ' . PHP_EOL;
		$type_field .= '  } ?>' . PHP_EOL;
		$type_field .= '        <?php the_post_thumbnail(); ?>' . PHP_EOL;
		$type_field .= '        <?php the_title(); ?>' . PHP_EOL;
		$allFields = [];

		foreach ($group_ids_array as $id_array) {
			if (isset(acf_get_field_group($id_array)['local_file'])) {
				// et_r(acf_get_field_group($id_array)['local_file']);

				$field_url = acf_get_field_group($id_array)['local_file'];
				$stringjson = json_decode(file_get_contents($field_url), true);
				$fields = $stringjson['fields'];

				array_push($allFields, ...$fields);
			}
		}
		$selected_fields = $single_acf['selected_acf_fields'];
		foreach ($allFields as $single_field) {
			if (in_array($single_field['name'], $selected_fields)) {
				$classa = isset($single_field['wrapper']['class']) && !empty($single_field['wrapper']['class'])
					? $single_field['wrapper']['class']
					: (!empty($name) ? $single_field['label'] . '--' . $classname . '--' . $name : '');
				$type_field .= et_get_fields_acf($single_field, 1, $classname);
			}
		}
		$type_field .= '<?php' . PHP_EOL;
		$type_field .= '    endwhile;' . PHP_EOL;
		$type_field .= '    wp_reset_postdata();' . PHP_EOL;
		$type_field .= 'else :' . PHP_EOL;
		$type_field .= "    echo 'Nie znaleziono postów.';" . PHP_EOL;
		$type_field .= 'endif;' . PHP_EOL;
		$type_field .= '?>';
	} else {
		$type_field = generate_field_html($type, $name, $classa, $single_acf, $get_field, $field);
	}

	return $type_field;
}

function get_repeater_file($library)
{
	switch ($library) {
		case 1:
			return '/assets/includes/file_configurator/splide-repeater.php';
		case 2:
			return '/assets/includes/file_configurator/accordion-repeater.php';
		default:
			return '/assets/includes/file_configurator/default-repeater.php';
	}
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
