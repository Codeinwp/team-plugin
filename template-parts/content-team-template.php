<?php
$section_heading  = get_theme_mod('team_plugin_section_heading', esc_html__('Our team','team-plugin'));
$section_subheading  = get_theme_mod('team_plugin_section_subheading', esc_html__('Present your team members and their role in the company.','team-plugin'));
$members_number = get_theme_mod('team_plugin_members_number', '4');
$args = array (
    'post_type' => 'team-member',
    'showposts' => $members_number,
  );
?>
<section id="team-plugin-section">
<?php
if(is_front_page()) {
  echo '<div class="container">';
}
?>

   <div class="row row-centered">


      <?php if(!empty($section_heading)) { ?>

           <div class="col-lg-12 team-plugin-section-title">

               <h1><?php echo esc_html($section_heading); ?></h1>

           </div><!-- team-plugin-section-title -->

       <?php }

       if(!empty($section_subheading)) { ?>

           <div class="col-lg-12 team-plugin-section-subtitle">

               <p><?php echo esc_html($section_subheading); ?></p>

           </div><!-- team-plugin-section-subtitle -->

       <?php } ?>

           <div class="team-plugin-members-wrapper">

			     <!-- Posts Loop -->
    				<?php

            $loop = new WP_Query( $args );

              while ( $loop->have_posts() ) : $loop->the_post();

                if ( $overridden_template = locate_template( '/content-team-single.php', get_post_format() ) ) {

                  load_template( $overridden_template );

                } else {

                  load_template( dirname( __FILE__ ) . '/content-team-single.php', get_post_format() );

                }

              endwhile;

              wp_reset_query();

              ?> <!-- End Posts Loop -->

        </div><!-- team-plugin-members-wrapper -->
    </div>

    <?php if(is_front_page()) {
      echo '</div>';
    } ?>
</section>
