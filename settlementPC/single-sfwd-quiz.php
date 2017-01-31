<?php
/*
 * LearnDash Quiz TEMPLATE
 *
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

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

									<!-- get content -->
									<?php the_content(); ?>
									
								</section><!-- end article-section workshopContent -->
									
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
										<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'bonestheme' ); ?></p>
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
