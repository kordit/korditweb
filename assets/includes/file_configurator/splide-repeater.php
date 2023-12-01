<?php
$type_field .= PHP_EOL . '<div class="' . $classname . '--' . $namerepeater . '">' . PHP_EOL . '<div class="splide splide_' . $namerepeater . '">' . PHP_EOL . '<div class="splide__track">' . PHP_EOL . '<ul class="splide__list">' . PHP_EOL . '<?php ' . "if(have_rows( '" . $namerepeater . "' )): while( have_rows('" . $namerepeater . "')): the_row();" . '?>' . PHP_EOL . '<li class="splide__slide">' . PHP_EOL;
$i = 0;
foreach ($repeater as $index_repeater) {
	$type_field .= et_get_fields_acf($index_repeater, 2, $classname);
}
$type_field .= '</li>' . PHP_EOL . '<?php ' . "endwhile; endif;" . '?>' . PHP_EOL . '</ul>' . PHP_EOL . '</div>' . PHP_EOL . '</div>' . PHP_EOL . '</div>' . PHP_EOL;
