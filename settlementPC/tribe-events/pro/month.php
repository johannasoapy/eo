<?php
/**
 * Month View Template
 * The wrapper template for month view.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month.php
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
		<main id="main" class="m-all t-all d-4of5 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<?php do_action( 'tribe_events_before_template' ) ?>
			
			<!-- Tribe Bar -->
			<?php tribe_get_template_part( 'modules/bar' ); ?>
			<section class="upcoming">
			<!-- Main Events Content -->
			<?php tribe_get_template_part( 'month/content' ); ?>
			
			<?php do_action( 'tribe_events_after_template' ) ?>
			</section>
		</main>
		<aside class="m-all t-all d-1of5 cf">
			<?php get_sidebar( 'events' ); ?>
		</aside>
	</div>
</div>
