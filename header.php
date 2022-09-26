<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$nav_menu_type = anchor_get_option( 'nav_menu_type' );
$social_media = anchor_get_option( 'social_media' );
$logo = ( anchor_get_option( 'logo' ) ) ? anchor_get_option( 'logo' ) : get_template_directory_uri() . '/images/logo.png';
$logo_light = ( anchor_get_option( 'logo_light' ) ) ? anchor_get_option( 'logo_light' ) : get_template_directory_uri() . '/images/logo-light.png';	
?>
<?php
if ( anchor_get_option( 'enable_preloader' ) ):
  $pre_loader_icon = ( anchor_get_option( 'pre_loader_icon' ) ) ? anchor_get_option( 'pre_loader_icon' ) : get_template_directory_uri() . '/images/preloader.gif';
$text_rotater = anchor_get_option( 'pre_loader_text_rotater' );
?>
<div class="preloader"><img src="<?php echo esc_url( $pre_loader_icon ); ?>" alt="<?php echo esc_attr__( 'Preloader', 'anchor' ); ?>">
  <?php
  if ( count( $text_rotater ) ):
    ?>
  <ul class="text-rotater">
    <?php
    foreach ( $text_rotater as $rotater ):
      ?>
    <li><?php echo esc_html( $rotater['title'] ); ?></li>
    <?php
    endforeach;
    ?>
  </ul>
  <?php
  endif;
  ?>
</div>
<!-- end preloader -->
<div class="page-transition"></div>
<!-- end page-transition -->
<?php endif; ?>
  <div class="hamburger-navigation">
    <?php
    wp_nav_menu( array(
      'theme_location' => 'header',
      'container' => false,
      'walker' => new WP_Themezinho_Navwalker(),
    ) );
    ?>
  </div>
  <!-- end hamburger-navigation -->
  <svg class="shape-overlays" viewBox="0 0 100 100" preserveAspectRatio="none">
    <path class="shape-overlays__path" d=""></path>
    <path class="shape-overlays__path" d=""></path>
    <path class="shape-overlays__path" d=""></path>
  </svg>
<nav class="navbar">
  <div class="logo"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"> 
	  <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo-original" /> 
	  <img src="<?php echo esc_url( $logo_light ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo-light" /> 
	  </a> </div>
  <!-- .logo -->
  
  <?php
  if ( $nav_menu_type === 'hamburger' ):
    if ( anchor_get_option( 'show_phone' ) ):
      ?>
  <span class="phone"><?php echo esc_html( anchor_get_option( 'phone_label' ) ); ?> <a href="tel:<?php echo esc_attr( anchor_get_option( 'phone_number') ); ?>"><?php echo esc_html( anchor_get_option( 'phone_number') ); ?></a> </span>
  <?php endif; ?>
  <div class="custom-menu">
   <?php anchor_get_wpml_langs(); ?>
  </div>
  <!-- end custom-menu -->
  <?php if( anchor_get_option( 'enable_background_music' ) ) : ?>
  <div class="equalizer"> <span></span> <span></span> <span></span> <span></span> </div>
  <!-- end equalizer -->
  <?php endif; ?>
  <div class="hamburger" id="hamburger">
    <div class="hamburger__line hamburger__line--01">
      <div class="hamburger__line-in hamburger__line-in--01"></div>
    </div>
    <div class="hamburger__line hamburger__line--02">
      <div class="hamburger__line-in hamburger__line-in--02"></div>
    </div>
    <div class="hamburger__line hamburger__line--03">
      <div class="hamburger__line-in hamburger__line-in--03"></div>
    </div>
    <div class="hamburger__line hamburger__line--cross01">
      <div class="hamburger__line-in hamburger__line-in--cross01"></div>
    </div>
    <div class="hamburger__line hamburger__line--cross02">
      <div class="hamburger__line-in hamburger__line-in--cross02"></div>
    </div>
  </div>
  <!-- end hamburger -->
  <?php
  else :
    ?>
  <div class="hamburger hamburger-mobile-only" id="hamburger">
    <div class="hamburger__line hamburger__line--01">
      <div class="hamburger__line-in hamburger__line-in--01"></div>
    </div>
    <div class="hamburger__line hamburger__line--02">
      <div class="hamburger__line-in hamburger__line-in--02"></div>
    </div>
    <div class="hamburger__line hamburger__line--03">
      <div class="hamburger__line-in hamburger__line-in--03"></div>
    </div>
    <div class="hamburger__line hamburger__line--cross01">
      <div class="hamburger__line-in hamburger__line-in--cross01"></div>
    </div>
    <div class="hamburger__line hamburger__line--cross02">
      <div class="hamburger__line-in hamburger__line-in--cross02"></div>
    </div>
  </div>
  <!-- end hamburger -->
  
  <div class="site-menu">
    <?php
    wp_nav_menu( array(
      'theme_location' => 'header',
      'container' => false,
      'walker' => new WP_Themezinho_Navwalker(),
    ) );
    ?>
  </div>
  <?php  endif; ?>
</nav>
<?php
if ( $social_media && count( $social_media ) ):
  ?>
<ul class="social-bar">
  <?php
  foreach ( $social_media as $social ):
    ?>
  <li><a href="<?php echo esc_url( $social['url'] ); ?>" title="<?php echo esc_attr( $social['title'] ); ?>"><?php echo esc_html( $social['label'] ); ?></a></li>
  <?php
  endforeach;
  ?>
</ul>
<?php
endif;
?>
