<?php
/**
 * The home template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Matt_Portfolio
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
				<div class="row">
					<div class="column column-25">
						<dl>

						<?php 
							$args = array('post_type' => 'portfolio'); 
							$loop = new WP_Query($args);
							
							if ( $loop->have_posts() ): 
								while ( $loop->have_posts() ) : $loop->the_post(); ?>

									<dt><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></dt>

								<?php endwhile;

							else:

							endif;
				
							wp_reset_postdata(); 
						?>

						</dl>
					</div>
					<div class="column column-75">PICTURE BOX</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
