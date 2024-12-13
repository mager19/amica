<?php

/*
	Taxonomy Name: Relationship
	Description: 
*/
function relationship_taxonomy() {
  register_taxonomy('relationship', ['person'], [
    'public' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => false,
    'show_ui' => true,
    'hierarchical' => true,
    'rewrite' => ['slug' => 'relationship'],
    'capabilities' => array(
      // 'manage_terms' => '',
      'manage_terms' => 'manage_categories',
      // 'edit_terms' => '',
      'edit_terms' => 'manage_categories',
      // 'delete_terms' => '',
      'delete_terms' => 'manage_categories',
      'assign_terms' => 'edit_posts'
    ),
    'label' => __('Relationship', 'amica_theme'),
    'labels' => [
      'singular_name' => __('Relationship', 'amica_theme'),
      'all_items' => __('All Relationships', 'amica_theme'),
      'edit_item' => __('Edit Relationship', 'amica_theme'),
      'view_item' => __('View Relationship', 'amica_theme'),
      'update_item' => __('Update Relationship', 'amica_theme'),
      'add_new_item' => __('Add New Relationship', 'amica_theme'),
      'new_item_name' => __('New Relationship Name', 'amica_theme'),
      'search_items' => __('Search Relationships', 'amica_theme'),
      'popular_items' => __('Popular Relationships', 'amica_theme'),
      'separate_items_with_commas' => __('Separate items with comma', 'amica_theme'),
      'choose_from_most_used' => __('Choose from most used relationship type', 'amica_theme'),
      'not_found' => __('No relationship types found', 'amica_theme'),
    ],

  ]);
  register_taxonomy_for_object_type('relationship', 'person');
}

add_action( 'init', 'relationship_taxonomy', 0 );


function add_email_field_to_taxonomy() {
	?>
	<div class="form-field term-group">
			<label for="contact-email"><?php _e('Contact Email', 'amica'); ?></label>
			<input type="email" id="contact-email" name="contact-email" value="">
	</div>
	<div class="form-field term-group">
			<label for="contact-label"><?php _e('Contact Label', 'amica'); ?></label>
			<input type="text" id="contact-label" name="contact-label" value="">
	</div>
	<?php
}
add_action('relationship_add_form_fields', 'add_email_field_to_taxonomy');


function edit_email_field_in_taxonomy($term) {
	$term_id = $term->term_id;
	$contact_email = get_term_meta($term_id, 'contact-email', true);
	$contact_label = get_term_meta($term_id, 'contact-label', true);
	?>
	<tr class="form-field term-group-wrap">
			<th scope="row"><label for="contact-email"><?php _e('Contact Email', 'amica'); ?></label></th>
			<td>
					<input type="email" id="contact-email" name="contact-email" value="<?php echo esc_attr($contact_email); ?>">
			</td>
	</tr>
	<tr class="form-field term-group-wrap">
			<th scope="row"><label for="contact-label"><?php _e('Contact Label', 'amica'); ?></label></th>
			<td>
					<input type="text" id="contact-label" name="contact-label" value="<?php echo esc_attr($contact_label); ?>">
			</td>
	</tr>
	<?php
}
add_action('relationship_edit_form_fields', 'edit_email_field_in_taxonomy');


function save_taxonomy_email_field($term_id) {
	if (isset($_POST['contact-email']) || isset($_POST['contact-label'])) {
    update_term_meta($term_id, 'contact-email', sanitize_email($_POST['contact-email']));
    update_term_meta($term_id, 'contact-label', sanitize_text_field($_POST['contact-label']));
	}
}
add_action('created_relationship', 'save_taxonomy_email_field');
add_action('edited_relationship', 'save_taxonomy_email_field');
