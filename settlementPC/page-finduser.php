<?php
/*
 Template Name: Admin only
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

                            <h1 class="page-title"><?php the_title(); ?></h1>
                        </header>

                        <section class="entry-content cf" itemprop="articleBody">

                            <?php if ( current_user_can( 'manage_options' ) ) { ?>
                            
                                <?php if (is_page('Finduser')) : ?>
                            
                                    <h2>Find user info from ID</h2>
                                        <form class="finduser" method="post">
                                            <input id="userid" type="text" name="userid" maxlength="8" />
                                            <input name="submitid" type="submit" value="Submit" />
                                        </form>

                                    <?php
                                    if (isset($_POST['submitid']))
                                        {
                                          // Execute this code if the submit button is pressed.
                                          $checkuser = sanitize_text_field( $_POST['userid'] );
                                          $user_info = get_userdata( $checkuser );
                                            echo $user_info->user_login . "<br>";
                                            echo $user_info->first_name . "&nbsp;";
                                            echo $user_info->last_name . "<br>";
                                            echo $user_info->user_email;
                                        } else { ?>
                                            <p>Enter a user id. </p>

                                    <?php } ?>
                            
                                <?php elseif (is_page('Never logged in')) : ?><!-- if other page -->
                                    <?php $args = array(
                                            'blog_id'      => $GLOBALS['blog_id'],
                                            'role__in'     => array('subscriber'),
                                            'role__not_in' => array('bbp_participant'),
                                            'orderby'      => 'login',
                                            'order'        => 'ASC',
                                         ); 
                                    $neverloggedinusers = get_users( $args ); ?>
                            
                                    <?php echo '<h2>Users who have never logged in</h2>';
                                        echo '<h3>Email list (copy and paste to BCC in Outlook)</h3><p>';
                                        foreach ( $neverloggedinusers as $neverloggedinuser ) {
                                                echo '<span>' . esc_html( $neverloggedinuser->user_email ) . '; </span>';
                                            }
                                        echo '</p><h3>User details<br><br></h3><div class="columns2">';
                                        foreach ( $neverloggedinusers as $neverloggedinuser ) {
                                                echo '<p><span>' . $neverloggedinuser->user_login . '</span><br><span>' . $neverloggedinuser->user_email . '</span><br><span>' . $neverloggedinuser->first_name . '</span> <span>' . $neverloggedinuser->last_name . '</span></p>';
                                            } ?>
                                        <?php echo '</div>'; ?>
                                <?php endif; ?><!-- endif is Finduser or other admin-only page -->

                            <?php } else { ?><!-- if not admin -->
                                <p>You do not have permissions to access this page.</p>
                            <?php } ?>									

                            </section>

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
                    <?php get_sidebar(); ?>
                </aside>
        </div>

    </div>


<?php get_footer(); ?>
