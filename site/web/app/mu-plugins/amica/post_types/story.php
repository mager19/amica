<?php

/*
	Plugin Name: Stories
	Description: 
*/
function story_post_type() {
	$labels = array(
		'name'                  => _x( 'Stories', 'Post Type General Name', 'default' ),
		'singular_name'         => _x( 'Story', 'Post Type Singular Name', 'default' ),
		'menu_name'             => __( 'Stories', 'default' ),
		'name_admin_bar'        => __( 'Story', 'default' ),
		'archives'              => __( 'All Stories', 'default' ),
		'attributes'            => __( 'Story Attributes', 'default' ),
		'all_items'             => __( 'All Stories', 'default' ),
		'add_new_item'          => __( 'Add New Story', 'default' ),
		'add_new'               => __( 'Add New', 'default' ),
		'new_item'              => __( 'New Story', 'default' ),
		'edit_item'             => __( 'Edit Story', 'default' ),
		'update_item'           => __( 'Update Story', 'default' ),
		'view_item'             => __( 'View Story', 'default' ),
		'view_items'            => __( 'View Stories', 'default' ),
		'search_items'          => __( 'Search Story', 'default' ),
		'not_found'             => __( 'Not found', 'default' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'default' ),
		'featured_image'        => __( 'Featured Image', 'default' ),
		'set_featured_image'    => __( 'Set featured image', 'default' ),
		'remove_featured_image' => __( 'Remove featured image', 'default' ),
		'use_featured_image'    => __( 'Use as featured image', 'default' ),

		'insert_into_item'      => __( 'Insert into story', 'default' ),
		'uploaded_to_this_item' => __( 'Uploaded to this story', 'default' ),
		'items_list'            => __( 'Stories list', 'default' ),
		'items_list_navigation' => __( 'Stories list navigation', 'default' ),
		'filter_items_list'     => __( 'Filter stories list', 'default' ),
	);
  $args = array(
		'label'                 => __( 'Story', 'amica' ),
		'description'           => __( "Stories about Amica's work", 'amica' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'taxonomies'  					=> ['story_category'],
		'capability_type'       => 'post',
    'show_in_rest'          => true,
    'rewrite'               => ['slug' => 'stories'],
	);
	register_post_type( 'story', $args );

}
add_action( 'init', 'story_post_type', 0 );

