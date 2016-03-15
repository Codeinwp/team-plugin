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
  // Add custom metabox.
  $prefix = 'team_plugin_';

  $meta_box = array(
      'id' => 'team-member-properties-meta-box',
      'title' => __('Team Member Properties', 'team-plugin'),
      'page' => 'team-member',
      'context' => 'normal',
      'priority' => 'high',
      'fields' => array(
          array(
              'id' => $prefix . 'facebook_link',
              'name' => 'Facebook Link',
              'description' => 'Add a Facebook link for this team member',
              'type' => 'text',
              'std' => '#'
          ),
      )
  );

  add_meta_box($meta_box['id'], $meta_box['title'], 'team_plugin_render_custom_metabox', $meta_box['page'], $meta_box['context'], $meta_box['priority']);

}
add_action('add_meta_boxes_team-member', 'team_plugin_add_custom_metabox');


/**
 *  Render metabox.
 */
function team_plugin_render_custom_metabox($post) {
   global $meta_box;

   // Use nonce for verification
   echo '<input type="hidden" name="team_plugin_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

   echo '<table class="form-table">';

   foreach ($meta_box['fields'] as $field) {
      //  get current post meta data
       $meta = get_post_meta($post->ID, $field['id'], true);

       echo '<tr>',
               '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
               '<td>';
       switch ($field['type']) {
           case 'text':
               echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['description'];
               break;
           case 'textarea':
               echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['description'];
               break;
           case 'select':
               echo '<select name="', $field['id'], '" id="', $field['id'], '">';
               foreach ($field['options'] as $option) {
                   echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
               }
               echo '</select>';
               break;
           case 'radio':
               foreach ($field['options'] as $option) {
                   echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
               }
               break;
           case 'checkbox':
               echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
               break;
       }
       echo     '</td><td>',
           '</td></tr>';
   }

   echo '</table>';
}


/**
 *  Save metaboxes data.
 */
function team_plugin_save_data($post_id) {
  // global $meta_box;
  //
  // // verify nonce
  // if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
  //     return $post_id;
  // }
  //
  // // check autosave
  // if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
  //     return $post_id;
  // }
  //
  // // check permissions
  // if ('team-member' == $_POST['post_type']) {
  //     if (!current_user_can('edit_page', $post_id)) {
  //         return $post_id;
  //     }
  // } elseif (!current_user_can('edit_post', $post_id)) {
  //     return $post_id;
  // }
  //
  // foreach ($meta_box['fields'] as $field) {
  //     $old = get_post_meta($post_id, $field['id'], true);
  //     $new = $_POST[$field['id']];
  //     echo '<script> alert( '. $new .' )</script>';
  //
  //     if ($new && $new != $old) {
  //         update_post_meta($post_id, $field['id'], $new);
  //     } elseif ('' == $new && $old) {
  //         delete_post_meta($post_id, $field['id'], $old);
  //     }
  // }
}

//On post save, save plugin's data
add_action('save_post', 'team_plugin_save_data');

?>
