<?php

/*
	Taxonomy Name: Judge
	Description: 
*/
function judge_taxonomy() {
  register_taxonomy('judge', ['case'], [
    'public' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => false,
    'show_ui' => true,
    'hierarchical' => true,
    'rewrite' => ['slug' => 'judge'],
    'capabilities' => array(
      // 'manage_terms' => '',
      'manage_terms' => 'manage_categories',
      // 'edit_terms' => '',
      'edit_terms' => 'manage_categories',
      // 'delete_terms' => '',
      'delete_terms' => 'manage_categories',
      'assign_terms' => 'edit_posts'
    ),
    'label' => __('Judge', 'amica_theme'),
    'labels' => [
      'singular_name' => __('Judge', 'amica_theme'),
      'all_items' => __('All Judges', 'amica_theme'),
      'edit_item' => __('Edit Judge', 'amica_theme'),
      'view_item' => __('View Judge', 'amica_theme'),
      'update_item' => __('Update Judge', 'amica_theme'),
      'add_new_item' => __('Add New Judge', 'amica_theme'),
      'new_item_name' => __('New Judge Name', 'amica_theme'),
      'search_items' => __('Search Judges', 'amica_theme'),
      'popular_items' => __('Popular Judges', 'amica_theme'),
      'separate_items_with_commas' => __('Separate judges with comma', 'amica_theme'),
      'choose_from_most_used' => __('Choose from most used judges', 'amica_theme'),
      'not_found' => __('No judges found', 'amica_theme'),
    ],

  ]);
  register_taxonomy_for_object_type('judge', 'case');
}

add_action( 'init', 'judge_taxonomy', 0 );

