<?php if (get_field('grafika')) : ?>
    <div class="right">
        <?php et_image("grafika", "full", false, "after-hero--grafika"); ?>
        <div class="heading-1">
            <?php the_field('podpis'); ?>
        </div>
    </div>
<?php endif ?>
<div class="left">
    <div class="heading-2">
        <?php the_field('tytul'); ?>
    </div>
    <div class="desc">
        <?php the_field('tresc'); ?>
    </div>
    <div class="heading-4">
        <?php the_field('dodatkowy_tytul'); ?>
    </div>
    <div class="after-hero--linki">
        <?php if (have_rows('linki')) : while (have_rows('linki')) : the_row(); ?>
                <div class="after-hero--linki--inner">
                    <div class="btn-wrapper">
                        <?php et_link('link_inner', 'btn-rounded'); ?>
                    </div>
                </div>
        <?php endwhile;
        endif; ?>
    </div>

    <div class="btn-wrapper">
        <?php et_link('link', 'btn-theme'); ?>
    </div>

</div>