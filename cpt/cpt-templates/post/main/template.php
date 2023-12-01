
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
