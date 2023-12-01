/usr/home/thesuit1995/domains/brrg.ergotree.pl/public_html/wp-content/themes/ergotree/cpt/cpt-templates/post/tax-post_tag
<div class="et-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
<?php

if ( have_posts() ) :
while ( have_posts() ) : 
the_post();
include("post-template.php");
endwhile;
endif; ?>
</div>
<?php echo get_the_posts_pagination(); ?>
