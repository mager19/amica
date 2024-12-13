<?php

add_action('after_setup_theme', function () {
    /**
     * Register the navigation menus.
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'footer_navigation'  => __('Footer Navigation', 'amica_theme'),
        'footer_details'       => __('Footer Details', 'amica_theme'),
    ]);

}, 30);

function nav_link_depth_attributes( $atts,$menu_item,$args,$depth ) { 
	if ( $args->theme_location == 'footer_navigation' ) {
		$atts['class'] = 'button';
	}	

	return $atts;
}

add_filter( 'nav_menu_link_attributes','nav_link_depth_attributes',10,4 ); 


class PrimaryNavigationWalker extends Walker_Nav_Menu {
	/**
		* Track Whether to show parent overview link
		*
		* @var Boolean
	*/
	// show_overview_link
	private $build_overview_link = false;
	private $show_overview_link = false;
	private $overview_output = '';
	private $is_primary_nav = false;
	private $has_translation = false;

	/**
   * Starts the list before the elements are added.
   *
   * Adds classes to the unordered list sub-menus.
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
	    $this->is_primary_nav = 'primary_navigation' === $args->theme_location;
      
			// Depth-dependent classes.
      $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
      $display_depth = ( $depth + 1); // because it counts the first submenu as 0
      $classes = array(
          'sub-menu',
          ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
          ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
          'menu-depth-' . $display_depth,
      );
      $class_names = implode( ' ', $classes );
			

			// Enable Submenu Title
	    $this->show_overview_link = $depth === 0 && $this->is_primary_nav;

      // Build HTML for output.
      $output .= "\n" . $indent . '<ul class="' . $class_names . '" data-dropdown-target="menu">' . "\n";
  }

  /**
   * Start the element output.
   *
   * Adds main/sub-classes to the list items and links.
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param object $item   Menu item data object.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   * @param int    $id     Current item ID.
   */
  function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$this->is_primary_nav = 'primary_navigation' === $args->theme_location;

    if ( $this->show_overview_link ) {
      $output .= $this->overview_output;
      $this->overview_output = '';
      $this->show_overview_link = false;
    }

		$menu_item = $item;
    $this->build_overview_link = $args->walker->has_children && $item->url !== '#';

		$has_children = array_filter($item->classes, function($class) {
      return $class == 'menu-item-has-children';
    });

		$cta = get_field('_menu_call_to_action', $item);
		$icon = get_field('_menu_icon', $item);
		$icon_left = get_field('_menu_icon_left', $item);

    $menu_link = '';
		
		$wpml = $item->object === 'wpml_ls_menu_item' ? true : false;
		if ($wpml && $has_children) {
			$menu_link .= 'button-border ';
			$this->has_translation = true;
		} else if ($wpml && !$this->has_translation) {
			return;
		}
		$overview_link = '';
		$overview_item_class = $item->classes;
		// parent elements
    if ($depth == 0) {
      $menu_link .= 'top-menu--link nav-link ';
      $tabindex = "0";
			// parent with child
			if($has_children) {
				$link_target = 'data-dropdown-target="toggler"';
				array_push($item->classes, 'group');
				$menu_link .= ' menu--dropdown ';
				$menu_link .= $this->is_primary_nav ? ' lg:pointer-events-auto pointer-events-none' : '';
			} else $link_target = '';
				
		// child sub elements
    } else {
      $menu_link .= ' sub-menu--link ';
      $tabindex = "-1";
      $link_target = 'data-dropdown-target="link"';
    }
    if ( $this->build_overview_link ) {
			$overview_link_tabindex = "-1";
			$overview_link_class = ' sub-menu--link overview-link';
			$overview_link_target = 'data-dropdown-target="overview"';
		}
		// cta and wpml parent
		if ( $cta || ($wpml && count($has_children) > 0)) {
			array_push($item->classes, 'menu-cta');
		}

		// wpml parent with children
		if($wpml && count($has_children) > 0) {
			$menu_link .= ' button-icon';
		}

    $dropdown_controller =  $has_children ? " data-controller='dropdown'" : "";
    $output .= '<li class="' .  implode(" ", $item->classes) . '"' . $dropdown_controller . '>';
		if ($wpml && $has_children) {
			$output .= '<button class="button ' . $menu_link . '" tabindex="' . $tabindex . '"' . $link_target . '>';
		} else {
			$output .= '<a class="' . $menu_link . '" href="' . $item->url . '" tabindex="' . $tabindex . '"' . $link_target . '>';
		}
    if ( $this->build_overview_link ) {
			array_push($overview_item_class, 'lg:hidden');
			$this->overview_output .= '<li class="' .  implode(" ", $overview_item_class) . '">';
			$this->overview_output .= '<a class="' . $overview_link_class . '" href="' . $item->url . '" tabindex="' . $overview_link_tabindex . '"' . $overview_link_target . '>';
		}
		if ( $icon && $icon_left ) {
			$output .= getSvg("icons/$icon");
		}

		if ( $icon ) $output .= '<span>';
    
		$output .= $item->title;
		
		if ( $icon ) $output .= '</span>';

		if ( $icon && !$icon_left ) {
			$output .= getSvg("icons/$icon");
		}

		$icon_span_classes = $this->is_primary_nav ? "hidden lg:block lg:ml-min" : "";

		if($has_children) $output .= '<span class="'. $icon_span_classes .'">' . getSvg('icons/arrow-down', ['class' => 'w-auto h-auto']) . '</span>';
		
    if ( $this->build_overview_link ) $this->overview_output .= $item->title . " Overview</a></li>\n";
		if ($wpml && $has_children) {
    	$output .= '</button>';
		} else {
			$output .= '</a>';
		}
  }
}

class FooterNavigationWalker extends Walker_Nav_Menu {
	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
	 *              to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output            Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object       Menu item data object.
	 * @param int      $depth             Depth of menu item. Used for padding.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		// Restores the more descriptive, specific name for use within this method.
		$menu_item = $data_object;

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param WP_Post  $menu_item Menu item data object.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );

		/**
		 * Filters the ID attribute applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_item_id The ID attribute applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item    The current menu item.
		 * @param stdClass $args         An object of wp_nav_menu() arguments.
		 * @param int      $depth        Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

		$li_atts          = array();
		$li_atts['id']    = ! empty( $id ) ? $id : '';
		$li_atts['class'] = ! empty( $class_names ) ? $class_names : '';

		/**
		 * Filters the HTML attributes applied to a menu's list item element.
		 *
		 * @since 6.3.0
		 *
		 * @param array $li_atts {
		 *     The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
		 *
		 *     @type string $class        HTML CSS class attribute.
		 *     @type string $id           HTML id attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$li_atts       = apply_filters( 'nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth );
		$li_attributes = $this->build_atts( $li_atts );

		$output .= $indent . '<li' . $li_attributes . '>';

		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if ( ! empty( $menu_item->url ) ) {
			if ( get_privacy_policy_url() === $menu_item->url ) {
				$atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
		$attributes = $this->build_atts( $atts );

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title     The menu item's title.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '><span>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</span></a>';
		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $menu_item   Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
	}
}
