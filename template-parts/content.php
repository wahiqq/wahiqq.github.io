<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package anchor
 */

?>
<div class="post-content">
    <?php
    if ( 'post' === get_post_type() ):
      ?>
	 <small class="post-date">
      <?php the_date(); ?>
      </small>
    <?php anchor_posted_by(); ?>
     
    <?php the_tags( '<ul class="post-tags"><li>', '</li><li>', '</li></ul>' ); ?>
    <?php
    endif;
    ?>
    

  <?php
  the_content( sprintf(
    '%s %s',
    esc_html__( 'Continue reading', 'anchor' ),
    '<span class="screen-reader-text"> ' . get_the_title() . '</span>'
  ) );

  wp_link_pages( array(
    'before' => '<div class="page-links"><h6>' . esc_html__( 'Pages:', 'anchor' ) . '</h6>',
    'after' => '</div>',
    'link_before' => '<span>',
    'link_after' => '</span>',
  ) );
  ?>

</div>
