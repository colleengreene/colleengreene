<?php
/* By taking advantage of hooks, filters, and the Custom Loop API, you can make Thesis
 * do ANYTHING you want. For more information, please see the following articles from
 * the Thesis User’s Guide or visit the members-only Thesis Support Forums:
 *
 * Hooks: http://diythemes.com/thesis/rtfm/customizing-with-hooks/
 * Filters: http://diythemes.com/thesis/rtfm/customizing-with-filters/
 * Custom Loop API: http://diythemes.com/thesis/rtfm/custom-loop-api/

---:[ place your custom code below this line ]:---*/

// Start functions import
// You can copy and paste this code block into your own custom_functions.php if you want
require_once(TEMPLATEPATH . '/custom/skins/skins_admin.php');
// End function import

// Add your Thesis functions after this line as you normally would!

function my_comments_link() {
if (!is_single() && !is_page()) {
echo '<p class="to_comments"><span class="bracket">{</span> <a href="';
the_permalink();
echo '#comments" rel="nofollow">';
comments_number(__('<span>0</span> comments - new code', 'thesis'), __('<span>1</span> comment - new code', 'thesis'), __('<span>%</span> comments - new code', 'thesis'));
echo ' <span class="bracket">}</span></p>';
}
}

remove_action('thesis_hook_after_post', 'thesis_comments_link');
add_action('thesis_hook_after_post', 'my_comments_link');


/* ****************************************HEADER CUSTOMIZATIONS********************************** */


/* ****************************************NAV MENU CUSTOMIZATIONS******************************** */

/***START FULL WIDTH NAV MENU***/
function full_width_nav() { ?>
	<div id="nav_area" class="full_width">
		<div class="page">
			<?php thesis_nav_menu(); ?>
		</div>
	</div>
<?php }
remove_action('thesis_hook_before_header', 'thesis_nav_menu');
add_action('thesis_hook_before_content_area', 'full_width_nav');
/***END FULL WIDTH NAV MENU***/


/* ****************************************POST CUSTOMIZATIONS************************************ */


/* ***START ADD CUSTOM SHARING BUTTONS TO BYLINE OF POSTS AND PAGES*** */

function custom_byline() {

if (is_single() || is_page()) {

global $post;

?>

<div class="social-single">

<!--This has to go first-->
<div id="twitterbutton"><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script><div> <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>" data-counturl="<?php the_permalink() ?>" data-text="<?php the_title(); ?>" data-via="colleengreene" data-related="colleengreene">Tweet</a></div></div>

<div id="linkedinshare"><script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-counter="right"></script></div>

<div id="likebutton"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo rawurlencode(get_permalink()); ?>&layout=button_count&show_faces=false&width=100&action=like&font=verdana
&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>

<div id="sharebutton" style="padding-top:1px;"><a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php"></a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script></div>

<!--This button has to go last, or it wraps to a new line-->
<div id="plusonebutton"><g:plusone size="medium"></g:plusone></div>

</div><br /><br />
<?php }
}
add_action('thesis_hook_byline_item','custom_byline');

/* ***END ADD CUSTOM SHARING BUTTONS TO BYLINE OF POSTS AND PAGES*** */


/* ***START FORCE ADD WP FEATURED IMAGE META BOX TO THESIS *** */

add_theme_support( 'post-thumbnails' );  

/* ***END FORCE ADD WP FEATURED IMAGE META BOX TO THESIS*** */


/* *** START ADD FACBOOK OPEN GRAPH META TAGS *** */

function add_facebook_open_graph_tags() {
	if (is_single()) {
		global $post;
		setup_postdata($post);
		$image = get_post_meta($post->ID, 'thesis_post_image', $single = true);
		if (!$image)
			$image = 'http://www.colleengreene.com/wp-content/uploads/2012/08/gravatar-small.jpg';
		?>
		<meta property="og:title" content="<?php the_title(); ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:image" content="<?php echo $image; ?>" />
		<meta property="og:url" content="<?php the_permalink(); ?>" />
		<meta property="og:description" content="<?php echo get_the_excerpt();  ?>" />
		<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
		<meta property="fb:admins" content="colleengreene" />
		<?php }
}
add_action('wp_head', 'add_facebook_open_graph_tags',99);

/* *** START ADD FACBOOK OPEN GRAPH META TAGS *** */


/* **************************************ARCHIVE PAGE CUSTOMIZATIONS******************************* */


/* **************************************FOOTER CUSTOMIZATIONS************************************* */


/* ***START ADD FOOTER WIDGET*** */
register_sidebars(1,
    array(
        'name' => 'Footer Widgets',
        'before_widget' => '<li class="widget %2$s" id="%1$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    )
);
function custom_footer_widgets() { ?>
	<div id="footer_1" class="sidebar_footer">
		<ul class="sidebar_list">
			<?php thesis_default_widget(3); ?>
		</ul>
	</div>
<?php }
add_action('thesis_hook_footer', 'custom_footer_widgets', '1');
/* ***END ADD FOOTER WIDGET* ***/


/* ***START CUSTOM COPYRIGHT IN FOOTER*** */
remove_action('thesis_hook_footer','thesis_attribution');
function add_custom_footer_terms(){
?>
<p>All content on <?php bloginfo('name') ?> is licensed under <a href="http://creativecommons.org/licenses/by-nc/3.0/us/">Creative Commons</a>.</p>
<p>Developed by <a href="http://www.colleengreene.com">Colleen Greene</a>, using the <a href="http://diythemes.com/thesis/">Thesis WordPress Theme</a> from DIYthemes.</p>
<?php
}
add_action('thesis_hook_footer','add_custom_footer_terms');
/* ***END CUSTOM COPYRIGHT IN FOOTER*** */