<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
						
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header entry-header">
				
								   <h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
				
								  <p class="byline vcard">
									<?php printf( __( 'Posted %1$s by %2$s', 'bonestheme' ),
									   /* the time the post was published */
									   '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
									   /* the author of the post */
									   '<span class="by">by</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>'
									); ?>
								  </p>
								  <?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
										  ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) );
								  } ?>
								</header> <?php // end article header ?>
				
								<section class="entry-content cf" itemprop="articleBody">

									<!-- featured image and attribution -->
											<div class="entry-attachment">
												<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>
													<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment"><img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a></p>
												<?php else : ?>
													<a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
												<?php endif; ?>
											</div>
												<p>
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
														<?php $cclicense = get_field_object('field_5583260d7493e',$postthumb); ?>
														<?php $ccvalue = get_field('cc_license',$postthumb); ?>
														<?php $cclabel = $cclicense['choices'][ $ccvalue ]; ?>
														<?php if ( $ccvalue == 'copyright'): ?>
															<span>&nbsp;<?php echo $cclabel; ?></span>
														<?php else: ?>
															<span>&nbsp;<a href="<?php echo $ccvalue; ?>" target="_blank"><?php echo $cclabel; ?></a></span>
														<?php endif; ?>
													<?php endif; ?>
													</p>
												
									<?php endwhile; ?>
							</section> <?php // end article section ?>
			
							<footer class="article-footer">
							  <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
			
							</footer> <?php // end article footer ?>
						</article>
						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
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
