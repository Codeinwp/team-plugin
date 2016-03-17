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

function team_plugin_enqueue_admin_styles() {
        wp_register_style( 'team_plugin_admin_style', plugin_dir_url( __FILE__ ) . 'admin/css/style.css', false, '1.0.0' );
        wp_enqueue_style( 'team_plugin_admin_style' );

        wp_register_style( 'team_plugin_font_awesome', plugin_dir_url( __FILE__ ) . 'admin/css/font-awesome.min.css', false, '4.5.0' );
        wp_enqueue_style( 'team_plugin_font_awesome' );

        wp_register_script( 'team_plugin_admin_script', plugin_dir_url( __FILE__ ) . 'admin/js/admin.js', false, '1.0.0', true );
        wp_enqueue_script( 'team_plugin_admin_script' );

        wp_register_script( 'team_plugin_ddslick', plugin_dir_url( __FILE__ ) . 'admin/js/ddslick.js', false, '1.0.0', true );
        wp_enqueue_script( 'team_plugin_ddslick' );

}
add_action( 'admin_enqueue_scripts', 'team_plugin_enqueue_admin_styles' );



include( plugin_dir_path( __FILE__ ) . 'admin/metaboxes.php');

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
    add_image_size( 'team-member-custom-thumbnail', 200, 200, true );
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
        //  die();
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

  if ( $overridden_template = locate_template( '/content-team-template.php' ) ) {
    load_template( $overridden_template );
  } else {

    load_template( dirname( __FILE__ ) . '/template-parts/content-team-template.php' );
  }

}
add_shortcode( 'team', 'team_plugin_section_shortcode' );

?>
