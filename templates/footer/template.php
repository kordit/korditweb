<?php 
$phone = get_field( 'telefon', 'options' );
if ($phone) {
  $phone_label = $phone['url'];
  $phone_tel = $phone['title'];
}
else {
  $phone_label = '';
  $phone_tel = '';
}
$mail = get_field( 'mail', 'options' );
$adress = get_field( 'adres', 'options' );
$facebook = get_field( 'url_facebook', 'options' );
$instagram = get_field( 'url_instagram', 'options' );
?>

<div class="et-container">
  <div class="single-footer">
    <div class="logo">
      <?php et_the_logo(); ?>
    </div>
    <div class="desc">
      <?php the_field( 'podpis_w_footerze', 'options' ); ?>
    </div>
    <?php if ($instagram || $facebook): ?>


      <ul class="social-media">
        <?php if ($facebook): ?>
          <li>
            <a target="_blank" href="<?php the_field( 'facebook', 'options' ); ?>">
              <?php et_svg('wp-content/themes/korditweb/assets/img/facebook.svg'); ?>
            </a>
          </li>
        <?php endif ?>
        <?php if ($instagram): ?>
          <li>
            <a target="_blank" href="<?php the_field( 'instagram', 'options' ); ?>">
              <?php et_svg('wp-content/themes/korditweb/assets/img/instagram.svg'); ?>
            </a>
          </li>
        <?php endif ?>
      </ul>
    <?php endif ?>
  </div>
  <div class="single-footer">
    <h3 class="heading-3 color-white">
      Skrócona mapa strony
    </h3>
    <?php
    wp_nav_menu([
      'menu'            => 'footer',
      'theme_location'  => 'footer',
      'container'       => 'nav',
      'container_id'    => 'header-nav',
      'container_class' => 'header-nav',
      'menu_id'         => 'header-nav-menu',
      'menu_class'      => 'header-nav-menu',
      'depth' => 1
    ]);
    ?>
  </div>
  <div class="single-footer">
    <h3 class="heading-3 color-white">
      Dane kontaktowe
    </h3>
    <?php if ($phone): ?>
      <div class="single-item-contact">
        <?php et_svg('wp-content/themes/korditweb/assets/img/phone.svg'); ?>
        <a href="tel:<?= $phone_label; ?>"><?= $phone_tel; ?></a>
      </div>
    <?php endif ?>
    <?php if ($mail): ?>
      <div class="single-item-contact">
        <?php et_svg('wp-content/themes/korditweb/assets/img/mail.svg'); ?>
        <a href="mailto:<?= $mail; ?>"><?= $mail; ?></a>
      </div>
    <?php endif ?>
    <?php if ($adress): ?>
      <div class="single-item-contact">
        <?php et_svg('wp-content/themes/korditweb/assets/img/adress.svg'); ?>
        <span><?= $adress; ?></span>
      </div>
    <?php endif ?>
  </div>
</div>