<div class="wrapper">
	<div class="heading-1">
		<?php the_field('tytul');?>
	</div>
	<div class="desc">
		<?php the_field('podpis');?>
	</div>
	<div class="kontakt--formularz">
		<?= et_form(get_field('formularz')->ID);?>
	</div>

</div>