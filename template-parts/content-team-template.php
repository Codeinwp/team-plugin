<?php

$args = array (
    'post_type' => 'team-member',
    'showposts' => 5,
  );

?>

<section id="lawyer" class="home-section lawyer">

  <div class="container">

    <div class="home-section-title-wrap">
      <h2 class="home-section-title">Team</h2>
    </div>

    <div class="home-section-inner lawyer-box-wrap">

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


  		 ?>
  			</div>
      </div>
</section>
