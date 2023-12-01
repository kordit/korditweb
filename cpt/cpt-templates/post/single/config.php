<?php 
//Wyświetla wszystkie termy (category)
$all_terms_category = get_terms( array( 
"taxonomy" => "category", "hide_empty" => false) );

//Wyświetla aktualnie przypisanego terma (category)
$current_terms_category = get_the_terms( get_the_ID(), "category" );
 ?>

<?php 
//Wyświetla wszystkie termy (post_tag)
$all_terms_post_tag = get_terms( array( 
"taxonomy" => "post_tag", "hide_empty" => false) );

//Wyświetla aktualnie przypisanego terma (post_tag)
$current_terms_post_tag = get_the_terms( get_the_ID(), "post_tag" );
 ?>

