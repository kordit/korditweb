<div class="heading-2">
    <?php the_field('tytul'); ?>
</div>
<div class="heading-5">
    <?php the_field('subtytul'); ?>
</div>
<div class="desc">
    <?php the_field('opis'); ?>
</div>
<div class="wrap-blog">
    <?php
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
    );

    $moj_cpt_query = new WP_Query($args);

    if ($moj_cpt_query->have_posts()) :
        while ($moj_cpt_query->have_posts()) : $moj_cpt_query->the_post();
            $fields = get_fields(get_the_ID());
            if ($fields) {
                acf_setup_meta($fields, get_the_ID(), true);
            } ?>
            <div class="single-item">
                <?php the_post_thumbnail(); ?>
                <div class="heading-5 bold">
                    <?php the_title(); ?>
                </div>
                <div class="desc">
                    <?php the_excerpt(); ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="btn-rounded">Czytaj więcej</a>
            </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Nie znaleziono postów.';
    endif;
    ?>
</div>