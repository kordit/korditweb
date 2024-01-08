<?php include("config.php"); ?>
<h1>post</h1>
Plik można edytować w <b>"/usr/home/huximo/domains/beta.huximo.pl/public_html/wp-content/themes/korditweb/cpt/cpt-templates/post/single//assets/template.php"</b>

<?php the_post_thumbnail(); ?>
<?php the_title(); ?>
<?php the_content(); ?>
<?= get_the_date(); ?>
<?php $author = get_the_author_meta(); ?>
<?php if($current_terms_category) : ?>
<?php echo "<h2>" . get_taxonomy($current_terms_category[0]->taxonomy)->label . ": </h2>"; ?>
<?php foreach ($current_terms_category as $single) {
echo "<span>" . $single->name . "</span>";
}; ?>
<?php endif; ?>
<?php et_the_list_term($all_terms_category,$current_terms_category); ?>
<?php if($current_terms_post_tag) : ?>
<?php echo "<h2>" . get_taxonomy($current_terms_post_tag[0]->taxonomy)->label . ": </h2>"; ?>
<?php foreach ($current_terms_post_tag as $single) {
echo "<span>" . $single->name . "</span>";
}; ?>
<?php endif; ?>
<?php et_the_list_term($all_terms_post_tag,$current_terms_post_tag); ?>
