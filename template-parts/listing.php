<?php
ob_start();
if ( has_excerpt() ) {
  $post_content = the_excerpt();
} else {
  $post_content = the_content();
}
$post_content = ob_get_clean();

$strip_content = ( anchor_get_option( 'archive_strip_content' ) ) ? anchor_get_option( 'archive_strip_content' ) : 'yes';

if ( $strip_content !== 'no' ) {
  $post_content = preg_replace( '~\[[^\]]+\]~', '', $post_content );
  $post_content = strip_tags( $post_content );
  $post_content = anchor_get_the_post_excerpt( $post_content, 300 );
}

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( array( 'blog-post' ) ); ?>>
	   <?php if( anchor_get_post_thumbnail_url() ) { ?>
    <figure class="post-image">
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
    </figure>
	   <?php } ?>
    <div class="post-content">
      <?php anchor_posted_by(); ?>
      <small class="post-date">
      <?php the_date(); ?>
      </small>
      <h3><a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
        </a></h3>
      <?php echo wp_kses_post( $post_content ); ?>
      <div class="clearfix"></div>
      <a href="<?php the_permalink(); ?>" class="link"><?php echo esc_html__( 'READ MORE', 'anchor' ); ?></a> </div>
  </div>


