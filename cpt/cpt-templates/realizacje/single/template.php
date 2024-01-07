<?php include("config.php"); ?>
<h1>realizacje</h1>
Plik można edytować w <b>"/usr/home/huximo/domains/beta.huximo.pl/public_html/wp-content/themes/korditweb/cpt/cpt-templates/realizacje/single//assets/template.php"</b>

<?php the_post_thumbnail(); ?>
<?php the_title(); ?>
<?php the_content(); ?>
<?= get_the_date(); ?>
<?php $author = get_the_author_meta(); ?>
