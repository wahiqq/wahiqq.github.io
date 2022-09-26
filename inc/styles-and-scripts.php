<?php

if( ! function_exists( 'anchor_google_fonts_url' ) ) {
	/*
	* Register Google Font Family
	*/
	function anchor_google_fonts_url() {
		$fonts_url = '';

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		 */
		$playfair = _x( 'on', 'Playfair Display font: on or off', 'anchor' );
		$fjalla_one = _x( 'on', 'Fjalla One font: on or off', 'anchor' );
		$poppins = _x( 'on', 'Poppins font: on or off', 'anchor' );

		if ( 'off' !== $playfair || 'off' !== $fjalla_one || 'off' !== $poppins ) {

			$font_families = array();

			if ( 'off' !== $playfair ) {
				$font_families[] = 'Playfair Display:400,700';
			}

			if ( 'off' !== $fjalla_one ) {
				$font_families[] = 'Fjalla One';
			}

			if ( 'off' !== $poppins ) {
				$font_families[] = 'Poppins:300,400,500,600,700,900';
			}

			$f_query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin-ext' ),
			);
			$fonts_url = add_query_arg( $f_query_args, '//fonts.googleapis.com/css' );

		}

		return esc_url_raw( $fonts_url );
	}

}

if ( ! function_exists( 'anchor_enqueue_styles_and_scripts' ) ) {
	/**
	 * This function enqueues the required css and js files.
	 *
	 * @return void
	 */
	function anchor_enqueue_styles_and_scripts() {
		/**
		 * Enqueue css files.
		 */
		wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css' );
		wp_enqueue_style( 'hamburger', get_template_directory_uri() . '/css/hamburger-menu.css' );
		wp_enqueue_style( 'odometer', get_template_directory_uri() . '/css/odometer.min.css' );
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/swiper.min.css' );
		wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/css/fancybox.min.css' );
		wp_enqueue_style( 'anchor-google-font', anchor_google_fonts_url(), array(), '1.0.0' );
		wp_enqueue_style( 'bootsrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_style( 'anchor-main-style', get_template_directory_uri() . '/css/style.css' );
		wp_enqueue_style( 'anchor-stylesheet', get_stylesheet_uri() );
		wp_add_inline_style( 'anchor-stylesheet', anchor_dynamic_css() );

		/**
		 * Enqueue javascript files.
		 */

		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/fancybox.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'odometer', get_template_directory_uri() . '/js/odometer.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'easings', get_template_directory_uri() . '/js/easings.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'hamburger', get_template_directory_uri() . '/js/hamburger.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.min.js', array( 'jquery' ), false, true );
		
		wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'tilt', get_template_directory_uri() . '/js/tilt.jquery.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'anchor-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), false, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$data = array(
			'audio_source' => '',
			'enable_hamburger_menu_click_sound' => false
		);
		if( anchor_get_option( 'enable_background_music' ) ) {
			$data['audio_source'] = esc_url( anchor_get_option( 'background_music_file' ) );
		}
		if( anchor_get_option( 'enable_hamburger_menu_click_sound' ) ) {
			$data['enable_hamburger_menu_click_sound'] = esc_url( anchor_get_option( 'enable_hamburger_menu_click_sound' ) );
		}

		wp_localize_script( 'anchor-scripts', 'data', $data );
	}

	add_action( 'wp_enqueue_scripts', 'anchor_enqueue_styles_and_scripts', 10 );
}

if( !function_exists( 'anchor_dynamic_css' ) ) {
	function anchor_dynamic_css() {

		$styles = '';

		if( anchor_get_option('logo_height') && anchor_get_option('logo_height') > 0 ) {
			$styles = "
				.navbar .logo img {
					height: " . str_replace(' ', '',anchor_get_option('logo_height') ) . "px;
					width: auto;
				}
			";
		}
		if( anchor_get_option( 'enable_dynamic_color' ) ) {

			$site_color_1 = ( anchor_get_option( 'theme_color_1' ) ) ? anchor_get_option( 'theme_color_1' ) : '#f50c1a';
			$site_color_2 = ( anchor_get_option( 'theme_color_2' ) ) ? anchor_get_option( 'theme_color_2' ) : '#56e9b1';
			$body_bg_color = ( anchor_get_option( 'body_background_color' ) ) ? anchor_get_option( 'body_background_color' ) : '#131314';
			
			$styles .="
			
			
			:root {
  --color-dark: {$body_bg_color} !important; 
  --color-main: {$site_color_1} !important;
  --color-second: {$site_color_2} !important; 
}
			
			
				
			";

		}

		return $styles;
	}
}

add_action( 'init', 'anchor_dynamic_css' );