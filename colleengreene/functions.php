<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* ***** Begin changes by Colleen *****

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );


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
<div class="signup-box"><span class="signup-box-heading">Hispanic Genealogy Tips &amp; News</span><br />
Interested in Hispanic genealogy and history?<br />
<a href="http://colleengreene.us12.list-manage1.com/subscribe?u=566e975d594e41e054953fe1b&amp;id=baa5909068"><strong>SIGN UP NOW with your email address</strong></a> to get my FREE email newsletter, <strong><em>HISPANIC HERITAGE HAPPENINGS</em></strong>, delivered to your inbox the 1st of every month! Packed with bonus tips, collections, events, and news recommended by me. Your email address will never be sold or shared with others.</div>
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
	<p>&copy; Copyright 2016 <a title="Colleen Greene" href="http://www.colleengreene.com/">Colleen Greene</a> &middot; Powered by <a title="WordPress" href="http://wordpress.org/">WordPress</a>  &middot; <a title="Site Administration" href="http://www.colleengreene.com/wp-admin">Admin</a></p>
	<?php
}



//* Create custom Classes post types
add_action( 'init', 'create_post_type_cg_class' );
function create_post_type_cg_class() { // must give each function a unique name

// Class custom post type

  register_post_type( 'cg_class',
    array(
      'labels' => array(
        'name' => __( 'My Classes' ),
        'singular_name' => __( 'Class' ),
	 'search_items' => _( 'Search Classes' ),
	 'all_items' => _( 'All Classes' ),
	 'edit_item' => _( 'Edit Class' ),
	 'update_item' => _( 'Update Class' ),
	 'add_new_item' => _( 'Add New Class' ),
	 'new_item_name' => _( 'New Class Name' ),
	 'menu_name' => _( 'My Classes' ),
      ),
      'public' => true,
      'hierarchical' => true,
      'supports' => array( 'title', 'editor', 'thumbnail', 'genesis-seo', 'excerpt', 'author', 'comments', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-cpt-archives-settings'),
      'taxonomies' => array( 'category', 'post_tag'),
      'has_archive' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'classes' ),
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


//* End changes by Colleen