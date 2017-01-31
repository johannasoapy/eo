<?php
/*
 Template Name: Index
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
										// the content
										the_content(); ?>
                                    <?php 
// Articles Index Page //////////////////////////////////////////////////////////////////////////////////////////////
                                    if(is_page('articles-index')) {
    
                                        // get a list of top-level settlement topics
                                        $settlementTopics = get_terms( array(
                                            'taxonomy' => 'settlement-topic',
                                            'parent' => 0,
                                            'hide_empty' => false,
                                        ) );
    
                                        ///////////// if there are top-level topics
                                        if ($settlementTopics && ! is_wp_error($settlementTopics)) {
                                            
                                            $themecount = 0;
                                            echo '<div class="standout-block"><h4>Scroll down to view themes alphabetically or click a theme here to skip ahead:</h4><p>';
                                            foreach ($settlementTopics as $settlementTopic) {
                                                $themecount++;
                                                echo '<a class="link-separated" href="#theme' . $themecount . '">' . $settlementTopic->name . '</a>';
                                            }
                                            echo '</p></div>';
                                            $themecount = 0;
                                            foreach ($settlementTopics as $settlementTopic) {
                                                
                                                $themecount++;
                                                
                                                /////////////for each top-level, echo it's title
                                                echo '<hr id="theme' . $themecount . '"><h2><a href="' . home_url() . '/immigration-theme/'. $settlementTopic->slug . '">' . $settlementTopic->name . '</a></h2>';
                                                
                                                /////////////for each top-level, get child topics
                                                $topicChilds = get_terms(
                                                    'settlement-topic',
                                                    array(
                                                        'parent' => $settlementTopic->term_id,
                                                        'child_of' => $settlementTopic->term_id,
                                                        'hide_empty' => false,
                                                    )
                                                );
                                                
                                                ///////////// if there are child topics
                                                if ($topicChilds && ! is_wp_error($topicChilds)) {
                                                    
                                                    echo '<div class="indent" style="padding-left: 1.5em;">';

                                                    foreach ($topicChilds as $topicChild){

                                                        /////////////for each top-level, echo it's title
                                                        $slugger = $topicChild->slug;
                                                        echo '<h3>' . $topicChild->name . '</h3><ul>';

                                                        $args8 = array(
                                                            'post_type' => 'article',
                                                            'posts_per_page' => -1,
                                                            'orderby' => 'title',
                                                            'order' => 'ASC',
                                                            'tax_query' => array(
                                                                  array(
                                                                      'taxonomy' => 'settlement-topic',
                                                                      'field' => 'slug',
                                                                        'terms' => $slugger,
                                                                  )
                                                                )

                                                        );
                                                        $loop8 = new WP_Query($args8);

                                                        if($loop8->have_posts()): while($loop8->have_posts()): $loop8->the_post(); ?> 

                                                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                                            <?php if( has_term( 'lower-intermediate-clb-3-4', 'language_level' ) ) { ?>
                                                                <ul><li><a href="<?php the_permalink(); ?>?clb-version=clb3-4">Simple English version (CLB3-4)</a></li></ul>
                                                        <?php } ?>

                                                            <?php
                                                        endwhile;

                                                        else : ?>
                                                            <li>There are not yet any articles in this topic. We are adding new content regularly - check back soon.</li>
                                                        <?php endif;

                                                        wp_reset_query();


                                                        echo '</ul>';
                                                       
                                                        
                                                    }///////////// end foreach child topics
                                                    
                                                    echo '</div>';
                                                    
                                                } ///////////// endif there are child topics
                                                
                                            }///////////// end foreach top-level topics

                                        }///////////// endif there are top-level topics
                                        
// Activities Index Page /////////////////////////////////////////////////////////////////////////////////////////////
                                    } elseif(is_page('activities-index')) {
    
                                        // get a list of top-level settlement topics
                                        $learningOptions = get_terms( array(
                                            'taxonomy' => 'learning_options',
                                            'hide_empty' => false,
                                        ) );
    
                                        //for each top-level, get child topics
                                        if ($learningOptions && ! is_wp_error($learningOptions)) {
                                            $themecount = 0;
                                            echo '<div class="standout-block"><h4>Scroll down to view activities alphabetically or click here to skip ahead:</h4><p>';
                                            foreach ($learningOptions as $learningOption) {
                                                $themecount++;
                                                echo '<a class="link-separated" href="#theme' . $themecount . '">' . $learningOption->name . '</a>';
                                            }
                                            echo '</p></div>';
                                            $themecount = 0;
                                            foreach ($learningOptions as $learningOption) {
                                                $themecount++;

                                                echo '<hr id="theme' . $themecount . '"><h2><a href="' . home_url() . '/learn/'. $learningOption->slug . '">' . $learningOption->name . '</a></h2><div class="indent" style="padding-left: 1.5em;">';
                                                if($learningOption->slug == 'coffee-chats') {
                                                    echo '<p>For dates of upcoming Coffee Chats, please see <a href="/events/category/coffee-chats">Events: Virtual Coffee Chats</a>.</p>';
                                                } elseif ($learningOption->slug == 'drop-in-classes') {
                                                    echo '<p>For dates of upcoming Drop-In Workshops, please see <a href="/events/category/drop-in-workshops">Events: Drop-In Workshops</a>. Click below to access the related learning materials.</p>';
                                                } elseif ($learningOption->slug == 'multi-week-sessions') {
                                                    echo '<p>For dates of upcoming Multi-Week Sessions, please see <a href="/events/category/multi-week-workshops">Events: Multi-Week Workshops</a>. Click below to access the related learning materials.</p>';
                                                }

                                                    $args8 = array(
                                                        'post_type' => 'sfwd-courses',
                                                        'posts_per_page' => -1,
                                                        'orderby' => 'title',
                                                        'order' => 'ASC',
                                                        'tax_query' => array(
		                                                      array(
                                                                    'taxonomy' => 'learning_options',
                                                                    'field' => 'slug',
                                                                    'terms' => $learningOption
                                                                  )
                                                            )

                                                    );
                                                    $loop8 = new WP_Query($args8);
                                                
                                                if($loop8->have_posts()): 

                                                
                                                while($loop8->have_posts()): $loop8->the_post(); ?>
                                                            
                                                    
                                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                        <ul>

                                                        <?php $lessons = learndash_get_lesson_list();
                                                        if ($lessons && ! is_wp_error($lessons)) {
                                                                    
                                                            foreach($lessons as $lesson) { ?>
                                                                <li>
                                                                    <a href="<?php echo get_permalink( $lesson ); ?>"><?php echo get_the_title( $lesson ); ?></a>
                                                                        
                                                                </li>
                                                            <?php } ?><!-- end foreach -->
                                                        
                                                        <?php } ?><!-- end if $lessons -->
                                                        </ul>

                                                <?php endwhile;
                                                    
                                                endif;

                                                wp_reset_query();
                                                
                                                echo '</div>'; // end class indent

                                            } ////// end foreach learningOptions end if learningOptions

                                        } ////////// end end if learningOptions 
    
                                    }/////////////// endif is_page activities-index
   // END Activities Index Page //////////////////////////////////////////////////////////////////////////////////////////////    
                                     ?>
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
