<div class="test">
	<?php the_field('tytul'); ?>
</div>
<div class="nowy-blok__opis">
	<?php the_field('opis'); ?>
</div>

<div class="nowy-blok--repeater">
	<?php if(have_rows( 'repeater' )): while( have_rows('repeater')): the_row();?>
		<div class="nowy-blok--repeater--inner">
			<div class="nowy-blok__pole">
				<?php the_sub_field('pole'); ?>
			</div>
		</div>
	<?php endwhile; endif;?>
</div>


<div class="nowy-blok--slider">
	<div class="splide splide_slider">
		<div class="splide__track">
			<ul class="splide__list">
				<?php if(have_rows( 'slider' )): while( have_rows('slider')): the_row();?>
					<li class="splide__slide">
						<?php et_image('grafika', 'full', false, 'moja-klasa'); ?>
						<div class="moja-klasa">
							<?php the_sub_field('tytul'); ?>
						</div>
						<?php $images = get_sub_field('gallery'); $size = 'full'; if( $images ): ?>
						<?php foreach( $images as $image_id ): ?>
							<?php echo wp_get_attachment_image( $image_id, $size ); ?>
						<?php endforeach; endif; ?>
					</li>
				<?php endwhile; endif;?>
			</ul>
		</div>
	</div>
</div>
<?php $images = get_field('galeria_zdjec'); $size = 'full'; if( $images ): ?>
<?php foreach( $images as $image_id ): ?>
	<?php echo wp_get_attachment_image( $image_id, $size ); ?>
<?php endforeach; endif; ?>
<div class="">
	<?php the_field(''); ?>
</div>
<a href="mailto:<?php the_field('mail'); ?>" class="nowy-blok__mail">
	<?php the_field('mail'); ?>
</a>
