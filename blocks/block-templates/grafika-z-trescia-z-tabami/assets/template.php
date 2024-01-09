<div class="top">
    <div class="et-container">
        <?php et_image('grafika', 'full', false, 'grafika-z-trescia-z-tabami--grafika'); ?>
        <div class="right">
            <div class="heading-2">
                <?php the_field('title'); ?>
            </div>
            <div class="bigger-custom">
                <?php the_field('tresc'); ?>
            </div>
            <div class="navigation">
                <?php
                if (have_rows("tab")) :
                    $x = 0;
                    while (have_rows("tab")) : the_row(); ?>
                        <div class="single-navi" data-template="grafika-z-trescia-z-tabami-tab-<?= $x ?>">
                            <div class="btn-rounded">
                                <?php the_sub_field('tytul'); ?>
                            </div>
                        </div>
                <?php $x++;
                    endwhile;
                endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="bottom">
    <div class="et-container">
        <div class="all-tab">
            <?php
            $y = 0;
            if (have_rows("tab")) :
                while (have_rows("tab")) :
                    the_row();
            ?>
                    <div class="single-tab" id="grafika-z-trescia-z-tabami-tab-<?= $y ?>">
                        <div class="left">
                            <div class="heading-2">
                                <?php the_sub_field('tytul'); ?>
                            </div>
                            <div class="bigger-custom">
                                <?php the_sub_field('opis'); ?>
                            </div>
                        </div>

                        <div class="grafika-z-trescia-z-tabami--dodaj_linki">
                            <?php if (have_rows('dodaj_linki')) : while (have_rows('dodaj_linki')) : the_row(); ?>
                                    <div class="grafika-z-trescia-z-tabami--dodaj_linki--inner">
                                        <div class="btn-wrapper">
                                            <?php et_link('linki', 'btn-rounded'); ?>
                                        </div>
                                    </div>
                            <?php endwhile;
                            endif; ?>
                        </div>

                    </div>
            <?php $y++;
                endwhile;
            endif; ?>
        </div>
    </div>
</div>