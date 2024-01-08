<div class="slider--slider">
    <div class="splide splide_slider">
        <div class="splide__track">
            <ul class="splide__list">
                <?php if (have_rows('slider')) : while (have_rows('slider')) : the_row(); ?>
                        <li class="splide__slide">
                            <?php et_image('grafika', 'full', false, 'slider--grafika'); ?>

                            <div class="content">
                                <div class="et-container">
                                    <div class="inner">
                                        <div class="heading-1">
                                            <?php the_sub_field('tytul'); ?>
                                        </div>
                                        <div class="btn-wrapper">
                                            <?php et_link('link', 'rounded-btn'); ?>
                                        </div>
                                        <div class="desc bigger">
                                            <?php the_sub_field('tresc'); ?>
                                        </div>
                                        <div class="btn-wrapper">
                                            <?php et_link('przycisk', 'btn-theme'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                <?php endwhile;
                endif; ?>
            </ul>
        </div>
    </div>
</div>