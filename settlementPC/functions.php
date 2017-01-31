<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // wp_title replaced by title_tag below
  //add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );
    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-900', 900, 300, true );
add_image_size( 'bones-thumb-600', 600, 200, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-900' => __('900px by 300px'),
        'bones-thumb-600' => __('600px by 200px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

//Make sizes selectable
add_filter( 'image_size_names_choose', 'my_custom_sizes' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-300' => __( '300px x 100px' ),
        'bones-thumb-600' => __( '600 x 200' ),
    ) );
}
/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'General Sidebar', 'bonestheme' ),
		'description' => __( 'The fallback sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Lessons Sidebar', 'bonestheme' ),
		'description' => __( 'The courses, lessons and topics sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'sidebar3',
		'name' => __( 'Themepage Sidebar', 'bonestheme' ),
		'description' => __( 'The themepage sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'sidebar4',
		'name' => __( 'Events Sidebar', 'bonestheme' ),
		'description' => __( 'The themepage sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form'
	) );

/*******
CUSTOMIZE LOGIN PAGE
*******/

//add our own paragraph to bottom of login screen
function my_loginfooter() { ?>
	<p class="login-addition">Not yet a registered learner?<br>
		<a href="<?php echo home_url(); ?>/register">Find out how to register</a>
	</p>
<?php }
add_action('login_footer','my_loginfooter');


// change wp_mail "from" email and name
add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email )
{
	return "info@myenglishonline.ca";
}

add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
function my_mail_from_name( $name )
{
	return "English Online Inc.";
}

//remove columns from courses and lessons
function my_columns_filter( $columns ) {
    unset($columns['tags']);
    unset($columns['categories']);
    unset($columns['tags']);
    unset($columns['comments']);
    return $columns;
}
add_filter( 'manage_edit-sfwd-lessons_columns', 'my_columns_filter', 10, 1 );
add_filter( 'manage_edit-sfwd-topic_columns', 'my_columns_filter', 10, 1 );
add_filter( 'manage_edit-sfwd-courses_columns', 'my_columns_filter', 10, 1 );

//add excerpt capability to "Pages"
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

/**
 * Adds a Learner column to the user display dashboard.
 */
function theme_add_user_learner_column( $columns ) {

 $columns['learner'] = __( 'Learner', 'bones' );
 return $columns;

} // end theme_add_user_learner_column
add_filter( 'manage_users_columns', 'theme_add_user_learner_column' );

/**
 * Populates the Learner column with the specified user's learner number
 */
function theme_show_user_learner_data( $value, $column_name, $user_id ) {

 if( 'learner' == $column_name ) {
	 return get_user_meta( $user_id, 'learner', true );
 } // end if

} // end theme_show_user_learner_data
add_action( 'manage_users_custom_column', 'theme_show_user_learner_data', 10, 3 );

// add learner section to profile only for admin to see and edit
function custom_user_profile_fields($user){
    if ( current_user_can('edit_posts') ) { // if current user can activate plugins they are admin
    ?>
        <h3>Learner Number</h3>
        <table class="form-table">
            <tr>
                    <th><label for="learner">Learner Number</label></th>
                    <td><input type="text" name="learner" value="<?php echo esc_attr(get_the_author_meta( 'learner', $user->ID )); ?>"></td>
                </tr>
        </table>
    <?php
    }
}
add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );
add_action( "user_new_form", "custom_user_profile_fields" );

function save_custom_user_profile_fields($user_id){
    // again do this only if you can
    if(!current_user_can('edit_posts'))
        return false;

    // save my custom field
    update_user_meta($user_id, 'learner', esc_html($_POST['learner']));
}
add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

// change default display name format from https://wordpress.org/support/topic/set-default-display-name-format-for-new-users
add_action('user_register', 'registration_save_displayname', 1000);
function registration_save_displayname($user_id) {
    if ( isset( $_POST['first_name']) &&  isset( $_POST['last_name']) ){
		$pretty_name = $_POST['first_name'];
		wp_update_user( array ('ID' => $user_id, 'display_name'=> $pretty_name) ) ;
	}
}

//https://codex.wordpress.org/Plugin_API/Action_Reference/user_register
add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {

    if ( isset( $_POST['first_name'] ) )
        update_user_meta($user_id, 'display_name', $_POST['first_name']);

}


//create loggedin shortcode
function check_user ($params, $content = null){
  if ( is_user_logged_in() ){
    return $content;
  }
  else{
    return;
  }
}
add_shortcode('loggedin', 'check_user' );

//create notloggedin shortcode
function check_user_not ($params, $content = null){
  if ( !is_user_logged_in() ){
    return $content;
  }
  else{
    return;
  }
}
add_shortcode('notloggedin', 'check_user_not' );

// shorten excerpt length
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// remove "Private" prefix from forums as per https://wordpress.org/support/topic/how-to-remove-protected-from-pw-protected-page-titles?replies=7#post-1658659
add_filter('private_title_format', 'ntwb_remove_private_title');
function ntwb_remove_private_title($title) {
	return '%s';
}

//taken from forum answer at http://wordpress.stackexchange.com/questions/97890/how-to-remove-a-metabox-from-menu-editor-page
// just add lines as needed to remove from the menu editor page
function custom_remove() {      
    remove_meta_box('add-sfwd-certificates', 'nav-menus', 'side');
    remove_meta_box('add-sfwd-assignment', 'nav-menus', 'side'); 
}
add_action('admin_head-nav-menus.php', 'custom_remove');

// add excerpt feature for custom fields from https://wordpress.org/support/topic/how-to-pull-excerpt-from-advanced-custom-field
function custom_field_excerpt() {
	global $post;
	$text = get_field('workshop_intro');
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$excerpt_length = 20; // 20 words
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}

// add excerpt feature for custom fields from https://wordpress.org/support/topic/how-to-pull-excerpt-from-advanced-custom-field
function custom_field_excerpt2() {
	global $post;
	$text = get_field('article_main');
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$excerpt_length = 20; // 20 words
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}

// add excerpt feature for custom fields from https://wordpress.org/support/topic/how-to-pull-excerpt-from-advanced-custom-field
function custom_field_excerpt3() {
	global $post;
	$text = get_field('quick_facts');
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$excerpt_length = 20; // 20 words
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}

// add excerpt feature for custom fields from https://wordpress.org/support/topic/how-to-pull-excerpt-from-advanced-custom-field
function custom_field_excerpt4() {
	global $post;
	$text = get_field('idiom_intro');
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$excerpt_length = 20; // 20 words
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}

// hide admin bar for subscribers 
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('edit_posts')) {
      show_admin_bar(false);
    }
}

//bbPress Messaging function overwrites
function eo_bbpm_get_breadcrumb() {
}
add_filter('bbpm_get_breadcrumb','eo_bbpm_get_breadcrumb');
function wp_8273966_pm_link( $user_id ) {

	if( ! get_userdata( $user_id ) || $user_id == wp_get_current_user()->ID || ! function_exists('bbpm_messages_base') )
		return;

	ob_start();
	?>
		<p><a href="<?php echo bbpm_messages_base( get_userdata( $user_id )->user_nicename . '/', wp_get_current_user()->ID ); ?>">Send <?php echo get_userdata( $user_id )->first_name; ?> a message</a></p>
	<?php

	return ob_get_clean();

}

add_filter('bbpm_bbp_template_after_user_profile', function() {

	return wp_8273966_pm_link( bbp_get_displayed_user_id() );

});

add_action('bbpm_bbp_theme_after_reply_author_details', function() {

	return wp_8273966_pm_link( bbp_get_reply_author_id() );

});


// add articles, themepages, lessons and courses to RSS feed
function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'article', 'sfwd-courses','sfwd-lessons','themepage');
	return $qv;
}
add_filter('request', 'myfeed_request');

// LearnDash redirect filters
add_filter("learndash_course_join_redirect", function($link, $course_id) {

$link = wp_login_url( get_permalink() );

return $link;
}, 5, 2);


// add facebook open graph meta to head from http://www.wpbeginner.com/wp-themes/how-to-add-facebook-open-graph-meta-data-in-wordpress-themes/

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
	global $post;
	if ( !is_singular()) {//if it is not a post or a page
		return;
    } else {
        $tf_url    = get_permalink();
        $tf_title  = get_the_title();
        
        if( custom_field_excerpt() ):
            $tf_desc = wp_strip_all_tags(custom_field_excerpt());
        elseif( custom_field_excerpt2() ):
            $tf_desc = wp_strip_all_tags(custom_field_excerpt2());
        elseif( custom_field_excerpt3() ):
            $tf_desc = wp_strip_all_tags(custom_field_excerpt3());
        else :
            $tf_desc = wp_strip_all_tags(get_the_excerpt());
        endif;
        
        if (has_post_thumbnail()) {
            $thumbid = get_post_thumbnail_id();
            $imgurl = wp_get_attachment_url( $thumbid );
        } else {
          $imgurl = home_url() . '/wp-content/themes/settlementPC/library/images/eo-livelearn.png';
        }
        $tf_name   = str_replace('@', '', get_the_author_meta('twitter'));
        ?>
        <meta name="twitter:card" value="summary" />
        <meta name="twitter:url" value="<?php echo $tf_url; ?>" />
        <meta name="twitter:title" value="<?php echo $tf_title; ?>" />
        
        <meta name="twitter:image" value="<?php echo $imgurl; ?>" />
        <meta name="twitter:site" value="@EnglishOnlineMB" />
        <?php if($tf_name) { ?>
            
            <meta name="twitter:creator" value="@<?php echo $tf_name; ?>" />
            
         <?php }
        
        echo '<meta property="og:title" content="' . $tf_title . '"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . $tf_url . '"/>';
        echo '<meta property="og:site_name" content="Live &amp; Learn: a project of English Online Inc."/>';
        echo '<meta property="og:description" content="' . $tf_desc . '"/>';
        echo '<meta property="og:image" content="' . $imgurl . '"/>';
    }
        
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

add_filter('learndash_show_next_link', 'learndash_show_next_link_proc', 10, 3);
function learndash_show_next_link_proc( $show_next_link = false, $user_id = 0, $post_id = 0 )
{ return true; }

// keep Autoptimize plugin from loading in IE7 and IE8 from https://wordpress.org/support/topic/is-there-any-way-to-exclude-autoptimize-for-ie78/ and http://stackoverflow.com/questions/5302302/php-if-internet-explorer-6-7-8-or-9

add_filter('autoptimize_filter_noptimize','browser_noptimize',10,0);
function browser_noptimize() {
	if ( (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8.0") !== false) || (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 7.0") !== false)) {
		return true;
	} else {
		return false;
	}
}

/* Body class browser detection */
function mv_browser_body_class($classes) {
        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
        if($is_lynx) $classes[] = 'lynx';
        elseif($is_gecko) $classes[] = 'gecko';
        elseif($is_opera) $classes[] = 'opera';
        elseif($is_NS4) $classes[] = 'ns4';
        elseif($is_safari) $classes[] = 'safari';
        elseif($is_chrome) $classes[] = 'chrome';
        elseif($is_IE) {
                $classes[] = 'ie';
                if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
                $classes[] = 'ie'.$browser_version[1];
        } else $classes[] = 'unknown';
        if($is_iphone) $classes[] = 'iphone';
        if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
                 $classes[] = 'osx';
           } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
                 $classes[] = 'linux';
           } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
                 $classes[] = 'windows';
           }
        return $classes;
}
add_filter('body_class','mv_browser_body_class');

/* DON'T DELETE THIS CLOSING TAG */ ?>