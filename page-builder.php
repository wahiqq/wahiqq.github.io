<?php
/**
 * Template Name: Builder
 *
 */

get_header();
?>

    <?php anchor_render_page_header( 'page' ); ?>

	<div class="wrap-page">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
	</div>
	<!-- end wrap-page -->
<?php
get_footer();
