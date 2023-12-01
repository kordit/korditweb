<div class="bg-header">
	<div class="bg-image"></div>
	<div class="bg-overlay"></div>
	<div class="et-container">
		<?php
		echo '<h1 class="bg-title">';
		if (is_home()) {
			_e('Blog');
		} elseif (is_tax()) {
			echo get_queried_object()->name;
		} elseif (is_archive()) {
			if (is_category()) {
				single_cat_title();
			} else {
				post_type_archive_title();
			}
		} elseif (is_page()) {
			the_title();
		} elseif (is_search()) {
			_e('Wyniki wyszukiwania dla: "' . get_query_var('s') . '"');
		} else {
			the_title();
		}
		echo '</h1>';
		if (get_the_archive_description()) {
			echo '<hr>';
			the_archive_description('<div class="bg-taxonomy-description">', '</div>');
		} else {
			the_excerpt();
		}
		?>
	</div>
</div>