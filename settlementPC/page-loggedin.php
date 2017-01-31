<?php
/*
 Template Name: Logged-in only
 *
*/
?>
<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
							<?php if ( is_user_logged_in() ) {
										?>
								<header class="article-header">

									<h1 class="page-title"><?php the_title(); ?></h1>
								</header>

								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										the_content();

									?>
								</section> 

								<footer class="article-footer">

									<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

								</footer>
								<?php } else { ?>
                                <header class="article-header">

									<h1 class="page-title"><?php the_title(); ?></h1>
								</header>
                                
									
                                
                                <section class="entry-content cf" itemprop="articleBody">
                                    <h2>This page is for registered learners only.</h2>
									<p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to view content.</p>
								</section> 
								<?php } ?>

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
												<p><?php _e( 'This is the error message in the page-profile.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>
                        <aside class="m-all t-1of4 d-1of4 cf">
                            <?php get_sidebar( 'events' ); ?>
                        </aside>

				</div>

			</div>


<?php get_footer(); ?>
