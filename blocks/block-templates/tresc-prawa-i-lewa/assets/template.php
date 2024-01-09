
<div class="tresc-prawa-i-lewa--tresc_po_lewej">
<?php if(have_rows( 'tresc_po_lewej' )): while( have_rows('tresc_po_lewej')): the_row();?>
<div class="tresc-prawa-i-lewa--tresc_po_lewej--inner">
<div class="heading-3">
<?php the_sub_field('tytul'); ?>
</div>
<div class="desc">
<?php the_sub_field('opis'); ?>
</div>
<div class="btn-wrapper">
<?php et_link('link', 'btn-round white'); ?>
</div>
</div>
<?php endwhile; endif;?>
</div>


<div class="tresc-prawa-i-lewa--tresc_po_prawej">
<?php if(have_rows( 'tresc_po_prawej' )): while( have_rows('tresc_po_prawej')): the_row();?>
<div class="tresc-prawa-i-lewa--tresc_po_prawej--inner">
<div class="heading-3">
<?php the_sub_field('tytul'); ?>
</div>
<div class="desc">
<?php the_sub_field('opis'); ?>
</div>
<div class="btn-wrapper">
<?php et_link('link', 'btn-round white'); ?>
</div>
</div>
<?php endwhile; endif;?>
</div>

