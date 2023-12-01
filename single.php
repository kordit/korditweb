<?php get_header();
include('cpt/config-src-cpt.php');
?>
<main class="single-<?= $post_type; ?>">
	<?php include(get_template_directory() . '/cpt/cpt-templates/' . $post_type . '/single/template.php') ?>
</main>
<?php get_footer(); ?>