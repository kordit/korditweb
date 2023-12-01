<?php
remove_action('wp_head', 'wp_generator');
function my_secure_generator($generator, $type)
{
	return '';
}
add_filter('the_generator', 'my_secure_generator', 10, 2);

function my_remove_src_version($src)
{
	global $wp_version;

	$version_str = '?ver=' . $wp_version;
	$offset = strlen($src) - strlen($version_str);

	if ($offset >= 0 && strpos($src, $version_str, $offset) !== FALSE)
		return substr($src, 0, $offset);

	return $src;
}
add_filter('script_loader_src', 'my_remove_src_version');
add_filter('style_loader_src', 'my_remove_src_version');

add_filter('xmlrpc_enabled', '__return_false');

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
