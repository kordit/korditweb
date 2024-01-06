<?php
$et_id = '';
$et_background_section = '';
$et_overlay_section = '';
if (have_rows('ustawienia_ulozenia')) {
        while (have_rows('ustawienia_ulozenia')) { 
                the_row();
                $et_id_section = get_sub_field('kotwica') ?: '';
                $et_type_section = get_sub_field('typ_tla') ?: '';
                $et_background_section = get_sub_field('tlo_graficzne') ?: '';
                $et_poster_section = get_sub_field('poster') ?: '';
                $et_video_section = get_sub_field('video') ?: '';
                $et_overlay_section = get_sub_field('overlay') ?: '';
                $et_mix_blendmode_section = get_sub_field('typ_mieszania') ?: '';
                $type_mix_blend = get_sub_field('type_mix_blend') ?: '';
        }
}
$all_block_values = array(
        'id_section' => $et_id_section,
        'type' => $et_type_section,
        'background_image' => $et_background_section,
        'poster' => $et_poster_section,
        'video_url' => $et_video_section,
        'overlay' => $et_overlay_section,
        'mix_blend_mode' => $et_mix_blendmode_section,
        'type_mix_blend' => $type_mix_blend
);

