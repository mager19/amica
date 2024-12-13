<?php

/**
 * Register our callback to the appropriate filter
 */
function add_style_select_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );


/**
 * Add editor stylesheet
 */
function my_format_TinyMCE( $in ) {
	// $style_formats = [
	// 	[
	// 		'title' => 'PullQuote',
	// 		'block' => 'p',
	// 		'classes' => 'pullQuote',
	// 		'wrapper' => false
	// 	], 
	// ];  
	// $in['style_formats'] = json_encode( $style_formats );  
    

	// $in['remove_linebreaks'] = false;
	// $in['gecko_spellcheck'] = false;
	// $in['keep_styles'] = true;
	// $in['accessibility_focus'] = true;
	// $in['tabfocus_elements'] = 'major-publishing-actions';
	// $in['media_strict'] = false;
	// $in['paste_remove_styles'] = false;
	// $in['paste_remove_spans'] = false;
	// $in['paste_strip_class_attributes'] = 'none';
	// $in['paste_text_use_dialog'] = true;
	// $in['wpeditimage_disable_captions'] = true;
	// $in['plugins'] = 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
	// $in['wpautop'] = true;
	// $in['apply_source_formatting'] = true;
    // $in['block_formats'] = "Paragraph=p; Heading 3=h3; Heading 4=h4";
	// $in['toolbar1'] = 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv ';
	// $in['toolbar2'] = 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ';
	// $in['toolbar3'] = '';
	// $in['toolbar4'] = '';
	// $in['content_css'] = get_template_directory_uri() . "/public/styles/editor.css";
	return $in;
}
add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );


/**
 * Break word for links with url as TextContent
 */
function breakWordUrlLinks( $content ) {
	$regexString = '/(\<a(.*?)\>)([a-zA-Z]+:\/\/[0-9a-zA-Z;.\/\-?:@=_#&%~,+$]*)(<\/a>)/i';
	$content = preg_replace_callback( $regexString, function( $matches ) {
		$newClass = 'break-all';
		$pos = strpos($matches[0], 'class="');
		if (!$pos) {
			$newClass = 'class="'. $newClass . '" ';
			$pos = strpos($matches[0], 'href');
		} else {
			$newClass = $newClass . ' ';
			$pos += strlen('class="');
		}
		$matches[0] = substr_replace($matches[0], $newClass, $pos, 0);
	
		return $matches[0];
	}, $content );

	return $content;

}
add_filter( 'acf_the_content', 'breakWordUrlLinks' );


/**
 * Sort taxonomy by count
 */
function my_acf_fields_taxonomy_query( $args, $field ) {
	
	// Order by most used.
	$args['orderby'] = 'count';
	$args['order'] = 'DESC';
	
	return $args;
}
add_filter('acf/fields/taxonomy/wp_list_categories', 'my_acf_fields_taxonomy_query', 10, 2);


/**
 * List allowed widgets and blocks
 */
function allow_blocks_list( $allowed_block_types, $block_editor_context ) {

	if ( 'core/edit-post' === $block_editor_context->name ) {
		if ( 'page' == $block_editor_context->post->post_type ) {
			$allowed_block_types = [
				'acf/accordion',
				'acf/alert',
				'acf/card-slider',
				'acf/color-card-repeater',
				'acf/c-t-a-full',
				'acf/form',
				'acf/hero',
				'acf/image-card',
				'acf/image-card-repeater',
				'acf/latest-posts',
				'acf/list-repeater',
				'acf/multi-column',
				'acf/multi-column-stats',
				'acf/one-column',
				'acf/one-column-embed',
				'acf/people',
				'acf/quote-carousel',
				'acf/sticky50',
				'acf/two-columns',
				'acf/video',
				// 'acf/stats',
				// 'acf/donate',
				// 'acf/events',
				'core/paragraph',
				'core/list',
				'core/list-item',
				'core/heading',
			];
		}
		
		// Only add block to Home / Front Page
		if( $block_editor_context->post->ID == get_option( 'page_on_front' ) ) {
			array_push($allowed_block_types, 'acf/campaign-hero');
		}
		
		// Only add modal to Resources
		if( $block_editor_context->post->post_title == "Resources" ) {
			array_push($allowed_block_types, 'acf/modal');
		}

		// Only add story/news block to story/news template
		if( get_page_template_slug($block_editor_context->post->ID) == "template-cases.blade.php" ) {
			array_push($allowed_block_types, 'acf/cases');
		}
		if( get_page_template_slug($block_editor_context->post->ID) == "template-news-story.blade.php" ) {
			array_push($allowed_block_types, 'acf/news-story-repeater');
			array_push($allowed_block_types, 'acf/featured-card');
		}
	}
  return $allowed_block_types;
}
add_filter('allowed_block_types_all', 'allow_blocks_list', 10,	2);
 
/**
 * Add styles on the admin pages
 */
function my_acf_admin_head() {
    ?>
    <style type="text/css">
        table.acf-table {
            border-collapse: collapse;
        }
        .acf-repeater .acf-row:not(:first-child) {
            border-top: 2px solid #aaa;
        }
		.mce-edit-area {
			padding: .75rem;
		}
    </style>
    <?php
}
add_action('acf/input/admin_head', 'my_acf_admin_head');

/**
 * Automatically add IDs to headings such as <h2></h2>
 */
function auto_id_headings( $content ) {

	$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
		if ( ! stripos( $matches[0], 'id=' ) ) :
			$matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $matches[3] . $matches[4];
		endif;
		return $matches[0];
	}, $content );

    return $content;

}
add_filter( 'the_content', 'auto_id_headings' );


/**
 * Remove discussion panel from posts.
 */
function remove_comments() {
	remove_post_type_support( 'post', 'comments' );
}
add_action( 'init', 'remove_comments' );


function nl2p( $originalString ) {
	$stringWithPs = str_replace("<br />", "</p>\n<p>", nl2br($originalString));
	$stringWithPs = "<p>" . $stringWithPs . "</p>";
	return $stringWithPs;
}

function get_default_image() {
	$assets = get_field('assets', 'options');
	return isset($assets['mobile_screen']) ? $assets['mobile_screen'] : ['ID' => 1];
}

/**
 * 
 * 		ADD COLUMNS IN PAGE LIST
 * 		template
 */
/** 
 * Display page template's name column into admin
 */
// //Add the custom column to the post type
function add_column_list( $columns ) {
	// save date to the variable
	$date = $columns['date'];
	// unset the 'date' column
	unset( $columns['date'] ); 
	// unset any column when necessary
	// unset( $columns['comments'] );
	$columns['template'] = __('Template');
	$columns['date'] = $date; // set the 'date' column again, after the custom column
  return $columns;
}
add_filter( 'manage_pages_columns', 'add_column_list' );
// Add the data to the custom column
function add_column_list_data( $column, $post_id ) {
	switch ( $column ) {
		case 'template' :
			$post = get_post( $post_id );
			$template_slug = get_page_template_slug( $post );
			if ($template_slug) {
				$available_templates = wp_get_theme()->get_page_templates();
				echo isset($available_templates[$template_slug]) ? $available_templates[$template_slug] : ''; 
			} else {
				echo 'Default Template';
			}
		break;
	}
}
add_action( 'manage_pages_custom_column' , 'add_column_list_data', 10, 2 );
function add_sortable_column_list( $columns ) {
		$columns['template'] = __('Template');
    return $columns;
}
add_filter( 'manage_edit-page_sortable_columns', 'add_sortable_column_list' );

function add_sortable_column_query( $query ) {
    $orderby = $query->get( 'orderby' );
     if ( 'Template' == $orderby ) {
        $meta_query = [
            'relation' => 'OR',
            [
                'key' => '_wp_page_template',
                'compare' => 'NOT EXISTS',
						],
            [
                'key' => '_wp_page_template',
						],
					];

        $query->set( 'meta_query', $meta_query );
        $query->set( 'orderby', 'meta_value' );
    }
}
add_action( 'pre_get_posts', 'add_sortable_column_query' );




/**
 * Add the Call to Action checkbox to the Menus section of the dashboard
 */
add_action( 'wp_nav_menu_item_custom_fields', function ($item_id, $item) {
    $menu_call_to_action = get_post_meta( $item_id, '_menu_call_to_action', true );
    $menu_icon = get_post_meta( $item_id, '_menu_icon', true );
    $menu_icon_left = get_post_meta( $item_id, '_menu_icon_left', true );
	?>
	<p class="description description-wide">
        <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />
	</p>
	<p class="description description-wide">
		<label class="selected block">
				<input type="checkbox" id="menu-call-to-action-<?php echo $item_id ;?>" name="menu_call_to_action[<?php echo $item_id ;?>]" value="Call to Action" <?php echo empty($menu_call_to_action) ? "" : "checked" ?>><?php _e( "Call to action", 'amica_theme' ); ?>
		</label>
		<label class="selected <?php echo empty($menu_call_to_action) ? "hidden" : "" ?> flex flex-col">
				<?php _e( "Icon", 'amica_theme' ); ?>
				<!-- <input type="text" id="menu-icon-<?php echo $item_id ;?>" name="menu_icon[<?php echo $item_id ;?>]" value="<?php echo $menu_icon?>"> -->
				<select id="menu-icon-<?php echo $item_id ;?>" name="menu_icon[<?php echo $item_id ;?>]" value="<?php echo $menu_icon?>">
    			<option <?php echo empty($menu_icon) ? 'selected' : '' ?> value="">--None--</option>
    			<option <?php echo $menu_icon === 'arrow-right' ? 'selected' : '' ?> value="arrow-right">Arrow Right</option>
    			<option <?php echo $menu_icon === 'arrow-left' ? 'selected' : '' ?> value="arrow-left">Arrow Left</option>
    			<option <?php echo $menu_icon === 'arrow-next' ? 'selected' : '' ?> value="arrow-next">Arrow Next</option>
    			<option <?php echo $menu_icon === 'arrow-prev' ? 'selected' : '' ?> value="arrow-prev">Arrow Prev</option>
    			<option <?php echo $menu_icon === 'arrow-down' ? 'selected' : '' ?> value="arrow-down">Arrow Dropdown</option>
    			<option <?php echo $menu_icon === 'search' ? 'selected' : '' ?> value="search">Search</option>
    			<option <?php echo $menu_icon === 'v' ? 'selected' : '' ?> value="v">V</option>
    			<option <?php echo $menu_icon === 'x' ? 'selected' : '' ?> value="x">X</option>
				</select>
		</label>
		<label class="selected mt-2 <?php echo empty($menu_call_to_action) || $menu_icon == '' ? "hidden" : "" ?> block">
				<input type="checkbox" id="menu-icon-left-<?php echo $item_id ;?>" name="menu_icon_left[<?php echo $item_id ;?>]" value="Left align icon" <?php echo empty($menu_icon_left) ? "" : "checked" ?>><?php _e( "Left align icon", 'amica_theme' ); ?>
		</label>
	</p>
	<style>
		.flex { 
			display: flex;
		}
		.flex-col {	
			flex-direction: column;
		}
		.block { display: block; }
		.hidden { display: none; }
		.mt-2 { margin-top: .5rem }
	</style>
	<script>
		(function(id) {
			const cta = document.getElementById(`menu-call-to-action-${id}`);
			const icon = document.getElementById(`menu-icon-${id}`);
			const iconLeft = document.getElementById(`menu-icon-left-${id}`);

			icon.addEventListener('change', function(e) {
				if (cta.checked && this.value !== '') {
					iconLeft.parentElement.classList.remove('hidden');
				} else {
					iconLeft.parentElement.classList.add('hidden');
					iconLeft.value = "";
				}
			})
			cta.addEventListener('change', function(e) {
				if (this.checked) {
					icon.parentElement.classList.remove('hidden');
					if (icon.value == '') {
						iconLeft.parentElement.classList.add('hidden');
					} else {
						iconLeft.parentElement.classList.remove('hidden');
					}
				} else {
					icon.parentElement.classList.add('hidden');
					iconLeft.parentElement.classList.add('hidden');
					icon.value = "";
					iconLeft.value = "";
				}
			})
		}(<?php echo $item_id ;?>));
		
	</script>
	<?php
}, 10, 2 );

/**
 * Updates the database for menu items based on the Call to Action checkbox
 */
add_action( 'wp_update_nav_menu_item', function ( $menu_id, $menu_item_db_id ) {
	if ( isset( $_POST['menu_call_to_action'][$menu_item_db_id] ) ) {
		$sanitized_data = sanitize_text_field( $_POST['menu_call_to_action'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, '_menu_call_to_action', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_call_to_action' );
	}
	if ( isset( $_POST['menu_icon'][$menu_item_db_id] ) ) {
		$sanitized_data = sanitize_text_field( $_POST['menu_icon'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, '_menu_icon', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_icon' );
	}
	if ( isset( $_POST['menu_icon_left'][$menu_item_db_id] ) ) {
		$sanitized_data = sanitize_text_field( $_POST['menu_icon_left'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, '_menu_icon_left', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_icon_left' );
	}
}, 10, 2 );

/**
 * Custom Gutemberg Categories
 */
function register_layout_category( $categories ) {
	
	$categories[] = [
		'slug'  => 'basic-content',
		'title' => 'Basic Content Modules'
	];
	$categories[] = [
		'slug'  => 'interactive-content',
		'title' => 'Interactive Content Modules'
	];
	$categories[] = [
		'slug'  => 'action-modules',
		'title' => 'Action Modules'
	];

	return $categories;
}

add_filter( 'block_categories', 'register_layout_category' );


/**
 * Add <div> surrounding ul gutemberg blocks
 */
function wrap_list_blocks( $block_content, $block ) {
		if ( $block['blockName'] === 'core/list' ) {
				$content = '<div class="wp-block-list">';
				$content .= $block_content;
				$content .= '</div>';
				return $content;
		}

		return $block_content;
}

add_filter( 'render_block', 'wrap_list_blocks', 10, 2 );

/**
 * Add X, Facebook, and Email social shares by default.
 */
function my_acf_set_repeater( $value, $post_id, $field ){
    if ( is_array($value) ) return $value;
    
    $social_fields = $field['sub_fields'];

    $name_field = '';

    foreach( $social_fields as $key => $social_field ) {
        if ( array_search('Name', $social_field) ) {
            $name_field = $social_fields[$key]['key'];
            break;
        }
    }

    $value = [
        [
            $name_field => "x",
        ],
        [
            $name_field => "facebook",
        ],
        [
            $name_field => "email",
        ],
    ];
    return $value;
}

add_filter('acf/load_value/name=social_share', 'my_acf_set_repeater', 10, 3);


/**
 * Removes tags from blog posts
 */
function unregister_posts_taxonomies() {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}


function save_external_link_meta($post_id) {

	// Verify field changed
	if (isset($_POST['_acf_changed']) && !$_POST['_acf_changed']) {
		return;
	}

	// Check if the user has permission to save data
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}
}


add_action( 'init', 'unregister_posts_taxonomies' );
add_action( 'save_post', 'save_external_link_meta' );

/**
 * Adds the environment to the admin bar
 *
 * @param WP_Admin_Bar $wp_admin_bar Toolbar instance.
 */
function amica_add_environment_to_admin( $wp_admin_bar ) {
	$bgClass;
	if ( env('WP_ENV') === 'development' ) {
		$bgClass = 'bg-bedrock';
	} else if ( env('WP_ENV') === 'staging' ) {
		$bgClass = 'bg-golden';
	} else {
		$bgClass = 'bg-verdant';
	}
	$wp_admin_bar->add_menu(
		array(
			'id'     => 'environment',
			'meta' => ['class'  => $bgClass,],
			'parent' => 'top-secondary',
			'href'   => '#',
			'title'  => env('WP_ENV'),
		)
	);
}
add_action( 'admin_bar_menu', 'amica_add_environment_to_admin', 1 );