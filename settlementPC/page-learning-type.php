<?php
/*
 Template Name: Learning Type
 *
*/
?>
<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
	
									<header class="article-header">
	
										<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
	
									</header> <?php // end article header ?>
	
									<section class="entry-content cf" itemprop="articleBody">
                                    <?php if( get_field('learning_type_select') ): ?>
								
                                        <?php $learningtype = get_field('learning_type_select'); ?>
                                        <?php if( $learningtype == 'one-on-one'): ?>
                                            <div class="m-all">
                                                <?php
                                                    // the content (pretty self explanatory huh)
                                                    the_content();

                                                ?>
                                        <?php else: ?>
                                            <div class="m-all t-2of3 d-2of3">
                                                <?php
                                                    // the content (pretty self explanatory huh)
                                                    the_content();

                                                ?>
                                            </div>
                                        
                                        <aside class="m-all t-1of3 d-1of3 last-col standout-block">
                                            <?php if(!is_user_logged_in()) { ?> <!-- if user is NOT logged in -->
                                                
                                                <?php $args = array(
                                                // arguments for login form
                                                    'echo'           => true,
                                                    'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                                                    'form_id'        => 'loginform',
                                                    'label_username' => __( 'Username or Email' ),
                                                    'label_password' => __( 'Password' ),
                                                    //'label_remember' => __( 'Remember Me' ),
                                                    'label_log_in'   => __( 'Log In' ),
                                                    'id_username'    => 'user_login',
                                                    'id_password'    => 'user_pass',
                                                    //'id_remember'    => 'rememberme',
                                                    'id_submit'      => 'wp-submit',
                                                    'remember'       => false,
                                                    'value_username' => '',
                                                    'value_password' => '',
                                                    'value_remember' => true
                                                ); ?>

                                                <?php wp_login_form( $args ); ?>
                                                <a class="lostpass" href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" title="Lost Password">Lost Password?</a>

<p class="clear">Not yet registered? <a title="Register" href="/register/">Find out how to join.</a></p>

                                        <?php } else { ?> <!-- else if user is logged in -->

                                                <div>
                                                    <?php $current_user = wp_get_current_user(); ?>
                                                    <p class="h4 user-identify">
                                                        Hello, <?php echo $current_user->user_firstname; ?>!
                                                    </p>
                                                    <p><?php echo do_shortcode('[uo_learndash_resume]'); ?></p>
                                                    <p>Go to <a href="/profile">My Activities</a> to view all your ongoing or completed learning activities.</p>
                                                </div>

                                            <p class="welcome-logout">Not <?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?>?&nbsp;<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Learner Logout">Log out</a></p>
                                           <?php } ?>
                                        </aside><!-- end .t-1of2 -->
                                        <?php endif; ?>
                                                <?php endif; ?>
									</section> <?php // end article section ?>
	
									<footer class="article-footer cf">
	
									</footer>
	
	
								</article>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; wp_reset_query(); ?>


							<?php if( get_field('learning_type_select') ): ?>
								
								<?php $learningtype = get_field('learning_type_select'); ?>
                            
								<?php if( $learningtype == 'peer-to-peer'): ?>

										<h2 class="page-sub"><a href="<?php echo home_url(); ?>/forums">Discussion Forums</a></h2>
										<section class="upcoming forum-list">
											<?php if ( is_user_logged_in() ):
											    echo do_shortcode( '[bbp-forum-index]' );
											    wp_reset_query();
											else: ?>
											<p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to view the Discussion Forums. If you are not yet a registered learner, <a href="<?php echo home_url(); ?>/register">find out how to register</a>.</p>
											<?php endif; ?>
										</section><!--end .upcoming -->				
									
								<?php elseif( $learningtype == 'self-study'): ?>

										<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/english-exercises">English Exercises</a></h2>
										<section class="upcoming">
										<?php
										
										$args3 = array(
											'post_type' => 'sfwd-courses',
											'learning_options' => 'english-exercises',
											'posts_per_page' => 6,
											'orderby' => 'modified',
											'order' => 'DESC', 
										);
										$loop3 = new WP_Query($args3);
										
										while($loop3->have_posts()): $loop3->the_post(); ?>
											<div class="post-grid">
												<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
												<?php the_excerpt(); ?>
											</div>
											<?php
										endwhile;
										wp_reset_query();
										?>
                                            <p class="clear"><a href="<?php echo home_url(); ?>/learn/english-exercises">More about English Exercises&hellip;</a></p>
										</section><!--end .upcoming -->
										
										<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/canadian-idioms">Canadian Idioms</a></h2>
										<section class="upcoming">
										<?php
										
										$args8 = array(
											'post_type' => array('sfwd-courses','sfwd-lessons'),
											'learning_options' => 'canadian-idioms',
											'posts_per_page' => 6,
											'orderby' => 'modified',
											'order' => 'DESC', 
										);
										$loop8 = new WP_Query($args8);
										
										while($loop8->have_posts()): $loop8->the_post(); ?>
											<?php $parentcourse = get_post_meta( $post->ID, 'course_id', true ); ?>
											<div class="post-grid">
												<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php elseif ( has_post_thumbnail( $parentcourse ) ) : ?>
													<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $parentcourse,'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
												<?php if ( 'sfwd-lessons' == get_post_type() ){
													$text = get_field('idiom_intro');
														if ( '' != $text ) {
															echo custom_field_excerpt4(); 
														}
													else { echo custom_field_excerpt(); }
												} elseif ( 'sfwd-courses' == get_post_type() ){
													the_excerpt();
												} ?>
											</div>
											<?php
										endwhile;
										wp_reset_query();
										?>
                                            <p class="clear"><a href="<?php echo home_url(); ?>/learn/canadian-idioms">More about Canadian Idioms&hellip;</a></p>
										</section><!--end .upcoming -->
										
										<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/i-english-videos">iEnglish</a></h2>
										<section class="upcoming">
										<?php
										
										$args7 = array(
											'post_type' => array('sfwd-courses','sfwd-lessons'),
											'learning_options' => 'ienglish',
											'posts_per_page' => 6,
											'orderby' => 'menu_order',
											'order' => 'ASC', 
										);
										$loop7 = new WP_Query($args7);
										
										while($loop7->have_posts()): $loop7->the_post(); ?>
											<?php $parentcourse = get_post_meta( $post->ID, 'course_id', true ); ?>
											<div class="post-grid">
												<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php elseif ( has_post_thumbnail( $parentcourse ) ) : ?>
													<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $parentcourse,'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
												<?php if ( 'sfwd-lessons' == get_post_type() ){
														echo custom_field_excerpt(); 
												} elseif ( 'sfwd-courses' == get_post_type() ){
													   the_excerpt();
												} ?>
											</div>
											<?php
										endwhile;
										wp_reset_query();
										?>
                                            <p class="clear"><a href="<?php echo home_url(); ?>/learn/i-english-videos">More about iEnglish&hellip;</a></p>
										</section><!--end .upcoming -->
										

									
								<?php elseif( $learningtype == 'group-study'): ?>

										<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/multi-week-sessions">Multi-Week Workshops</a></h2>
										<section class="upcoming">
										<?php
										// Get the 'LearnDash Courses' post type
										$args4 = array(
											'post_type' => 'sfwd-courses',
											'learning_options' => 'multi-week-sessions',
											'include_children' => false,
											'posts_per_page' => 6,
											'orderby' => 'modified',
											'order' => 'DESC', 
										);
										$loop4 = new WP_Query($args4);
										
										while($loop4->have_posts()): $loop4->the_post(); ?>
                                            <div class="post-grid">
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
								                <?php the_excerpt(); ?>
                                            </div>
											<?php
										endwhile;
										wp_reset_query();
										?>
                                        <p class="clear"><a href="<?php echo home_url(); ?>/learn/multi-week-sessions">More about Multi-Week Workshops&hellip;</a></p>
										</section><!--end .upcoming -->
										
										<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/drop-in-classes">Drop-In Workshops</a></h2>
										<section class="upcoming">
											<?php
											// Get the 'LearnDash Courses' post type
											$args1 = array(
												'post_type' => 'sfwd-courses',
												'learning_options' => 'drop-in-classes',
												'include_children' => false,
												'posts_per_page' => 6,
												'orderby' => 'modified',
												'order' => 'DESC', 
											);
											$loop1 = new WP_Query($args1);
											
											while($loop1->have_posts()): $loop1->the_post(); ?>
												<div class="post-grid">
													<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
													<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
													<?php the_excerpt(); ?>
												</div>
												<?php
											endwhile;
											wp_reset_query();
											?>
                                            <p class="clear"><a href="<?php echo home_url(); ?>/learn/drop-in-classes">More about Drop-In Workshops&hellip;</a></p>
											</section><!--end .upcoming -->
										
										<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/coffee-chats">Virtual Coffee Chats</a></h2>
										<section class="upcoming">
											<?php
											
											$args2 = array(
												'post_type' => 'tribe_events',
												'tribe_events_cat' => 'coffee-chats',
												'posts_per_page' => 6,
												'orderby' => 'event_date',
												'order' => 'ASC'
											);
											$loop2 = new WP_Query($args2);
											
											while($loop2->have_posts()): $loop2->the_post(); ?>
												<div class="post-grid coffee-chat">
													<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?><br><small><?php echo tribe_get_start_date(); ?></small></a></h4>
													<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
													
													<?php the_excerpt(); ?>
												</div>
												<?php
											endwhile;
											wp_reset_query();
											?>
                                            <p class="clear"><a href="<?php echo home_url(); ?>/learn/coffee-chats">More about Virtual Coffee Chats&hellip;</a></p>
											</section><!--end .upcoming -->


								<?php endif; ?> <!--end if has certain terms-->
                                    <h2 class="page-sub">Activities Index</h2>
                                    <section class="upcoming">
                                        <p>For a full list of all learning options and activity titles, see our <a href="/activities-index">Activities Index page</a>.</p>
                                    </section>
							
							<?php endif; ?><!--end if has field learning_type_select-->

						</main>

				</div>

			</div>

<?php get_footer(); ?>
