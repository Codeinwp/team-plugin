<?php
/**
 * Single Team Member
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lawyeriax
 */

get_header();
?>

<div class="content-wrap">

	<div id="primary" class="col-sm-12 col-md-9 content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="entry-content">

					<div class="lawyer-image">
						<?php the_post_thumbnail(); ?>
					</div>

					<div class="entry-content-lawyer">
						<header class="entry-header">
							<div class="entry-content-lawyer-top">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								<p class="lawyer-social-media">
									<?php $social_meta = get_post_meta($post->ID,'songs',true);
									foreach($social_meta as $track) {

										if( !empty($track['title']) && !empty($track['icons']) ) { ?>

											<a href="<?php echo $track['title']; ?>"><i class="fa <?php echo $track['icons'];?>"></i></a>
											<?php } } ?>

								</p>
							</div>
						</header><!-- .entry-header -->

						<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lawyeriax' ),
								'after'  => '</div>',
							) );
						?>
					</div>
				</div><!-- .entry-content -->




				<div class="practice-aria-lawyers-page">

					<h3>Practice Aria</h3>

					<div class="practice-aria-lawyers-inner">

						<ul class="practice-aria-lawyer">
							<?php the_tags(); ?>
								<!-- <li class="col-md-2">
								<a href="#">Administrative Law</a>
							</li>
							<li class="col-md-2">
								<a href="#">Bankig Law</a>
							</li>
							<li class="col-md-2">
								<a href="#">Civil Rights</a>
							</li>
							<li class="col-md-2">
								<a href="#">Immigaration</a>
							</li>
							<li class="col-md-2">
								<a href="#">Business Law</a>
							</li>
							<li class="col-md-2">
								<a href="#">Family Law</a>
							</li> -->
						</ul>

					</div>

				</div>



				<footer class="entry-footer">
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								esc_html__( 'Edit %s', 'lawyeriax' ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							),
							'<span class="edit-link">',
							'</span>'
						);
					?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-## -->

<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
