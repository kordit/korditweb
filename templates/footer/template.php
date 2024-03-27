<?php $options_fields = et_options_fields();
if (!isset($options_fields['url_facebook'])) {
  $options_fields['url_facebook'] = '';
}
if (!isset($options_fields['url_instagram'])) {
  $options_fields['url_instagram'] = '';
}
if (!isset($options_fields['lista_telefonow'])) {
  $options_fields['lista_telefonow'] = '';
}
if (!isset($options_fields['lista_maili'])) {
  $options_fields['lista_maili'] = [];
}
if (!isset($options_fields['adres'])) {
  $options_fields['adres'] = '';
}
?>

<div class="et-container">
  <div class="single-footer">
    <div class="logo">
      <?php et_the_logo(); ?>
    </div>
    <div class="desc">
      <?php the_field('podpis_w_footerze', 'options'); ?>
    </div>
    <?php if ($options_fields['url_facebook'] || $options_fields['url_instagram']) : ?>


      <ul class="social-media">
        <?php if ($options_fields['url_facebook']) : ?>
          <li>
            <a target="_blank" href="<?= $options_fields['url_facebook']; ?>">
              <?php et_svg('wp-content/themes/korditweb/assets/img/facebook.svg'); ?>
            </a>
          </li>
        <?php endif ?>
        <?php if ($options_fields['url_instagram']) : ?>
          <li>
            <a target="_blank" href="<?= $options_fields['url_instagram']; ?>">
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
    <?php
    ?>
    <?php if ($options_fields['lista_telefonow']) : ?>
      <?php foreach ($options_fields['lista_telefonow'] as $var => $phone) : ?>
        <div class="single-item-contact">
          <?php et_svg('wp-content/themes/korditweb/assets/img/phone.svg'); ?>
          <a href="tel:<?= $phone['telefon']['url']; ?>"><?= $phone['telefon']['title']; ?></a>
        </div>
      <?php endforeach; ?>
    <?php endif ?>
    <?php foreach ($options_fields['lista_maili'] as $mail) : ?>
      <div class="single-item-contact">
        <?php et_svg('wp-content/themes/korditweb/assets/img/mail.svg'); ?>
        <a href="mailto::<?= $mail['mail']; ?>"><?= $mail['mail']; ?></a>
      </div>
    <?php endforeach; ?>
    <?php if ($options_fields['adres']) : ?>
      <div class="single-item-contact">
        <?php et_svg('wp-content/themes/korditweb/assets/img/adress.svg'); ?>
        <span><?= $options_fields['adres']; ?></span>
      </div>
    <?php endif ?>
  </div>
</div>