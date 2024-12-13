<?php
/*
  Plugin Name: Amica Custom Plugin
  Description: Custom post types, functions, and configurations for Amica Center website
  Author: Swell, Inc.
  Version: 1.0
*/

require_once __DIR__ . '/post_types/case.php';
require_once __DIR__ . '/post_types/person.php';
require_once __DIR__ . '/post_types/story.php';
require_once __DIR__ . '/taxonomies/relationship.php';
require_once __DIR__ . '/taxonomies/judge.php';
require_once __DIR__ . '/taxonomies/story_category.php';
require_once __DIR__ . '/taxonomies/legal_category.php';



/**
 * Redirect any user trying to access comments page
 */
add_action('admin_init', function () {
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }


    // wp_insert_term('Advisory committee', 'relationship'); 
    // wp_insert_term('Board of directors','relationship');
    // wp_insert_term('Staff','relationship');
});

/**
 * Removes Comments
 */
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

add_action('add_sharer_script', function () {
	wp_enqueue_script('sharer', 'https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js');
});


/**
 * Function to change "posts" to "news" in the admin side menu
 */ 
function amica_change_post_menu_label() {
    global $menu;
    global $submenu;
    $post_index = null;
    foreach ( $menu as $key => $item ) {
      if ( $item[0] == "Posts" ) $post_index = $key;
    }
    if ( $post_index ) {
      $menu[$post_index][0] = 'News';
      $submenu['edit.php'][5][0] = 'News';
      $submenu['edit.php'][10][0] = 'Add News';
      echo '';
    }
    
}
add_action( 'admin_menu', 'amica_change_post_menu_label' );

// Function to change post object labels to "news"
function amica_change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
}
add_action( 'init', 'amica_change_post_object_label' );

add_filter( 'body_class', function( $classes ) {
	return array_merge( $classes, array( 'bg-white' ) );
} );

/**
 * Post Classes
 */
function amica_post_class( $classes, $class, $post_id ) {
    if ( get_post_type($post_id) === 'case' ) $classes[] = 'bg-white -mt-px pt-inner pb-max';
        else $classes[] = 'bg-white -mt-px py-full';

    // Add a class


    return $classes;
}
add_filter( 'post_class', 'amica_post_class', 10, 3 );

/**
 * Add Query Var
 */
// function form_submitted_var( $qvars ) {
  // $qvars[] = 'form_submitted';
  // return $qvars;
// }
// add_filter( 'query_vars', 'form_submitted_var' );



/**
 * Use radio inputs instead of checkboxes for term checklists in specified taxonomies.
 *
 * @param  array  $args
 * @return  array
 */
// function amica_term_radio_checklist( $args ) {
//   if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'judge' ) {
//     if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { // Don't override 3rd party walkers.
//       if ( ! class_exists( 'Amica_Walker_Category_Radio_Checklist' ) ) {
//         /**
//         * Custom walker for switching checkbox inputs to radio.
//         *
//         * @see Walker_Category_Checklist
//         */
//         class Amica_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
//           function walk( $elements, $max_depth, ...$args ) {
//            $output = parent::walk( $elements, $max_depth, ...$args );
//            $output = str_replace(
//             array( 'type="checkbox"', "type='checkbox'" ),
//             array( 'type="radio"', "type='radio'" ),
//             $output
//            );
//            return $output;
//           }
//         }
//       }
//       $args['walker'] = new Amica_Walker_Category_Radio_Checklist;
//     }
//   }
//   return $args;
// }

// add_filter( 'wp_terms_checklist_args', 'amica_term_radio_checklist' );