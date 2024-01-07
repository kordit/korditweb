<?php
$args = array(
    'post_type' => 'realizacje',
    'posts_per_page' => -1,
);

$moj_cpt_query = new WP_Query($args);

if ($moj_cpt_query->have_posts()) :
    while ($moj_cpt_query->have_posts()) : $moj_cpt_query->the_post();
        setup_postdata(get_post());
?>
       
<?php
    endwhile;
    wp_reset_postdata();
else :
    echo 'Nie znaleziono postów.';
endif;
?>