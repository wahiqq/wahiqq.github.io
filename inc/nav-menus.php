<?php

if ( !function_exists( 'anchor_register_nav_menus' ) ) {
  /**
   * Register required nav menus
   */
  function anchor_register_nav_menus() {

    register_nav_menus( array(
      'header' => __( 'Main menu', 'anchor' ),
    ) );

  }
  add_action( 'after_setup_theme', 'anchor_register_nav_menus' );
}