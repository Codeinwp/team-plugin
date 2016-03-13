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
function team_members_custom_post_type() {
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
        'supports'            => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
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

    //add thumbnail size for team members.
    add_image_size( 'team-member-custom-thumbnail', 200, 200, true );
}

add_action( 'init', 'team_members_custom_post_type', 0 );


/**
 *  Custom Post Type Metaboxes
 */
function add_team_members_metaboxes() {
  add_meta_box(
          'my-meta-box',
          __( 'My Meta Box' ),
          'render_my_meta_box',
          'team-member',
          'normal',
          'default'
      );
}
add_action( 'add_meta_boxes', 'add_team_members_metaboxes' );


/**
 *  Check for single template. Fallback to default single.php
 */
function get_custom_post_type_template($single_template) {
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
add_filter( 'single_template', 'get_custom_post_type_template' );


/**
 *  Create Shortcode For Section Output
 */
function team_section_creation() {

  if ( $overridden_template = locate_template( '/content-team-template.php' ) ) {
    load_template( $overridden_template );
  } else {
    load_template( dirname( __FILE__ ) . '/template-parts/content-team-template.php' );
  }

}
add_shortcode('team', 'team_section_creation');

?>
