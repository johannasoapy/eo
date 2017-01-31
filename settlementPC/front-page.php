<?php
/*
 Template Name: Front Page
 *
*/
?>

<?php get_header(); ?>

	<div id="content">
         <div class="hero">
                                <?php if(!is_user_logged_in()) { ?> <!-- if user is NOT logged in -->

                                    <div class="m-all t-1of2 d-1of2 cf">
                                        <div class="hero-inner cf">
                                            <h1>Your New Life Starts Here</h1>
                                            
                                            <p class="extra-margin">Live and Learn is your resource for reliable information and flexible learning options in Manitoba. We are a community of newcomers helping newcomers realize goals for a better life. Join us today!</p>
                                        </div>

                                        <div class="home-cta-btns">
                                            <a class="hero-btn register" href="<?php echo home_url(); ?>/register"><big>Register</big><br>Join the Community</a>
                                            <a class="hero-btn learn-more" href="<?php echo home_url(); ?>/explore-live-learn"><big>Learn More</big><br>Explore the site</a>
                                            
                                        </div>
                                    </div>
             
                                    <div class="m-all t-1of2 d-1of2 last-col cf">
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
                                    

                                    </div>
                            
                                <?php } else { ?> <!-- else if user is logged in -->
                                <div class="m-all t-1of3 d-1of3 cf hero-inner">
                                        <div>
                                            <?php $current_user = wp_get_current_user(); ?>
                                            <p class="h1 user-identify">
                                                Hello, <?php echo $current_user->user_firstname; ?>!
                                            </p>
                                            <nav>
                                                <ul>
                                                <li><a href="/profile">My Activities</a></li>
                                                <li><a href="/my-articles">My Articles</a></li>
                                                <li><a href="<?php echo bbp_get_user_profile_url( get_current_user_id() ); ?>subscriptions">My Discussions</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                            
                                    <p class="welcome-logout">Not <?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?>?&nbsp;<?php wp_loginout($_SERVER['REQUEST_URI'], true); ?>.</p>
                                    
                                </div><!-- end .t-1of3 -->
             
                                <div class="m-all t-2of3 d-2of3 last-col cf hero-inner">
                                    <p>View the most recent articles about settlement in Manitoba in the "Live" section. Explore learning activities at your own pace in the "Learn" section. Or, check out the online language and settlement workshops under "Events".</p>


                                    <div class="home-cta-btns">
                                        <a class="hero-btn live" href="<?php echo home_url(); ?>/live"><big>Live</big><br>Browse Articles</a>
                                        <a class="hero-btn learn" href="<?php echo home_url(); ?>/learn"><big>Learn</big><br>Explore Activities</a>
                                        <a class="hero-btn events" href="<?php echo home_url(); ?>/events"><big>Events</big><br>Group Learning</a>

                                    </div>
                                </div>
             
                                <?php } ?> <!-- end if user is logged in -->
                            </div> <!-- end .hero -->
        
		<main id="main" class="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<h2 class="page-sub special">Let's work together to ease your transition by&hellip;</h2>
			<section class="upcoming">
                
				<div class="wrap cf">
					<section class="clear">
						<div class="m-all t-all d-all">
							<h3 class="h2">Sharing Stories<br><small>Learn about newcomer experiences, or share your own</small></h3>
							<?php
									
									$args3 = array(
										'category_name' => 'learner-stories',
										'posts_per_page' => 2,
										'orderby' => 'date',
										'order' => 'DESC', 
									);
									$loop3 = new WP_Query($args3);
									
									while($loop3->have_posts()): $loop3->the_post(); ?>
										<div class="post-grid">
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/nataliapeijeaniwona-sm.jpg" alt="Share Stories thumbnail fallback"></a>
												<?php endif; ?>
											<?php the_excerpt(); ?>
											<p><strong><a href="<?php echo home_url(); ?>/category/learner-stories">More Newcomer Stories&hellip;</a></strong></p>
										</div>
										<?php
									endwhile;
									wp_reset_query();
									?>
                            <div class="post-grid">
                                <h4><a href="<?php echo home_url(); ?>/forums">Join the Conversation</a></h4>
                                <a href="<?php echo home_url(); ?>/forums"><img src="<?php bloginfo("template_url"); ?>/library/images/nataliapeijeaniwona-sm.jpg" alt="Share Stories thumbnail fallback"></a>
                                <p>Must be registered and logged in. Share your own thoughts and experiences with other learners in our discussion forums.</p>
                                <p><strong><a href="<?php echo home_url(); ?>/learn/peer-to-peer/">More about forums&hellip;</a></strong></p>
                            </div>
                            
					   </div>
                    </section>
			
					<section class="clear">
						<div class="m-all t-all d-all">
							<h3 class="h2">Sharing Expertise<br><small>Explore articles about settlement in Manitoba, Canada</small></h3>
						</div>
						<div class="m-all t-all d-all">
							
							<?php
									
									$args23 = array(
										'post_type' => 'article',
										'posts_per_page' => 3,
										'orderby' => 'date',
										'order' => 'DESC', 
									);
									$loop23 = new WP_Query($args23);
									
									while($loop23->have_posts()): $loop23->the_post(); ?>
										<div class="post-grid">
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/live-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
											<?php echo custom_field_excerpt2(); ?>
											<p><strong><a href="<?php echo home_url(); ?>/live">More Settlement Topics&hellip;</a></strong></p>
										</div>
										<?php
									endwhile;
									wp_reset_query();
									?>
                        </div>
                    </section>
                    <section class="clear">
                        <div class="m-all t-all d-all">
							<h3 class="h2">Sharing Resources<br><small>Complete self-directed activities about language and settlement</small></h3>
						</div>
						<div class="m-all t-all d-all">
							<?php
									
									$args3 = array(
										'post_type' => 'sfwd-courses',
										'learning_options' => 'english-exercises',
										'posts_per_page' => 1,
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
											<p><strong><a href="<?php echo home_url(); ?>/learn/english-exercises">More English Exercises&hellip;</a></strong></p>
										</div>
										<?php
									endwhile;
									wp_reset_query();
									?>
                            <?php
									
									$args3 = array(
										'post_type' => 'sfwd-courses',
										'learning_options' => 'ienglish',
										'posts_per_page' => 1,
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
											<p><strong><a href="<?php echo home_url(); ?>/learn/ienglish/">More iEnglish activities&hellip;</a></strong></p>
										</div>
										<?php
									endwhile;
									wp_reset_query();
									?>
							<?php
									
									$args13 = array(
										'post_type' => 'sfwd-courses',
										'learning_options' => 'canadian-idioms',
										'posts_per_page' => 1,
										'orderby' => 'modified',
										'order' => 'DESC', 
									);
									$loop13 = new WP_Query($args13);
									
									while($loop13->have_posts()): $loop13->the_post(); ?>
										<div class="post-grid">
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
											<?php the_excerpt(); ?>
											<p class="clear"><strong><a href="<?php echo home_url(); ?>/learn/canadian-idioms">More Canadian Idioms&hellip;</a></strong></p>
										</div>
										<?php
									endwhile;
									wp_reset_query();
									?>
						</div>
					</section>

					<section class="clear">
						<div class="m-all t-all d-all">
							<h3 class="h2">Sharing Learning<br><small>Participate in workshops and group activities</small></h3>
						</div>
						<div class="m-all t-all d-all">
								<?php
								$args4 = array(
									'post_type' => 'sfwd-courses',
									'learning_options' => 'multi-week-sessions',
									'include_children' => false,
									'posts_per_page' => 1,
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
									   <p class="clear"><strong><a href="<?php echo home_url(); ?>/learn/multi-week-sessions">More about Multi-week Sessions&hellip;</a></strong></p>
								</div>
									<?php
								endwhile;
								wp_reset_query();
								?>
								<!-- Drop-in Workshops -->
								<?php
								$args14 = array(
									'post_type' => 'sfwd-courses',
									'learning_options' => 'drop-in-classes',
									'include_children' => false,
									'posts_per_page' => 1,
									'orderby' => 'modified',
									'order' => 'DESC', 
								);
								$loop14 = new WP_Query($args14);
								
								while($loop14->have_posts()): $loop14->the_post(); ?>
								<div class="post-grid">
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
									   <?php the_excerpt(); ?>
									   <p class="clear"><strong><a href="<?php echo home_url(); ?>/learn/drop-in-classes">More about Drop-in Workshops&hellip;</a></strong></p>
								</div>
									<?php
								endwhile;
								wp_reset_query();
								?>
								<!-- Coffee Chats -->
								<?php
								
								$args2 = array(
									'post_type' => 'tribe_events',
									'tribe_events_cat' => 'coffee-chats',
									'posts_per_page' => 1,
									'orderby' => 'event_date',
									'order' => 'ASC'
								);
								$loop2 = new WP_Query($args2);
								
								while($loop2->have_posts()): $loop2->the_post(); ?>
									<div class="post-grid coffee-chat">
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?><br><span class="event-date"><?php echo tribe_get_start_date(); ?></span></a></h4>
										<?php if (has_post_thumbnail()): ?>
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
												<?php else: ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
												<?php endif; ?>
										<?php the_excerpt(); ?>
										<p class="clear"><strong><a href="<?php echo home_url(); ?>/learn/coffee-chats">More about Coffee Chats&hellip;</a></strong></p>
									</div>
									<?php
								endwhile;
								wp_reset_query();
								?>
						</div>
					</section>
				</div><!-- end #inner-content .wrap -->
			</section><!--end .upcoming -->
			
		
		</main>
	</div><!-- end #content -->


<?php get_footer(); ?>
