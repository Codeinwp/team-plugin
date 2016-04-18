<?php
/**
 * Single Team Member
 *
 * @package teammates
 */


 get_header(); ?>
<div class="container">
 	<div id="primary" class="content-area col-md-12">
 		<main id="main" class="site-main" role="main">

 		<?php
 		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php $member_image = get_the_post_thumbnail();

						if(!empty($member_image)) { ?>

						<div class="team-member-image">

							<?php the_post_thumbnail('teammate-single-page-thumbnail'); ?>

						</div>

					<?php } ?>

					<header class="entry-header">

						<?php the_title( '<h1 class="entry-title">', '</h1>' );

						$role_meta = get_post_meta($post->ID, 'role_text', true);

						if(!empty($role_meta)) {

							echo '<h3>'. $role_meta .'</h3>';

						}

						$social_meta = get_post_meta($post->ID,'social_icons',true);

						if(!empty($social_meta)) {

							echo '<p class="team-member-social-icons">';

							foreach($social_meta as $social_icon) {

									if( !empty($social_icon['title']) && !empty($social_icon['icons']) ) { ?>

										<a href="<?php echo esc_html($social_icon['title']); ?>"><i class="fa <?php echo esc_html($social_icon['icons']);?>"></i></a>

									<?php }
							}

								echo '</p>';

						} ?>

					</header>

					<div class="entry-content">

						<?php the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'teammates' ),
							'after'  => '</div>',
						)); ?>

					</div> <!-- entry-content -->

					<footer class="entry-footer">

						<div class="team-member-groups">

							<?php $group_heading_meta = get_post_meta($post->ID,'group_heading_text',true);

							if(!empty($group_heading_meta)) {

								echo '<h3>' . esc_html($group_heading_meta) . '</h3>';

							}?>

							<?php $terms = get_the_terms($post->ID, 'member-group');

							if(!empty($terms)) {

							?>

									<ul class="group-team-member">

										<?php

										foreach ($terms as $term) {

											echo '<li class="col-md-2"><a href="' . get_term_link($term) . '">' . esc_html($term->name) . '</a></li>';

										} ?>

									</ul>

							<?php } ?>

						</div><!-- team-member-groups -->

						<?php
							edit_post_link(
								sprintf(
									/* translators: %s: Name of current post */
									esc_html__( 'Edit %s', 'teammates' ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
								),
								'<span class="edit-link">',
								'</span>'
							);
						?>
					</footer><!-- .entry-footer -->
			</article>


    <?php endwhile; ?>

    </main><!-- #main -->
  </div> <!-- #primary -->
</div>


<?php get_footer(); ?>
