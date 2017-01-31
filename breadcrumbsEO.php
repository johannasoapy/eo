<?php
/**
 * @package Breadcrumbs_EO
 */
/*
Plugin Name: Breadcrumbs by EO
Description: EO's custom breadcrumbs
Author: English Online Inc.
Author URI: http://youliveandlearn.ca
*/

//wordpress custom breadcrumbs without plugin from http://fellowtuts.com/wordpress/wordpress-custom-breadcrumbs-without-plugin/
// start ft_custom_breadcrumb
function ft_custom_breadcrumbs(array $options = array() ) {
	
	// default values assigned to options
	$options = array_merge(array(
        'crumbId' => 'nav_crumb', // id for the breadcrumb Div
	'crumbClass' => 'nav_crumb', // class for the breadcrumb Div
	//'beginningText' => '', // text showing before breadcrumb starts
	//'showOnHome' => 0,// 1 - show breadcrumbs on the homepage, 0 - don't show
	'homePageText' => 'Home', // text for the 'Home' link
	'showCurrent' => 1, // 1 - show current post/page title in breadcrumbs, 0 - don't show
	'beforeTag' => '<span class="current">', // tag before the current breadcrumb
	'afterTag' => '</span>', // tag after the current crumb
	'showTitle'=> 1 // showing post/page title or slug if title to show then 1
   ), $options);
   
   $crumbId = $options['crumbId'];
	$crumbClass = esc_html($options['crumbClass']);
	//$beginningText = esc_html($options['beginningText']);
	//$showOnHome = esc_html($options['showOnHome']);
	$homePageText = esc_html($options['homePageText']); 
	$showCurrent = esc_html($options['showCurrent']); 
	$beforeTag = $options['beforeTag']; 
	$afterTag = $options['afterTag']; 
	$showTitle =  esc_html($options['showTitle']); 
	
	global $post;

	$wp_query = $GLOBALS['wp_query'];

	$homeLink = get_bloginfo('url');
	
	echo '<div id="'. $crumbId .'" class="'. $crumbClass .'" >';
	
	  echo '<a href="' . esc_url($homeLink) . '">' . $homePageText . '</a> ';
	
	  if ( is_category() ) {
		$thisCat = get_category(get_query_var('cat'), false);
		if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ');
		echo $beforeTag . 'Archive by category "' . single_cat_title('', false) . '"' . $afterTag;
	
	  } elseif ( is_tax('events-category') ) {
		  $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		  $parents = array();
		  $parent = $term->parent;
		  while ( $parent ) {
			  $parents[] = $parent;
			  $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
			  $parent = $new_parent->parent;

		  }		  
		  if ( ! empty( $parents ) ) {
			  $parents = array_reverse( $parents );
			  foreach ( $parents as $parent ) {
				  $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
				  echo   '<a href="' . esc_url(get_term_link( $item->slug, get_query_var( 'taxonomy' ) ) . '">' . $item->name) . 'lalalala</a>';
			  }
		  }

		  $queried_object = $wp_query->get_queried_object();
		  echo $beforeTag . $queried_object->name . $afterTag;	  
	} elseif ( is_tax() ) {
		  $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		  $parents = array();
		  $parent = $term->parent;
		  while ( $parent ) {
			  $parents[] = $parent;
			  $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
			  $parent = $new_parent->parent;

		  }		  
		  if ( ! empty( $parents ) ) {
			  $parents = array_reverse( $parents );
			  foreach ( $parents as $parent ) {
				  $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
				  echo   '<a href="' . esc_url(get_term_link( $item->slug, get_query_var( 'taxonomy' ) ) . '">' . $item->name) . '</a>';
			  }
		  }

		  $queried_object = $wp_query->get_queried_object();
		  echo $beforeTag . $queried_object->name . $afterTag;	  
	} elseif ( is_search() ) {
		echo $beforeTag . 'Search results for "' . get_search_query() . '"' . $afterTag;
	
	  } elseif ( is_day() ) {
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y')) . '">' . get_the_time('Y')) . '</a> ';
		echo '<a href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F')) . '</a>';
		echo $beforeTag . get_the_time('d') . $afterTag;
	
	  } elseif ( is_month() ) {
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y')) . '">' . get_the_time('Y')) . '</a> ';
		echo $beforeTag . get_the_time('F') . $afterTag;
	
	  } elseif ( is_year() ) {
		echo $beforeTag . get_the_time('Y') . $afterTag;
	
	  } elseif ( is_single() && !is_attachment() ) {
		  
		     if($showTitle)
			   $title = get_the_title();
			  else
			  $title =  $post->post_name;
		  
					if ( get_post_type() == 'article' ) { // for single-article

					  if ( $terms = wp_get_object_terms( $post->ID, 'settlement-topic' ) ) {
		
						  $term = current( $terms );
		
						  $parents = array();
		
						  $parent = $term->parent;
						  while ( $parent ) {
		
							  $parents[] = $parent;
		
							  $new_parent = get_term_by( 'id', $parent, 'settlement-topic' );
		
							  $parent = $new_parent->parent;
		
						  }
						  if ( ! empty( $parents ) ) {
		
							  $parents = array_reverse($parents);
		
							  foreach ( $parents as $parent ) {
		
								  $item = get_term_by( 'id', $parent, 'settlement-topic');
	
								  echo  '<a href="' . esc_url(home_url()) . '/live">Live</a><a href="' . esc_url(home_url() . '/immigration-theme/' . $item->slug) . '">' . $item->name . '</a>';
		
							  }
						  }
						  
						  echo  '<span>' . esc_html($term->name) . '</span>'; //echo name of the settlement topic - not linked to anything
					  }
					  
				  } elseif ( get_post_type() == 'themepage' ) {
                        if ( $terms = wp_get_object_terms( $post->ID, 'settlement-topic' ) ) {
		
						  $term = current( $terms );
		
						  $parents = array();
		
						  $parent = $term->parent;
						  while ( $parent ) {
		
							  $parents[] = $parent;
		
							  $new_parent = get_term_by( 'id', $parent, 'settlement-topic' );
		
							  $parent = $new_parent->parent;
		
						  }
						  if ( ! empty( $parents ) ) {
		
							  $parents = array_reverse($parents);
		
							  foreach ( $parents as $parent ) {
		
								  $item = get_term_by( 'id', $parent, 'settlement-topic');
	
								  echo  '<a href="' . esc_url(home_url()) . '/live">Live</a><span>' . $item->name . '</span>';
		
							  }
						  }
					  }
                        
                } elseif ( get_post_type() == 'sfwd-courses' ) { //for LearnDash single-sfwd-courses
					
                        $types = wp_get_object_terms( $post->ID, 'learning_types' );
                        $options = wp_get_object_terms( $post->ID, 'learning_options' );
                        if ( $types ) {
		
						  $type = current( $types );

                          //$item = get_term_by( 'id', $term, 'learning_types');                          
                        
                            echo  '<a href="' . esc_url(home_url()) . '/learn">Learn</a><a href="' . esc_url(home_url() . '/learn/' . $type->slug) . '">' . $type->name . '</a>';				 
                        } else {
                            echo  '<a href="' . esc_url(home_url()) . '/learn">Learn</a>';
                        }// end if $types
                        if ( $options ) {
							$option = current( $options );
							echo  '<a href="' . esc_url(home_url() . '/learn/' . $option->slug) . '">' . $option->name . '</a>';
                        } // end if options
                        
                        echo  '<span>' . the_title() . '</span>'; //echo name of the course - not linked to anything
                        
                } elseif ( get_post_type() == 'sfwd-lessons' || get_post_type() == 'sfwd-topic' ) { // for LearnDash topics and lessons
                        $id = $post->ID;
                        
                        $parent_id = get_post_meta( $id, 'course_id', true );
                            
                        $parent = get_the_title( $parent_id );
                        
                        $types = wp_get_object_terms( $parent_id, 'learning_types' );
						$options = wp_get_object_terms( $parent_id, 'learning_options' );
						if ( $types ) {
		
						  $type = current( $types );

                          //$item = get_term_by( 'id', $term, 'learning_types');                          
                        
                            echo  '<a href="' . esc_url(home_url()) . '/learn">Learn</a><a href="' . esc_url(home_url() . '/learn/' . $type->slug) . '">' . $type->name . '</a>';				 
                        } else {
                            echo  '<a href="' . esc_url(home_url()) . '/learn">Learn</a>';
                        }// end if $types
                        if ( $options ) {
							$option = current( $options );
							echo  '<a href="' . esc_url(home_url() . '/learn/' . $option->slug) . '">' . $option->name . '</a>';
                        } // end if options
                        
                        echo  '<a href="' . get_post_permalink( $parent_id ) . '">' . $parent . '</a>';
						  
                        echo  '<span>' . the_title() . '</span>'; //echo name of the course - not linked 
                        
                } elseif ( get_post_type() == 'tribe_events' ) {
				                         
                        echo  '<a href="' . esc_url(home_url()) . '/events">Events</a>';
                        $types = wp_get_object_terms( $post->ID, 'tribe_events_cat' );
                        if ( $types !== '' ) {
		
                            $type = current( $types ); 
                            echo '<a href="' . esc_url(home_url() . '/events/category/' . $type->slug) . '">' . $type->name . '</a>';
                        }
						  echo  '<span>' . the_title() . '</span>'; //echo name of the course - not linked to anything
                } elseif ( get_post_type() == 'tribe_venue' || get_post_type() == 'tribe_organizer' ) {
				                         
                        echo  '<a href="' . esc_url(home_url()) . '/events">Events</a>';
						  echo  '<span>' . the_title() . '</span>'; //echo name of the course - not linked to anything
                } elseif ( get_post_type() != 'post' ) {
				  $post_type = get_post_type_object(get_post_type());
				  $slug = $post_type->rewrite;
				  echo '<a href="' . esc_url(home_url() . '/' . $slug) . '">' . $post_type->name . '</a>';
				} else {
				  $cat = get_the_category(); $cat = $cat[0];
				  $cats = get_category_parents($cat, TRUE, ' ');
				  if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				  echo $cats;
				  if ($showCurrent == 1) echo $beforeTag . $title . $afterTag;
		
				}

	  } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
		  
		$post_type = get_post_type_object(get_post_type());
		
		echo $beforeTag . $post_type->labels->singular_name . $afterTag;
			 
	 } elseif ( is_attachment() ) {
			 
		$parent = get_post($post->post_parent);
		$cat = get_the_category($parent->ID); $cat = $cat[0];
		echo get_category_parents($cat, TRUE, ' ');
		echo '<a href="' . esc_url(get_permalink($parent) . '">' . $parent->post_title) . '</a>';
		if ($showCurrent == 1) echo $beforeTag . get_the_title() . $afterTag;	
		  
		} elseif ( is_page() && !$post->post_parent ) {
			$title =($showTitle)? get_the_title():$post->post_name;
			  
		if ($showCurrent == 1) echo $beforeTag .  $title . $afterTag;

	  } elseif ( is_page() && $post->post_parent ) {
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ($parent_id) {
		  $page = get_page($parent_id);
		  $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID) . '">' . get_the_title($page->ID)) . '</a>';
		  $parent_id  = $page->post_parent;
		}
		$breadcrumbs = array_reverse($breadcrumbs);
		for ($i = 0; $i < count($breadcrumbs); $i++) {
		  echo $breadcrumbs[$i];
		  if ($i != count($breadcrumbs)-1) echo ' ';
		}
			$title =($showTitle)? get_the_title():$post->post_name;
		   
	if ($showCurrent == 1) echo $beforeTag . $title . $afterTag;

	  } elseif ( is_tag() ) {

		echo $beforeTag . 'Posts tagged "' . single_tag_title('', false) . '"' . $afterTag;

	  } elseif ( is_author() ) {
		 global $author;
		$userdata = get_userdata($author);

		echo $beforeTag . 'Articles posted by ' . $userdata->display_name . $afterTag;

	  } elseif ( is_404() ) {
		  
		echo $beforeTag . 'Error 404' . $afterTag;

	  }

	  if ( get_query_var('paged') ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_tax() ) echo ' (';
		echo __('Page') . ' ' . get_query_var('paged');
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_tax() ) echo ')';
	  }
	echo '</div>';
  }
// end ft_custom_breadcrumb
?>