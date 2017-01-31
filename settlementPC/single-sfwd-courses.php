<?php
/*
 * LearnDash Courses TEMPLATE
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
                                    <section class="article-section cf" itemprop="workshopDescription">
                                        
                                        <?php 
                                        
                                        $current = get_field('current');
                                        if( $current == 'yes' && get_field('first_workshop') && get_field('final_workshop') ){
                                            
                                            $firstDate = get_field('first_workshop');
                                            $finalDate = get_field('final_workshop');
                                            $finalDate = new DateTime($finalDate);
                                            $firstDate = new DateTime($firstDate);
    
                                            echo '<p>This workshop runs weekly from <strong>' . $firstDate->format('F j, Y') . '</strong> to <strong>' . $finalDate->format('F j, Y') . '</strong>.</p>';
                                        }; ?>
                                                                    
                                        <!-- get content -->
                                        <?php the_content(); ?>
                                        
                                    </section>
									
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
											<p><?php _e( 'This is the error message in the single-courses.php template.', 'bonestheme' ); ?></p>
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