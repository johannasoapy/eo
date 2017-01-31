<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
								    
							<?php if ( is_tax( 'learning_types' ) ) { ?>
								    <h1 class="archive-title h2"><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></h1>

							<?php } else { ?>
									<h1 class="archive-title h2">
										<span><?php _e( 'Results', 'bonestheme' ); ?></span>
									</h1>
									<?php }?>
							
							<?php

								// set up our archive arguments
								$tax = $wp_query->get_queried_object();
								
								$archive_args = array(
								  'post_type' => array( 'sfwd-lessons','sfwd-courses','tribe_events' ),
								  'learning_types' => $tax->slug,
								  'posts_per_page' => '20',
								  'paged' => $paged
								);
								$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								// new instance of WP_Query
								$wp_query = new WP_Query( $archive_args );
							
							?>


							<?php if ( $wp_query->have_posts()) : while ( $wp_query->have_posts()) : $wp_query->the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="entry-header article-header">

									<h3 class="search-title entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

								<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time(get_option('date_format')) );
									?></p>

								</header>

								<section class="entry-content">
									<?php $excerpt = the_excerpt();
										if($excerpt):
											the_excerpt( '<span class="read-more">' . __( 'Read more &raquo;', 'bonestheme' ) . '</span>' );
										elseif( custom_field_excerpt() ):
											echo custom_field_excerpt();
										elseif( custom_field_excerpt2() ):
											echo custom_field_excerpt2();
										elseif( custom_field_excerpt3() ):
											echo custom_field_excerpt3();
										endif; ?>

								</section>

								<footer class="article-footer">
									
									
									<?php if(get_the_term_list( $post->ID , 'settlement-topic',', ') != ''): ?>
										<?php printf( __( 'Filed under: %1$s', 'bonestheme' ), get_the_term_list( $post->ID , 'settlement-topic','',', ') ); ?>
                                    
                                    <?php elseif(get_the_term_list( $post->ID , 'learning_options') != ''): ?>
										<?php printf( __( 'Activity type: %1$s', 'bonestheme' ), get_the_term_list( $post->ID , 'learning_options','',', ') ); ?>
                                    
									<?php elseif(get_the_category_list(', ') != ''): ?>
										<?php printf( __( 'Filed under: %1$s', 'bonestheme' ), get_the_category_list(', ') ); ?>
									<?php endif; ?>
                                    <?php if(get_the_term_list( $post->ID , 'learning_types',', ') != ''): ?>
										<?php printf( __( '<br>Learning Type: %1$s', 'bonestheme' ), get_the_term_list( $post->ID , 'learning_types','',', ') ); ?>
										<?php endif; ?>
                                    <?php if(get_the_term_list( $post->ID , 'language_level',', ') != ''): ?>
		                              <?php printf( __( '<br>Language Level: %1$s', 'bonestheme' ), get_the_term_list( $post->ID , 'language_level','',', ') ); ?>
                                    <?php endif; ?>

								</footer> <!-- end article footer -->

							</article>

						<?php endwhile; ?>

									<?php bones_page_navi(); ?>
									<?php wp_reset_postdata(); // always reset post data after a custom query ?>
							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the archive.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>

					<aside class="m-all t-1of4 d-1of4 cf">
						<?php get_sidebar(); ?>
					</aside>

				</div>

			</div>

<?php get_footer(); ?>
