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
$datablock .= '$srctemplate = $srcdir . "/assets/template.php";'  . PHP_EOL;
$datablock .= '$srcdir = explode("/", $srcdir);' . PHP_EOL;
$datablock .= '$srcdir = array_reverse($srcdir);' . PHP_EOL;
$datablock .= '$containername = "et-container";' . PHP_EOL;
$datablock .= '$lastsrc = "/blocks/" . $srcdir[1] . "/" . $srcdir[0];' . PHP_EOL;
$datablock .= '$namesrc = $srcdir[0] ."-" . $srcdir[1];' . PHP_EOL;
$datablock .= 'include(get_template_directory() . "/blocks/layout.php");' . PHP_EOL;
$datablock .= 'isset($GLOBALS["counter-section"]) || $GLOBALS["counter-section"] = 0;' . PHP_EOL;
$datablock .= 'et_start_section($srcdir[0], $srctemplate, get_defined_vars(), $et_id, $et_background_section, $et_overlay_section,$GLOBALS["counter-section"],$containername);' . PHP_EOL;
$datablock .= '$GLOBALS["counter-section"] = $GLOBALS["counter-section"] + 1;' . PHP_EOL;
$datablock .= $libs;
$datablock .= 'add_css_theme($namesrc, $lastsrc .  "/assets/style.css");' . PHP_EOL;
$datablock .= 'add_js_theme($namesrc, $lastsrc .  "/assets/script.js");' . PHP_EOL;
$datablock .= 'if(is_admin()) {' . PHP_EOL;
$datablock .= "add_action('enqueue_block_editor_assets', function () use(&" . '$namesrc, $lastsrc) {' . PHP_EOL;
$datablock .= $libs;
$datablock .= 'add_css_theme($namesrc, $lastsrc .  "/assets/style.css");' . PHP_EOL;
$datablock .= 'add_js_theme($namesrc, $lastsrc .  "/assets/script.js");' . PHP_EOL;
$datablock .= '});' . PHP_EOL;
$datablock .= '}' . PHP_EOL;
$datablock .= '?>' . PHP_EOL;
