<?php
/*
Plugin Name: EO Change Permalinks
Plugin URI: http://youliveandlearn.ca
Description: Customizes permalinks to include settlement topics
Version: 1.0
Author: English Online
Author URI: http://myenglishonline.ca
License: GPL2
*/
// help wp understand %settlement-topic% in urls from http://wordpress.stackexchange.com/questions/5308/custom-post-types-taxonomies-and-permalinks
function filter_post_type_link($link, $post)
{
	// We want to add the settlement topic in front of articles, courses, lessons, topics and quizzes, so check if it's one of those
    if ($post->post_type != 'article' && $post->post_type != 'sfwd-courses' && $post->post_type != 'sfwd-lessons' && $post->post_type != 'sfwd-quiz' && $post->post_type != 'sfwd-topic' ) {
        return $link; // if not, return regular link
    }
	
	// if is lesson, quiz or topic, look for term in parent post (course)
	elseif ( $post->post_type == 'sfwd-lessons' || $post->post_type == 'sfwd-quiz' || $post->post_type == 'sfwd-topic' ) {
        $course_id = get_post_meta( $post->ID, 'course_id', true ); // Getting Parent Course ID
			if ($catsp = get_the_terms($course_id, 'settlement-topic')) {
				// loop through all settlement topics applied
					foreach($catsp as $catp) {
						//get parent of each term (there should only be one parent - no overlap)
						$parent1p = get_term($catp->parent, 'settlement-topic' );
						// if there is no parent
						if (is_wp_error($parent1p)) {
							$parentslug1p = $catp->slug;
						} else {
							$parentslug1p = $parent1p->slug;
						}
						// add parent settlement topic term into permalink
							$link = str_replace('%settlement-topic%', $parentslug1p, $link);
					}
				return $link;
			}
			else {
				return $link;
			}
    }
	// else if is article or course
	else {
		// if has settlement topics applied to it
		if ($cats = get_the_terms($post->ID, 'settlement-topic')) {
				// loop through all settlement topics applied
				foreach($cats as $cat) {
					//get parent of each term (there should only be one parent - no overlap)
					$parent1 = get_term($cat->parent, 'settlement-topic' );
					// if there is a parent (like there should be for articles)
					if (is_wp_error($parent1)) {
						$parentslug1 = $cat->slug;
					} else {
						$parentslug1 = $parent1->slug;
					}
					// add parent settlement topic term into permalink
						$link = str_replace('%settlement-topic%', $parentslug1, $link);
				}
			return $link;
		}
		// if has no settlement topics applied to it, return link
		else {
				return $link;
		}  
	}
}
add_filter('post_type_link', 'filter_post_type_link', 10, 2);

add_filter("learndash_post_args", function($post_args) {
	foreach ($post_args as $key => $post_arg) {
		if($post_arg["post_type"] == "sfwd-courses") {
			
			$post_args[$key]["slug_name"] = "activities/%settlement-topic%";
		}
		elseif($post_arg["post_type"] == "sfwd-lessons") {
				$post_args[$key]["slug_name"] = "lessons/%settlement-topic%";
		}
		elseif($post_arg["post_type"] == "sfwd-quiz") {
			$post_args[$key]["slug_name"] = "quizzes/%settlement-topic%";
		}
		elseif($post_arg["post_type"] == "sfwd-topic") {
			$post_args[$key]["slug_name"] = "topic/%settlement-topic%";
		}
	}
	
	return $post_args;
}, 10, 1);


?>