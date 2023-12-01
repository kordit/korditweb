<?php

# Add defer to all scripts
function prefix_add_defer_attribute($tag, $handle)
{
	if ('google-recaptcha' !== $handle) {
		return $tag;
	}
	if (false === strpos($tag, 'defer ') && false === strpos($tag, ' defer')) {
		$tag = str_replace('src=', 'defer src=', $tag);
	}
	return $tag;
}
add_filter('script_loader_tag', 'prefix_add_defer_attribute', 10, 2);

#	Remove type from sricpts
function myplugin_remove_type_attr($tag, $handle)
{
	return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}
add_filter('style_loader_tag', 'myplugin_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'myplugin_remove_type_attr', 10, 2);

# Remove emoji
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
	if ('dns-prefetch' == $relation_type) {
		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
		$urls = array_diff($urls, array($emoji_svg_url));
	}
	return $urls;
}

# Remove jQuery migrate
function remove_jquery_migrate($scripts)
{
	if (!is_admin() && isset($scripts->registered['jquery'])) {
		$script = $scripts->registered['jquery'];
		if ($script->deps) {
			$script->deps = array_diff($script->deps, array('jquery-migrate'));
		}
	}
}
add_action('wp_default_scripts', 'remove_jquery_migrate');

if (!is_admin()) {
	function wps_deregister_styles()
	{
		wp_dequeue_style('global-styles');
	}
	add_action('wp_enqueue_scripts', 'wps_deregister_styles', 100);
	function remove_unwanted_css_and_js()
	{
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('wc-block-style');
		wp_deregister_script('wp-embed');
		wp_deregister_script('jquery');
	}
	add_action('wp_enqueue_scripts', 'remove_unwanted_css_and_js', 100);
}

#	Disable Emojis on frontend
function disable_wp_emojicons()
{
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
add_action('init', 'disable_wp_emojicons');

#	Disable Emojis on backend
function disable_emojicons_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

# Disable Dashicons on frontend
function wpdocs_dequeue_dashicon()
{
	if (current_user_can('update_core')) {
		return;
	}
	wp_deregister_style('dashicons');
}
add_action('wp_enqueue_scripts', 'wpdocs_dequeue_dashicon');

# Disable Embeds
function disable_embeds_init()
{
	global $wp;
	$wp->public_query_vars = array_diff($wp->public_query_vars, array(
		'embed',
	));
	remove_action('rest_api_init', 'wp_oembed_register_route');
	add_filter('embed_oembed_discover', '__return_false');
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
	add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
}
add_action('init', 'disable_embeds_init', 9999);

function disable_embeds_tiny_mce_plugin($plugins)
{
	return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules)
{
	foreach ($rules as $rule => $rewrite) {
		if (false !== strpos($rewrite, 'embed=true')) {
			unset($rules[$rule]);
		}
	}
	return $rules;
}

function disable_embeds_remove_rewrite_rules()
{
	add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'disable_embeds_remove_rewrite_rules');

function disable_embeds_flush_rewrite_rules()
{
	remove_filter('rewrite_rules_array', 'disable_embeds_rewrites');
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'disable_embeds_flush_rewrite_rules');

#	Disable RSS feeds
function fb_disable_feed()
{
	wp_die(__('No feed available,please visit our <a href="' . esc_url(home_url('/')) . '">homepage</a>!'));
}
add_action('do_feed', 'fb_disable_feed', 1);
add_action('do_feed_rdf', 'fb_disable_feed', 1);
add_action('do_feed_rss', 'fb_disable_feed', 1);
add_action('do_feed_rss2', 'fb_disable_feed', 1);
add_action('do_feed_atom', 'fb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'fb_disable_feed', 1);
add_action('do_feed_atom_comments', 'fb_disable_feed', 1);

# Remove RSS Feed Links
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

# Disable Self Pingbacks
function disable_self_ping(&$links)
{
	$home = get_option('home');
	foreach ($links as $l => $link)
		if (0 === strpos($link, $home))
			unset($links[$l]);
}
add_action('pre_ping', 'disable_self_ping');

# Disable REST API when logged out
// add_filter('rest_authentication_errors', function ($result) {
// 	if (!empty($result)) {
// 		return $result;
// 	}
// 	if (!is_user_logged_in()) {
// 		return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', array('status' => 401));
// 	}
// 	return $result;
// });

# Remove Rest API Links
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

# Disable Password Strength Meter
function disable_password_strength_meter()
{
	wp_dequeue_script('wc-password-strength-meter');
}
add_action('wp_print_scripts', 'disable_password_strength_meter', 100);

# Disable Comments
function disable_comments_status()
{
	return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

function disable_comments_hide_existing_comments($comments)
{
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

function disable_comments_admin_menu()
{
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

function disable_comments_admin_menu_redirect()
{
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
}
add_action('admin_init', 'disable_comments_admin_menu_redirect');

function disable_comments_dashboard()
{
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'disable_comments_dashboard');

function disable_comments_admin_bar()
{
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'disable_comments_admin_bar');

/* Removes from admin bar */
function mytheme_admin_bar_render()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'mytheme_admin_bar_render');

# Disable Comments URLs
function disable_comments_url($url)
{
	return '#';
}
add_filter('get_comments_pagenum_link', 'disable_comments_url');

# Disable Comments Feed
function disable_comments_feed()
{
	wp_die(__('No feed available,please visit our <a href="' . esc_url(home_url('/')) . '">homepage</a>!'));
}
add_action('do_feed_rss2_comments', 'disable_comments_feed', 1);
add_action('do_feed_atom_comments', 'disable_comments_feed', 1);

# Disable Comments Post Types
function disable_comments_post_types_support()
{
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'disable_comments_post_types_support');
