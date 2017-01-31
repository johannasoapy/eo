<?php
/*
 Template Name: Learning Options Child
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
                                        
									</section> <?php // end article section ?>

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
												<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; wp_reset_query(); ?>
								
                            <?php if( get_field('learning_option_select') ): ?>
								
                                <?php $learningoption = get_field('learning_option_select'); ?>
                            
								<?php if( $learningoption =='canadian-idioms'): ?>
                            
                                        <h2 class="page-sub">Idiom Sets</h2>
										<section class="upcoming">
										<?php
										// Get the 'LearnDash Activities' post type
										
										$args = array(
											'post_type' => 'sfwd-courses',
											'learning_options' => 'canadian-idioms',
											'include_children' => false,
                                            'posts_per_page' => 18,
											'orderby' => 'title',
											'order' => 'ASC', 
										);
										$loop = new WP_Query($args);
										
										while($loop->have_posts()): $loop->the_post(); ?>
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
										</section><!--end .upcoming -->
                            
                                        <h2 class="page-sub">Recently Added Idioms</h2>
										<section class="upcoming">
										<?php
										// Get the 'LearnDash Lessons' post type
										
										$args = array(
											'post_type' => 'sfwd-lessons',
											'learning_options' => 'canadian-idioms',
											'include_children' => false,
                                            'posts_per_page' => 12,
											'orderby' => 'date',
											'order' => 'DESC', 
										);
										$loop = new WP_Query($args);
										
										while($loop->have_posts()): $loop->the_post(); ?>
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
                                            <?php echo do_shortcode('[ajax_load_more container_type="div" post_type="post, sfwd-lessons" posts_per_page="12" taxonomy="learning_options" taxonomy_terms="canadian-idioms" taxonomy_operator="IN" offset="12" pause="true" scroll="false" transition_speed="500" destroy_after="6" button_label="Load more +" button_loading_label="Loading..."]'); ?>
										</section><!--end .upcoming -->
                            
								
								<?php elseif( $learningoption == 'multi-week-sessions'): ?>

                                            <h2 class="page-sub">Currently Running and Upcoming</h2>
                                            <section class="upcoming">
                                            <?php
                                            // Get the 'LearnDash Courses' post type
                                            
                                            // set variable with today's date to compare to final_workshop field
                                            $datehere = new DateTime("now", new DateTimeZone('America/Winnipeg'));
                                            $todayDate = $datehere->format('Ymd');
                                                
                                            $argsm = array(
                                                'post_type' => 'sfwd-courses',
                                                'tax_query' => array(
                                                    'relation' => 'OR',
                                                    array(
                                                        'taxonomy' => 'learning_options',
                                                        'field'    => 'slug',
                                                        'terms'    => 'multi-week-sessions',
                                                    ),
                                                
                                                
                                                ),
                                                'meta_key' => 'current',
                                                'meta_value' => 'yes',
                                                'posts_per_page' => 3,
                                                'orderby' => 'modified',
                                                'order' => 'DESC', 
                                            );
                                                                                   
                                                
                                            $loopm = new WP_Query($argsm);

                                            if($loopm->have_posts()): while($loopm->have_posts()): $loopm->the_post(); ?>
                                                <div class="post-grid">
                                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?><small><span class="workshopdates"> | <?php /*if(get_field('workshop_dates')) {
                                                        echo the_field('workshop_dates');
                                                        }*/
                                                        $firstDate = get_field('first_workshop');
                                                        $finalDate = get_field('final_workshop');
                                                        
                                                        $datehere = new DateTime("now", new DateTimeZone('America/Winnipeg'));
                                                        $todayDate = $datehere->format('Ymd');

                                                        if( $todayDate <= $finalDate ){
                                                            $finalDate = new DateTime($finalDate);
                                                            $firstDate = new DateTime($firstDate);
                                                            echo $firstDate->format('F j, Y') . ' - ' . $finalDate->format('F j, Y');

                                                        }; ?></span></small></a></h4>
                                                    
                                                    <?php if (has_post_thumbnail()): ?>
                                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
                                                    <?php else: ?>
                                                        <a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
                                                    <?php endif; ?>
                                                    <?php the_excerpt(); ?>
                                                </div>
                                                <?php
                                            endwhile;
                                            else :
                                                echo '<p>There are no Multi-Week Workshops currently scheduled. Check the Events Calendar to see what other group activities are scheduled, or see the Archives section below to view materials from past workshops.</p>';
                                            endif;
                                            wp_reset_query();
                                            ?>
                                               
                                            </section><!--end .upcoming -->
                            
                                        <h2 class="page-sub">Materials for Archived Multi-Week Workshops</h2>
                                        <section class="upcoming">
										<?php
										// Get the 'LearnDash Courses' post type
										$argsma = array(
											'post_type' => 'sfwd-courses',
											'tax_query' => array(
                                                'relation' => 'OR',
                                                array(
                                                    'taxonomy' => 'learning_options',
                                                    'field'    => 'slug',
                                                    'terms'    => 'multi-week-sessions',
                                                ),
                                            ),
											'meta_key' => 'current',
                                            'meta_value' => array('no',''),
                                            'posts_per_page' => 12,
											'orderby' => 'modified',
											'order' => 'DESC', 
										);
										$loopma = new WP_Query($argsma);
										
										while($loopma->have_posts()): $loopma->the_post(); ?>
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
										</section><!--end .upcoming -->
									
								<?php elseif( $learningoption == 'coffee-chats'): ?>

										<h2 class="page-sub">Upcoming Coffee Chats</h2>
										
										<section class="upcoming">
											<ul>

												<?php
												
												$args3 = array(
													'post_type' => 'tribe_events',
													'tribe_events_cat' => 'coffee-chats',
                                                    'posts_per_page' => 12,
													'orderby' => 'event_date',
													'order' => 'ASC'
												);
												$loop3 = new WP_Query($args3);
												
												while($loop3->have_posts()): $loop3->the_post(); ?>

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
											</ul>
										</section><!--end .upcoming -->
									
								<?php elseif( $learningoption == 'drop-in-classes'): ?>
                            
                                        <h2 class="page-sub">Upcoming Workshops</h2>
										<section class="upcoming">
											<?php
                                            $datehere = new DateTime("now", new DateTimeZone('America/Winnipeg'));
                                            $todayDate = $datehere->format('Y-m-d');

											$args4 = array(
												'post_type' => 'sfwd-lessons',
												'learning_options' => 'drop-in-classes',
                                                'meta_query'	=> array(
                                                    'relation'		=> 'OR',
                                                    array(
                                                        'key'		=> 'workshop_current',
                                                        'compare'	=> '>=',
                                                        'value'		=> $todayDate,
                                                    ),
                                                ),
                                                'posts_per_page' => 12,
												'orderby' => 'meta_value',
												'order' => 'ASC', 
											);
											$loop4 = new WP_Query($args4);
											
											while($loop4->have_posts()): $loop4->the_post(); ?>
                                                <?php $current = get_metadata('post', $id, 'workshop_current', true );
                                                $workshopDate = new DateTime($current); ?>
                                            <?php $parentcourse = get_post_meta( $post->ID, 'course_id', true ); ?>
												<div class="post-grid">
													<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?><small> | <?php echo $workshopDate->format('F j, Y'); ?></small></a></h4>
													<?php if (has_post_thumbnail()): ?>
                                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
                                                    <?php elseif ( has_post_thumbnail( $parentcourse ) ) : ?>
                                                        <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $parentcourse,'bones-thumb-600' ); ?></a>
                                                    <?php else: ?>
                                                        <a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Article thumbnail fallback"></a>
                                                    <?php endif; ?>
													<?php echo custom_field_excerpt(); ?>
												</div>
												<?php
											endwhile;
											wp_reset_query();
											?>
										</section>
                            
										<h2 class="page-sub">Archived Workshops by Theme</h2>
										<section class="upcoming">
											<?php

											$args4 = array(
												'post_type' => 'sfwd-courses',
												'learning_options' => 'drop-in-classes',
												'include_children' => false,
                                                'posts_per_page' => 12,
												'orderby' => 'name',
												'order' => 'ASC', 
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
										</section>
										<h2 class="page-sub">Individual Archived Workshops</h2>
										<section class="upcoming">
											
											<?php
											$args6 = array(
												'post_type' => 'sfwd-lessons',
												'learning_options' => 'drop-in-classes',
												'include_children' => false,
                                                'posts_per_page' => 12,
												'orderby' => 'modified',
												'order' => 'DESC', 
											);
											$loop6 = new WP_Query($args6);
											
											while($loop6->have_posts()): $loop6->the_post(); ?>
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
													<?php echo custom_field_excerpt(); ?>
												</div>
												<?php
											endwhile;
											wp_reset_query();
											?>
                                            <?php echo do_shortcode('[ajax_load_more container_type="div" post_type="post, sfwd-lessons" posts_per_page="12" taxonomy="learning_options" taxonomy_terms="drop-in-classes" taxonomy_operator="IN" offset="12" pause="true" scroll="false" transition_speed="500" button_label="Load more +" button_loading_label="Loading..."]'); ?>
										</section>

								<?php elseif( $learningoption == 'english-exercises'): ?>
                                    <h2 class="page-sub">English Exercises by Level</h2>
										<section class="upcoming">
										<?php
										// Get the 'LearnDash Courses' post type
										$args5 = array(
											'post_type' => 'sfwd-courses',
											'learning_options' => 'english-exercises',
											'include_children' => false,
                                            'posts_per_page' => 6,
											'orderby' => 'modified',
											'order' => 'DESC', 
										);
										$loop5 = new WP_Query($args5);
										
										while($loop5->have_posts()): $loop5->the_post(); ?>
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
										</section><!--end .upcoming -->
                            
								

										<h2 class="page-sub">Individual English Exercises</h2>
										<section class="upcoming">
										<?php
										// Get the 'LearnDash Courses' post type
										$args15 = array(
											'post_type' => 'sfwd-lessons',
											'learning_options' => 'english-exercises',
                                            'posts_per_page' => 18,
											'orderby' => 'modified',
											'order' => 'DESC', 
										);
										$loop15 = new WP_Query($args15);
										
										while($loop15->have_posts()): $loop15->the_post(); ?>
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
													<?php
														if(custom_field_excerpt()){
															echo custom_field_excerpt(); 
														} else {
															the_excerpt();
														}
															
													?>
											</div>
											<?php
										endwhile;
										wp_reset_query();
										?>
										</section><!--end .upcoming -->
                            <?php elseif( $learningoption == 'ienglish'): ?>

                                <h2 class="page-sub">iEnglish Modules</h2>
										<section class="upcoming">
										<?php
										// Get the 'LearnDash Courses' post type
										$args15 = array(
											'post_type' => array('sfwd-lessons'),
											'learning_options' => $learningoption,
                                            'posts_per_page' => 12,
											'orderby' => 'menu_order',
											'order' => 'ASC', 
										);
										$loop15 = new WP_Query($args15);
										
										while($loop15->have_posts()): $loop15->the_post(); ?>
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
													
												<?php if(custom_field_excerpt()){
														echo custom_field_excerpt(); 
													} else {
														the_excerpt();
													} ?>
                                                    
											</div>
											<?php
										endwhile;
										wp_reset_query();
										?>
										</section><!--end .upcoming -->
                            
                                        
                            
								<?php endif; ?> <!--end if has certain terms-->
                            <h2 class="page-sub">Activities Index</h2>
                                        <section class="upcoming">
                                            <p>For a full list of all learning options and activity titles, see our <a href="/activities-index">Activities Index page</a>.</p>
                                        </section>
                            <?php endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
