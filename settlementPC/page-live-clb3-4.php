<?php
/*
 Template Name: CLB3-4 Articles
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

                                        <?php } else { ?> <!-- else if user is logged in -->

                                                <div>
                                                    <?php $current_user = wp_get_current_user(); ?>
                                                    <p class="h4 user-identify">
                                                        Hello, <?php echo $current_user->user_firstname; ?>!
                                                    </p>
                                                    <?php 
                                                    /**
                                                    * Get an array of User Favorites
                                                    * https://favoriteposts.com/
                                                    */
                                                    $favorites = get_user_favorites();
                                                    if ( isset($favorites) && !empty($favorites) ) :
                                                        
                                                        echo '<h4>My Articles</h4><ul>';
                                                        foreach ( $favorites as $favorite ) :
                                                            $favlink = get_the_permalink($favorite);
                                                            $favtitle = get_the_title($favorite); ?>
                                                            
                                                            <li><a href="<?php echo $favlink ?>"><?php echo $favtitle; ?></a></li>
                                                            <?php
                                                            // You'll have access to the post ID in this foreach loop, so you can use WP functions like get_the_title($favorite);
                                                        endforeach;
                                                        echo '</ul>';
                                                    else :
                                                    echo '<h4>My Articles</h4><p>There is nothing saved in your articles.</p><p>Click the “Add to My Articles” button in any individual article under our twelve immigration themes to save the article to your list.</p>';

                                                    endif; ?>
                                                </div>

                                            <p class="welcome-logout">Not <?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?>?&nbsp;<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Learner Logout">Log out</a></p>
                                           <?php } ?>
                                        </aside><!-- end .t-1of2 -->
									</section> <?php // end article section ?>

								</article>
								
								
								<h2 class="page-sub">Click on an article below</h2>
								<section class="upcoming">
									<?php
									
									$args8 = array(
										'post_type' => 'article',
										'posts_per_page' => 12,
										'orderby' => 'date',
										'order' => 'DESC',
                                        'language_level' => 'lower-intermediate-clb-3-4',
									);
									$loop8 = new WP_Query($args8);
									
									while($loop8->have_posts()): $loop8->the_post(); ?>
										<div class="post-grid">
											<h4><a href="<?php the_permalink(); ?>?clb-version=clb3-4"><?php if(get_field('title_simple')) { echo get_field('title_simple'); } else { the_title(); } ?></a></h4>
											<?php if (has_post_thumbnail()): ?>
												<a href="<?php the_permalink(); ?>?clb-version=clb3-4"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
											<?php else: ?>
												<a href="<?php the_permalink(); ?>?clb-version=clb3-4"><img src="<?php bloginfo("template_url"); ?>/library/images/live-thumbnail.jpg" alt="Article thumbnail fallback"></a>
											<?php endif; ?>
											<?php echo custom_field_excerpt2();  ?>
										</div>
										<?php
									endwhile;
									wp_reset_query();
									?>
                                    
                                    <?php echo do_shortcode('[ajax_load_more container_type="div" post_type="article" posts_per_page="12" taxonomy="language_level" taxonomy_terms="lower-intermediate-clb-3-4" taxonomy_operator="IN" offset="12" pause="true" scroll="false" transition_speed="500" destroy_after="2" button_label="Load More +" button_loading_label="Loading..."]'); ?>
								</section><!--end .upcoming -->
                            <h2 class="page-sub">Articles Index</h2>
                            <section class="upcoming">
                                <p>For a full list of all settlement topics and article titles, see our <a href="/articles-index">Articles Index page</a>.</p>
                            </section>
								

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

						</main>

				</div>

			</div>

<?php get_footer(); ?>
