<?php

add_theme_support('yoast-seo-breadcrumbs');
add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('dark-editor-style');

if (function_exists('acf_add_options_page')) {
	$parent = acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title' 	=> 'Theme Settings',
		'redirect' 		=> false
	));
}

# Add resizeable UI to Gutenberg sidebar
function toast_enqueue_jquery_ui()
{
	wp_enqueue_script('jquery-ui-resizable');
}
add_action('admin_enqueue_scripts', 'toast_enqueue_jquery_ui');

function toast_resizable_sidebar()
{ ?>
	<style>
		.interface-interface-skeleton__sidebar .interface-complementary-area {
			width: 100%;
		}

		.edit-post-layout:not(.is-sidebar-opened) .interface-interface-skeleton__sidebar {
			display: none;
		}

		.is-sidebar-opened .interface-interface-skeleton__sidebar {
			width: 350px;
		}

		/* UI Styles */
		.ui-dialog .ui-resizable-n {
			height: 2px;
			top: 0;
		}

		.ui-dialog .ui-resizable-e {
			width: 2px;
			right: 0;
		}

		.ui-dialog .ui-resizable-s {
			height: 2px;
			bottom: 0;
		}

		.ui-dialog .ui-resizable-w {
			width: 2px;
			left: 0;
		}

		.ui-dialog .ui-resizable-se,
		.ui-dialog .ui-resizable-sw,
		.ui-dialog .ui-resizable-ne,
		.ui-dialog .ui-resizable-nw {
			width: 7px;
			height: 7px;
		}

		.ui-dialog .ui-resizable-se {
			right: 0;
			bottom: 0;
		}

		.ui-dialog .ui-resizable-sw {
			left: 0;
			bottom: 0;
		}

		.ui-dialog .ui-resizable-ne {
			right: 0;
			top: 0;
		}

		.ui-dialog .ui-resizable-nw {
			left: 0;
			top: 0;
		}

		.ui-draggable .ui-dialog-titlebar {
			cursor: move;
		}

		.ui-draggable-handle {
			-ms-touch-action: none;
			touch-action: none;
		}

		.ui-resizable {
			position: relative;
		}

		.ui-resizable-handle {
			position: absolute;
			font-size: 0.1px;
			display: block;
			-ms-touch-action: none;
			touch-action: none;
		}

		.ui-resizable-disabled .ui-resizable-handle,
		.ui-resizable-autohide .ui-resizable-handle {
			display: none;
		}

		.ui-resizable-n {
			cursor: n-resize;
			height: 7px;
			width: 100%;
			top: -5px;
			left: 0;
		}

		.ui-resizable-s {
			cursor: s-resize;
			height: 7px;
			width: 100%;
			bottom: -5px;
			left: 0;
		}

		.ui-resizable-e {
			cursor: e-resize;
			width: 7px;
			right: -5px;
			top: 0;
			height: 100%;
		}

		.ui-resizable-w {
			cursor: w-resize;
			width: 7px;
			left: -5px;
			top: 0;
			height: 100%;
		}

		.ui-resizable-se {
			cursor: se-resize;
			width: 12px;
			height: 12px;
			right: 1px;
			bottom: 1px;
		}

		.ui-resizable-sw {
			cursor: sw-resize;
			width: 9px;
			height: 9px;
			left: -5px;
			bottom: -5px;
		}

		.ui-resizable-nw {
			cursor: nw-resize;
			width: 9px;
			height: 9px;
			left: -5px;
			top: -5px;
		}

		.ui-resizable-ne {
			cursor: ne-resize;
			width: 9px;
			height: 9px;
			right: -5px;
			top: -5px;
		}
	</style>

	<script>
		jQuery(window).ready(function() {
			setTimeout(function() {
				jQuery('.interface-interface-skeleton__sidebar').width(localStorage.getItem('toast_sidebar_width'))
				jQuery('.interface-interface-skeleton__sidebar').resizable({
					handles: 'w',
					resize: function(event, ui) {
						jQuery(this).css({
							'left': 0
						});
						localStorage.setItem('toast_sidebar_width', jQuery(this).width());
					}
				});
			}, 500)
		});
	</script>
<?php }
add_action('admin_head', 'toast_resizable_sidebar');

# Remove Gutenberg auto full screen
function ghub_disable_editor_fullscreen_mode()
{
	$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
	wp_add_inline_script('wp-blocks', $script);
}
add_action('enqueue_block_editor_assets', 'ghub_disable_editor_fullscreen_mode');

add_theme_support('admin-bar', array('callback' => '__return_false'));

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

if (!function_exists('ergotree_logo')) :
	function ergotree_logo()
	{
		add_theme_support('custom-logo', array(
			// 'height' => 240,
			// 'width' => 400,
			// 'flex-width' => false,
		));
	}
	add_action('after_setup_theme', 'ergotree_logo');
endif;

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
	$filetype = wp_check_filetype($filename, $mimes);
	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
}, 10, 4);

function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function fix_svg()
{
	echo '<style type="text/css">
	.attachment-266x266, .thumbnail img {
		width: 100% !important;
		height: auto !important;
	}
	</style>';
}
add_action('admin_head', 'fix_svg');

function admin_bar()
{
	if (is_user_logged_in()) {
		add_filter('show_admin_bar', '__return_true', 1000);
	}
}
add_action('init', 'admin_bar');

/* Set image sizes */
remove_image_size('1536x1536');
remove_image_size('2048x2048');
add_image_size('medium_medium', 512, 512);
add_image_size('medium_large', 768, 768);
add_image_size('medium_full', 1536, 1536);
add_image_size('full', 2560, 2560);
add_image_size('slider-size', 1920, 1080, true);


register_nav_menu('header', 'Header menu');
register_nav_menu('footer', 'Footer menu');
register_nav_menu('mobile', 'Mobile menu');
