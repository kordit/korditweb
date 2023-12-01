<?php
$dataloop = '' . PHP_EOL;
$dataloop .= '<div class="et-container" style="display: flex; flex-wrap: wrap; justify-content: center;">' . PHP_EOL;
$dataloop .= '<?php' . PHP_EOL;
$dataloop .= PHP_EOL;
$dataloop .= 'if ( have_posts() ) :' . PHP_EOL;
$dataloop .= 'while ( have_posts() ) : ' . PHP_EOL;
$dataloop .= 'the_post();' . PHP_EOL;
$dataloop .= 'include("post-template.php");' . PHP_EOL;
$dataloop .= 'endwhile;' . PHP_EOL;
$dataloop .= 'endif; ?>' . PHP_EOL;
$dataloop .= '</div>';
$dataloop .= PHP_EOL;
$dataloop .= '<?php echo get_the_posts_pagination(); ?>' . PHP_EOL;

$postloop = '<div class="single-post-wrapper" style="width: 30%;">' . PHP_EOL;
$postloop .= '<?php the_post_thumbnail(); ?>' . PHP_EOL;
$postloop .= '<a href="<?= get_permalink(); ?>"><?php the_title(); ?></a>' . PHP_EOL;
$postloop .= '</div>';

$searchloop = '' . PHP_EOL;
$searchloop .= '<div class="et-container" style="display: flex; flex-wrap: wrap; justify-content: center;">' . PHP_EOL;
$searchloop .= '<?php' . PHP_EOL;
$searchloop .= PHP_EOL;
$searchloop .= 'if ( have_posts() ) :' . PHP_EOL;
$searchloop .= 'while ( have_posts() ) : ' . PHP_EOL;
$searchloop .= 'the_post();' . PHP_EOL;
$searchloop .= 'include("post-template.php");' . PHP_EOL;
$searchloop .= 'endwhile;' . PHP_EOL;
$searchloop .= 'else: ?>' . PHP_EOL;
$searchloop .= '<h2 style="font-weight:bold;color:#000">Nic nie znaleziono</h2>' . PHP_EOL;
$searchloop .= '<p>Przepraszamy, na powyższą frazę nie ma wyników. Proszę spróbuj z innym słowem kluczowym.</p>' . PHP_EOL;
$searchloop .= '<?php endif; ?>' . PHP_EOL;
$searchloop .= '</div>';
$searchloop .= PHP_EOL;
$searchloop .= '<?php echo get_the_posts_pagination(); ?>' . PHP_EOL;
