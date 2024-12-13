<?php

/*
	Taxonomy Name: Story Category
	Description: 
*/
function story_category_taxonomy() {
  register_taxonomy('story_category', ['story'], [
    'public' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => false,
    'show_in_rest'      => true,
    'show_ui'           => true,
    'hierarchical'      => true,
    'rewrite'           => ['slug' => 'story_category'],
    'capabilities'      => array(
      // 'manage_terms' => '',
      'manage_terms' => 'manage_categories',
      // 'edit_terms' => '',
      'edit_terms' => 'manage_categories',
      // 'delete_terms' => '',
      'delete_terms' => 'manage_categories',
      'assign_terms' => 'edit_posts'
    ),
    'label' => __('Story Category', 'amica_theme'),
    'labels' => [
      'singular_name' => __('Story Category', 'amica_theme'),
      'all_items' => __('All Story Categories', 'amica_theme'),
      'edit_item' => __('Edit Story Category', 'amica_theme'),
      'view_item' => __('View Story Category', 'amica_theme'),
      'update_item' => __('Update Story Category', 'amica_theme'),
      'add_new_item' => __('Add New Story Category', 'amica_theme'),
      'new_item_name' => __('New Story Category Name', 'amica_theme'),
      'search_items' => __('Search Story Categories', 'amica_theme'),
      'popular_items' => __('Popular Story Categories', 'amica_theme'),
      'separate_items_with_commas' => __('Separate story_categories with comma', 'amica_theme'),
      'choose_from_most_used' => __('Choose from most used story_categories', 'amica_theme'),
      'not_found' => __('No story_categories found', 'amica_theme'),
    ],

  ]);
  register_taxonomy_for_object_type('story_category', 'story');
}

add_action( 'init', 'story_category_taxonomy', 0 );
