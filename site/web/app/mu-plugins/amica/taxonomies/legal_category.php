<?php

/*
	Taxonomy Name: Legal Category
	Description: 
*/
function legal_category_taxonomy() {
  register_taxonomy('legal_category', ['case'], [
    'public' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => false,
    'show_ui' => true,
    'hierarchical' => true,
    'rewrite' => ['slug' => 'legal_category'],
    'capabilities' => array(
      // 'manage_terms' => '',
      'manage_terms' => 'manage_categories',
      // 'edit_terms' => '',
      'edit_terms' => 'manage_categories',
      // 'delete_terms' => '',
      'delete_terms' => 'manage_categories',
      'assign_terms' => 'edit_posts'
    ),
    'label' => __('Legal Category', 'amica_theme'),
    'labels' => [
      'singular_name' => __('Legal Category', 'amica_theme'),
      'all_items' => __('All Legal Categories', 'amica_theme'),
      'edit_item' => __('Edit Legal Category', 'amica_theme'),
      'view_item' => __('View Legal Category', 'amica_theme'),
      'update_item' => __('Update Legal Category', 'amica_theme'),
      'add_new_item' => __('Add New Legal Category', 'amica_theme'),
      'new_item_name' => __('New Legal Category Name', 'amica_theme'),
      'search_items' => __('Search Legal Categories', 'amica_theme'),
      'popular_items' => __('Popular Legal Categories', 'amica_theme'),
      'separate_items_with_commas' => __('Separate legal_categories with comma', 'amica_theme'),
      'choose_from_most_used' => __('Choose from most used legal_categories', 'amica_theme'),
      'not_found' => __('No legal_categories found', 'amica_theme'),
    ],

  ]);
  register_taxonomy_for_object_type('legal_category', 'case');
}

add_action( 'init', 'legal_category_taxonomy', 0 );
