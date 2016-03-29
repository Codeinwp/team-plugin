<?php
$section_heading  = get_theme_mod('team_plugin_section_heading', esc_html__('Our team','team-plugin'));
$section_subheading  = get_theme_mod('team_plugin_section_subheading', esc_html__('Present your team members and their role in the company.','team-plugin'));
$members_number = get_theme_mod('team_plugin_members_number', '4');
$view_profile_button = get_theme_mod('team_plugin_profile_button', esc_html__('View Profile'));
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

               <h2><?php echo esc_html($section_heading); ?></h2>

           </div><!-- team-plugin-section-title -->

       <?php } ?>

           <div class="team-plugin-members-wrapper">

			     <!-- Posts Loop -->
    				<?php

            $loop = new WP_Query( $args );

              while ( $loop->have_posts() ) : $loop->the_post();

                if(file_exists ( get_template_directory() . '/content-team-single.php' )) {

                    $overridden_template = get_template_directory() . '/content-team-single.php';
                    load_template( $overridden_template, false );

                } else {

                  $social_meta      = get_post_meta($post->ID,'social_icons',true);
                  $description_meta = get_post_meta($post->ID,'description_text',true);
                  $role_meta        = get_post_meta($post->ID,'role_text',true);

                   ?>


                   <div class="col-lg-3 col-sm-6 col-xs-12 col-centered team-plugin-member-container">
                       <div class="team-plugin-member-thumbnail-container">
                           <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                             <?php the_post_thumbnail('team-member-custom-thumbnail'); ?>
                           </a>

                           <div class="team-plugin-member-thumbnail-overlay">

                                 <?php if(!empty($description_meta)) {

                                   echo '<p class="team-plugin-member-description">' . esc_html($description_meta) . '</p>';

                                 } ?>

                           </div><!-- team-plugin-member-thumbnail-overlay -->
                       </div><!-- team-plugin-member-thumbnail-container -->

                       <?php

                       if(!empty($social_meta)) {

                           echo '<p class="team-plugin-member-social-icons">';

                           foreach($social_meta as $social_icon) {

                               if( !empty($social_icon['title']) && !empty($social_icon['icons']) ) {

                                 echo '<a href="' . esc_html($social_icon['title']) . '"><i class="fa ' . esc_html($social_icon['icons']) . '"></i></a>';

                               }
                           }
                             echo '</p>';
                         }
                       ?>

                       <hr/>

                       <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>

                       <?php if(!empty($role_meta)) {

                          echo '<p>' . esc_html($role_meta) . '</p>';

                        } ?>

                        <a href="<?php the_permalink(); ?>"><button type="button"><?php echo esc_html($view_profile_button); ?></button></a>


                   </div><!-- team-plugin-member-container -->

                  <?php }

              endwhile;

              wp_reset_query();

              ?> <!-- End Posts Loop -->

        </div><!-- team-plugin-members-wrapper -->
    </div>

    <?php if(is_front_page()) {
      echo '</div>';
    } ?>
</section>
