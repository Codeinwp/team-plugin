<?php
//
// the_title();
// the_post_thumbnail('team-member-custom-thumbnail',array( 'alt' => get_the_title() ) );

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

      <a href="<?php the_permalink(); ?>"><button type="button">View Profile</button></a>


 </div><!-- team-plugin-member-container -->
