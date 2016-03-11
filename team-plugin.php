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



add_action( 'init', 'team_members_custom_post_type', 0 );
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
}


add_action( 'init', 'team_members_categories', 0 );
/**
 *  Taxonomy: Team Member Categories
 */
function team_members_categories() {
    $labels = array(
        'name'              => _x( 'Team Members Categories', 'taxonomy general name', 'team-plugin' ),
        'singular_name'     => _x( 'Team Members Category', 'taxonomy singular name', 'team-plugin' ),
        'search_items'      => __( 'Search Team Members Categories', 'team-plugin' ),
        'all_items'         => __( 'All Team Members Categories', 'team-plugin' ),
        'parent_item'       => __( 'Parent Team Members Category', 'team-plugin' ),
        'parent_item_colon' => __( 'Parent Team Members Category:', 'team-plugin' ),
        'edit_item'         => __( 'Edit Team Members Category', 'team-plugin' ),
        'update_item'       => __( 'Update Team Members Category', 'team-plugin' ),
        'add_new_item'      => __( 'Add New Team Members Category', 'team-plugin' ),
        'new_item_name'     => __( 'New Team Members Category', 'team-plugin' ),
        'menu_name'         => __( 'Team Members Categories', 'team-plugin' ),
        'rewrite' => array('slug' => 'team-member-categories', 'with_front' => true),
    );
    $args = array(
        'labels'              => $labels,
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'exclude_from_search' => false,
        'show_admin_column'   => true,
        'query_var'           => true,
        'rewrite'             => false
    );
    register_taxonomy( 'team-member-categories', 'lawyers', $args );
}


// Shortcode Script
function team_section_creation() {

$query = new WP_Query( array( 'post_type' => 'team-member', ) );

if ( $query->have_posts() ) : ?>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="entry">
			<h2 class="title"><?php the_title(); ?></h2>
			<?php the_content(); ?>
		</div>
	<?php endwhile; wp_reset_postdata(); ?>
	<!-- show pagination here -->
<?php else : ?>
	<!-- show 404 error here -->
<?php endif; ?>
<h1>SHORTCODE</h1>

<?php
}
add_shortcode('team', 'team_section_creation');
?>
