<div class="slider--slider">
	<div class="splide splide_slider">
		<div class="splide__track">
			<ul class="splide__list">
				<?php if(have_rows( 'slider' )): while( have_rows('slider')): the_row();?>
					<li class="splide__slide">
						<?php et_image("background_slide","slider-size",false,"slider--background_slide"); ?>
						<div class="content">
							<div class="et-container">		
								<div class="heading-1">
									<?php the_sub_field('title');?>
								</div>
								<div class="desc">
									<?php the_sub_field('description');?>
								</div>
								<div class="btn-wrapper">
									<?php et_link("button", "btn-theme"); ?>
								</div>
							</div>
						</div>
					</li>
				<?php endwhile; endif;?>
			</ul>
		</div>
	</div>
</div>
