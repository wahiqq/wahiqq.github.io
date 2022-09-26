<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package anchor
 */
get_header();
?>
<?php
anchor_render_page_header( 'search' );

$show_sidebar = ( anchor_get_option( 'archive_show_sidebar' ) ) ? anchor_get_option( 'archive_show_sidebar' ) : 'yes';
$wrapper_cols = '11';

if ( !is_active_sidebar( 'sidebar-1' ) ) {
  $show_sidebar = 'no';
}

if ( $show_sidebar == 'yes' ) {
  $wrapper_cols = '8';
}

$search_text = anchor_get_option( 'search_text' );

if ( !$search_text ) {
  $search_text = __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'anchor' );
}
?>
<section class="content-section">
  <div class="container">
    <div class="row justify-content-center">
      <?php
      if ( have_posts() ):
        ?>
      <div class="col-md-<?php echo esc_attr( $wrapper_cols ); ?>">
        <?php
        while ( have_posts() ):
          the_post();

       ?>
		  
		  <div id="post-<?php the_ID(); ?>" <?php post_class( array( 'blog-post' ) ); ?>>
	  
    <div class="post-content">
      <?php anchor_posted_by(); ?>
     
      <h3><a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
        </a></h3>
      </div>
  </div>
		  
		  <?php

        endwhile;
        // show pagination
        anchor_pagination();
        ?>
      </div>
      <!-- end col-8 -->
      <?php
      if ( $show_sidebar == 'yes' ) {
        ?>
      <div class="col-md-4 col-sm-12">
        <?php get_sidebar(); ?>
      </div>
      <!-- end col-4 -->
      <?php
      }
      ?>
      <?php
      else :
		?>
		
		
		<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'anchor' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p><?php echo esc_html( $search_text ); ?></p>
			<?php
			get_search_form();

	

		endif;
		?>
	</div>
		
		
		<?php
		

      endif;
      ?>
    </div>
  </div>
</section>
<?php
get_footer();
