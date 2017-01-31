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
                                    <?php $classes = get_body_class();
                                        if (in_array('bbp-user-edit',$classes)) : ?>
                                    
                                        <?php $user = wp_get_current_user();
                                            if ( in_array( 'guest_user', (array) $user->roles ) ) :
                                                    echo 'This profile is not editable.';
                                            else : ?>
                                        <?php
                                            the_content();
                                        ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                    
                                        <?php the_content(); ?>
                                    
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

							<?php endif; ?>

						</main>
					<aside class="m-all t-1of4 d-1of4">
						<?php get_sidebar(); ?>
					</aside>

				</div>

			</div>

<?php get_footer(); ?>
