<?php
get_header();
include('cpt/config-src-cpt.php');
?>
<main id="main-search" class="main-search-<?= $source_cpt ?>">
	<?php include($get_src_taxonomy . '/template.php'); ?>
</main>
<?php get_footer(); ?>