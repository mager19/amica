<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    bundle('app')->enqueue();
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     *
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls',
    ]);

    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'amica_theme'),
        'secondary_navigation' => __('Secondary Navigation', 'amica_theme'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // add_image_size( 'background-low', 1440, 1200, true );
    add_image_size( 'background', 2880, 2400, true );
    add_image_size( 'background-inset', 2560, 1680, true );
    add_image_size( 'wide', 1280, 640, true );
    add_image_size( 'card-bg', 1284, 1284, true );
    add_image_size( 'card-insert', 1280, 1420, true );
    add_image_size( 'card-top', 860, 640, true );
    add_image_size( 'content', 1280, 1570, true );
    // add_image_size( 'accordion', 533, 1570, true );


    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});
/**
 * Register the admin theme.
 *
 * @return void
 */
add_action('admin_enqueue_scripts', function () {
    bundle('admin')->enqueue();
}, 100);
add_action('login_enqueue_scripts', function () {
    bundle('admin')->enqueue();
}, 100);

/**
 * Removes WP Emoji script
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// Production environment
if(getenv('WP_ENV') == 'production') {

    // Google Tag Manager
    add_action('wp_head',function() { ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WL9ZGRKS');</script>
        <!-- End Google Tag Manager -->
    <?php } );

    add_action('wp_body_open', function() {
        echo '<!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WL9ZGRKS"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->';
    }, 10);

// Staging environment
} else if(getenv('WP_ENV') == 'staging') {
    // Marker Widget
    add_action('wp_head', function() {
        echo '
            <script>
            window.markerConfig = {
                destination: \'66452fad2e5a20d755b9a228\',
                source: \'snippet\'
            };
            </script>

            <script>
            !function(e,r,a){if(!e.__Marker){e.__Marker={};var t=[],n={__cs:t};["show","hide","isVisible","capture","cancelCapture","unload","reload","isExtensionInstalled","setReporter","setCustomData","on","off"].forEach(function(e){n[e]=function(){var r=Array.prototype.slice.call(arguments);r.unshift(e),t.push(r)}}),e.Marker=n;var s=r.createElement("script");s.async=1,s.src="https://edge.marker.io/latest/shim.js";var i=r.getElementsByTagName("script")[0];i.parentNode.insertBefore(s,i)}}(window,document);
            </script>
            ';
    });
}

/**
 * Custom Menu Order
 */
$custom_menu_order = function($menu_ord) {
    if (!$menu_ord) return true;
    return array(
        'index.php', // Dashboard
        'kinsta-tools', // Kinsta
        'separator1',
        'edit.php?post_type=page', // Pages
        'edit.php?post_type=person', // Campaign
        'edit.php?post_type=case', // Campaign
        'edit.php', // News
        'edit.php?post_type=story', // Campaign
        'separator2',
        'upload.php', // Media
        'gf_edit_forms', //GF
        'brand-options',
        'separator-last',
        'themes.php',
        'plugins.php',
        'tools.php',
        'options-general.php',
        'users.php',
    );
};
add_filter('custom_menu_order', $custom_menu_order);
add_filter('menu_order', $custom_menu_order);

/**
 * Custom Admin Logo
 */
add_filter( 'login_headerurl', function() {
    return home_url();
} );

add_filter( 'login_headertitle', function() {
    $svg = \Roots\asset('images/logo.svg');

    return $svg->contents();
} );

/**
 * Webfont libraries
 */
add_action('wp_enqueue_scripts', function () {
    // Adobe Typekit
    wp_enqueue_style('typekit', 'https://use.typekit.net/tst3ssz.css', false, null);
    
    // Google Fonts
    // wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap', false );

}, 101);

/**
 * Create Site Options Parent
 * Note: creating this using the ACF Options page setup was not working.
 */
add_action('acf/init', function() {
    // Check function exists.
    if( function_exists('acf_add_options_sub_page') ) {
        // Add parent.
        $parent = acf_add_options_page(array(
            'page_title'  => __('Site Options', 'amica_theme'),
            'menu_title'  => __('Site Options', 'amica_theme'),
            'menu_slug'  => 'site-options',
            'redirect'    => true,
        ));
    }
}, 1);

$add_category_fields = function($tag) {
    $plural_title = "Plural";
    $plural_description = "Plural name for the category";
    $plural_id = "cat_plural";
    
    if (current_filter() == 'category_edit_form_fields') {	
        $cat_plural = get_term_meta($tag->term_id, '_plural', true);
    ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo $plural_id ?>"><?php _e($plural_title); ?></label></th>
            <td>
            <input type="text" name="<?php echo $plural_id ?>" id="<?php echo $plural_id ?>" value="<?php echo $cat_plural ?>"><br />
                <span class="description"><?php _e($plural_description); ?></span>
            </td>
        </tr>
    <?php } elseif (current_filter() == 'category_add_form_fields') {
    ?>
        <div class="form-field">
            <label for="<?php echo $plural_id ?>"><?php _e($plural_title); ?></label>
            <input type="text" size="40" value="" name="<?php echo $plural_id ?>">
            <p class="description"><?php _e($plural_description); ?></p>
        </div>  
    <?php
    }
};

add_action('category_add_form_fields', $add_category_fields);

add_action ( 'edited_category', function($term_id) {
    if ( isset( $_POST['cat_plural'] ) )
        update_term_meta( $term_id , '_plural', $_POST['cat_plural'] );
});
add_action('category_edit_form_fields', $add_category_fields, 10, 2);




/**
 * Custom theme functions
 */

require_once __DIR__ . '/../functions/editor.php';
require_once __DIR__ . '/../functions/utilities.php';
require_once __DIR__ . '/../functions/nav.php';
require_once __DIR__ . '/../functions/posts.php';
require_once __DIR__ . '/../functions/gravityforms.php';
