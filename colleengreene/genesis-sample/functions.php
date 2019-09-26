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
// unregister_sidebar( 'header-right' ); Modified by Colleen to re-add the widget

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


//* Add in Wrap Content Widget Areas

function cg_fullwrap_widgets() {
    register_sidebar( array(          
        'name' => __( 'Top Wrap', 'genesis' ),
        'id' => 'topwrap',
        'description' => __( 'Top Wrap', 'genesis' ),
        'before_widget' => '<div class="wrap topwrap">',
        'after_widget' => '</div>',
    ) );

 }
add_action( 'widgets_init', 'cg_fullwrap_widgets' );

 //* Add the top widgets in place
function cg_top_wrap_widgets() {
    genesis_widget_area ('topwrap', array(
        'before' => '<div class="topwrapwrapper">',
        'after' => '</div>',));
    }
add_action( 'genesis_after_header', 'cg_top_wrap_widgets' );


//* Add Jetpack share buttons above post
remove_filter( 'the_content', 'sharing_display', 19 );
remove_filter( 'the_excerpt', 'sharing_display', 19 );

add_filter( 'the_content', 'sp_share_buttons_above_post', 19 );
add_filter( 'the_excerpt', 'sp_share_buttons_above_post', 19 );

function sp_share_buttons_above_post( $content = '' ) {
	if ( function_exists( 'sharing_display' ) ) {
		return sharing_display() . $content;
	}
	else {
		return $content;
	}
}


/* Add eNews Signup Box before Select Posts */
function enews_signup_box() {
if ( is_single() && has_tag(array('Mexican genealogy', 'Mexican-American genealogy', 'Hispanic genealogy'))) { ?>

<!-- Start Sign UP Box -->
<div class="signup-box"><span class="signup-box-heading">Hispanic Genealogy Tips &amp; News</span>
<p>Interested in Hispanic genealogy and history?</p>
<p><a href="http://www.colleengreene.com/hispanic-research-heritage/" title="Hispanic Research & Heritage Newsletter">SIGN UP NOW with your email address</a> to get my FREE email newsletter, <strong><em>HISPANIC RESEARCH & HERITAGE</em></strong>, delivered to your inbox the last week of every month! Packed with bonus tips, collections, events, and news recommended by me. Your email address will never be sold or shared with others.</p>
<p><a class="btn-white-outline" href="/hispanic-research-heritage/"><strong>Sign Me Up Now!</strong></a></p>
</div>
<!-- End Sign Up-->

<?php }
}
add_action('genesis_entry_content', 'enews_signup_box', 20);
/* End eNews Signup Box after Select Posts */


//* Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'sp_custom_footer' );
function sp_custom_footer() {
	?>
	<p>&copy; 2007 – <?php echo date('Y'); ?> <a title="Colleen Robledo Greene" href="http://www.colleengreene.com/">Colleen Robledo Greene</a> &middot; Powered by <a title="WordPress" href="http://wordpress.org/">WordPress</a>  &middot; <a title="Site Administration" href="http://www.colleengreene.com/wp-admin">Admin</a></p>
	<?php
}


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


//* Create custom Teaching Topic taxonomy 
add_action( 'init', 'create_cg_teaching_taxonomy' );
function create_cg_teaching_taxonomy() {
$labels = array(
	'name' => 'Teaching Topics',
	'singular_name' => 'Teaching Topic',
	'search_items' => 'Search Teaching Topics',
	'all_items' => 'All Teaching Topics',
	'edit_item' => 'Edit Teaching Topic',
	'update_item' => 'Update Teaching Topic',
	'add_new_item' => 'Add New Teaching Topic',
	'new_item_name' => 'New Teaching Topic',
	'menu_name' => 'Teaching Topics',
	'view_item' => 'View Teaching Topic',
	'popular_items' => 'Popular Teaching Topics',
	'add_or_remove_items' => 'Add or remove teaching topics',
	'choose_from_most_used' => 'Choose from the most used teaching topics',
	'not_found' => 'No teaching topics found'
);
register_taxonomy(
	'cg_teaching',
	array('cg_lecture', 'cg_workshop'), //An array of post types that share this taxonomy
	array(
		'label' => __( 'Teaching Topics' ),
		'hierarchical' => true, //Has to be true for drop-down list instead of free-written tags
		'query_var' => true,
		'rewrite' => array( 'slug' => 'speaking/topics' ),
		'labels' => $labels
	)
);
}


//* Remove Post Info, Post Meta from CPT
//* Borrowed from https://www.engagewp.com/remove-custom-post-type-post-meta-genesis/
add_action ( 'get_header', 'cg_cpt_remove_post_info_genesis' );
function cg_cpt_remove_post_info_genesis() {
 	if ( 'post' !== get_post_type() ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
 		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}


//* On Guide Archive, shows only top-level post.
  //pre_get_posts filter is called before WordPress gets posts
    add_filter( 'pre_get_posts', 'my_get_posts' );

    function my_get_posts( $query ) {
        //if page is an archive and post_parent is not set and post_type is the post type in question
        if ( is_archive() && false == $query->query_vars['post_parent'] &&  $query->query_vars['post_type'] == 'cg_guide')
            //set post_parent to 0, which is the default post_parent for top level posts
            $query->set( 'post_parent', 0 );
        return $query;
    }


// function and action to order Lectures CPT alphabetically

function alpha_order_lecture( $query ) {
    if ( $query->is_post_type_archive('cg_lecture') && $query->is_main_query() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}

add_action( 'pre_get_posts', 'alpha_order_lecture' );


// function and add acton to remove the thumbnail from the archive view of Lectures CPT

function remove_thumbnail_lecture( $query ) {
    if ( $query->is_post_type_archive('cg_lecture') && $query->is_main_query() ) {
	remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
    }
}

add_action( 'pre_get_posts', 'remove_thumbnail_lecture' );


// Show 20 Lectures on Lectures Archive Page

function cg_lecture( $query ) {
    if ( $query->is_post_type_archive('cg_lecture') && $query->is_main_query() ) {
            $query->set( 'posts_per_page', '20' );
    }
}

add_action( 'pre_get_posts', 'cg_lecture' );


// function and action to order Workshops CPT alphabetically

function alpha_order_workshop( $query ) {
    if ( $query->is_post_type_archive('cg_workshop') && $query->is_main_query() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}

add_action( 'pre_get_posts', 'alpha_order_workshop' );


// function and add acton to remove the thumbnail from the archive view of Workshops CPT

function remove_thumbnail_workshop( $query ) {
    if ( $query->is_post_type_archive('cg_workshop') && $query->is_main_query() ) {
	remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
    }
}

add_action( 'pre_get_posts', 'remove_thumbnail_workshop' );





// function and action to order Guides CPT alphabetically

function alpha_order_guide( $query ) {
    if ( $query->is_post_type_archive('cg_guide') && $query->is_main_query() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}

add_action( 'pre_get_posts', 'alpha_order_guide' );


//* End changes by Colleen



