<?php
/*
 * ARTICLE TEMPLATE
*/
?>

<?php get_header(); ?>

			<div id="content">
				<div id="inner-content" class="wrap cf">

					<div class="breadcrumbs">
							<?php if (function_exists('ft_custom_breadcrumbs')) {
								ft_custom_breadcrumbs();
							} ?>
					</div>
						<main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
                            
                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            
							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">
                                
                                
                                
								<header class="article-header">

									<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time(get_option('date_format')) );
									?></p>

									<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
										ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) );
									} ?>

								</header>

								<section class="entry-content cf" item>
                                    
										<!-- featured image and attribution -->
											<?php if (has_post_thumbnail()): ?>
											<div class="wp-caption" itemprop="image">
												<?php the_post_thumbnail( 'bones-thumb-900' ); ?>
												<p class="wp-caption-text">
													<?php $postthumb = get_post_thumbnail_id(); ?>
													<?php if( get_field('cc_title', $postthumb ) ): ?>
														<span>
															<?php if( get_field('cc_title_link', $postthumb) ): ?>
														<a href="<?php echo the_field('cc_title_link', $postthumb); ?>" target="_blank"><?php echo the_field('cc_title', $postthumb); ?></a>
															<?php else: ?>
																<?php echo the_field('cc_title', $postthumb); ?>
															<?php endif; ?>
														</span>
													<?php endif; ?>
		
													<?php if( get_field('cc_author', $postthumb ) ): ?>
														<span>
															<?php if( get_field('cc_author_link', $postthumb) ): ?>
														&nbsp;by <a href="<?php echo the_field('cc_author_link', $postthumb); ?>" target="_blank"><?php echo the_field('cc_author', $postthumb); ?></a>.
															<?php else: ?>
																&nbsp;by <?php echo the_field('cc_author', $postthumb); ?>.
															<?php endif; ?>
														</span>
													<?php endif; ?>
		
													<?php if( get_field('cc_license', $postthumb) ): ?>
														<?php if( null !== get_field('cc_license', $postthumb)): ?>
															<?php $cclicense = get_field_object('field_5583260d7493e',$postthumb); ?>
															<?php $ccvalue = get_field('cc_license',$postthumb); ?>
															<?php $cclabel = $cclicense['choices'][ $ccvalue ]; ?>
															<?php if ( $ccvalue == 'copyright'): ?>
																<span>&nbsp;<?php echo $cclabel; ?></span>
															<?php else: ?>
																<span>&nbsp;<a href="<?php echo $ccvalue; ?>" target="_blank"><?php echo $cclabel; ?></a></span>
															<?php endif; ?>
														<?php endif; ?>
													<?php endif; ?>
												</p>
											</div>
											<?php endif; ?>
                                    
                                    <?php if( has_term( 'lower-intermediate-clb-3-4', 'language_level' ) ) : ?>
                                    <!-- if this article has this language level set, we will then check the url for the term clb3, and if it's there we will load the simple fields into the variables to use in the content -->

                                        <?php $articleURI = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
                                    
                                        <?php if (strpos($articleURI, 'clb3') !== false) { // if the page uri includes the word clb3, load the simple fields into the variables ?>
                                            <form name="switcher" class="switcher" id="switcher" method="get" action="<?php echo get_permalink(); ?>" >
                                                <label class="simple-label" for="clb5plus">Read Original Version (CLB5+)</label>
                                                <input onclick='javascript:document.forms.switcher.submit();return true;' type="radio" name="clb-version" value="clb5plus" id="clb5plus">
                                                <label class="simple-label active" for="clb3-4">You are reading the Simple Version (CLB3-4)</label>
                                                <input onclick='javascript:document.forms.switcher.submit();return true;' type="radio" name="clb-version" value="clb3-4" id="clb3-4">
                                                
                                                <input type="submit" value="Submit" style="display:none;">
                                            </form>
                                    
                                            <p class="switcher-alternative" style="margin-bottom: 1em;"><a class="label" href="<?php the_permalink(); ?>?clb-version=clb5plus">Read Original Version (CLB5+)</a> <a class="label active" href="<?php the_permalink(); ?>?clb-version=clb3-4">You are reading the Simple Version (CLB3-4)</a>
                                    
                                            <?php $main = get_field('main_simple');
                                                $titleSimple = get_field('title_simple');
                                                $resources = get_field('resources_simple');
                                                $quiz = get_field('quiz_simple');
                                                $forum = get_field('article_forum');
    
                                        }  else { ?><!-- if url doesn't have clb3 in it we will load original fields into variables and show the input to switch to CLB5+ version -->
                                    
                                            <form name="switcher" class="switcher" id="switcher" method="get" action="<?php echo get_permalink(); ?>" >
                                                <label class="simple-label active" for="clb5plus">You are reading the Original Version (CLB5+)</label>
                                                <input onclick='javascript:document.forms.switcher.submit();return false;' type="radio" name="clb-version" value="clb5plus" id="clb5plus">
                                                <label class="simple-label" for="clb3-4">Read Simple Version (CLB3-4)</label>
                                                <input onclick='javascript:document.forms.switcher.submit();return false;' type="radio" name="clb-version" value="clb3-4" id="clb3-4">
                                                
                                                <input type="submit" value="Submit" style="display:none;"><!-- this is supposed to be a fix for Firefox/ie8 glitch, doesn't seem to work, therefore there is also the .switcher-alternative -->
                                            </form>
                                    
                                            <p class="switcher-alternative" style="margin-bottom: 1em;"><a class="label active" href="<?php the_permalink(); ?>?clb-version=clb5plus">You are reading the Original Version (CLB5+)</a> <a class="label" href="<?php the_permalink(); ?>?clb-version=clb3-4">Read Simple Version (CLB3-4)</a>
                                    
                                            <?php
                                                $main = get_field('article_main');
                                                $resources = get_field('article_resources');
                                                $quiz = get_field('article_quiz');
                                                $forum = get_field('article_forum'); 
                                            ?>


                                        <?php } ?>

                                    
                                    <?php else : ?><!-- if doesn't have term lower-intermediate-clb-3-4 -->
                                    
                                        <?php
                                            $main = get_field('article_main');
                                            $resources = get_field('article_resources');
                                            $quiz = get_field('article_quiz');
                                            $forum = get_field('article_forum'); 
                                        ?>
                                    
                                    <?php endif; ?><!-- end if has term lower-intermediate-clb-3-4 -->
                                    
										<?php if( !empty($main) ): ?>
											<section id="article-main" class="article-section cf" itemprop="articleMain">
                                                
                                                <span id="skipto-block" class="m-all t-all d-1of4 last-col">
                                                     <?php if(is_user_logged_in()) : ?> <!-- if user is logged in -->
                                                        <?php /**
                                                        * Get the favorite button for a specified post
                                                        * Post ID not required if inside the loop
                                                        * @param $post_id int, defaults to current post
                                                        */
                                                        get_favorites_button();

                                                        /**
                                                        * Echo the favorite button for a specified post
                                                        * Post ID not required if inside the loop
                                                        * @param $post_id int, defaults to current post
                                                        */ 
                                                        the_favorites_button(); ?>
                                                    <?php endif; ?>
                                                
                                                <span class="standout-block">
                                                    <h3>Skip to:</h3>
                                                    <ul>

                                                        <?php if( !empty($resources) ): ?>
                                                            <li><a href="#article-links">Community Resources</a></li>
                                                        <?php endif; ?>
                                                        <?php if( !empty($quiz) ): ?>
                                                            <li><a href="#article-quiz">Language Quiz</a></li>
                                                        <?php endif; ?>
                                                        
                                                            <li><a href="#related-learning">Related Activities</a></li>
                                                        <?php if( !empty($forum) ): ?>
                                                            <li><a href="#article-forum">Discussion Forum</a></li>
                                                        <?php endif; ?>
                                                        
                                                    </ul>
                                                    </span>
                                                </span>
											     <div id="article-content">
                                                <?php if( !empty($titleSimple) ): ?>
                                                    <?php echo '<h2>' . $titleSimple . '</h2>'; ?>
                                                <?php endif; ?><?php echo $main; ?></div>
                                                <p class="clear"><a href="#main" class="backtotop">Back to top</a></p>
											</section>
										<?php endif; ?>
										<?php if( !empty($resources) ): ?>
											<section id="article-links" class="article-section cf" itemprop="articleResources">
												<h2>Community Resources</h2>
												<?php echo $resources; ?>
                                                <p class="clear"><a href="#main" class="backtotop">Back to top</a></p>
											</section>
										<?php endif; ?>
                                    
                                    <section id="learner-feedback" class="article-section cf">
                                        <h3>We'd love to hear from you!</h3>
                                        <?php if(!is_user_logged_in()) { ?> <!-- if user is NOT logged in -->
                                            <p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to tell us what you think.</p>
                                        <?php } else {
                                            echo do_shortcode('[mrp_rating_form rating_form_id="2"]');
                                        } ?>
                                    </section>
                                    
                                    
										<?php if( !empty($quiz) ): ?>
											<section id="article-quiz" class="article-section cf" itemprop="articleQuiz">
												<h2>Quiz</h2>
												<?php echo $quiz; ?>
                                                <p class="clear"><a href="#main" class="backtotop">Back to top</a></p>
											</section>
										<?php endif; ?>
                                                                     
                                    <!--related learning activities-->
                                    <section id="related-learning" class="article-section cf">
                                        
                                        
                                        <?php $postsr = get_field('article_conversation');
											
											if( $postsr ): ?>
												<section class="article-subsection cf" itemprop="articleConversation">
												<h2>Join a Virtual Coffee Chat</h2>
                                                    
												
                                                    <?php foreach( $postsr as $post): // variable must be called $post (IMPORTANT) ?>
                                                        <?php setup_postdata($post); ?>
                                                        
                                                        <h3><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h3>
                                                        <?php echo tribe_get_start_date(); ?>
                                                        <?php $eventDate = tribe_get_start_date( null, false, 'Y-m-d' );

                                                        $datehere = new DateTime("now", new DateTimeZone('America/Winnipeg'));
                                                        $todayDate = $datehere->format('Y-m-d');

                                                            if( $todayDate <= $eventDate ): //only shows 'Join' on day of event
                                                    ?>
                                                        <p>You must be <a href="<?php home_url(); ?>/register" title="Register" target="_blank">registered</a> and logged in to join.</p>
                                                    <?php else: ?>
                                                        <p>This event has passed.</p>
                                                    <?php endif; ?>
                                                        
                                                    <?php endforeach; ?>
												
												<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>    
                                                    <hr>
												</section>  <!--end section if there are no external links-->
                                            <?php endif; ?>
                                    
                                    
                                    <?php if ( $terms = wp_get_object_terms( $post->ID, 'settlement-topic' ) ) {
		
                                      $term = current( $terms );

                                      $parents = array();

                                      $parent = $term->parent;
                                      while ( $parent ) {
                                          $parents[] = $parent;
                                          $new_parent = get_term_by( 'id', $parent, 'settlement-topic' );
                                          $parent = $new_parent->parent;
                                      }
                                      if ( ! empty( $parents ) ) { ?>
                                          
                                          <section class="article-subsection cf" itemprop="relatedLearning">
                                              <h2>Related Learning Activities</h2>
                                          
                                         <?php $parents = array_reverse($parents);
              
                                          foreach ( $parents as $parent ) {

                                              $item = get_term_by( 'id', $parent, 'settlement-topic');
                                              $args3 = array(
                                                    'post_type' => array('sfwd-courses', 'sfwd-lessons','tribe_events'),
                                                    'settlement-topic' => $item->slug,
                                                    'posts_per_page' => 4,
                                                    'orderby' => 'modified',
                                                    'order' => 'DESC', 
                                                );
                                            $loop3 = new WP_Query($args3);
								
                                            if($loop3->have_posts()): while($loop3->have_posts()): $loop3->the_post(); ?>
                                            <div class="post-grid">
                                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                    <?php if (has_post_thumbnail()): ?>
                                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
                                                        <?php else: ?>
                                                            <a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
                                                        <?php endif; ?>
                                                   <?php if( get_the_excerpt() !== '' ):  ?>
                                                        <?php echo the_excerpt(); ?>
                                                    <?php elseif( custom_field_excerpt() !== '' ): ?>
                                                        <?php echo custom_field_excerpt(); ?>
                                                    <?php elseif( custom_field_excerpt4() !== '' ): ?>
                                                        <?php echo custom_field_excerpt4(); ?>
                                                    <?php endif; ?>
                                            </div>
                                        <?php
                                            endwhile; ?>
                                        
                                              <?php else: ?>
                                              <p>There are no related learning activities at this time.</p>
                                              <?php endif; ?>
                                            <?php wp_reset_query();
                                          } ?>
                                              <p class="clear"><a href="#main" class="backtotop">Back to top</a></p>
                                              </section>
                                              
                                          
                                      <?php } 
}
                                    ?>
                                    </section>
                                        <?php if( get_field('article_forum') ): ?>
											<section id="article-forum" class="article-section cf" itemprop="articleForum">
												<h2>Join the Discussion</h2>
                                                <?php if ( is_user_logged_in() ): ?>
												    <?php esc_attr(the_field('article_forum')); ?>
                                                <?php else : ?>
                                                    <p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to view the Discussion Forums. If you are not yet a registered learner, <a href="<?php echo home_url(); ?>/register">find out how to register</a>.</p>
                                                <?php endif; ?>
                                                <p class="clear"><a href="#main" class="backtotop">Back to top</a></p>
											</section>
										<?php endif; ?>
								</section> <!-- end entry-content -->

								<footer class="article-footer">
                                    <p class="eo-cc-license"><img src="<?php echo get_template_directory_uri(); ?>/library/images/by-nc-sa.png" alt="CC BY-NC-SA">Text of this page is licensed under <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">CC BY-NC-SA</a>, unless otherwise marked. Please attribute to English Online Inc. and link back to this page where possible. For images and videos, check the source for licensing information.</p>
									<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
										ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) );
									} ?>
									
									<!--find out why these prev and next links aren't working-->
									<div class="previous-next">
										<p><?php posts_nav_link('&#8734;','&laquo; Previous Article','Next Article &raquo;'); ?></p>
									</div>
									<div class="alignleft"><?php previous_posts_link( '&laquo; Previous Entries' ); ?></div>
									<div class="right"><?php next_posts_link( 'Next Entries &raquo;', '' ); ?></div>
								</footer>
							</article>

							<?php endwhile; ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">

											<p><?php _e( 'This is the error message in the single-article.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>
						
						<aside id="articles-menu" class="m-all t-1of4 d-1of4 fixed">
                            <?php include('sidebar-article.php'); ?>
						</aside>

				</div>

			</div>
<?php get_footer(); ?>