<?php
$args = array(
    'post_type' => 'realizacje',
    'posts_per_page' => -1,
);

$moj_cpt_query = new WP_Query($args);

if ($moj_cpt_query->have_posts()) :
    while ($moj_cpt_query->have_posts()) : $moj_cpt_query->the_post();
 $fields = get_fields(get_the_ID());
  if ($fields) {
     acf_setup_meta($fields, get_the_ID(), true);
  }
        <?php the_post_thumbnail(); ?>
        <?php the_title(); ?>
<div class="jakis-dodatkowy-blok--cena">
<?php the_field('cena'); ?>
</div>
<?php et_image('grafika', 'full', false, 'jakis-dodatkowy-blok--grafika'); ?>
<div class="btn-wrapper">
<?php et_link('link', 'jakis-dodatkowy-blok--link'); ?>
</div>
<div class="jakis-dodatkowy-blok--ulepszony_tytul">
<?php the_field('ulepszony_tytul'); ?>
</div>
<?php
    endwhile;
    wp_reset_postdata();
else :
    echo 'Nie znaleziono postów.';
endif;
?>