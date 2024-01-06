<?php

function my_custom_styles()
{
	echo '<style>
	.popup-admin-panel {
		position: fixed;
		z-index: 999999;
		background: #191919;
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 60px;
		right: 30px;
		top: 60px;
		border: solid 1px #000;
		box-shadow: 0px 0px 20px #000;
	}
	.popup-admin-panel .title {
		color:#fff;
		font-size:2em;
	}
	.popup-admin-panel-close {
		position: absolute;
		top: 5%;
		right: 5%;
		color: #fff;
		cursor: pointer;
		font-size: 2em;
	}
	.background-wrapper {
		position: absolute;
		height: 100%;
		width: 100%;
		background-size: cover;
	}
	.background-wrapper div {
		height: 100%;
		width: 100%;
		display: block;
	}
	section {
		position:relative;
	}
	section>*:nth-child(2) {
		position: relative;
		z-index: 2;
	}
	.all-popup {
		display:none !important;
	}
	.css-1wkpk1y-Flex-ItemsColumn {
		height:auto !important;
	}
	html :where(.wp-block) {
		max-width: min(1366px, 95%);
	}
	.acf-block-preview {
		h1, h2, h3, h4, h5, h6 {
			color: #000;
		}
	}
	@media screen and (min-width: 851px) and (max-width: 920px) {
		.admin-column-25 {
			width: 50% !important;
		}
	}
	@media screen and (max-width: 767px) {
		.admin-column-25 {
			width: 50% !important;
		}
	}
	@media screen and (max-width:575px) {
		.admin-column-25 {
			width: 100% !important;
		}
	}
	</style>';
}
add_action('admin_head', 'my_custom_styles');

function general_admin_notice()
{
	if (isset($_GET['error-msg'])) {
		echo '<div class="notice notice-info is-dismissible">
		<p>' . $_GET['error-msg'] . '</p>
		</div>';
	}
}

function rrmdir($dir)
{
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
					rrmdir($dir . DIRECTORY_SEPARATOR . $object);
				else
					unlink($dir . DIRECTORY_SEPARATOR . $object);
			}
		}
		rmdir($dir);
	}
}

function et_redirect()
{
	global $pagenow;
	if ("themes.php" == $pagenow && is_admin() && isset($_GET['activated'])) {
		wp_redirect(esc_url_raw(add_query_arg('page', 'acf-options-theme-settings', admin_url('admin.php'))));
	}
}
add_action('admin_init', 'et_redirect');

function is_debug()
{
	if (defined('WP_DEBUG') && WP_DEBUG) {
		return true;
	} else {
		return false;
	}
}

if (is_debug()) {
	function create_custom_page()
	{
		$page_title = 'Ergotree';
		$menu_title = 'Ergotree';
		$capability = 'read';
		$slug = 'custom_page_content';
		$callback = 'custom_page_content';
		$icon = 'dashicons-welcome-write-blog';
		$position = 100;
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
	}
	add_action('admin_menu', 'create_custom_page');
}

function remove_files_block()
{
	if (!is_admin()) {
		status_header(404);
		wp_die();
	}
	$current_dir = get_template_directory() . '/blocks/block-templates/';
	echo $current_dir;
	rrmdir($current_dir);
	if (wp_get_referer()) {
		$url =  wp_get_referer();
	} else {
		$url = get_home_url();
	}
	wp_safe_redirect($url);
	exit("Completed");
}
add_action('admin_post_remove_files_block', 'remove_files_block');

function remove_files_cpt()
{
	if (!is_admin()) {
		status_header(404);
		wp_die();
	}
	$current_dir = get_template_directory() . '/cpt/cpt-templates';
	echo $current_dir;
	rrmdir($current_dir);
	if (wp_get_referer()) {
		$url =  wp_get_referer();
	} else {
		$url = get_home_url();
	}
	wp_safe_redirect($url);
	exit("Completed");
}
add_action('admin_post_remove_files_cpt', 'remove_files_cpt');

function custom_page_content()
{
	echo '<h1>Wygeneruj nowe pliki bloków</h1>';
	echo '<p style="margin: 10px 0; width: max-content;" class="notice notice-error">Kliknięcie usunie wszytskie napisane pliki i wygeneruje na nowo</p>';
	echo '<a href="' . admin_url("admin-post.php") . '?action=remove_files_block" class="button button-secondary">Odśwież pliki motywu</a>';

	echo '<hr><h1>Wygeneruj nowe pliki CPT</h1>';
	echo '<p style="margin: 10px 0; width: max-content;" class="notice notice-error">Kliknięcie usunie wszytskie napisane pliki i wygeneruje na nowo</p>';
	echo '<a href="' . admin_url("admin-post.php") . '?action=remove_files_cpt" class="button button-secondary">Odśwież pliki motywu</a>';
}
add_action('acf/render_field_settings/type=repeater', 'my_repeater_render_field_settings');

function my_repeater_render_field_settings($field)
{

	acf_render_field_setting($field, array(
		'label'     => __('Wygeneruj kod dla'),
		'instructions'  => __('Kod zostanie automatycznie wygenerowany'),
		'name'      => 'library_type',
		'type' => 'select',
		'default_value' => 0,
		'choices' => array(
			0 => 'Domyślny',
			1 => 'Splide slider',
			2 => 'Accordion',
			3 => 'Collapse',
			4 => 'Tab',
		),

	));
}
add_filter('acf/validate_value/type=repeater', 'acf_addons_library', 10, 4);

function acf_addons_library($valid, $value, $field, $input)
{
	if (!$valid) return $valid;
	if (empty($field['library_type'])) return $valid;
	$words = explode(',', $field['library_type']);
	/* trim white spaces */
	$words = array_map('trim', $words);
	/* remove empty values */
	$words = array_values($words);
	foreach ($words as $word) {
		if (stripos($value, $word) !== false) {
			$valid = sprintf(__('Value must not include "%s"'), $word);
			break;
		}
	}
	return $valid;
}

// add_action('acf/render_field_settings/type=message', 'my_message_render_field_settings');

// function my_message_render_field_settings($field)
// {
// 	acf_render_field_setting($field, array(
// 		'label'     => __('Wygeneruj kod dla'),
// 		'instructions'  => __('Kod zostanie automatycznie wygenerowany'),
// 		'name'      => 'type_cpt',
// 		'type' => 'select',
// 		'choices' => et_get_cpt(),
// 		'allow_null' => 1,
// 		'multiple' => 0,
// 		'ui' => 0,
// 		'return_format' => 'array',
// 		'ajax' => 0,
// 		'placeholder' => '',
// 	));
// }
