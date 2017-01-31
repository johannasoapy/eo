<?php
/**
 * Related Events Template
 * The template for displaying related events on the single event page.
 *
 * You can recreate an ENTIRELY new related events view by doing a template override, and placing
 * a related-events.php file in a tribe-events/pro/ directory within your theme directory, which
 * will override the /views/pro/related-events.php.
 *
 * You can use any or all filters included in this file or create your own filters in
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters
 *
 * @package TribeEventsCalendarPro
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$posts = tribe_get_related_posts( $count = 4 );

if ( is_array( $posts ) && ! empty( $posts ) ) : ?>
<section class="article-section">
    <hr>
    <h2 class="tribe-events-related-events-title"><?php printf( __( 'Related %s', 'tribe-events-calendar-pro' ), tribe_get_event_label_plural() ); ?></h2>

    <!--<ul class="tribe-related-events tribe-clearfix">-->
        <?php foreach ( $posts as $post ) : ?>
        <div class="post-grid">
            <h4 class="tribe-related-events-title"><a href="<?php echo tribe_get_event_link( $post ); ?>" class="tribe-event-url" rel="bookmark"><?php echo get_the_title( $post->ID ); ?></a></h4>
            <div class="tribe-related-events-thumbnail">
                <?php if (has_post_thumbnail( $post->ID )): ?>
                <?php $eventthumb = get_the_post_thumbnail( $post->ID , 'bones-thumb-600'  ); ?>
                                                    <a href="<?php echo esc_url( tribe_get_event_link( $post ) ); ?>" class="url" rel="bookmark"><?php echo $eventthumb; ?></a>
                                                <?php else: ?>
                                                    <a href="<?php echo esc_url( tribe_get_event_link( $post ) ); ?>" class="url" rel="bookmark"><img src="<?php bloginfo("template_url"); ?>/library/images/tribe-related-events-placeholder.png" alt="Article thumbnail fallback"></a>
                                                <?php endif; ?>

            </div>
            <div class="tribe-related-event-info">
                <?php
                    if ( $post->post_type == Tribe__Events__Main::POSTTYPE ) {
                        echo tribe_events_event_schedule_details( $post );
                    }
                ?>
            </div>
        </div>
        <?php endforeach; ?>
    <!--</ul>-->
</section>
<?php
endif;
