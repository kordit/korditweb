<div class="et-container">
  <a class="logo" href="<?= et_site_url(); ?>"><?php et_the_logo('183px', '54px'); ?></a>
  <?php if (has_nav_menu('header')) : ?>
    <?php
    wp_nav_menu([
      'menu'            => 'header',
      'theme_location'  => 'header',
      'container'       => 'nav',
      'container_id'    => 'header-nav',
      'container_class' => 'header-nav',
      'menu_id'         => 'header-nav-menu',
      'menu_class'      => 'header-nav-menu'
    ]);
    ?>
  <?php endif; ?>
  <?= et_svg('wp-content/themes/ergotree/assets/img/hamburger.svg'); ?>
</div>