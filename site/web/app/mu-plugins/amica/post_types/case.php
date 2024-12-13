<?php

/*
	Plugin Name: Cases
	Description: 
*/
function case_post_type() {
	$labels = array(
		'name'                  => _x( 'Cases', 'Post Type General Name', 'default' ),
		'singular_name'         => _x( 'Case', 'Post Type Singular Name', 'default' ),
		'menu_name'             => __( 'Cases', 'default' ),
		'name_admin_bar'        => __( 'Case', 'default' ),
		'archives'              => __( '4th Circuit Cases', 'default' ),
		'attributes'            => __( 'Case Attributes', 'default' ),
		// 'parent_item_colon'     => __( 'Parent Case:', 'default' ),
		'all_items'             => __( 'All Cases', 'default' ),
		'add_new_item'          => __( 'Add New Case', 'default' ),
		'add_new'               => __( 'Add New', 'default' ),
		'new_item'              => __( 'New Case', 'default' ),
		'edit_item'             => __( 'Edit Case', 'default' ),
		'update_item'           => __( 'Update Case', 'default' ),
		'view_item'             => __( 'View Case', 'default' ),
		'view_items'            => __( 'View Cases', 'default' ),
		'search_items'          => __( 'Search Case', 'default' ),
		'not_found'             => __( 'Not found', 'default' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'default' ),
		// 'featured_image'        => __( 'Featured Image', 'default' ),
		// 'set_featured_image'    => __( 'Set featured image', 'default' ),
		// 'remove_featured_image' => __( 'Remove featured image', 'default' ),
		// 'use_featured_image'    => __( 'Use as featured image', 'default' ),

		'insert_into_item'      => __( 'Insert into case', 'default' ),
		'uploaded_to_this_item' => __( 'Uploaded to this case', 'default' ),
		'items_list'            => __( 'Cases list', 'default' ),
		'items_list_navigation' => __( 'Cases list navigation', 'default' ),
		'filter_items_list'     => __( 'Filter cases list', 'default' ),
	);
	$args = array(
		'label'                 => __( 'Case', 'default' ),
		'description'           => __( '4th Circuit Cases', 'default' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields', 'categories' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'taxonomies'  					=> ['legal_category', 'judge'],
		'show_in_rest'          => true,
    'rewrite' 						  => ['slug' => 'cases'],
	);
	register_post_type( 'case', $args );

}
add_action( 'init', 'case_post_type', 0 );
