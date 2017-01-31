<?php
/**
 * List View Template
 * The wrapper template for a list of events. This includes the Past Events and Upcoming Events views
 * as well as those same views filtered to a specific category.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>
<div id="content">

	<div id="inner-content" class="cf">
        <div class="breadcrumbs">
                <?php if (function_exists('ft_custom_breadcrumbs')) {
                    ft_custom_breadcrumbs();
                } ?>
        </div>
		<main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<?php do_action( 'tribe_events_before_template' ); ?>
			
				<!-- Tribe Bar -->
			<?php tribe_get_template_part( 'modules/bar' ); ?>
			<section class="upcoming">
				<!-- Main Events Content -->
			<?php tribe_get_template_part( 'list/content' ); ?>
			
				<div class="tribe-clear"></div>
			
			<?php do_action( 'tribe_events_after_template' ) ?>
			</section>
		</main>
		<aside class="m-all t-1of4 d-1of4 cf">
			<?php get_sidebar( 'events' ); ?>
		</aside>
	</div>
</div>