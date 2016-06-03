<?php
/*
Plugin Name: Teammates
Plugin URI: https://wordpress.org/plugins/teammates/
Description: A plugin that helps you manage your team area easier using just a shortcode [teammates] that can be simply added anywhere on your site.
Version: 0.1.3
Author: Themeisle
Author URI: http://themeisle.com
Text Domain: teammates
*/

/**
 *  Enqueue style and script for back end
 */
function teammates_enqueue_admin_styles() {
       
	wp_register_style( 'teammates_admin_style', plugin_dir_url( __FILE__ ) . 'admin/css/style.css', false, '1.0.0' );
    wp_enqueue_style( 'teammates_admin_style' );

    wp_register_script( 'teammates_admin_script', plugin_dir_url( __FILE__ ) . 'admin/js/admin.js', false, '1.0.0', true );
    wp_enqueue_script( 'teammates_admin_script' );

}
add_action( 'admin_enqueue_scripts', 'teammates_enqueue_admin_styles' );


/**
 *  Load customizer script for settings async
 */
function teammates_customizer_async() {
	
	wp_register_script( 'teammates_async_script', plugin_dir_url( __FILE__ ) . 'admin/js/customizer.js', false, '1.0.0', true );
    wp_enqueue_script( 'teammates_async_script' );

}
add_action( 'customize_preview_init', 'teammates_customizer_async' );

/**
 *  Check for Bootstrap and enqueue it if it is not present
 */
function teammates_check_dependencies() {

	$wp_styles = wp_styles();
	$registered_styles = $wp_styles->registered;
	$serialized_styles = serialize($registered_styles);

	$wp_scripts = wp_scripts();
	$registered_scripts = $wp_scripts->registered;
	$serialized_scripts = serialize($registered_scripts);

	//check for twitter bootstrap and enqueue it in absence.
	if ((strpos($serialized_scripts, 'bootstrap') == false) && (strpos($serialized_styles, 'bootstrap') == false)) {
		wp_register_style( 'teammates_bootstrap', plugin_dir_url( __FILE__ ) . 'public/css/bootstrap.min.css', false, 'v3.3.6' );
		wp_enqueue_style( 'teammates_bootstrap' );
	}
	
	//check for fontawesome and enqueue it in absence.
	if((strpos($serialized_styles, 'fontawesome') == false) && (strpos($serialized_styles, 'font-awesome') == false)) {
		wp_register_style( 'teammates_fontawesome', plugin_dir_url( __FILE__ ) . 'public/css/font-awesome.min.css', false, 'v4.5.0' );
		wp_enqueue_style( 'teammates_fontawesome' );
	}

}
add_action( 'wp_enqueue_scripts', 'teammates_check_dependencies', 9999 );


/**
 *  Enqueue style and script for front end
 */
function teammates_enqueue_styles() {
	
	if (!file_exists(get_template_directory() . '/content-team-single.php')) {
		wp_register_style( 'teammates_style_shortcode_section', plugin_dir_url( __FILE__ ) . 'public/css/style-section.css', false, '1.0.0' );
		wp_enqueue_style( 'teammates_style_shortcode_section' );
	}

	if (!file_exists(get_template_directory() . '/single-teammates.php')) {
		wp_register_style( 'teammates_style_single_member', plugin_dir_url( __FILE__ ) . 'public/css/style-single.css', false, '1.0.0' );
		wp_enqueue_style( 'teammates_style_single_member' );
	}
}
add_action( 'wp_enqueue_scripts', 'teammates_enqueue_styles' );


/**
 *  Flush Rewrite Rules on activation and on theme change
 */
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

register_activation_hook( __FILE__, 'teammates_flush_rewrites' );

add_action( 'after_switch_theme', 'flush_rewrite_rules' );

function teammates_flush_rewrites() {
	teammates_members_custom_post_type();
	flush_rewrite_rules();
}

/**
 *  Include the metabox construction for team members custom post type.
 */
include plugin_dir_path( __FILE__ ) . 'admin/inc/metaboxes.php';

/*
Call customizer extension
*/
require plugin_dir_path( __FILE__ ) . 'admin/inc/customizer.php';

/*
Call customizer extension
*/
require plugin_dir_path( __FILE__ ) . 'admin/inc/custom-colors.php';

/*
Call customizer extension
*/
function teammates_settings_buttons( $actions, $plugin_file ) {
	static $plugin;

	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	if ($plugin == $plugin_file) {

		$settings = array('settings' => '<a href="' . admin_url( 'customize.php?autofocus[panel]=teammates_panel' ) . '">' . __('Settings', 'teammates') . '</a>');

    	$actions = array_merge($settings, $actions);

	}

	return $actions;
}
add_filter( 'plugin_action_links', 'teammates_settings_buttons', 10, 5 );

/**
 *  Custom Post Type: Team Member
 */
function teammates_members_custom_post_type() {
	
	$labels = array(
        'name'                => _x( 'Teammates', 'teammates' ),
        'singular_name'       => _x( 'Teammate', 'teammates' ),
        'menu_name'           => __( 'Teammates', 'teammates' ),
        'parent_item_colon'   => __( 'Parent Teammate:', 'teammates' ),
        'all_items'           => __( 'All Teammates', 'teammates' ),
        'view_item'           => __( 'View Teammate', 'teammates' ),
        'add_new_item'        => __( 'Add New Teammate', 'teammates' ),
        'add_new'             => __( 'Add New Teammate', 'teammates' ),
        'edit_item'           => __( 'Edit Teammate', 'teammates' ),
        'update_item'         => __( 'Update Teammate', 'teammates' ),
        'search_items'        => __( 'Search Teammates', 'teammates' ),
        'not_found'           => __( 'Not found', 'teammates' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'teammates' ),
    );
    $args = array(
        'label'               => __( 'teammate', 'teammates' ),
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
    register_post_type( 'teammate', $args );

	//Add thumbnail size for team members.
    add_image_size( 'teammate-custom-thumbnail', 220, 220, true );
    add_image_size( 'teammate-single-page-thumbnail', 370, 550, true );

	// Add new taxonomy, make it hierarchical (like categories)
    $labels_tax = array(
    	'name'              => _x( 'Member Groups', 'taxonomy general name', 'teammates' ),
    	'singular_name'     => _x( 'Member Group', 'taxonomy singular name', 'teammates' ),
    	'search_items'      => __( 'Search Member Groups', 'teammates' ),
    	'all_items'         => __( 'All Member Groups', 'teammates' ),
    	'parent_item'       => __( 'Parent Member Group', 'teammates' ),
    	'parent_item_colon' => __( 'Parent Member Group:', 'teammates' ),
    	'edit_item'         => __( 'Edit Member Group', 'teammates' ),
    	'update_item'       => __( 'Update Member Group', 'teammates' ),
    	'add_new_item'      => __( 'Add New Member Group', 'teammates' ),
    	'new_item_name'     => __( 'New Member Group Name', 'teammates' ),
    	'menu_name'         => __( 'Member Groups', 'teammates' ),
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
    register_taxonomy( 'member-group', array( 'teammate' ), $args_tax );

}
add_action( 'init', 'teammates_members_custom_post_type', 50 );


/**
 *  Check for single template. Fallback to default single.php if there is none.
 */
function teammates_check_template($single_template) {
     global $post;

     if ($post->post_type == 'teammate') {

       if (file_exists(get_template_directory() . '/single-teammate.php')) {

         $single_template = get_template_directory() . '/single-teammate.php';
       } else {
         $single_template = dirname( __FILE__ ) . '/template-parts/single-teammate.php';
        }
    }

    return $single_template;
}
add_filter( 'single_template', 'teammates_check_template' );


/**
 *  Create Shortcode For Section Output
 */
function teammates_section_shortcode() {

  // if ( $overridden_template = locate_template( '/content-team-template.php' ) ) {
  //
  //   load_template( $overridden_template );
  //
  // } else {

    load_template( dirname( __FILE__ ) . '/template-parts/content-team-template.php' );
  // }

}
add_shortcode( 'teammates', 'teammates_section_shortcode' );

?>
