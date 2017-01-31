<?php
/**
 * Single Organizer Template
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$organizer_id = get_the_ID();

?>
<div id="content">

	<div id="inner-content" class="cf">
		<div class="breadcrumbs">
                <?php if (function_exists('ft_custom_breadcrumbs')) {
                    ft_custom_breadcrumbs();
                } ?>
        </div>

		<main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							
			<article class="hentry tribe-article">				
				<div id="tribe-events-content" class="tribe-events-single vevent hentry">
				
					<p class="tribe-events-back">
						<a href="<?php echo tribe_get_events_link() ?>"> <?php _e( '&laquo; All Events', 'tribe-events-calendar' ) ?></a>
					</p>
				
				
					<?php while ( have_posts() ) : the_post(); ?>
                        <div class="tribe-events-organizer">
                            <p class="tribe-events-back">
                                <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" rel="bookmark"><?php printf( __( '&larr; Back to %s', 'tribe-events-calendar-pro' ), tribe_get_event_label_plural() ); ?></a>
                            </p>

                        <?php do_action( 'tribe_events_single_organizer_before_organizer' ) ?>
                        
                            <div class="tribe-events-organizer-meta tribe-clearfix">
                                <header class="article-header entry-header">
                                    <!-- Organizer Title -->
                                    <?php do_action( 'tribe_events_single_organizer_before_title' ) ?>
                                    <h2 class="tribe-organizer-name"><?php echo tribe_get_organizer( $organizer_id ); ?></h2>
                                    <?php do_action( 'tribe_events_single_organizer_after_title' ) ?>
                                 </header>
                                <section class="entry-content cf" itemprop="articleBody">
                                    <!-- Organizer Meta -->
                                    <?php do_action( 'tribe_events_single_organizer_before_the_meta' ); ?>
                                    <?php echo tribe_get_meta_group( 'tribe_event_organizer' ) ?>
                                    <?php do_action( 'tribe_events_single_organizer_after_the_meta' ) ?>

                                    <!-- Organizer Featured Image -->
                                    <?php echo tribe_event_featured_image( null, 'full' ) ?>

                                    <!-- Organizer Content -->
                                    <?php if ( get_the_content() ) { ?>
                                    <div class="tribe-organizer-description tribe-events-content">
                                        <?php the_content(); ?>
                                    </div>
                                    <?php } ?>
                                </section>

                            </div>
                       
                            <!-- .tribe-events-organizer-meta -->
                        <?php do_action( 'tribe_events_single_organizer_after_organizer' ) ?>

                        <!-- Upcoming event list -->
                        <?php do_action( 'tribe_events_single_organizer_before_upcoming_events' ) ?>

                        <?php
                        // Use the tribe_events_single_organizer_posts_per_page to filter the number of events to get here.
                        echo tribe_organizer_upcoming_events( $organizer_id ); ?>

                        <?php do_action( 'tribe_events_single_organizer_after_upcoming_events' ) ?>

                    </div><!-- .tribe-events-organizer -->
                    <?php
                    do_action( 'tribe_events_single_organizer_after_template' );
                endwhile; ?>
				
					<!-- Event footer -->
                    <footer class="article-footer">
                        <div id="tribe-events-footer">
                            <!-- Navigation -->
                            <!-- Navigation -->
                            <h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
                            <ul class="tribe-events-sub-nav">
                                <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
                                <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
                            </ul>
                            <!-- .tribe-events-sub-nav -->
                        </div>
                    </footer>
					<!-- #tribe-events-footer -->
				
				</div><!-- #tribe-events-content -->
			</article><!-- end .hentry -->
		</main>
		<aside class="m-all t-1of4 d-1of4 cf">
			<?php get_sidebar( 'events' ); ?>
		</aside>
	</div><!-- end #inner-content-->
</div><!-- end #content-->
