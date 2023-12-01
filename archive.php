<?php
get_header();
include('cpt/config-src-cpt.php');
?>
<main id="main-archive" class="main-archive-<?= $archive_name; ?>">
  <?php include($get_src_taxonomy . '/template.php'); ?>
</main>
<?php get_footer(); ?>