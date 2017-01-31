
              <?php
                /*
                 * This is the default post format.
                 *
                 * So basically this is a regular post. if you don't want to use post formats,
                 * you can just copy ths stuff in here and replace the post format thing in
                 * single.php.
                 *
                 * The other formats are SUPER basic so you can style them as you like.
                 *
                 * Again, If you want to remove post formats, just delete the post-formats
                 * folder and replace the function below with the contents of the "format.php" file.
                */
              ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

                <header class="article-header entry-header">

                  <h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

                  <p class="byline vcard"><?php
                      printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> by <span class="author">%3$s</span>', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) ) );
                  ?></p>
                    
                  <?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
                          ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) );
                  } ?>

                </header> <?php // end article header ?>

                <section class="entry-content cf" itemprop="articleBody">
                    
                  <?php
                    // the content (pretty self explanatory huh)
                    the_content();
                  ?>
                </section> <?php // end article section ?>

                <footer class="article-footer">
                    
                  <p><?php printf( __( 'Filed under: %1$s', 'bonestheme' ), get_the_category_list(', ') ); ?></p>

                  <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
                    <span id="skipto-block" class="m-all t-all d-1of4 last-col">
                         <?php if(is_user_logged_in()) : ?> <!-- if user is logged in -->
                            <?php /**
                            * Get the favorite button for a specified post
                            * Post ID not required if inside the loop
                            * @param $post_id int, defaults to current post
                            * @param $site_id int, defaults to current blog/site
                            */
                            get_favorites_button();

                            /**
                            * Echo the favorite button for a specified post
                            * Post ID not required if inside the loop
                            * @param $post_id int, defaults to current post
                            * @param $site_id int, defaults to current blog/site
                            */ 
                            the_favorites_button(); ?>
                        <?php endif; ?>
                    </span>

                </footer> <?php // end article footer ?>

              </article> <?php // end article ?>
