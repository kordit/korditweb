<?php
$type_field = '';

// Generowanie nagłówków zakładek
$type_field .= '<div class="navigation">' . PHP_EOL;
$type_field .= '<?php' . PHP_EOL;
$type_field .= 'if (have_rows("' . $namerepeater . '")) :' . PHP_EOL;
$type_field .= '$x = 0;' . PHP_EOL;
$type_field .= '    while (have_rows("' . $namerepeater . '")) : the_row(); ?>' . PHP_EOL;
$x = 0;
foreach ($repeater as $index_repeater) {
    if ($x == 0) {
        $type_field .= '<div class="single-navi" data-template="' . $classname . '-tab-<?= $x ?>">' . PHP_EOL;
        // $classname = $classname . ' single-navigation single-navigation-';
        $type_field .= et_get_fields_acf($index_repeater, 2, $classname);
        $type_field .= '</div>' . PHP_EOL;
    }
    $x++;
}
$type_field .= '<?php $x++; endwhile; endif; ?>' . PHP_EOL;
$type_field .= '</div>' . PHP_EOL;

// Generowanie treści zakładek
$type_field .= '<div class="all-tab">' . PHP_EOL;
$type_field .= '<?php' . PHP_EOL;
$type_field .= '$y = 0;' . PHP_EOL;
$type_field .= 'if (have_rows("' . $namerepeater . '")) :' . PHP_EOL;
$type_field .= '    while (have_rows("' . $namerepeater . '")) :' . PHP_EOL;
$type_field .= '        the_row();' . PHP_EOL;
$type_field .= '?>' . PHP_EOL;
$type_field .= '<div class="single-tab" id="' . $classname . '-tab-<?= $y ?>">' . PHP_EOL;
foreach ($repeater as $index_repeater) {
    $type_field .= et_get_fields_acf($index_repeater, 2, $classname);
}
$type_field .= '</div>' . PHP_EOL;
$type_field .= '<?php $y++; endwhile;endif; ?>' . PHP_EOL;
$type_field .= '</div>' . PHP_EOL;

return $type_field;
