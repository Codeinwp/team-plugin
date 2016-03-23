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
 *  Enqueue style and script for back end
 */
function team_plugin_enqueue_admin_styles() {
        wp_register_style( 'team_plugin_admin_style', plugin_dir_url( __FILE__ ) . 'admin/css/style.css', false, '1.0.0' );
        wp_enqueue_style( 'team_plugin_admin_style' );

        wp_register_script( 'team_plugin_admin_script', plugin_dir_url( __FILE__ ) . 'admin/js/admin.js', false, '1.0.0', true );
        wp_enqueue_script( 'team_plugin_admin_script' );

}
add_action( 'admin_enqueue_scripts', 'team_plugin_enqueue_admin_styles' );

/**
 *  Check for Bootstrap and enqueue it if it is not present
 */
function team_plugin_check_dependencies() {

  $wp_styles = wp_styles();
  $registered_styles = $wp_styles->registered;
  $serialized_styles = serialize($registered_styles);

  $wp_scripts = wp_scripts();
  $registered_scripts = $wp_scripts->registered;
  $serialized_scripts = serialize($registered_scripts);

//check for twitter bootstrap and enqueue it in absence
  if ((strpos($serialized_scripts, 'bootstrap') == false) || (strpos($serialized_styles, 'bootstrap') == false)) {
    wp_register_style( 'team_plugin_bootstrap', plugin_dir_url( __FILE__ ) . 'public/css/bootstrap.min.css', false, 'v3.3.6' );
    wp_enqueue_style( 'team_plugin_bootstrap' );
  }
//check for fontawesome and enqueue it in absence
  if((strpos($serialized_styles, 'fontawesome') == false) || (strpos($serialized_styles, 'font-awesome') == false)) {
    wp_register_style( 'team_plugin_fontawesome', plugin_dir_url( __FILE__ ) . 'public/css/font-awesome.min.css', false, 'v4.5.0zz' );
    wp_enqueue_style( 'team_plugin_fontawesome' );
  }

}
add_action( 'wp_enqueue_scripts', 'team_plugin_check_dependencies', 9999 );


/**
 *  Enqueue style and script for front end
 */
function team_plugin_enqueue_styles() {
   if (!file_exists(TEMPLATEPATH . '/content-team-single.php')) {
    wp_register_style( 'team_plugin_style_shortcode_section', plugin_dir_url( __FILE__ ) . 'public/css/style-section.css', false, '1.0.0' );
    wp_enqueue_style( 'team_plugin_style_shortcode_section' );
  }

  if (!file_exists(TEMPLATEPATH . '/single-team-member.php')) {
   wp_register_style( 'team_plugin_style_single_member', plugin_dir_url( __FILE__ ) . 'public/css/style-single.css', false, '1.0.0' );
   wp_enqueue_style( 'team_plugin_style_single_member' );
 }
}
add_action( 'wp_enqueue_scripts', 'team_plugin_enqueue_styles' );


/**
 *  Flush Rewrite Rules on activation and on theme change
 */
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

register_activation_hook( __FILE__, 'team_plugin_flush_rewrites' );

add_action( 'after_switch_theme', 'flush_rewrite_rules' );

function team_plugin_flush_rewrites() {
	team_plugin_members_custom_post_type();
	flush_rewrite_rules();
}


/**
 *  Include the metabox construction for team members custom post type.
 */
include plugin_dir_path( __FILE__ ) . 'admin/metaboxes.php';

/*
Call customizer extension
*/
require plugin_dir_path( __FILE__ ) . '/inc/customizer.php';

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
        'supports'            => array( 'title', 'editor', 'thumbnail'),
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

//Add thumbnail size for team members.
    add_image_size( 'team-member-custom-thumbnail', 220, 220, true );
    add_image_size( 'team-member-single-page-thumbnail', 370, 550, true );

// Add new taxonomy, make it hierarchical (like categories)
    $labels_tax = array(
    	'name'              => _x( 'Member Groups', 'taxonomy general name' ),
    	'singular_name'     => _x( 'Member Group', 'taxonomy singular name' ),
    	'search_items'      => __( 'Search Member Groups' ),
    	'all_items'         => __( 'All Member Groups' ),
    	'parent_item'       => __( 'Parent Member Group' ),
    	'parent_item_colon' => __( 'Parent Member Group:' ),
    	'edit_item'         => __( 'Edit Member Group' ),
    	'update_item'       => __( 'Update Member Group' ),
    	'add_new_item'      => __( 'Add New Member Group' ),
    	'new_item_name'     => __( 'New Member Group Name' ),
    	'menu_name'         => __( 'Member Groups' ),
    );
    $args_tax = array(
      'hierarchical'          => false,
  		'labels'                => $labels_tax,
  		'show_ui'               => true,
  		'show_admin_column'     => true,
  		'update_count_callback' => '_update_post_term_count',
  		'query_var'             => true,
  		'rewrite'               => array( 'slug' => 'member-group' ),
    );
    register_taxonomy( 'member-group', array( 'team-member' ), $args_tax );

}
add_action( 'init', 'team_plugin_members_custom_post_type', 50 );


/**
 *  Check for single template. Fallback to default single.php if there is none.
 */
function team_plugin_check_template($single_template) {
     global $post;

     if ($post->post_type == 'team-member') {

       if (file_exists(TEMPLATEPATH . '/single-team-member.php')) {

         $single_template = TEMPLATEPATH . '/single-team-member.php';
       } else {
         $single_template = dirname( __FILE__ ) . '/template-parts/single-team-member.php';
        }
    }

    return $single_template;
}
add_filter( 'single_template', 'team_plugin_check_template' );


/**
 *  Create Shortcode For Section Output
 */
function team_plugin_section_shortcode() {

  // if ( $overridden_template = locate_template( '/content-team-template.php' ) ) {
  //
  //   load_template( $overridden_template );
  //
  // } else {

    load_template( dirname( __FILE__ ) . '/template-parts/content-team-template.php' );
  // }

}
add_shortcode( 'team', 'team_plugin_section_shortcode' );

?>
