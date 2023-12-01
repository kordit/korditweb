<div class="smaller">
	FAQ
</div>
<div class="section-title">
	<?php the_field('tytul');?>
</div>

<div class="faq--faq">
	<div class="et_accordion et_accordion_faq">
		<?php if(have_rows( 'faq' )): while( have_rows('faq')): the_row();?>
			<div class="et_accordion__single-wrapper is-contracted">
				<div class="faq--tytul">
					<?php the_sub_field('tytul');?>
				</div>
				<div class="desc">
					<?php the_sub_field('opis');?>
				</div>
			</div>
		<?php endwhile; endif;?>
	</div>
</div>

