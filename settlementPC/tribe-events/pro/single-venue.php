<?php
/**
 * Single Venue Template
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$venue_id = get_the_ID();

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
<div class="tribe-events-venue">

	<div class="tribe-events-venue-meta tribe-clearfix">
		<!-- Venue Title -->
		<?php do_action( 'tribe_events_single_venue_before_title' ) ?>
		<h2 class="tribe-venue-name"><?php echo tribe_get_venue( $venue_id ); ?></h2>
		<?php do_action( 'tribe_events_single_venue_after_title' ) ?>

		<?php if ( tribe_embed_google_map() && tribe_address_exists() ) : ?>
			<!-- Venue Map -->
			<div class="tribe-events-map-wrap">
				<?php echo tribe_get_embedded_map( $venue_id, '100%', '200px' ); ?>
			</div><!-- .tribe-events-map-wrap -->
		<?php endif; ?>

		<div class="tribe-events-event-meta">

			<?php if ( tribe_show_google_map_link() && tribe_address_exists() ) : ?>
				<!-- Google Map Link -->
				<?php echo tribe_get_meta( 'tribe_event_venue_gmap_link' ); ?>
			<?php endif; ?>

			<!-- Venue Meta -->
			<?php do_action( 'tribe_events_single_venue_before_the_meta' ) ?>
			<?php echo tribe_get_meta_group( 'tribe_event_venue' ) ?>
			<?php do_action( 'tribe_events_single_venue_after_the_meta' ) ?>

		</div><!-- .tribe-events-event-meta -->

		<!-- Venue Description -->
		<?php if ( get_the_content() ) : ?>
		<div class="tribe-venue-description tribe-events-content">
			<?php the_content(); ?>
		</div>
		<?php endif; ?>

		<!-- Venue Featured Image -->
		<?php echo tribe_event_featured_image( null, 'full' ) ?>

	</div><!-- .tribe-events-event-meta -->

	<!-- Upcoming event list -->
	<?php do_action( 'tribe_events_single_venue_before_upcoming_events' ) ?>

	<?php
	// Use the tribe_events_single_venuer_posts_per_page to filter the number of events to get here.
	echo tribe_venue_upcoming_events( $venue_id ); ?>

	<?php do_action( 'tribe_events_single_venue_after_upcoming_events' ) ?>

</div><!-- .tribe-events-venue -->
<?php
endwhile; ?>
				
					<!-- Event footer -->
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
					<!-- #tribe-events-footer -->
				
				</div><!-- #tribe-events-content -->
			</article><!-- end .hentry -->
		</main>
		<aside class="m-all t-1of4 d-1of4 cf">
			<?php get_sidebar( 'events' ); ?>
		</aside>
	</div><!-- end #inner-content-->
</div><!-- end #content-->
