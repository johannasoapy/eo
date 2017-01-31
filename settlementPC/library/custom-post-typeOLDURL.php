<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
// let's create the function for the Articles
function custom_post_article() { 
	// creating (registering) the custom type 
	register_post_type( 'article', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Articles', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Article', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Articles', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Article', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Article', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Article', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Article', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Articles', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'These are the immigration articles', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'article', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'article', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_article');

// let's create the function for the Theme Pages
function custom_post_themepage() { 
	// creating (registering) the custom type 
	register_post_type( 'themepage', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Theme Pages', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Immigration Theme', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Theme Pages', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Theme Page', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Theme Page', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Theme Page', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Theme Page', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Theme Pages', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'These are the pages for the immigration themes, including Quick Facts and lists of sub-topics.', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'immigration-theme', 'with_front' => false ), /* you can specify its url slug */
			//'has_archive' => 'theme', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'sticky')
		) /* end of options */
	); /* end of register post type */

}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_themepage');
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories for Articles and Theme Pages (these act like categories)
	register_taxonomy( 'settlement-topic', 
		array('article','themepage','sfwd-courses','sfwd-lessons','forum','topic'), /* if you change the name of register_post_type( 'article', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Settlement Topics', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Settlement Topic', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Settlement Topics', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Settlement Topics', 'bonestheme' ), /* all title for taxonomies */
				//'parent_item' => __( 'Parent Settlement Topic', 'bonestheme' ), /* parent title for taxonomy */
				//'parent_item_colon' => __( 'Parent Settlement Topic:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Settlement Topic', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Settlement Topic', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Settlement Topic', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Settlement Topic Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'settlement-topic' ),
		)
	);
	
	
	
	// now let's add custom categories for sfwd-courses, sfwd-lessons, and sfwd-topic (these act like categories)
	register_taxonomy( 'learning_options', 
		array('sfwd-courses', 'sfwd-lessons', 'sfwd-topic', 'forum'), /* the name of the post type */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Learning Options', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Learning Option', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Learning Options', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Learning Options', 'bonestheme' ), /* all title for taxonomies */
				'edit_item' => __( 'Edit Learning Option', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Learning Option', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Learning Option', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Learning Option Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'learning_options' ),
		)
	);
	
	// interaction type for learning options ie. Peer-to-Peer, One-on-One, Group Study, Self Study (these act like tags)
	register_taxonomy( 'learning_types', 
		array('sfwd-courses', 'sfwd-lessons', 'forum'), /* the name of the post type */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Learning Types', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Learning Type', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Learning Types', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Learning Types', 'bonestheme' ), /* all title for taxonomies */
				'edit_item' => __( 'Edit Learning Type', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Learning Type', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Learning Type', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Learning Type Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'learning_types' ),
		)
	);
	
	// Language Level (these act like tags)
	register_taxonomy( 'language_level', 
		array('sfwd-courses', 'sfwd-lessons', 'sfwd-quiz', 'forum'), /* the name of the post type */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Language Levels', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Language Level', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Language Levels', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Language Levels', 'bonestheme' ), /* all title for taxonomies */
				'edit_item' => __( 'Edit Language Level', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Language Level', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Language Level', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Language Level Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'language_level' ),
		)
	);
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
