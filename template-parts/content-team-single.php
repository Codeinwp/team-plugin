<?php
//
// the_title();
// the_post_thumbnail('team-member-custom-thumbnail',array( 'alt' => get_the_title() ) );

$social_meta = get_post_meta($post->ID,'social_icons',true);


 ?>




     <div class="col-xs-12 col-sm-4 lawyer-box">

       <div class="lawyer-box-image">

         <?php if(!empty(get_the_post_thumbnail())) { ?>
         <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
           <?php the_post_thumbnail('team-member-custom-thumbnail'); ?>
         </a>
       <?php } ?>
       </div>

       <div class="lawyer-box-content">

         <h5 class="lawyer-title">

           <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?> </a>

         </h5>

         <div class="border-left lawyer-box-content-inner">
           <div class="lawyer-box-inside">

         <?php $role_meta = get_post_meta($post->ID,'role_text',true);

         if(!empty($role_meta)) { ?>

            <p class="lawyer-box-info"><?php echo esc_html($role_meta); ?></p>

         <?php } ?>

         <?php $social_meta = get_post_meta($post->ID,'social_icons',true);
          if(!empty($social_meta)) {

          echo '<ul class="lawyer-media-icons">';

          foreach($social_meta as $social_icon) {

              if( !empty($social_icon['title']) && !empty($social_icon['icons']) ) { ?>

                <li>
                  <a href="<?php echo esc_html($social_icon['title']); ?>"><i class="fa <?php echo esc_html($social_icon['icons']);?>"></i></a>
                </li>
        <?php }
            }
            echo '</ul>';
          }?>
          </div>

          <a href="<?php the_permalink(); ?>" class="view-profile" title="<?php the_title(); ?>"> <?php echo __('View Profile', 'team-plugin') ?></a>

        </div>
      </div>
    </div>



    <!-- <section id="team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-centered text-center">
                    <h1>Our team</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-centered">
                    <div class="separator"></div>
                </div>
                <div class="col-lg-12 col-centered text-center">
                    <p class="team-p">Present your team members and their role in the company.</p>
                </div>
            </div>

            <div class="row team-row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="team-picture">
                        <img src="img/team1.png" alt="" class="img-responsive">
                        <div class="team-picture-overlay">
                            <p class="team-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vulputate aliquam libero.</p>
                            <p class="team-social-icons">
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="separator-team"></div>
                    <h4 class="team-name1">Helena Rowling</h4>
                    <p>Project Supervisor</p>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  text-center">
                    <div class="team-picture">
                        <img src="img/team2.png" alt="" class="img-responsive">
                        <div class="team-picture-overlay">
                            <p class="team-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vulputate aliquam libero.</p>
                            <p class="team-social-icons">
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="separator-team"></div>
                    <h4 class="team-name2">Daisy Gatsby</h4>
                    <p>Web Designer</p>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  text-center">
                    <div class="team-picture">
                        <img src="img/team3.png" alt="" class="img-responsive">
                        <div class="team-picture-overlay">
                            <p class="team-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vulputate aliquam libero.</p>
                            <p class="team-social-icons">
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="separator-team"></div>
                    <h4 class="team-name3">Tom Boone</h4>
                    <p>Front end Developer</p>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  text-center">
                    <div class="team-picture">
                        <img src="img/team4.png" alt="" class="img-responsive">
                        <div class="team-picture-overlay">
                            <p class="team-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vulputate aliquam libero.</p>
                            <p class="team-social-icons">
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="separator-team"></div>
                    <h4 class="team-name4">Holden Caulfeld</h4>
                    <p>UX designer</p>
                </div>

            </div>


        </div>
    </section> -->
