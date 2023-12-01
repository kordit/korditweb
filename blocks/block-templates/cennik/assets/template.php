<div class="desc">
	<?php the_field('opis');?>
</div>

<div class="cennik--repeater">
	<?php if(have_rows( 'repeater' )): while( have_rows('repeater')): the_row();?>
		<div class="cennik--repeater--inner">
			<?php et_image("grafika","full",false,"cennik--grafika"); ?>
			<div class="cennik--tytul">
				<?php the_sub_field('tytul');?>
			</div>
			<div class="desc">
				<?php the_sub_field('opis');?>
			</div>
			<div class="btn-wrapper">
				<?php et_link("link", "cennik--link"); ?>
			</div>
		</div>
	<?php endwhile; endif;?>
</div>


<div class="cennik--tabela">
	<?php if(have_rows( 'tabela' )): while( have_rows('tabela')): the_row();?>
		<div class="cennik--tabela--inner">
			<div class="cennik--etykieta_tabeli">
				<?php the_sub_field('etykieta_tabeli');?>
			</div>

			<div class="cennik--pozycje">
				<?php if(have_rows( 'pozycje' )): while( have_rows('pozycje')): the_row();?>
					<div class="cennik--pozycje--inner type-<?= get_sub_field('typ_pol'); ?>">
						<?php if (get_sub_field('typ_pol') == 1): ?>
							<div class="cennik--etykieta">
								<?php the_sub_field('etykieta');?>
							</div>
							<div class="cennik--wartosc">
								<?php the_sub_field('wartosc');?>
							</div>
						<?php else: ?>
							<div class="cennik--dodatkowy_opis">
								<?php the_sub_field('dodatkowy_opis');?>
							</div>
						<?php endif ?>
					</div>
				<?php endwhile; endif;?>
			</div>

		</div>
	<?php endwhile; endif;?>
</div>

