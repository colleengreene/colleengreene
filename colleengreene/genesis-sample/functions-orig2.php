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
<a href="http://www.colleengreene.com/email-newsletters/hispanic-research-heritage/" title="Hispanic Research & Heritage Newsletter"><strong>SIGN UP NOW with your email address</strong></a> to get my FREE email newsletter, <strong><em>HISPANIC RESEARCH & HERITAGE</em></strong>, delivered to your inbox the last week of every month! Packed with bonus tips, collections, events, and news recommended by me. Your email address will never be sold or shared with others.</div>
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


// function and action to order Guides CPT alphabetically

function alpha_order_guide( $query ) {
    if ( $query->is_post_type_archive('cg_guide') && $query->is_main_query() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}

add_action( 'pre_get_posts', 'alpha_order_guide' );


//* End changes by Colleen