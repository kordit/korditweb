<div class="hero--slider">
	<div class="splide splide_slider">
		<div class="splide__track">
			<ul class="splide__list">
				<?php if(have_rows( 'slider' )): while( have_rows('slider')): the_row();?>
					<li class="splide__slide">
						<div class="et-container">
							<div class="left">
								<div class="hero-title">
									<?php the_sub_field('tytul');?>
								</div>
								<div class="desc-hero">
									<?php the_sub_field('desc');?>
								</div>
								<div class="btn-wrapper">
									<?php et_link("link_1", "button"); ?>
									<?php et_link("link_2", "button white"); ?>
								</div>
							</div>
						</div>	
						<?php et_image("grafika","full",false,"hero--grafika"); ?>
					</li>
				<?php endwhile; endif;?>
			</ul>
		</div>
	</div>
</div>
