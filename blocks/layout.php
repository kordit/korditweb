<?php
$et_id = '';
$et_background_section = '';
$et_overlay_section = '';
if (have_rows('ustawienia_ulozenia')) : while (have_rows('ustawienia_ulozenia')) : the_row();
        $et_id = get_sub_field('kotwica') ?: '';
        $et_background_section = get_sub_field('tlo_graficzne');
        $et_overlay_section = get_sub_field('overlay');
    endwhile;
endif;
