<div class="test">
    <?php the_field('tytul'); ?>
</div>
<div class="nowy-blok--opis">
    <?php the_field('opis'); ?>
</div>

<div class="nowy-blok--repeater">
    <?php if (have_rows('repeater')) : while (have_rows('repeater')) : the_row(); ?>
            <div class="nowy-blok--repeater--inner">
                <div class="nowy-blok--pole">
                    <?php the_sub_field('pole'); ?>
                </div>
            </div>
    <?php endwhile;
    endif; ?>
</div>


<div class="nowy-blok--slider">
    <div class="splide splide_slider">
        <div class="splide__track">
            <ul class="splide__list">
                <?php if (have_rows('slider')) : while (have_rows('slider')) : the_row(); ?>
                        <li class="splide__slide">
                            <?php et_image('grafika', 'full', false, 'moja-klasa'); ?>
                            <div class="moja-klasa">
                                <?php the_sub_field('tytul'); ?>
                            </div>
                            <?php
                            $images = get_field('galeria_zdjec');
                            $size = 'full';
                            if ($images) :
                                foreach ($images as $image_id) :
                                    $image = wp_get_attachment_image($image_id, $size);
                                    $image_url = wp_get_attachment_image_src($image_id, $size)[0];
                            ?>
                                    <a class="name_library" href="<?= esc_url($image_url); ?>"><?= $image; ?></a>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </li>
                <?php endwhile;
                endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php
$images = get_field('galeria_zdjec');
$size = 'full';
if ($images) :
    foreach ($images as $image_id) :
        $image = wp_get_attachment_image($image_id, $size);
        $image_url = wp_get_attachment_image_src($image_id, $size)[0];
?>
        <a class="name_library" href="<?= esc_url($image_url); ?>"><?= $image; ?></a>
<?php
    endforeach;
endif;
?>
<a href="mailto:<?php the_field('mail'); ?>" class="nowy-blok--mail">
    <?php the_field('mail'); ?>
</a>
<div class="nowy-blok--testowe_cpt">
    <?php the_field('testowe_cpt'); ?>
</div>
<div class="nowy-blok--testowa_liczba">
    <?php the_field('testowa_liczba'); ?>
</div>
<a href="<?php the_field('testowy_url'); ?>" class="nowy-blok--testowy_url">
    <?php the_field('testowy_url'); ?>
</a>