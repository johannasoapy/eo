<?php
/*
 * LearnDash Lessons TEMPLATE
 *
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
										printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> by <span class="author">%3$s</span>', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) ) );
									?></p>
									<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
										ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) );
									} ?>

								</header>

								<section class="entry-content cf">
									<!-- featured image and attribution -->
										<!-- Check if post is workshop or drop-in (not a canadian idiom or english exercise or iEnglish) -->
										<?php if( has_term( 'multi-week-sessions', 'learning_options' ) || has_term( 'drop-in-classes', 'learning_options' ) ): ?>
											<?php if (has_post_thumbnail()): ?>
											<div class="wp-caption">
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
										<?php endif; ?>
											
									<?php if( get_field('workshop_intro') ): ?>
										<section class="article-section cf" itemprop="workshopIntro">
											<?php esc_html(the_field('workshop_intro')); ?>
										</section>
									<?php endif; ?>
									
									<!--Check if post is either a Multi-week session or a Drop-in Class, and if so calls the workshop fields-->
									<?php if( has_term( 'multi-week-sessions', 'learning_options' ) || has_term( 'drop-in-classes', 'learning_options' ) ): ?>
										
										<?php if( get_field('learning_goals_topics') ): ?>
											
											<section class="article-section cf" itemprop="workshopGoals">
												<h2>Workshop Goals</h2>
												<div class="m-all t-1of2 d1of2">
													<h3>Learning Goals</h3>
													<ul>
													<?php while( has_sub_field('learning_goals_topics') ): ?>
			
														
														    <li><?php esc_html(the_sub_field('learning_goal_topic')); ?></li>
														
												
													<?php endwhile; ?>
													</ul>
												</div>
												<?php if( ! get_field('learning_goals_language') ): ?>
													</section>
											<?php endif; ?>
										<?php endif; ?>
										
										<?php if( get_field('learning_goals_language') ): ?>
											<?php if( ! get_field('learning_goals_topics') ): ?>
												<section class="article-section cf" itemprop="workshopGoals">
													<div class="m-all t-1of2 d1of2">
											<?php else: ?>
												<div class="m-all t-1of2 d1of2 last-col">
											<?php endif; ?>

													<h3>Language Goals</h3>
													<ul>
													<?php while( has_sub_field('learning_goals_language') ): ?>
			
														
														    <li><?php esc_html(the_sub_field('learning_goal_language')); ?></li>
														
												
													<?php endwhile; ?>
													</ul>
												</div>
											</section>
										<?php endif; ?>
										
										<?php if( get_field('workshop_handouts') ): ?>
											
											<section class="article-section handouts clear cf" itemprop="workshopHandouts">
												<h2>Files for Download</h2>
												<?php while( has_sub_field('workshop_handouts') ): ?>
													<a class="blue-btn" href="<?php esc_url(the_sub_field('workshop_handout')); ?>" target="_blank" ><?php esc_html(the_sub_field('workshop_handout_title')); ?></a>
											
												<?php endwhile; ?>
											</section>
										<?php endif; ?>
                                                    
<!---------------------------------Synchronous session--------------------------------------------------->
                                                    
										<?php if( get_field('workshop_synchronous') ): ?>
											<section class="article-section cf" itemprop="workshopSynchronous">
												<h2>Join the Live Workshop</h2>
                                                
                                               <?php $postsr = get_field('workshop_synchronous'); ?>
                                                <?php 
                                                $eventDateNewest = '0000-00-00';
                                                foreach( $postsr as $post): // variable must be called $post (IMPORTANT) ?>
                                                        <?php setup_postdata($post); ?>
                                                        
                                                        <h3><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h3>
                                                        <?php echo tribe_get_start_date(); ?>
                                                
                                                <?php 
                                                $eventDate = tribe_get_start_date( null, false, 'Y-m-d' );
                                                
                                                if($eventDateNewest < $eventDate){
                                                    $eventDateNewest = $eventDate;
                                                }

                                            // from http://stackoverflow.com/questions/8006692/get-current-date-given-a-timezone-in-php
                                            $datehere = new DateTime("now", new DateTimeZone('America/Winnipeg'));
                                            $todayDate = $datehere->format('Y-m-d');
                                            if( $todayDate > $eventDate ): //only shows 'Join' on day of event ?>
                                                        
                                                <p>This event has passed. <a href="<?php echo home_url(); ?>/events/category/drop-in-workshops/">Click here</a> to see other upcoming drop-in workshops.</p>
                                                
                                            <?php else : ?>
                                                <p>Click the title above to go to the event page.</p>
                                            <?php endif; ?>
                                                        
                                                    <?php endforeach; ?>
												
												<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                            </section>
                                                    <?php
                                                        $id = get_the_ID();
                                                        if ( ! add_post_meta( $id, 'workshop_current', $eventDateNewest, true ) ) { 
                                                           update_post_meta( $id, 'workshop_current', $eventDateNewest );
                                                        }
                                                    ?>
										<?php endif; ?>
                                                    
<!------------------------------end Synchronous session--------------------------------------------------->     
                                                    
                                                    
										<?php if( get_field('workshop_asynchronous') ): ?>
											<section class="article-section cf" itemprop="workshopAsynchronous">
												<h2>View Workshop Presentation Slides</h2>
												<div><?php esc_attr(the_field('workshop_asynchronous')); ?></div>
											</section>
										<?php endif; ?>
										
										
										<?php if( get_field('workshop_videos') ): ?>
											
											<section class="article-section cf" itemprop="workshopVideos">
												<h2>Videos</h2>
												<?php while( has_sub_field('workshop_videos') ): ?>
		
													<div>
													    <?php esc_attr(the_sub_field('workshop_video')); ?>
													</div>
											
												<?php endwhile; ?>
											</section>
										<?php endif; ?>
										
										<?php if( get_field('workshop_inline_quiz') ): ?>
											<section class="article-section cf" itemprop="workshopQuiz">
												<h2>Test Your Learning</h2>
												<div><?php the_field('workshop_inline_quiz'); ?></div>
											</section>
										<?php endif; ?>
										
										<?php if( get_field('workshop_community_resources') ): ?>
											
											<section class="article-section cf" itemprop="workshopResources">
												<h2>Community Resources</h2>
												<ul>
												<?php while( has_sub_field('workshop_community_resources') ): ?>
		
													
													    <li><a href="<?php esc_url(the_sub_field('workshop_community_resource')); ?>" target="_blank"><?php esc_html(the_sub_field('workshop_resource_title')); ?></a><?php if( get_sub_field('workshop_resource_description') ): ?>&ndash;<?php esc_html(the_sub_field('workshop_resource_description')); ?><?php endif; ?></li>
													
											
												<?php endwhile; ?>
												</ul>
											</section>
										<?php endif; ?>

									<!-- Check if post is Canadian Idiom; if it is, get idiom fields -->
									<?php elseif( has_term( 'canadian-idioms', 'learning_options' ) ): ?>


										<?php
											$intro = get_field('idiom_intro');
											if( !empty($intro) ): ?>
											<section class="article-section cf" itemprop="workshopResources">
												<h2>Step 1</h2>
												<?php echo $intro; ?>
											</section>
											<?php endif; ?>
										
										<?php 
											$image = get_field('idiom_infographic');
											if( !empty($image) ): ?>
											<section class="article-section cf" itemprop="workshopResources">
												<img class="idiom-img" src="<?php echo esc_attr($image['url']); ?>" alt="<?php echo esc_html($image['alt']); ?>" />
											</section>
											<?php endif; ?>
											
										<?php
											$activities = get_field('idiom_activities');
											if( !empty($activities) ): ?>
											<section class="article-section cf" itemprop="workshopResources">
												<h2>Step 2</h2>
												<?php echo $activities; ?>
											</section>
											<?php endif; ?>
											
										<?php
											$extra= get_field('idiom_extra');
											if( !empty($extra) ): ?>
											<section class="article-section cf" itemprop="workshopResources">
												<h2>Step 3</h2>
												<?php echo $extra; ?>
											</section>
											<?php endif; ?>
											
										<?php
											$quiz = get_field('workshop_inline_quiz');
											if( !empty($quiz) ): ?>
											<section class="article-section cf" itemprop="workshopResources">
												<h2>Quiz</h2>
												<?php echo $quiz; ?>
											</section>
											<?php endif; ?>
									<!-- Check other post terms -->		
									<?php elseif( has_term( 'english-exercises', 'learning_options' ) ): ?>

										<?php if( get_field('workshop_videos') ): ?>
											
											<section class="article-section cf" itemprop="workshopVideos">
												
												<?php while( has_sub_field('workshop_videos') ): ?>
		
													<div>
													    <?php esc_attr(the_sub_field('workshop_video')); ?>
													</div>
											
												<?php endwhile; ?>
											</section>
										<?php endif; ?>
										
										<?php if( get_field('workshop_handouts') ): ?>
											
											<section class="article-section handouts clear cf" itemprop="workshopHandouts">
												<h2>Files for Download</h2>
												<?php while( has_sub_field('workshop_handouts') ): ?>
													<div class="blue-btn"><a href="<?php esc_url(the_sub_field('workshop_handout')); ?>" target="_blank" ><?php esc_html(the_sub_field('workshop_handout_title')); ?></a></div>
											
												<?php endwhile; ?>
											</section>
										<?php endif; ?>
										
										<?php if( get_field('workshop_inline_quiz') ): ?>
											<section class="article-section cf" itemprop="workshopQuiz">
												<h2>Test Your Learning</h2>
												<div><?php esc_attr(the_field('workshop_inline_quiz')); ?></div>
											</section>
										<?php endif; ?>
									
									
									<?php elseif( has_term( 'ienglish', 'learning_options' ) ): ?>

										<?php if( get_field('workshop_videos') ): ?>
											
											<section class="article-section cf" itemprop="workshopVideos">
												<h2>Video</h2>
												<?php while( has_sub_field('workshop_videos') ): ?>
		
													<div>
													    <?php esc_attr(the_sub_field('workshop_video')); ?>
													</div>
											
												<?php endwhile; ?>
											</section>
										<?php endif; ?>
										
										<?php if( get_field('workshop_handouts') ): ?>
											
											<section class="article-section handouts clear cf" itemprop="workshopHandouts">
												<h2>Files for Download</h2>
												<?php while( has_sub_field('workshop_handouts') ): ?>
													<div class="blue-btn"><a href="<?php esc_url(the_sub_field('workshop_handout')); ?>" target="_blank" ><?php esc_html(the_sub_field('workshop_handout_title')); ?></a></div>
											
												<?php endwhile; ?>
											</section>
										<?php endif; ?>
										
										<?php if( get_field('workshop_inline_quiz') ): ?>
											<section class="article-section cf" itemprop="workshopQuiz">
												<h2>Test Your Learning</h2>
												<div><?php esc_attr(the_field('workshop_inline_quiz')); ?></div>
											</section>
										<?php endif; ?>
										
										<?php endif; ?>
									<!--end checking post terms -->
									
									<?php $postsr = get_field('workshop_learning_resource');
											
											if( $postsr ): ?>
												<section class="article-section cf" itemprop="workshopResources">
												<h2>Useful Links</h2>
												<h3>Within this site&hellip;</h3>
												<ul>
												<?php foreach( $postsr as $post): // variable must be called $post (IMPORTANT) ?>
												    <?php setup_postdata($post); ?>
												    <li>
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												    </li>
												<?php endforeach; ?>
												</ul>
												<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
												<?php if( ! get_field('workshop_learning_resource') ): ?>
													</section>  <!--end section if there are no external links-->
												<?php endif; ?>
											<?php endif; ?>
				    
										<?php if( get_field('workshop_learning_resources_external') ): ?>
															    
											
											<?php if( ! get_field('workshop_learning_resource') ): ?>
												<section class="article-section cf" itemprop="workshopResources"><!--start section if there are no internal links-->
												<h2>Useful Links</h2>
											<?php endif; ?>
											<h3>External Links&hellip;</h3>
											<ul>
											<?php while( has_sub_field('workshop_learning_resources_external') ): ?>
						    
												<?php if( get_sub_field('workshop_learning_resource_external') ): ?>
													<li><a href="<?php esc_url(the_sub_field('workshop_learning_resource_external')); ?>" target="_blank"><?php esc_html(the_sub_field('workshop_external_resource_title')); ?></a>
												<?php endif; ?>
															    
											<?php endwhile; ?>
											</ul>
										</section>
										<?php endif; ?>
														    
										<?php if( get_field('workshop_forum') ): ?>
											<section class="article-section cf" itemprop="workshopForum">
												<h2>Join the Discussion</h2>
                                                <?php if ( is_user_logged_in() ): ?>
												    <?php esc_attr(the_field('workshop_forum')); ?>
                                                <?php else : ?>
                                                    <p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to view the Discussion Forums. If you are not yet a registered learner, <a href="<?php echo home_url(); ?>/register">find out how to register</a>.</p>
                                                <?php endif; ?>
											</section>
										<?php endif; ?>
									
									<section class="article-section cf" itemprop="workshopContent">

									<!-- get content -->
									<?php the_content(); ?>
                                        <?php if ( !is_user_logged_in() ): ?>
                                            <p>To "Mark Complete" you must <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> and complete all the lesson topics.</p>
                                        <?php else : ?>
                                            <p>To "Mark Complete" you must complete all the lesson topics.</p>
                                        <?php endif; ?>
									</section><!-- end article-section workshopContent -->
									<!--Contact information for selected efacilitators -->
									<?php
										$facilitator = get_field('efacilitator');
										if( $facilitator ): ?>
										<section class="article-section e-facilitator cf" itemprop="workshopContact">
											
											<?php echo '<h2>e-Facilitator</h2>'; ?>
											<?php if ( is_user_logged_in() ):
											foreach($facilitator as $facilitate) { ?>
												
												<div class="m-all t-all d-all">
													
													<div class="profile-avatar">
														<?php echo $facilitate['user_avatar']; ?>
													</div>
													
													<div class="profile-details">
														<?php echo '<strong>Name: </strong>' . esc_html($facilitate['user_firstname']) . ' ' . esc_html($facilitate['user_lastname']) . '<br><strong>Email:</strong> <a href="mailto:' . antispambot($facilitate['user_email']) . '">' . antispambot($facilitate['user_email']) . '</a>'; ?>
														<?php echo '<p>' . esc_html($facilitate['user_description']) . '</p>' ;?>
													</div>
													
												</div>
												
												
											<?php }
											endif; // end if is_user_logged_in
											
											if ( ! is_user_logged_in() ): ?>
												<p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to view e-facilitator contact information.</p>
											<?php endif; ?>
											
										</section><!-- end article-section .e-facilitator -->
										<?php endif; ?><!--  end if $facilitator  -->
									
								
									
							</section> <!-- end entry-content -->

							<footer class="article-footer">
                                <p class="eo-cc-license"><img src="<?php echo get_template_directory_uri(); ?>/library/images/by-nc-sa.png" alt="CC BY-NC-SA">Text of this page is licensed under <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">CC BY-NC-SA</a>, unless otherwise marked. Please attribute to English Online Inc. and link back to this page where possible. For images and videos, check the source for licensing information.</p>
								<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
											ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) );
										} ?>

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
										<p><?php _e( 'This is the error message in the single-sfwd-lesson.php template.', 'bonestheme' ); ?></p>
									</footer>
								</article>

						<?php endif; ?>

					</main>
					<aside class="m-all t-1of4 d-1of4">
						<?php include('sidebar-lessons.php'); ?>
					</aside>
				</div>

			</div>

<?php get_footer(); ?>