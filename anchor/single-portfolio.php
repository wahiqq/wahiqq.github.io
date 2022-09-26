<?php
get_header();
?>


<?php
while ( have_posts() ) :
    the_post();
	?>
	<section class="project-hero">
		<?php
		if ( has_post_thumbnail() ) {
			?>
			<figure style="background: url(<?php the_post_thumbnail_url('post-single'); ?>) center;">
			<figcaption>
				<div class="container">
				<h2><?php the_title(); ?></h2>
					</div>
				<!-- end container -->
			</figcaption>
			</figure>
			<?php
		}
		?>
		
	</section>


		<div class="project-detail">
			<div class="container">
				<?php
				if( have_rows('section') ) :
				?>
					<div class="project-navbar">
						<ul class="navbar">
							<?php
							$section_id = 1;
							while ( have_rows('section') ) : the_row();
								?>
								<li>
									<a href="#portfolio-section-<?php echo esc_attr( $section_id ); ?>" title="<?php echo esc_attr( get_sub_field( 'section_title' ) ); ?>"><?php the_sub_field( 'section_title' ); ?></a>
								</li>
								<?php
								$section_id++;
							endwhile;
							?>
						</ul>
					</div>

					<?php
					$section_id = 1;
					while ( have_rows('section') ) : the_row();
						?>
						<div class="project" id="portfolio-section-<?php echo esc_attr( $section_id ); ?>">
							<h2><?php the_sub_field( 'section_title' ); ?></h2>

							<?php if( get_sub_field( 'short_description' ) !== '' ){ ?>
								<p class="lead"><?php the_sub_field( 'short_description' ); ?></p>
							<?php } ?>
							
							<?php if( get_sub_field( 'content_image' ) !== '' ){ ?>
								<div class="content-image"><img src="<?php the_sub_field( 'content_image' ); ?>" alt="<?php the_sub_field( 'section_title' ); ?>"></div>
							<?php } ?>

							<?php the_sub_field( 'section_content' ); ?>
							
							
							
						</div>
						<?php
						$section_id++;
					endwhile;
					?>
				<?php endif; ?>
			</div>
		</div>

<?php endwhile; ?>

<?php
get_footer();
?>
