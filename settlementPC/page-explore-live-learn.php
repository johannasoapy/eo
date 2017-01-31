<?php
/*
 Template Name: Explore
 *
*/
?>

<?php get_header(); ?>

	<div id="content">
        <div id="inner-content" class="wrap cf">
		<main id="main" class="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
	
									<header class="article-header">
	
										<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
	
									</header> <?php // end article header ?>

            
                                    <section class="entry-content cf" itemprop="articleBody">
                                        <div class="m-all t-2of3 d-2of3 cf">
									       <?php the_content(); ?>
                                        </div>
                                        <div class="m-all t-1of3 d-1of3 last-col cf">
									       <?php

                                            $post_object = get_field('section_one_pullin');

                                            if( $post_object ): 

                                                // override $post
                                                $post = $post_object;
                                                setup_postdata( $post ); 

                                                ?>
                                                    <div class="post-grid">
                                                        <h4><a href="<?php the_permalink(); ?>">Read about one of our learner's experiences</a></h4>
                                                        <?php if (has_post_thumbnail()): ?>
                                                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
                                                            <?php else: ?>
                                                                <a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/live-thumbnail.jpg" alt="Article thumbnail fallback"></a>
                                                            <?php endif; ?>
                                                        <p><?php the_title(); ?>&ndash; how English Online services helped them settle into their new life in Manitoba <a href="<?php the_permalink(); ?>">Read more...</a></p>
                                                    </div>
                                                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                            <?php endif; ?>
                                        </div>
                                        
                                    </section>

                                    <section class="entry-content cf" itemprop="articleBody">
                                        <?php if( get_field('page_section_two') ): ?>
                                            <div class="m-all t-2of3 d-2of3 cf">
                                                <?php the_field('page_section_two'); ?>
                                            </div>
                                            <div class="m-all t-1of3 d-1of3 last-col cf">
                                               <?php

                                                $post_object2 = get_field('section_two_pullin');

                                                if( $post_object2 ): 

                                                    // override $post
                                                    $post = $post_object2;
                                                    setup_postdata( $post ); 

                                                    ?>
                                                        <div class="post-grid">
                                                            <h4><a href="<?php the_permalink(); ?>">View an example of a Settlement Article</a></h4>
                                                            <?php if (has_post_thumbnail()): ?>
                                                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
                                                                <?php else: ?>
                                                                    <a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/live-thumbnail.jpg" alt="Article thumbnail fallback"></a>
                                                                <?php endif; ?>
                                                            <?php echo the_title() . ': ' . custom_field_excerpt2(); ?>
                                                        </div>
                                                    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                                <?php endif; ?>
                                            </div>
                                        
                                        <?php endif; ?>
								    </section>
                                
                                    <section class="entry-content cf" itemprop="articleBody">
                                        <?php if( get_field('page_section_three') ): ?>
                                        <div class="m-all t-2of3 d-2of3 cf">
                                            <?php the_field('page_section_three'); ?>
                                        </div>
                                        <div class="m-all t-1of3 d-1of3 last-col cf">
									       <?php

                                                $post_object3 = get_field('section_three_pullin');

                                                if( $post_object3 ): 

                                                    // override $post
                                                    $post = $post_object3;
                                                    setup_postdata( $post ); 

                                                    ?>
                                                    <div class="post-grid">
                                                        <h4><a href="<?php the_permalink(); ?>">Try one of our Canadian Idioms lessons</a></h4>
                                                        <?php if (has_post_thumbnail()): ?>
                                                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
                                                            <?php else: ?>
                                                                <a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/learn-thumbnail.jpg" alt="Learn thumbnail fallback"></a>
                                                            <?php endif; ?>
                                                        <?php echo the_title() . ': ' . custom_field_excerpt4(); ?>
                                                    </div>
                                                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                                <?php endif; ?>
                                        </div>
                                        
                                        <?php endif; ?>
								    </section>
                                
                                
                                    <section class="entry-content cf" itemprop="articleBody">
                                        <?php if( get_field('page_section_four') ): ?>
                                        <div class="m-all t-2of3 d-2of3 cf">
                                            <?php the_field('page_section_four'); ?>
                                        </div>
                                        <div class="m-all t-1of3 d-1of3 last-col cf">
									       <?php

                                                $post_object4 = get_field('section_four_pullin');

                                                if( $post_object4 ): 

                                                    // override $post
                                                    $post = $post_object4;
                                                    setup_postdata( $post ); 

                                                    ?>
                                                    <div class="post-grid">
                                                        <h4><a href="<?php the_permalink(); ?>">Check out one of our Virtual Coffee Chats</a></h4>
                                                        <?php if (has_post_thumbnail()): ?>
                                                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
                                                            <?php else: ?>
                                                                <a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/live-thumbnail.jpg" alt="Article thumbnail fallback"></a>
                                                            <?php endif; ?>
                                                        <?php echo the_title('',': ') . the_excerpt(); ?>
                                                    </div>
                                                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                                                <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
								    </section>
                                
                                    <section class="entry-content cf" itemprop="articleBody">
                                        <?php if( get_field('page_section_five') ): ?>
                                        <div class="m-all t-2of3 d-2of3 cf">
                                            <?php the_field('page_section_five'); ?>
                                        </div>
                                        <div class="m-all t-1of3 d-1of3 last-col cf">
                                            <div class="post-grid">
                                                <a href="/register" target="_blank" title="Find out how to register"><img src="<?php bloginfo("template_url"); ?>/library/images/join-us.jpg" alt="Join us - Register"></a>
                                        
                                            </div>
                                        </div>
                                        <?php endif; ?>
								    </section>
                                
                                    <section class="entry-content cf" itemprop="articleBody">
                                        <?php if( get_field('page_section_six') ): ?>
                                        <div class="m-all t-2of3 d-2of3 cf">
                                            <?php the_field('page_section_six'); ?>
                                        </div>
                                        <div class="m-all t-1of3 d-1of3 last-col cf">
                                            <div class="post-grid">
                                                <a href="http://myenglishonline.ca/staff" target="_blank" title="More about the EO team"><img src="<?php bloginfo("template_url"); ?>/library/images/eo-team.jpg" alt="The English Online team"></a>
                                                <p>The English Online team</p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
								    </section>
                                
                                <footer class="article-footer">

                  <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

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
												<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>
			
		
		</main>
            </div><!-- end inner-content -->
	</div><!-- end #content -->


<?php get_footer(); ?>
