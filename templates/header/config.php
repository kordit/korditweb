<?php
if (have_rows('predefined_colors', 'options')) :
  echo ":root {";
  while (have_rows('predefined_colors', 'options')) : the_row();
    $label = get_sub_field('label');
    $color = get_sub_field('color');
    echo PHP_EOL . '    --' . $label . ': ' . $color . ';';
  endwhile;
  echo PHP_EOL . '}' . PHP_EOL;
endif;
if (get_field('header_on')) : get_template_part("templates/header-subpage/config");
endif;
