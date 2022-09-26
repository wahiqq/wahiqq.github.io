<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package anchor
 */

get_header();

$error_image = ( anchor_get_option( 'error_image' ) ) ? anchor_get_option( 'error_image' ) : get_template_directory_uri() . '/images/404.png';

$error_page_text = anchor_get_option( 'error_page_text' );

if ( !$error_page_text ) {
  $error_page_text = __( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'anchor' );
}


anchor_render_page_header( '404' );
?>
<section class="content-section">
  <div class="container"> 
	  <div class="error-404">
	  <img src="<?php echo esc_url( $error_image ); ?>" alt="<?php the_title_attribute(); ?>" />
    <p><?php echo esc_html( $error_page_text ); ?></p>
    <?php get_search_form(); ?>
		  </div>
  </div>
</section>
<?php
get_footer();
