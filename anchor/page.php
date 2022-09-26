<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package anchor
 */

get_header();
?>

<?php
anchor_render_page_header( 'page' );

while ( have_posts() ) :
	the_post();
    ?>
	<!-- end int-hero -->
	<section class="content-section">
            <?php
            get_template_part( 'template-parts/content', 'page' );
            ?>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                ?>
                <div class="clearfix"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <?php comments_template(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

	</section>
	<?php 
endwhile; ?>
<?php
get_footer();
