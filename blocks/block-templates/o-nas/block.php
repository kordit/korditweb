<?php 
$srcdir = dirname(__FILE__);
$srctemplate = "$srcdir/assets/template.php";
$srcdirParts = explode("/", $srcdir);
$lastsrc = "/blocks/{$srcdirParts[count($srcdirParts) - 2]}/{$srcdirParts[count($srcdirParts) - 1]}";
$namesrc = "{$srcdirParts[count($srcdirParts) - 1]}";
include(get_template_directory() . "/blocks/layout.php");
isset($GLOBALS["counter-section"]) || $GLOBALS["counter-section"] = 1;
$counter = $GLOBALS["counter-section"];

$additional = array(
	'src_dir' => $srcdir,
	'src_template' => $srctemplate,
	'last_src' => $lastsrc,
	'name_src' => $namesrc,
	'container' => 'et-container',
	'counter_section' => $counter,
	'defined_vars' => get_defined_vars(),
	'srctemplate' => $srctemplate
);
$all_block_values = array_merge($all_block_values, $additional);
et_start_section($all_block_values);

$GLOBALS["counter-section"] = $GLOBALS["counter-section"] + 1;
add_css_theme($namesrc, $lastsrc .  "/assets/style.css");
add_js_theme($namesrc, $lastsrc .  "/assets/script.js");
if(is_admin()) {
	add_action('enqueue_block_editor_assets', function () use(&$namesrc, $lastsrc) {
		et_lib_splide(true);
		add_css_theme($namesrc, $lastsrc .  "/assets/style.css");
		add_js_theme($namesrc, $lastsrc .  "/assets/script.js");
	});
}
?>
