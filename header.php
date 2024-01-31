<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <style type="text/css">
    <?php include('templates/header/config.php'); ?>
  </style>
  <?php wp_head(); ?>
</head>

<body <?php body_class('body'); ?>>
  <?php if (has_nav_menu('mobile')) : ?>
    <?php
    wp_nav_menu([
      'menu'            => 'mobile',
      'theme_location'  => 'mobile',
      'container'       => 'nav',
      'container_id'    => 'mobile-nav',
      'container_class' => 'mobile-nav',
      'menu_id'         => 'mobile-nav-menu',
      'menu_class'      => 'mobile-nav-menu'
    ]);
    ?>
  <?php endif; ?>
  <header id="header">
    <?php include('templates/header/template.php'); ?>
  </header>

  <?php if (!is_front_page()) : ?>
    <div class="section-title">
      <?php the_title(); ?>
    </div>
  <?php endif ?>