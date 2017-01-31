				<div id="sidebar5" class="sidebar" role="complementary">

					<nav id="tertiary-navigation" class="site-navigation tertiary-navigation articles" role="navigation">
							 
								<?php
								//get current post's settlement-topics, display topic title and link to other posts in that settlement-topic
								//from http://wordpress.stackexchange.com/questions/66219/list-all-posts-in-custom-post-type-by-taxonomy
								$custom_terms1 = get_the_terms( $post->ID , 'settlement-topic' );
                                if ($custom_terms1 && ! is_wp_error($custom_terms1)) :
                                    foreach($custom_terms1 as $custom_term1) {

                                        wp_reset_query();
                                        $args = array('post_type' => 'article',
                                            'tax_query' => array(
                                            array(
                                                'taxonomy' => 'settlement-topic',
                                                'field' => 'slug',
                                                'terms' => $custom_term1->slug,
                                            ),
                                            ),
                                            'orderby'   => 'menu_order',
                                            'order'     => 'ASC'
                                         );

                                         $loop = new WP_Query($args);
                                         if($loop->have_posts()) {
                                            echo '<h1 class="topic-title"><small>Articles about:</small><br>'.$custom_term1->name.'</h1><div class="menu-header-menu-container"><ul>';
                                            while($loop->have_posts()) : $loop->the_post(); ?>
                                                <li<?php if ( $post->ID == $wp_query->post->ID ) { echo ' class="current"'; } else {} ?>>

                                                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>

                                                </li>
                                            <?php endwhile;
                                            echo '</ul></div>';
                                         }

                                    }
                                endif;
								wp_reset_query();
								?>
								
								<!--//from wordpress codex http://codex.wordpress.org/Function_Reference/get_the_terms along with bit in functions.php-->
							</nav>
							
							<nav class="site-navigation tertiary-navigation topics" role="navigation">
                                
								<!--loop through this settlement-topic's children, list title but link to first article, also count articles in child and display count-->								
								<?php
									$first_terms = get_the_terms( $post->ID , 'settlement-topic' );
                                    if ($first_terms && ! is_wp_error($first_terms)) :
                                        foreach($first_terms as $first_term) {
                                            $parent = get_term($first_term->parent, 'settlement-topic' );
                                            $parentslug = $parent->slug;
                                            $parentname = $parent->name;
                                            $parenturl = get_site_url() . '/immigration-theme/' . $parentslug;
                                            $postid = url_to_postid( $parenturl );
                                            //$parentchildren = get_terms( $postid, 'settlement-topic');
                                            $custom_terms = get_the_terms( $postid , 'settlement-topic' );
                                            echo '<h4 class="widgettitle special">All ' . $parentname . ' Topics</h4>';
                                            echo '<ul class="no-arrow">';
                                            $topics = 0;
                                            foreach($custom_terms as $custom_term) {
                                                $termslug = $custom_term->slug;
                                                $postsarticles = get_posts( array(
                                                    'post_type' => 'article',
                                                    'settlement-topic' => $termslug,
                                                ) );
                                                $count =  count( $postsarticles );
                                                if ($count > 0) { //don't repeat topic user is currently in
                                                    $args = array(
                                                        'post_type' => 'article', // change this to the post type you registered
                                                        'orderby'   => 'menu_order',
                                                        'order'     => 'ASC',
                                                        'posts_per_page' => 1,
                                                        'tax_query' => array(
                                                            array(
                                                                'post_type' => 'article',
                                                                  'taxonomy' => 'settlement-topic',
                                                                  'field' => 'id',
                                                                  'terms' => array($custom_term->term_id),
                                                            )
                                                        )
                                                          );
                                                    $first_article = get_posts($args);
                                                    if ($custom_term->name !== $first_term->name) {
                                                        echo '<li><a href="'. get_permalink( $first_article[0]->ID ) .'" title="Articles about '. $custom_term->name . '" style="text-decoration:none;">' . $custom_term->name . '</a></li>';
                                                    } else {
                                                        echo '<li class="current"><a href="'. get_permalink( $first_article[0]->ID ) .'" title="Articles about '. $custom_term->name . '" style="text-decoration:none;">' . $custom_term->name . '</a></li>';
                                                    }

                                                    $topics++;
                                                }


                                            }

                                            if( $topics == 0) {
                                                echo '<li>We are currently adding more topics and articles. Please check back.</li>';
                                            }
                                            echo '</ul>';
                                        }
                                endif;
									wp_reset_query();

								?>
			   
							</nav>
							
							<nav class="tertiary-navigation"><h4 class="widgettitle special">My Articles</h4>
                                <?php if(!is_user_logged_in()) : ?> <!-- if user is NOT logged in -->
                                    <ul><li>Please login to access your saved articles.</li></ul>
                                <?php else :
                                    /**
                                    * Get an array of User Favorites
                                    * https://favoriteposts.com/
                                    */
                                    $favorites = get_user_favorites();
                                    if ( isset($favorites) && !empty($favorites) ) :

                                        echo '<ul>';

                                        foreach ( $favorites as $favorite ) :
                                            $favlink = get_the_permalink($favorite);
                                            $favtitle = get_the_title($favorite);
                                            echo '<li>'; ?>
                                            <a href="<?php echo $favlink ?>"><?php echo $favtitle; ?></a>
                                            <?php echo '</li>';
                                            // You'll have access to the post ID in this foreach loop, so you can use WP functions like get_the_title($favorite);
                                        endforeach;
                                        echo '</ul>';
                                    else :
                                        echo '<ul><li>Nothing is saved in My Articles.</li></ul>';

                                    endif;
                                endif; ?>

                            </nav>

                            <div class="widget report-error">
                                <h4 class="widgettitle">To report an error&hellip;</h4>

                                <?php
                                //if($_SERVER["REQUEST_METHOD"]=="POST"){
                                    
                                   if(isset($_POST['submit'])) {
      
                                        $EmailFrom = "info@myenglishonline.ca";
                                        $EmailTo = "cloza@myenglishonline.ca";
                                        $Subject = "Live & Learn Article error";
                                        $Name = Trim(stripslashes($_POST['Name']));
                                        $Emailf = Trim(stripslashes($_POST['Emailf']));
                                        $Email = Trim(stripslashes($_POST['Email']));
                                        $url = Trim(stripslashes($_POST['url']));
                                        $Message = Trim(stripslashes($_POST['Issue']));

                                        // validation

                                            $validationOK=true;
                                            if (!$validationOK || $Emailf != '') {
                                              echo '<p><strong>We were unable to process your feedback. For further assistance, contact us <a href="http://myenglishonline.ca/contact-us/" target=_blank">here</a>.</strong></p>';
                                              exit;
                                            }


                                        // prepare email body text
                                        $Body = "";
                                        $Body .= "Name: ";
                                        $Body .= $Name;
                                        $Body .= "\n";
                                        $Body .= "Email: ";
                                        $Body .= $Email;
                                        $Body .= "\n";
                                        $Body .= "URL: ";
                                        $Body .= $url;
                                        $Body .= "\n";
                                        $Body .= "Issue: ";
                                        $Body .= $Message;
                                        $Body .= "\n";

                                        // send email
                                        $success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

                                        // redirect to success page 
                                        if ($success){
                                          echo "<p><strong>Thank you for helping us improve!</strong></p>";
                                        }
                                        else{
                                          echo '<p><strong>We were unable to process your feedback. For further assistance, contact us <a href="http://myenglishonline.ca/contact-us/" target=_blank">here</a>.</strong></p>';
                                        }
                                    //}
                                    
                                } else { ?>
                                <p>We do our best to keep our content accurate and up-to-date. If you see an error here, please use this form.</p>

                                <form method="post" action="<?php echo get_permalink( $post->ID ); ?>">
                                    <label for="Name">Name:</label>
                                    <input type="text" name="Name" id="Name" required>

                                    <label for="Email">Email:</label>
                                    
                                    <input class="honey" type="text" name="Emailf" id="Emailf">
                                    
                                    <input type="email" name="Email" id="Email" required>
                                    
                                    <label for="Issue">Description of Issue:</label>
                                    <textarea name="Issue" rows="10" cols="20" id="Issue" required></textarea>
                                    
                                    <input class="honey" type="url" name="url" id="url" value="<?php echo get_permalink( $post->ID ); ?>">
                                    <input type="submit" name="submit" value="Submit" class="submit-button">
                                </form>
                                    
                               <?php }


?>
                            </div>

				</div>
