<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all t-2of3 d-3of4 last-col cf" role="main">
						<h1 class="page-title"><span><?php _e( 'Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?>
						</h1>
						
						<!--filter from http://www.wpbeginner.com/wp-tutorials/how-to-create-advanced-search-form-in-wordpress-for-custom-post-types/-->
                        <?php global $wp;
                        $current_url = home_url(add_query_arg(array(),$wp->request)); ?>
						<form class="refine-search" role="search" method="get" id="searchform">
						<input type="text" name="s" id="s" <?php if(is_search()) { ?>value="<?php the_search_query(); ?>" <?php } else { ?>value="Enter keywords &hellip;" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"<?php } ?> />
							<div class="right checkboxes">
								<?php $query_types = get_query_var('post_type'); ?>

									
								<fieldset><label class="article-label"><input type="checkbox" name="post_type[]" value="article"  <?php if (in_array('article', $query_types)) { echo 'checked'; } ?> />Articles</label></fieldset>
								<fieldset><label class="activities-label"><input type="checkbox" name="post_type[]" value="sfwd-courses" <?php if (in_array('sfwd-courses', $query_types)) { echo 'checked'; } ?> />Activities</label></fieldset>
								<fieldset style="display:none;"><label><input type="checkbox" name="post_type[]" value="themepage" <?php if (in_array('article', $query_types)) { echo 'checked'; } ?> />Themepage</label></fieldset>
								<fieldset><label class="events-label"><input type="checkbox" name="post_type[]" value="tribe_events" <?php if (in_array('tribe_events', $query_types)) { echo 'checked'; } ?> />Events</label></fieldset>
								<fieldset><label class="blog-label"><input type="checkbox" name="post_type[]" value="post" <?php if (in_array('post', $query_types)) { echo 'checked'; } ?> />Blog Posts</label></fieldset>
								<fieldset style="display:none;"><label><input type="checkbox" name="post_type[]" value="sfwd-lessons" <?php if (in_array('sfwd-courses', $query_types)) { echo 'checked'; } else { echo str_replace( 'checked','','checked'); } ?> />Lessons</label></fieldset>
								
									
								<input class="blue-btn" type="submit" id="searchsubmit" value="s" />
							</div>
						</form>
						<!--end filter from http://www.wpbeginner.com/wp-tutorials/how-to-create-advanced-search-form-in-wordpress-for-custom-post-types/-->
						
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

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

							<?php else : ?>

									<article id="post-not-found" class="hentry type-post cf">

                                        <header class="article-header">

                                            <h1><?php _e( 'Sorry, no results for this subject.', 'bonestheme' ); ?></h1>

                                        </header>

                                        <section class="entry-content">

                                            <p><?php _e( 'The subject you were looking for was not found. Check our <a href="/articles-index">Articles Index</a> page for a full list of article titles or our <a href="/activities-index">Activities Index</a> page for a full list of activities and lessons, or try another search.', 'bonestheme' ); ?></p>

                                        </section>

                                        <footer class="article-footer">
                                            <p>Thank you for your patience!</p>

                                        </footer>

                                    </article>

							<?php endif; ?>

						</main>

					<aside class="m-all t-1of3 d-1of4">
						<?php get_sidebar(); ?>
					</aside>

					</div>

			</div>

<?php get_footer(); ?>
