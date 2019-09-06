<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style(
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		[],
		genesis_get_theme_version()
	);

	wp_enqueue_style( 'dashicons' );

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			[ genesis_get_theme_handle() ],
			genesis_get_theme_version()
		);
	}

}

add_action( 'after_setup_theme', 'genesis_sample_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'genesis_sample_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'genesis-singular-images', 702, 526, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}


//* ***** Begin changes by Colleen *****


//* Create custom Lectures post type
add_action( 'init', 'create_post_type_cg_lecture' );
function create_post_type_cg_lecture() { // must give each function a unique name

// Lecture custom post type

  register_post_type( 'cg_lecture',
    array(
      'labels' => array(
        'name' => __( 'My Lectures' ),
        'singular_name' => __( 'Lecture' ),
	 'search_items' => _( 'Search Lectures' ),
	 'all_items' => _( 'All Lectures' ),
	 'edit_item' => _( 'Edit Lecture' ),
	 'update_item' => _( 'Update Lecture' ),
	 'add_new_item' => _( 'Add New Lecture' ),
	 'new_item_name' => _( 'New Lecture Name' ),
	 'menu_name' => _( 'My Lectures' ),
      ),
      'public' => true,
      'hierarchical' => true,
      'supports' => array( 'title', 'editor', 'thumbnail', 'genesis-seo', 'excerpt', 'author', 'comments', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-cpt-archives-settings'),
      'taxonomies' => array( 'category', 'post_tag'),
      'has_archive' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'lectures' ),
    )
  );
}

//* Create custom Workshops post type
add_action( 'init', 'create_post_type_cg_workshop' );
function create_post_type_cg_workshop() { // must give each function a unique name


// Workshop custom post type

  register_post_type( 'cg_workshop',
    array(
      'labels' => array(
        'name' => __( 'My Workshops' ),
        'singular_name' => __( 'Workshop' ),
	 'search_items' => _( 'Search Workshops' ),
	 'all_items' => _( 'All Workshops' ),
	 'edit_item' => _( 'Edit Workshop' ),
	 'update_item' => _( 'Update Workshop' ),
	 'add_new_item' => _( 'Add New Workshop' ),
	 'new_item_name' => _( 'New Workshop Name' ),
	 'menu_name' => _( 'My Workshops' ),
      ),
      'public' => true,
      'hierarchical' => true,
      'supports' => array( 'title', 'editor', 'thumbnail', 'genesis-seo', 'excerpt', 'author', 'comments', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-cpt-archives-settings'),
      'taxonomies' => array( 'category', 'post_tag'),
      'has_archive' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'workshops' ),
    )
  );
}


//* Create custom Criteria taxonomy 
add_action( 'init', 'create_criteria_taxonomy' );
function create_criteria_taxonomy() {
$labels = array(
	'name' => 'Criteria',
	'singular_name' => 'Criteria',
	'search_items' => 'Search Criteria',
	'all_items' => 'All Criteria',
	'edit_item' => 'Edit Criteria',
	'update_item' => 'Update Criteria',
	'add_new_item' => 'Add New Criteria',
	'new_item_name' => 'New Criteria Name',
	'menu_name' => 'Criteria',
	'view_item' => 'View Criteria',
	'popular_items' => 'Popular Criteria',
	'add_or_remove_items' => 'Add or remove criteria',
	'choose_from_most_used' => 'Choose from the most used criteria',
	'not_found' => 'No criteria found'
);
register_taxonomy(
	'criteria',
	array('cg_class'), //An array of post types that share this taxonomy
	array(
		'label' => __( 'Criteria' ),
		'hierarchical' => true, //Has to be true for drop-down list instead of free-written tags
		'query_var' => true,
		'rewrite' => array( 'slug' => 'criteria' ),
		'labels' => $labels
	)
);
}


//* Create custom Guides post types
add_action( 'init', 'create_post_type_cg_guide' );
function create_post_type_cg_guide() { // must give each function a unique name

// Guide custom post type

  register_post_type( 'cg_guide',
    array(
      'labels' => array(
        'name' => __( 'My Guides' ),
        'singular_name' => __( 'Guide' ),
	 'search_items' => _( 'Search Guides' ),
	 'all_items' => _( 'All Guides' ),
	 'edit_item' => _( 'Edit Guide' ),
	 'update_item' => _( 'Update Guide' ),
	 'add_new_item' => _( 'Add New Guide' ),
	 'new_item_name' => _( 'New Guide Name' ),
	 'menu_name' => _( 'My Guides' ),
      ),
      'public' => true,
      'hierarchical' => true,
      'supports' => array( 'title', 'editor', 'thumbnail', 'genesis-seo', 'excerpt', 'author', 'comments', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-cpt-archives-settings'),
      'taxonomies' => array( 'category', 'post_tag'),
      'has_archive' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'guides' ),
    )
  );
}


//* End changes by Colleen



