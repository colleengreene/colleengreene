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

//* Begin changes by Colleen

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


//* Add Featured Image to RSS Feed
function cg_post_thumbnail_rss($content) {
global $post;
if ( has_post_thumbnail( $post->ID ) ){
$content = '' . get_the_post_thumbnail( $post->ID, 'rss-image', array( 'style' => 'float:left; margin-right:10px; height: 100px; width: 200px; border: 2px solid #e5e5e5' ) ) . '' . $content;
}
return $content;
}
/**
* @author Brad Dalton
* @example http://wpsites.net/web-design/add-featured-image-thumbnail-from-post-to-rss-feed/
*/
add_filter('the_content_feed', 'cg_post_thumbnail_rss');
add_filter('the_excerpt_rss', 'cg_post_thumbnail_rss');


//* End changes by Colleen