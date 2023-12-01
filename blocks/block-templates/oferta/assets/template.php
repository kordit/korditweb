<div class="section-title">
	<?php the_field('title'); ?>
</div>
<div class="description">
	<?php the_field('opis');?>
</div>
<div class="posts-wrapper">
	<?php
	$featured_posts = get_field("relacja");
	if( $featured_posts ):

		foreach( $featured_posts as $post ):
			setup_postdata($post); ?>
			<div class="single-element">
				<div class="thumbnail">
					<?= get_the_post_thumbnail($post->ID); ?>
				</div>
				<div class="wrap">
					<div class="heading-1">
						<?= get_the_title($post->ID); ?>
					</div>	
					<div class="desc white">
						<?= get_the_excerpt($post->ID); ?>
					</div>
					<a class="button white" href="<?= get_permalink($post->ID); ?>">WIĘCEJ
					</a>
				</div>
			</div>
			<?php
		endforeach;
		wp_reset_postdata();
	endif; ?>
</div>