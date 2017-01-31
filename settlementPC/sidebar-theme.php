				<div id="sidebar3" class="sidebar" role="complementary">

					<?php if ( is_active_sidebar( 'sidebar3' ) ) : ?>

						<?php dynamic_sidebar( 'sidebar3' ); ?>
                    
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
                                    echo '<ul><li>There is nothing in your collection.</li></ul>';

                                endif;
                            endif; ?>
                            
                        </nav>
					<?php else : ?>

						<?php
							/*
							 * This content shows up if there are no widgets defined in the backend.
							*/
						?>

						<div class="no-widgets">
							<p><?php _e( 'This is a widget ready area. Add some and they will appear here.', 'bonestheme' );  ?></p>
						</div>

					<?php endif; ?>

				</div>
