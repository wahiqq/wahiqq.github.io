<?php
$footer_logo = anchor_get_option( 'footer_logo' );

if ( !$footer_logo ) {
  $footer_logo = get_template_directory_uri() . '/images/logo.png';
}
$show_cta = anchor_get_option( 'show_call_to_action' );
$copyright = anchor_get_option( 'footer_copyright_text' );

if ( !$copyright ) {
  $copyright = __( 'Anchor - All rights reserved.', 'anchor' );
}
$credit = anchor_get_option( 'footer_site_credit' );

if ( !$credit ) {
  $credit = __( 'Site created by <a href="#">Themezinho</a>', 'anchor' );
}

$footer_styling = '';

if ( anchor_get_option( 'footer_bg_image' ) ) {
  $footer_styling .= 'background: url(' . esc_url( anchor_get_option( 'footer_bg_image' ) ) . ') center no-repeat;';
}
?>
<footer class="footer" <?php if( $footer_styling !== '' ) { echo 'style="' . esc_attr( $footer_styling ) . '"'; } ?>>
  <?php if( $footer_logo ) { ?>
  <div class="logo"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"> <img src="<?php echo esc_url( $footer_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"> </a> </div>
  <!-- end logo -->
  <?php } ?>
  <?php if( $show_cta ) : ?>
  <?php if( anchor_get_option( 'footer_cta_tagline' ) ) { ?>
  <h4><?php echo esc_html( anchor_get_option( 'footer_cta_tagline' ) ); ?></h4>
  <?php } ?>
  <h2><?php echo wp_kses_post( anchor_get_option( 'footer_cta_tagline_title' ) ); ?></h2>
  <?php if( anchor_get_option( 'footer_cta_tagline_button_label' ) ) { ?>
  <a href="<?php echo esc_url( anchor_get_option( 'footer_cta_tagline_button_link' ) ); ?>" class="btn-contact"><span data-hover="<?php echo esc_attr( anchor_get_option( 'footer_cta_tagline_button_label' ) ); ?>"><?php echo esc_html( anchor_get_option( 'footer_cta_tagline_button_label' ) ); ?></span></a>
  <?php } ?>
  <?php endif; ?>
  <?php if( $copyright !== '' || $credit !== '' ) { ?>
  <div class="footer-bar">
    <?php if( $copyright !== '' ) { ?>
    <span class="copyright">&copy; <?php echo date("Y"); ?> <?php echo esc_html( $copyright ); ?> </span>
    <?php } ?>
    <?php if( $credit !== '' ) { ?>
    <span class="creation"><?php echo wp_kses_post( $credit ); ?> </span>
    <?php } ?>
  </div>
  <?php } ?>
  <!-- end footer-bar --> 
</footer>
<!-- end footer -->

<?php
if ( anchor_get_option( 'enable_hamburger_menu_click_sound' ) ) {
  $audio_link = get_template_directory_uri() . '/audio/doong.mp3';
  ?>
<audio id="link" src="<?php echo esc_url( $audio_link ); ?>" preload="auto"></audio>
<?php
}
?>
<div class="map" id="map"></div>
<?php wp_footer(); ?>
</body></html>