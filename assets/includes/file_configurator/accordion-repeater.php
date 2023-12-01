<?php
$type_field .= PHP_EOL . '<div class="' . $classname . '--' . $namerepeater . '">' . PHP_EOL . '<div class="et_accordion et_accordion_' . $namerepeater . '">' . PHP_EOL . '<?php ' . "if(have_rows( '" . $namerepeater . "' )): while( have_rows('" . $namerepeater . "')): the_row();" . '?>' . PHP_EOL . '<div class="et_accordion__single-wrapper is-contracted">' . PHP_EOL;
$i = 0;
foreach ($repeater as $index_repeater) {
	$type_field .= et_get_fields_acf($index_repeater, 2, $classname);
}
$type_field .= '</div>' . PHP_EOL . '<?php ' . "endwhile; endif;" . '?>' . PHP_EOL . '</div>' . PHP_EOL . '</div>' . PHP_EOL . PHP_EOL;
