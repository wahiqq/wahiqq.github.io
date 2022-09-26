<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package anchor
 */

?>

<?php anchor_post_thumbnail(); ?>
<div class="post-<?php the_ID(); ?> <?php post_class(); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

	            <?php
	            the_content();

	            wp_link_pages( array(
		            'before'      => '<div class="page-links"><h6>' . __( 'Pages:', 'anchor' ) . '</h6>',
		            'after'       => '</div>',
		            'link_before' => '<span>',
		            'link_after'  => '</span>',
	            ) );
	            ?>

	            <?php if ( get_edit_post_link() ) : ?>
                    <div class="post-entry-footer">
			            <?php
			            edit_post_link(
				            sprintf(
					            wp_kses(
					            /* translators: %s: Name of current post. Only visible to screen readers */
						            __( 'Edit <span class="screen-reader-text">%s</span>', 'anchor' ),
						            array(
							            'span' => array(
								            'class' => array(),
							            ),
						            )
					            ),
					            get_the_title()
				            ),
				            '<span class="edit-link">',
				            '</span>'
			            );
			            ?>
                    </div><!-- .entry-footer -->
	            <?php endif; ?>

            </div>
        </div>
    </div>
</div>