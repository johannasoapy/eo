<?php
/*
 Template Name: Learn
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
                                            
                                            <p class="clear">Not yet registered? <a title="Register" href="/register/">Join us!</a></p>
                                            <p class="clear">Our learning activities are open to all visitors to the website. However, you can take advantage of extra features (live workshops, forums, eVolunteers, eFacilitators, tracking your progress), by registering with us and logging in.</p>

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
									</section> <?php // end article section ?>
	
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
								
							
							
							<!--Self Study-->	
							<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/self-study">Self Study</a></h2>
							<section class="upcoming">
								<?php
								
								$args3 = array(
									'post_type' => 'sfwd-courses',
									'learning_options' => 'english-exercises',
									'posts_per_page' => 2,
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
                                <?php
								
								$args13 = array(
									'post_type' => 'sfwd-courses',
									'learning_options' => 'canadian-idioms',
									'posts_per_page' => 3,
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
									</div>
									<?php
								endwhile;
								wp_reset_query();
								?>
                                <?php
								
								$args23 = array(
									'post_type' => 'sfwd-courses',
									'learning_options' => 'ienglish',
									'posts_per_page' => 1,
									'orderby' => 'modified',
									'order' => 'DESC', 
								);
								$loop23 = new WP_Query($args23);
								
								while($loop23->have_posts()): $loop23->the_post(); ?>
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
                                <p class="clear"><a href="<?php echo home_url(); ?>/learn/self-study">More about Self Study options&hellip;</a></p>
							</section><!--end .upcoming -->
								

								
							<!-- Group Study -->

							<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/group-study">Group Study</a></h2>
							<section class="upcoming">
								<?php
								// Get the 'LearnDash Courses' post type
								$args4 = array(
									'post_type' => 'sfwd-courses',
									'learning_options' => 'multi-week-sessions',
									'include_children' => false,
									'posts_per_page' => 2,
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
								
								<?php
								// Get the 'LearnDash Courses' post type
								$args41 = array(
									'post_type' => 'sfwd-courses',
									'learning_options' => 'drop-in-classes',
									'include_children' => false,
									'posts_per_page' => 2,
									'orderby' => 'modified',
									'order' => 'DESC', 
								);
								$loop41 = new WP_Query($args41);
								
								while($loop41->have_posts()): $loop41->the_post(); ?>
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
								<!-- Coffee Chats -->
								<?php
								
								$args2 = array(
									'post_type' => 'tribe_events',
									'tribe_events_cat' => 'coffee-chats',
									'posts_per_page' => 2,
									'orderby' => 'event_date',
									'order' => 'ASC'
								);
								$loop2 = new WP_Query($args2);
								
								while($loop2->have_posts()): $loop2->the_post(); ?>
									<div class="post-grid coffee-chat">
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?><br><small style="white-space: nowrap;">&nbsp;<?php echo tribe_get_start_date(); ?></small></a></h4>
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
                                <p class="clear"><a href="<?php echo home_url(); ?>/learn/group-study">More about Group Study options&hellip;</a></p>
							</section><!--end .upcoming -->
							
							<!-- One-on-One -->
							<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/one-on-one">One-on-One</a></h2>
							<section class="upcoming">
								<div class="post-grid">
									<h4><a href="<?php echo home_url(); ?>/learn/one-on-one">LINC Home Study</a></h4>
									<a href="<?php echo home_url(); ?>/learn/one-on-one"><img src="<?php home_url(); ?>/wp-content/uploads/2015/05/laptop-900-600x200.jpg" alt="LINC HS image"></a>
									<p>LINC Home Study (LHS) is a language training program available to ESL learners who cannot attend a face-to-face class in Manitoba.</p>
								</div>
								<div class="post-grid">
									<h4><a href="<?php echo home_url(); ?>/learn/one-on-one/#etutor">EAL e-Tutors</a></h4>
                                    <a href="<?php echo home_url(); ?>/learn/one-on-one/#etutor"><img src="<?php bloginfo("template_url"); ?>/library/images/etutor.jpg" alt="Get English help from an e-tutor"></a>
									<p>EAL e-Tutors (qualified language instructors) will help you improve your English skills: reading, writing, listening, speaking.</p>
								</div>
								<div class="post-grid">
									<h4><a href="<?php echo home_url(); ?>/learn/one-on-one/#ementor">Career e-Mentors</a></h4>
									<a href="<?php echo home_url(); ?>/learn/one-on-one/#ementor"><img src="<?php bloginfo("template_url"); ?>/library/images/ementor.jpg" alt="Get career help with an e-mentor"></a>
									<p>Career e-Mentors (established professionals and tradespeople) will answer your questions about your field and help you on your career path.</p>
								</div>
								<div class="post-grid">
									<h4><a href="<?php echo home_url(); ?>/learn/one-on-one/#evolunteer">Settlement e-Volunteers</a></h4>
                                    <a href="<?php echo home_url(); ?>/learn/one-on-one/#evolunteer"><img src="<?php home_url(); ?>/wp-content/uploads/2015/03/settlement-volunteers-600x200.jpg" alt="Hands holding a map - settlement help with an e-volunteer"></a>
									<p>Settlement e-Volunteers (friendly Manitobans) provide hands-on assistance and practical information to pre-arrivals, newcomers and recent immigrants.</p>
								</div>
                                <p class="clear"><a href="<?php echo home_url(); ?>/learn/one-on-one">More about One-on-One options&hellip;</a></p>
							</section><!--end .upcoming -->
							
							<!--peer-to-peer-->
							<h2 class="page-sub"><a href="<?php echo home_url(); ?>/learn/peer-to-peer">Peer-to-Peer</a></h2>
							<section class="upcoming forum-list">
								<?php if ( is_user_logged_in() ):
								    echo do_shortcode( '[bbp-forum-index]' );
								    wp_reset_query();
								else: ?>
								<p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to view the Discussion Forums. If you are not yet a registered learner, <a href="<?php echo home_url(); ?>/register">find out how to register</a>.</p>
								<?php endif; ?>
                                <p class="clear"><a href="<?php echo home_url(); ?>/learn/peer-to-peer">More about Peer-to-Peer options&hellip;</a></p>
							</section><!--end .upcoming -->
                            <h2 class="page-sub">Activities Index</h2>
                            <section class="upcoming">
                                <p>For a full list of all learning options and activity titles, see our <a href="/activities-index">Activities Index page</a>.</p>
                            </section>
						</main>
				</div>
			</div>
<?php get_footer(); ?>