
<div class="et-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
<?php

if ( have_posts() ) :
while ( have_posts() ) : 
the_post();
include("post-template.php");
endwhile;
else: ?>
<h2 style="font-weight:bold;color:#000">Nic nie znaleziono</h2>
<p>Przepraszamy, na powyższą frazę nie ma wyników. Proszę spróbuj z innym słowem kluczowym.</p>
<?php endif; ?>
</div>
<?php echo get_the_posts_pagination(); ?>
