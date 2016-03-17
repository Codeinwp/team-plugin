<?php

the_title();
the_post_thumbnail('team-member-custom-thumbnail',array( 'alt' => get_the_title() ) );

$social_meta = get_post_meta($post->ID,'social_icons',true);
if(!empty($social_meta)) {

  // print_r($social_meta);

}
 ?>
<!--


<div class="col-md-4 team-member-box">
  <div class="team-member">
    <div class="news-date">
      <?php
      $day    = get_the_time('d');
      $month  = get_the_time('M'); ?>

      <span><?php echo $day ?></span>
      <span><?php echo $month ?></span>
    </div>
    <div class="news-post-title-wrap">
      <h4 class="news-post-title">
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
      </h4>
    </div>
    <div class="news-posted-on">
      <a href="<?php the_author_link(); ?> " title="<?php the_author(); ?>"><?php the_author(); ?></a>
      <a href="<?php comments_link() ?>"><?php comments_number( __('no comments', 'lawyeriax'), __('1 comment', 'lawyeriax'), __('% comments','lawyeriax') ); ?></a>
    </div>
  </div>
  <?php if (has_post_thumbnail()) { ?>
  <div class="news-img-wrap">
    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
      <?php the_post_thumbnail('lawyeriax-post-thumbnail-home',array( 'alt' => get_the_title() ) );?>

    </a>
  </div> <?php } ?>
  <div class="border-left news-content-wrap">
    <p><?php the_excerpt();?></p>
    <a href="<?php echo get_permalink(); ?>" title="Read more" class="read-more"><?php esc_html_e('Read more...', 'lawyeriax') ?></a>
  </div>
</div> -->
