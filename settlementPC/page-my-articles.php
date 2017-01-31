<?php
/*
 Template Name: My Articles
 *
*/
?>
<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
						<main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
									<div class="byline-wrap">
										<p class="byline vcard">
											<?php printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
										</p>
									</div>
								</header> <?php // end article header ?>

								<section class="entry-content cf" itemprop="articleBody">

									<?php
										the_content();
									?>
                                    <h2>Recently Published Articles</h2>
                                    <?php
								
                                    $args3 = array(
                                        'post_type' => 'article',
                                        'posts_per_page' => 12,
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
												<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo("template_url"); ?>/library/images/live-thumbnail.jpg" alt="Article thumbnail fallback"></a>
											<?php endif; ?>
											<?php echo custom_field_excerpt2();  ?>
										</div>
                                        <?php
                                    endwhile;
                                    wp_reset_query();
                                    ?>
                                    <?php echo do_shortcode('[ajax_load_more container_type="div" post_type="article" posts_per_page="12" offset="12" pause="true" scroll="false" transition_speed="500" button_label="Load More +" button_loading_label="Loading..."]'); ?>

								</section>

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

							<?php endif; ?>

						</main>
					<aside class="m-all t-1of4 d-1of4">
						<?php get_sidebar(); ?>
					</aside>

				</div>

			</div>

<?php get_footer(); ?>
