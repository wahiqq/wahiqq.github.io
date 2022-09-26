<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package anchor
 */

get_header();
?>
<?php
anchor_render_page_header( 'single' );

$show_sidebar = ( anchor_get_option( 'archive_show_sidebar' ) ) ? anchor_get_option( 'archive_show_sidebar' ) : 'yes';
if ( !is_active_sidebar( 'sidebar-1' ) ) {
  $show_sidebar = 'no';
}
$wrapper_cols = '10';

if ( $show_sidebar === 'yes' ) {
  $wrapper_cols = '8';
}

$post_class = array( 'single-post', 'blog-post' );
?>
<section class="content-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-<?php echo esc_attr( $wrapper_cols ); ?>">
        <div id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
          <?php anchor_post_thumbnail(); ?>
          <?php
          while ( have_posts() ):
            the_post();

          get_template_part( 'template-parts/content', get_post_type() );

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ):
            comments_template();
          endif;

          ?>
          <div class="clearfix"></div>
          <div class="post-navigation">
            <?php the_post_navigation(); ?>
          </div>
          <?php
          endwhile; // End of the loop.
          ?>
        </div>
      </div>
      <?php
      if ( $show_sidebar == 'yes' ) {
        ?>
      <div class="col-lg-4">
        <?php get_sidebar(); ?>
      </div>
      <!-- end col-4 -->
      <?php
      }
      ?>
    </div>
  </div>
</section>
<?php
get_footer();
