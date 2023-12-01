<?php 
$srcdir = dirname(__FILE__);
$srctemplate = $srcdir . "/assets/template.php";
$srcdir = explode("/", $srcdir);
$srcdir = array_reverse($srcdir);
$containername = "et-container";
$lastsrc = "/blocks/" . $srcdir[1] . "/" . $srcdir[0];
$namesrc = $srcdir[0] ."-" . $srcdir[1];
include(get_template_directory() . "/blocks/layout.php");
isset($GLOBALS["counter-section"]) || $GLOBALS["counter-section"] = 0;
et_start_section($srcdir[0], $srctemplate, get_defined_vars(), $et_id, $et_background_section, $et_overlay_section,$GLOBALS["counter-section"],$containername);
$GLOBALS["counter-section"] = $GLOBALS["counter-section"] + 1;
add_css_theme($namesrc, $lastsrc .  "/assets/style.css");
add_js_theme($namesrc, $lastsrc .  "/assets/script.js");
if(is_admin()) {
add_action('enqueue_block_editor_assets', function () use(&$namesrc, $lastsrc) {
add_css_theme($namesrc, $lastsrc .  "/assets/style.css");
add_js_theme($namesrc, $lastsrc .  "/assets/script.js");
});
}
?>
