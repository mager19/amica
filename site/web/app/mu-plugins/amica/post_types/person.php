<?php
// 
// 
//   -> Category (Staff Directory, Advisory, Directors), Category Description
//     -> Name
//     -> Title
//     -> Contact (not required)

/*
	Post Type: People
	Description: 
*/
function person_post_type() {
	$labels = array(
		'name'                  => _x( 'People and Partners', 'Post Type General Name', 'default' ),
		'singular_name'         => _x( 'Person or Partner', 'Post Type Singular Name', 'default' ),
		'menu_name'             => __( 'People and Partners', 'default' ),
		'name_admin_bar'        => __( 'Person or Partner', 'default' ),
		// 'archives'              => __( 'Person Archive', 'default' ),
		'attributes'            => __( 'Person Attributes', 'default' ),
		'parent_item_colon'     => __( 'Parent Person or Partner:', 'default' ),
		'all_items'             => __( 'All People and Partners', 'default' ),
		'add_new_item'          => __( 'Add New Person or Partner', 'default' ),
		'add_new'               => __( 'Add New', 'default' ),
		'new_item'              => __( 'New Person or Partner', 'default' ),
		'edit_item'             => __( 'Edit Person or Partner', 'default' ),
		'update_item'           => __( 'Update Person or Partner', 'default' ),
		'view_item'             => __( 'View Person', 'default' ),
		'view_items'            => __( 'View People and Partners', 'default' ),
		'search_items'          => __( 'Search Person or Partner', 'default' ),
		'not_found'             => __( 'Not found', 'default' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'default' ),
		// 'featured_image'        => __( 'Featured Image', 'default' ),
		// 'set_featured_image'    => __( 'Set featured image', 'default' ),
		// 'remove_featured_image' => __( 'Remove featured image', 'default' ),
		// 'use_featured_image'    => __( 'Use as featured image', 'default' ),

		'insert_into_item'      => __( 'Insert into person', 'default' ),
		'uploaded_to_this_item' => __( 'Uploaded to this person', 'default' ),
		'items_list'            => __( 'People list', 'default' ),
		'items_list_navigation' => __( 'People list navigation', 'default' ),
		'filter_items_list'     => __( 'Filter people list', 'default' ),
	);
	$args = array(
		'label'                 => __( 'Person', 'default' ),
		'description'           => __( 'People', 'default' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields', 'categories' ), 
		'hierarchical'          => false,
		'public'                => true, // set to false to stop having people pages
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-businessperson',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rewrite'               => ['slug' => 'person'],
	);
	register_post_type( 'person', $args );
}
add_action( 'init', 'person_post_type', 0 );
