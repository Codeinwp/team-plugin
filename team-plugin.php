<?php
/*
Plugin Name: Team Plugin
Plugin URI: https://wordpress.org/plugins/team-plugin/
Description: Generates a shortcode to add a section for your team
Version: 0.1.0
Author: Themeisle
Author URI: http://themeisle.com
Text Domain: team-plugin
*/


/**
 *  Custom Post Type: Team Member
 */
function team_plugin_members_custom_post_type() {
    $labels = array(
        'name'                => _x( 'Team Members', 'team-plugin' ),
        'singular_name'       => _x( 'Team Member', 'team-plugin' ),
        'menu_name'           => __( 'Team', 'team-plugin' ),
        'parent_item_colon'   => __( 'Parent Team Member:', 'team-plugin' ),
        'all_items'           => __( 'All Team Members', 'team-plugin' ),
        'view_item'           => __( 'View Team Member', 'team-plugin' ),
        'add_new_item'        => __( 'Add New Team Member', 'team-plugin' ),
        'add_new'             => __( 'Add New Team Member', 'team-plugin' ),
        'edit_item'           => __( 'Edit Team Member', 'team-plugin' ),
        'update_item'         => __( 'Update Team Member', 'team-plugin' ),
        'search_items'        => __( 'Search Team Members', 'team-plugin' ),
        'not_found'           => __( 'Not found', 'team-plugin' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'team-plugin' ),
    );
    $args = array(
        'label'               => __( 'team-member', 'team-plugin' ),
        'description'         => __( 'Description for lawyers.', 'team-plugin' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-businessman',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'team-member', $args );

    flush_rewrite_rules();

    //Add thumbnail size for team members.
    add_image_size( 'team-member-custom-thumbnail', 200, 200, true );

}
add_action( 'init', 'team_plugin_members_custom_post_type', 0 );


/**
 *  Check for single template. Fallback to default single.php if there is none.
 */
function team_plugin_check_template($single_template) {
     global $post;

     if ($post->post_type == 'team-member') {

     if ( $plugin_template = locate_template( '/single-team-member.php' ) ) {
          $single_template = $plugin_template;
        } else {
          $single_template = locate_template( '/single.php' );
        }
     }
     return $single_template;
}
add_filter( 'single_template', 'team_plugin_check_template' );


/**
 *  Create Shortcode For Section Output
 */
function team_plugin_section_shortcode() {

  if ( $overridden_template = locate_template( '/content-team-template.php' ) ) {
    load_template( $overridden_template );
  } else {

    load_template( dirname( __FILE__ ) . '/template-parts/content-team-template.php' );
  }

}
add_shortcode('team', 'team_plugin_section_shortcode');


/**
 *  Create and add custom metabox.
 */
function team_plugin_add_custom_metabox() {
  global $meta_box;

  $meta_box = array (
    'field_id'      => 'team-member-properties-meta-box',
    'title'   => __('Team Member Properties', 'team-plugin'),
    'page'    => 'team-member',
    'context' => 'normal',
    'priority'=> 'high',
    'fields'  => array(
                        array(
                        'field_id'          => 'team_plugin_facebook_link',
                        'field_name'        => __('Facebook Link', 'team-plugin'),
                        'field_description' => __('Add a Facebook link for this team member'),
                        'field_type'        => 'text',
                        'field_placeholder' => esc_url('http://facebook.com'),
                      ),
                 )
            );
    add_meta_box( $meta_box['field_id'], $meta_box['title'], 'team_plugin_render_custom_metabox', $meta_box['page'], $meta_box['context'], $meta_box['priority'] );
}
//add_action('add_meta_boxes_team-member', 'team_plugin_add_custom_metabox');



/**
 *  Render metabox.
 */
function team_plugin_render_custom_metabox() {
  global $meta_box, $post, $meta;


  // Use nonce for verification
  echo '<input type="hidden" name="team_member_noncename" id="team_member_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';


  foreach ($meta_box['fields'] as $field) {
      // get current post meta data
      //print_r($field);
       $meta = get_post_meta($post->ID, 'team_plugin_facebook_link', true);
       print_r($meta);
       echo '<input type="text" name="_location" id= "_location" value="' . $meta  . '" class="widefat" />';
    }
}


/**
 *  Save metaboxes data.
 */
function team_plugin_save_data($post_id) {
  global $meta_box;

  // verify nonce
  if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
      return $post_id;
  }

  // check autosave
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
  }

  // check permissions
  if ('team-member' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
          return $post_id;
      }
  } elseif (!current_user_can('edit_post', $post_id)) {
      return $post_id;
  }

  foreach ($meta_box['fields'] as $field) {
      $old = get_post_meta($post_id, $field['id'], true);
      $new = $_POST[$field['id']];
      echo '<script> alert( '. $new .' )</script>';

      if ($new && $new != $old) {
          update_post_meta($post_id, $field['id'], $new);
      } elseif ('' == $new && $old) {
          delete_post_meta($post_id, $field['id'], $old);
      }
  }
}

//On post save, save plugin's data
//add_action('save_post', 'team_plugin_save_data');






























add_action( 'add_meta_boxes', 'dynamic_add_custom_box' );

/* Do something with the data entered */
add_action( 'publish_team-member', 'dynamic_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function dynamic_add_custom_box() {
    add_meta_box(
        'dynamic_sectionid',
        __( 'My Tracks', 'myplugin_textdomain' ),
        'dynamic_inner_custom_box',
        'team-member');
}

/* Prints the box content */
function dynamic_inner_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php
    $social = array( 'No Icon','fa-envelope','fa-map-marker','fa-500px','fa-amazon','fa-android','fa-behance','fa-behance-square','fa-bitbucket','fa-bitbucket-square','fa-cc-amex','fa-cc-diners-club','fa-cc-discover','fa-cc-jcb','fa-cc-mastercard','fa-paypal','fa-cc-stripe','fa-cc-visa','fa-codepen','fa-css3','fa-delicious','fa-deviantart','fa-digg','fa-dribbble','fa-dropbox','fa-drupal','fa-facebook','fa-facebook-official','fa-facebook-square','fa-flickr','fa-foursquare','fa-git','fa-git-square','fa-github','fa-github-alt','fa-github-square','fa-google','fa-google-plus','fa-google-plus-square','fa-html5','fa-instagram','fa-joomla','fa-jsfiddle','fa-linkedin','fa-linkedin-square','fa-opencart','fa-openid','fa-pinterest','fa-pinterest-p','fa-pinterest-square','fa-rebel','fa-reddit','fa-reddit-square','fa-share-alt','fa-share-alt-square','fa-skype','fa-slack','fa-soundcloud','fa-spotify','fa-stack-overflow','fa-steam','fa-steam-square','fa-tripadvisor','fa-tumblr','fa-tumblr-square','fa-twitch','fa-twitter','fa-twitter-square','fa-vimeo','fa-vimeo-square','fa-vine','fa-whatsapp','fa-wordpress','fa-yahoo','fa-youtube','fa-youtube-play','fa-youtube-square');
    //get the saved meta as an arry
    $songs = get_post_meta($post->ID,'songs',true);
    $c =0;
    if ( !empty( $songs )) {
        foreach( $songs as $track ) {



            if ( isset( $track['title'] ) || isset( $track['track'] ) ) {

                echo '<select name="songs['.$c.'][icons]">';
                foreach ($social as  $value) {
                  echo '<option value='.$value.' '.($track['icons'] == $value? 'selected':'' ).'>';
                  echo $value;
                  echo '</option>';
                }
                echo '</select>';



                printf( '<p>Song Title <input type="text" name="songs[%1$s][title]" value="%2$s" /> -- Track number : <input type="text" name="songs[%1$s][track]" value="%3$s" /><span class="remove">%4$s</span></p>', $c, $track['title'], $track['track'], __( 'Remove Track' ) );
                $c = $c +1;
            }
        }
    }

    ?>
<span id="here"></span>
<span class="add"><?php _e('Add Tracks'); ?></span>
<script>
    var $ =jQuery.noConflict();
    $(document).ready(function() {
        var count = <?php echo $c; ?>;
        $(".add").click(function() {
            count = count + 1;

            $('#here').append('<select name="songs['+count+'][icons]"><option value="No" icon="">No Icon</option><option value="fa-envelope">fa-envelope</option><option value="fa-map-marker">fa-map-marker</option><option value="fa-500px">fa-500px</option><option value="fa-amazon">fa-amazon</option><option value="fa-android">fa-android</option><option value="fa-behance">fa-behance</option><option value="fa-behance-square">fa-behance-square</option><option value="fa-bitbucket">fa-bitbucket</option><option value="fa-bitbucket-square">fa-bitbucket-square</option><option value="fa-cc-amex">fa-cc-amex</option><option value="fa-cc-diners-club">fa-cc-diners-club</option><option value="fa-cc-discover">fa-cc-discover</option><option value="fa-cc-jcb">fa-cc-jcb</option><option value="fa-cc-mastercard">fa-cc-mastercard</option><option value="fa-paypal">fa-paypal</option><option value="fa-cc-stripe">fa-cc-stripe</option><option value="fa-cc-visa">fa-cc-visa</option><option value="fa-codepen">fa-codepen</option><option value="fa-css3">fa-css3</option><option value="fa-delicious">fa-delicious</option><option value="fa-deviantart">fa-deviantart</option><option value="fa-digg">fa-digg</option><option value="fa-dribbble">fa-dribbble</option><option value="fa-dropbox">fa-dropbox</option><option value="fa-drupal">fa-drupal</option><option value="fa-facebook">fa-facebook</option><option value="fa-facebook-official">fa-facebook-official</option><option value="fa-facebook-square">fa-facebook-square</option><option value="fa-flickr">fa-flickr</option><option value="fa-foursquare">fa-foursquare</option><option value="fa-git">fa-git</option><option value="fa-git-square">fa-git-square</option><option value="fa-github">fa-github</option><option value="fa-github-alt">fa-github-alt</option><option value="fa-github-square">fa-github-square</option><option value="fa-google">fa-google</option><option value="fa-google-plus">fa-google-plus</option><option value="fa-google-plus-square">fa-google-plus-square</option><option value="fa-html5">fa-html5</option><option value="fa-instagram">fa-instagram</option><option value="fa-joomla">fa-joomla</option><option value="fa-jsfiddle">fa-jsfiddle</option><option value="fa-linkedin">fa-linkedin</option><option value="fa-linkedin-square">fa-linkedin-square</option><option value="fa-opencart">fa-opencart</option><option value="fa-openid">fa-openid</option><option value="fa-pinterest">fa-pinterest</option><option value="fa-pinterest-p">fa-pinterest-p</option><option value="fa-pinterest-square">fa-pinterest-square</option><option value="fa-rebel">fa-rebel</option><option value="fa-reddit">fa-reddit</option><option value="fa-reddit-square">fa-reddit-square</option><option value="fa-share-alt">fa-share-alt</option><option value="fa-share-alt-square">fa-share-alt-square</option><option value="fa-skype">fa-skype</option><option value="fa-slack">fa-slack</option><option value="fa-soundcloud">fa-soundcloud</option><option value="fa-spotify">fa-spotify</option><option value="fa-stack-overflow">fa-stack-overflow</option><option value="fa-steam">fa-steam</option><option value="fa-steam-square">fa-steam-square</option><option value="fa-tripadvisor">fa-tripadvisor</option><option value="fa-tumblr">fa-tumblr</option><option value="fa-tumblr-square">fa-tumblr-square</option><option value="fa-twitch">fa-twitch</option><option value="fa-twitter">fa-twitter</option><option value="fa-twitter-square">fa-twitter-square</option><option value="fa-vimeo">fa-vimeo</option><option value="fa-vimeo-square">fa-vimeo-square</option><option value="fa-vine">fa-vine</option><option value="fa-whatsapp">fa-whatsapp</option><option value="fa-wordpress">fa-wordpress</option><option value="fa-yahoo">fa-yahoo</option><option value="fa-youtube">fa-youtube</option><option value="fa-youtube-play">fa-youtube-play</option><option value="fa-youtube-square">fa-youtube-square</option></select><p> Song Title <input type="text" name="songs['+count+'][title]" value="" /> -- Track number : <input type="text" name="songs['+count+'][track]" value="" /><span class="remove">Remove Track</span></p>' );
            return false;
        });
        $(".remove").live('click', function() {
            $(this).parent().remove();
        });
    });
    </script>
</div><?php

}

/* When the post is saved, saves our custom data */
function dynamic_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['dynamicMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data

    $songs = $_POST['songs'];

    update_post_meta($post_id,'songs',$songs);
}
?>
