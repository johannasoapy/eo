<?php
/*
 * THEMEPAGE TEMPLATE
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


						<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

							<header class="article-header">

								<h1 class="single-title page-title"><?php the_title(); ?></h1>
								<div class="byline-wrap">
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>' ), get_the_time( 'Y-m-j' ), get_the_time(get_option('date_format')) );
									?></p>
									<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
											ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) );
										} ?>
								</div>
							</header>

							<section class="entry-content cf">
									<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
									
                                    <?php $terms = get_the_terms( $post->ID , 'settlement-topic' );
                                        foreach($terms as $term) {
                                            $parent = $term->parent;
                                        } ?>
									
										<section class="article-section cf" itemprop="themeIntro">
                                            
                                            <?php
                                                    $resources = get_field('theme_resources');
                                                    $forum = get_field('theme_forum'); ?>
                                            
                                            <span id="skipto-block" class="standout-block m-all t-all d-1of4 last-col">
                                                    <h3>Skip to:</h3>
                                                    <ul>
                                                        <li><a href="#theme-topics"><?php the_title(); ?> Topics</a></li>
                                                        <?php if( !empty($resources) ): ?>
                                                        <li><a href="#theme-resources"><?php the_title(); ?> Resources</a></li>
                                                        <?php endif; ?>
                                                        <li><a href="#theme-recent">Newest <?php the_title(); ?> Articles</a></li>
                                                        <li><a href="#clb3-recent">Recent <?php the_title(); ?> Articles, CLB3-4</a></li>
                                                        <?php if( !empty($forum) ): ?>
                                                        <li><a href="#theme-forum">Discussion Forum</a></li>
                                                        <?php endif; ?>
                                                        <li><a href="#theme-learning">Related Activities</a></li>
                                                    </ul>
                                                </span>
                                            <?php if( get_field('theme_intro') ): ?>

                                                <?php the_field('theme_intro'); ?>
                                            <?php endif; ?>
                                            <?php if( get_field('quick_facts') ): ?>

                                                <h2><br>Quick Facts</h2>
                                                
                                                <?php the_field('quick_facts'); ?>

                                           <?php endif; ?>
                                        </section>
									
									
									
									<section id="theme-topics" class="article-section theme-submenu cf" itemprop="themeSubmenu">
										<h2><?php the_title(); ?> Articles by Topic</h2>
										
										<!--loop through this settlement-topic's children, list title but link to first article, also count articles in child and display count-->								
										<?php
											$custom_terms = get_the_terms( $post->ID , 'settlement-topic' );
											echo '<ul>';
											foreach($custom_terms as $custom_term) {
                                                
                                                $args = array(
                                                    'post_type' => 'article',
                                                    'orderby'   => 'menu_order',
                                                    'order'     => 'ASC',
                                                    'tax_query' => array(
                                                        array(
                                                              'taxonomy' => 'settlement-topic',
                                                              'field' => 'id',
                                                              'terms' => array($custom_term->term_id),
                                                        )
                                                    )
                                                );
                                                $the_query = new WP_Query( $args );
                                                $count = $the_query->found_posts;
                                                $first_article = get_posts($args);
                                                
												if ($count > 0) {

													if ($count == 1) {
														echo '<li class=""><a href="'. get_permalink( $first_article[0]->ID ) .'" title="Articles about '. $custom_term->name . '" style="text-decoration:none;">' . $custom_term->name . '</a><span class="count">' . esc_html($count) . ' article</span></li>';
													} else {
														echo '<li class=""><a href="'. get_permalink( $first_article[0]->ID ) .'" title="Articles about '. $custom_term->name . '" style="text-decoration:none;">' . $custom_term->name . '</a><span class="count">' . esc_html($count) . ' articles</span></li>';
													}
												}
												
											    
											}
				
											echo '</ul>';
										?>
					   
									</section>
									
									<?php $resources = get_field('theme_resources'); ?>
											
									<?php if( $resources ): ?>
										<section id="theme-resources" class="article-section cf" itemprop="themeResources">
										<h2><?php the_title(); ?> Resources</h2>
										<?php echo $resources; ?>
										</section>
									<?php endif; ?>
                                 <!-- display 3 most recent articles in theme-->
                                <section id="theme-recent" class="article-section cf">
                                    <h2>Newest <?php the_title(); ?> Articles</h2>
									<?php
                                    
                                    
									$args8 = array(
										'post_type' => 'article',
										'posts_per_page' => 4,
										'orderby' => 'date',
										'order' => 'DESC',
                                        'tax_query' => array(
                                                            array(
                                                                  'taxonomy' => 'settlement-topic',
                                                                  'field' => 'id',
                                                                  'terms' => $parent,
                                                            )
                                                        )
									);
									$loop8 = new WP_Query($args8);
									
									while($loop8->have_posts()): $loop8->the_post(); ?>
										<div class="post-grid">
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<?php if (has_post_thumbnail()): ?>
												<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bones-thumb-600' ); ?></a>
											<?php else: ?>
												<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/live-thumbnail.jpg" alt="Article thumbnail fallback"></a>
											<?php endif; ?>
											<?php echo custom_field_excerpt2();  ?>
										</div>
										<?php
									endwhile; ?>
                                    <?php $parentall = get_term($parent); ?>
                                    <?php $parentslug = $parentall->slug; ?>
                                    <?php echo do_shortcode('[ajax_load_more container_type="div" post_type="article" posts_per_page="4" taxonomy="settlement-topic" taxonomy_terms="' . $parentslug . '" taxonomy_operator="IN" offset="4" pause="true" scroll="false" transition_speed="500" button_label="Load More +" button_loading_label="Loading..."]');
									wp_reset_query(); ?>
								</section><!--end .upcoming -->
                                
                                
								<section id="clb3-recent" class="article-section cf">
                                    <h2>Recent <?php the_title(); ?> Articles, CLB3-4</h2>
									<?php
									
									$args8 = array(
										'post_type' => 'article',
										'posts_per_page' => 4,
										'orderby' => 'date',
										'order' => 'DESC',
                                        'language_level' => 'lower-intermediate-clb-3-4',
                                        'tax_query' => array(
                                                            array(
                                                                  'taxonomy' => 'settlement-topic',
                                                                  'field' => 'id',
                                                                  'terms' => $parent,
                                                            )
                                                        )
									);
									$loop8 = new WP_Query($args8);
									
									if($loop8->have_posts()): while($loop8->have_posts()): $loop8->the_post(); ?>
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
                                    echo '<div style="clear:both;padding-top:2em;"><p>You can see more <a href="' . home_url() . '/simple-english-articles-clb3-4/">simple English articles here</a>.</p></div>';
                                    else :
                                    echo '<p>There are no CLB3-4 articles on this topic yet. We are writing more simple English articles&mdash;please check back soon.</p><p>You can see more <a href="' . home_url() . '/simple-english-articles-clb3-4/">simple English articles here</a>.</p>';
                                    endif;
									wp_reset_query();
									?>
								</section><!--end .upcoming -->
                                
                                
                                <section id="theme-learning" class="article-section cf">
                                    <h2>Related Activities</h2>
									<?php
                                    
                                    /*$terms = get_the_terms( $post->ID , 'settlement-topic' );
                                    foreach($terms as $term) {
                                        $parent = $term->parent;
                                    }*/
									$args9 = array(
										'post_type' => array('sfwd-lessons','sfwd-courses','tribe_events'),
										'posts_per_page' => 4,
										'orderby' => 'modified',
										'order' => 'DESC',
                                        'tax_query' => array(
                                                            array(
                                                                  'taxonomy' => 'settlement-topic',
                                                                  'field' => 'id',
                                                                  'terms' => $parent,
                                                            )
                                                        )
									);
									$loop9 = new WP_Query($args9);
									$countactivities = 0;
									while($loop9->have_posts()): $loop9->the_post(); ?>
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
                                    $countactivities++;
									endwhile;
                                    if( $countactivities >= 4 ) {
                                        echo do_shortcode('  [ajax_load_more container_type="div" post_type="sfwd-courses, sfwd-lessons" posts_per_page="4" taxonomy="settlement-topic" taxonomy_terms="' . $parentslug . '" taxonomy_operator="IN" offset="4" pause="true" scroll="false" transition_speed="500" destroy_after="2" button_label="Load More +" button_loading_label="Loading..."]');
                                    }
                                    
									wp_reset_query();
									?>
                                  
								</section><!--end .upcoming -->

							</section> <!-- end article section -->

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
										<p><?php _e( 'This is the error message in the single-themepage.php template.', 'bonestheme' ); ?></p>
									</footer>
								</article>

						<?php endif; ?>

					</main>
					<aside class="m-all t-1of4 d-1of4 cf">
						<?php include('sidebar-theme.php'); ?>
					</aside>

				</div>

			</div>

<?php get_footer(); ?>
