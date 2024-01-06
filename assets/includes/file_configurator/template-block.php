<?php
$libs = '';
$styles = '';
if (in_array('1', $active_num_library)) {
	$libs .= 'et_lib_splide(true);' . PHP_EOL;
} elseif (in_array('2', $active_num_library)) {
	$libs .= 'et_lib_accordion(true);' . PHP_EOL;
} elseif (in_array('3', $active_num_library)) {
	$libs .= 'et_lib_halka(true);' . PHP_EOL;
} else {
	$libs = '';
}

$datablock = '<?php ' . PHP_EOL;
$datablock .= '$srcdir = dirname(__FILE__);' . PHP_EOL;
$datablock .= '$srctemplate = "$srcdir/assets/template.php";' . PHP_EOL;
$datablock .= '$srcdirParts = explode("/", $srcdir);' . PHP_EOL;
$datablock .= '$lastsrc = "/blocks/{$srcdirParts[count($srcdirParts) - 2]}/{$srcdirParts[count($srcdirParts) - 1]}";' . PHP_EOL;
$datablock .= '$namesrc = "{$srcdirParts[count($srcdirParts) - 1]}";' . PHP_EOL;
$datablock .= 'include(get_template_directory() . "/blocks/layout.php");' . PHP_EOL;
$datablock .= 'isset($GLOBALS["counter-section"]) || $GLOBALS["counter-section"] = 1;' . PHP_EOL;
$datablock .= '$counter = $GLOBALS["counter-section"];' . PHP_EOL;
$datablock .= PHP_EOL . PHP_EOL;
$datablock .= '$additional = array(' . PHP_EOL;
$datablock .= '"src_dir" => $srcdir,' . PHP_EOL;
$datablock .= '"src_template" => $srctemplate,' . PHP_EOL;
$datablock .= '"last_src" => $lastsrc,' . PHP_EOL;
$datablock .= '"name_src" => $namesrc,' . PHP_EOL;
$datablock .= '"container" => "et-container",' . PHP_EOL;
$datablock .= '"counter_section" => $counter,' . PHP_EOL;
$datablock .= '"defined_vars" => get_defined_vars(),' . PHP_EOL;
$datablock .= '"srctemplate" => $srctemplate' . PHP_EOL;
$datablock .= ');' . PHP_EOL;
$datablock .= '$all_block_values = array_merge($all_block_values, $additional);' . PHP_EOL;
$datablock .= 'et_start_section($all_block_values);' . PHP_EOL;
$datablock .= PHP_EOL . PHP_EOL;
$datablock .= '$GLOBALS["counter-section"] = $GLOBALS["counter-section"] + 1;' . PHP_EOL;
$datablock .= $libs;
$datablock .= 'add_css_theme($namesrc, $lastsrc .  "/assets/style.css");' . PHP_EOL;
$datablock .= 'add_js_theme($namesrc, $lastsrc .  "/assets/script.js");' . PHP_EOL;
$datablock .= 'if(is_admin()) {' . PHP_EOL;
$datablock .= 'add_action("enqueue_block_editor_assets", function () use(&$namesrc, $lastsrc) {' . PHP_EOL;
$datablock .= $libs;
$datablock .= 'add_css_theme($namesrc, $lastsrc .  "/assets/style.css");' . PHP_EOL;
$datablock .= 'add_js_theme($namesrc, $lastsrc .  "/assets/script.js");' . PHP_EOL;
$datablock .= '});' . PHP_EOL;
$datablock .= '}' . PHP_EOL;
