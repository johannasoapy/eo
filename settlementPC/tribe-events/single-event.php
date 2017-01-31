<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$event_id = get_the_ID();

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
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				    <header class="article-header">
			
                        <p class="tribe-events-back">
                            <a href="<?php echo tribe_get_events_link() ?>"> <?php _e( '&laquo; All Events', 'tribe-events-calendar' ) ?></a>
                        </p>

                        <!-- Notices -->
                        <?php tribe_the_notices() ?>

                        <?php the_title( '<h1 class="single-title custom-post-type-title">', '</h1>' ); ?>

                        <div class="tribe-events-schedule updated published tribe-clearfix">
                            <?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
                            <?php if ( tribe_get_cost() ) : ?>
                                <span class="tribe-events-divider">|</span>
                                <span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Event header -->
                        <div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
                            <!-- Navigation -->
                            <h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
                            <ul class="tribe-events-sub-nav">
                                <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
                                <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
                            </ul>
                            <!-- .tribe-events-sub-nav -->
                        </div>
					<!-- #tribe-events-header -->
                    </header>
                    
				    <section class="entry-content cf">
					<?php while ( have_posts() ) :  the_post(); ?>

							<!-- Event featured image, but exclude link -->
							<?php if (has_post_thumbnail()): ?>
							<div class="wp-caption" itemprop="image">
								
								<?php echo tribe_event_featured_image( $event_id, 'bones-thumb-900', false ); ?>
								<p class="wp-caption-text">
									
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
										<?php if( null !== get_field('cc_license', $postthumb)): ?>
											<?php $cclicense = get_field_object('field_5583260d7493e',$postthumb); ?>
											<?php $ccvalue = get_field('cc_license',$postthumb); ?>
											<?php $cclabel = $cclicense['choices'][ $ccvalue ]; ?>
											<?php if ( $ccvalue == 'copyright'): ?>
												<span>&nbsp;<?php echo $cclabel; ?></span>
											<?php else: ?>
												<span>&nbsp;<a href="<?php echo $ccvalue; ?>" target="_blank"><?php echo $cclabel; ?></a></span>
											<?php endif; ?>
										<?php endif; ?>
									<?php endif; ?>
									</p>
								</div>
							<?php endif; ?>
							<!-- Event content -->
							<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
							<div class="tribe-events-single-event-description tribe-events-content description">
								<?php the_content(); ?>
                                
                                <!-- EO Custom fields - 'Event Links' -->
                                <?php 
                                // EO link to workshop/session learning materials
                                $posts = get_field('activity_link');
								if( $posts ): ?>
										<div class="cf">
											<h3>Related Learning Materials</h3>
											<ul>
												<?php foreach( $posts as $p ): // variable must NOT be called $post (IMPORTANT) ?>
														<li><a class="" href="<?php echo get_permalink( $p ); ?>" target="_blank"><?php echo get_the_title( $p ); ?></a></li>
												<?php endforeach; ?>
											</ul>
										</div>
                                    <?php endif; ?>
                                
                                <?php 
                                // EO WIZIQ or Zoom link and instructions
								$livesession = get_field('synchronous_link');
                                    if( $livesession ): ?>
                                    <div class="cf" itemprop="workshopSynchronous">
                                        <?php 
                                            $eventDate = tribe_get_start_date( null, false, 'Y-m-d' );
                                        
                                            // from http://stackoverflow.com/questions/8006692/get-current-date-given-a-timezone-in-php
                                            $datehere = new DateTime("now", new DateTimeZone('America/Winnipeg'));
                                            $todayDate = $datehere->format('Y-m-d');
                                        
                                            if( $todayDate === $eventDate ): //only shows 'Join' on day of event
                                                //only for logged in users ?>
                                            
                                                
                                        <?php if ( is_user_logged_in() ): ?>
                                            
                                             <p><a class="blue-btn join-synchronous" href="<?php esc_url(the_field('synchronous_link')); ?>" target="_blank">Join Event</a></p>
                                                <p class="clear">If you have any problems with the Join button, copy and paste this url into your browser: <?php esc_url(the_field('synchronous_link')); ?>.</p>
                                            
                                            <div class="standout-block">
                                                <p>We are using <a href="https://zoom.us/" target="_blank">Zoom</a> to deliver this event. You will need a computer with internet access and a headset with a microphone.</p>

                                                <ul><li>Click on the "Join Event" button to open the virtual classroom in a separate page. Please have a headset with a microphone ready if you want to speak during the workshop.</li>

                                                    <li>If you haven't already installed Zoom, you will be prompted to download and install the app when you click the Join button. You can find detailed instructions on our <a href="/joining-webinars-and-drop-in-workshops/" target="_blank">"Joining Events with Zoom"</a> page.</li>
                                                <li>If you have any sound problems, check your headset or speaker connections, test and adjust your audio settings - <a href="/joining-webinars-and-drop-in-workshops/#zoom-settings" target="_blank">instructions here</a>, or close and re-enter the session.</li>
                                                </ul>
                                            </div>
                                        
                                        <?php else: ?><!--else if user is not logged in-->
                                            <p><a style="pointer-events: none; background: #ddd !important" class="blue-btn join-synchronous" href="#" target="_blank">Join Event</a></p>
                                        <p class="clear">Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to join live sessions. If you are not yet registered with us, <a href="<?php echo home_url(); ?>/register" title="Register">find out how to register</a>.</p>
                                        <div class="standout-block">
                                            <p>We are using <a href="https://zoom.us/" target="_blank">Zoom</a> to deliver this event. You will need a computer with internet access and a headset with a microphone.</p>

                                            <ul><li>Click on the "Join Event" button to open the virtual classroom in a separate page. Please have a headset with a microphone ready if you want to speak during the workshop.</li>

                                                <li>If you haven't already installed Zoom, you will be prompted to download and install the app when you click the Join button. You can find detailed instructions on our <a href="/joining-webinars-and-drop-in-workshops/" target="_blank">"Joining Events with Zoom"</a> page.</li>
                                            <li>If you have any sound problems, check your headset or speaker connections, test and adjust your audio settings - <a href="/joining-webinars-and-drop-in-workshops/#zoom-settings" target="_blank">instructions here</a>, or close and re-enter the session.</li>
                                            </ul>
                                        </div>
                                        
                                        <?php endif; ?><!--endif user is logged in-->
                                        
                                    <?php else: ?><!--else if not today's date-->
                                        <h3>How to Join the Session</h3>
                                        <p>We are using <a href="https://zoom.us/" target="_blank">Zoom</a> to deliver this event. You will need a computer with internet access and a headset with a microphone.</p>

                                        <ul>
                                            <li>You can set up Zoom ahead of time - instructions are on our <a href="/joining-webinars-and-drop-in-workshops/" target="_blank">"Joining Events with Zoom"</a> page.</li>
                                            <li>On the date of the event, a "Join Event" button will appear here. Click the button to open the virtual classroom in a separate page. Please have a headset with a microphone ready if you want to speak during the workshop.</li>
                                            <li>If you haven't already installed Zoom, you will be prompted to download and install the app when you click the Join button.  If you have installed Zoom, you will have to agree to launch the program.</li>
                                        <li>If you have any sound problems, check your headset or speaker connections, test and adjust your audio settings - <a href="/joining-webinars-and-drop-in-workshops/#zoom-settings" target="_blank">instructions here</a>, or close and re-enter the session.</li>
                                        </ul>
                                    <?php if ( is_user_logged_in() ): ?>
                                        <p>Session url: <?php esc_url(the_field('synchronous_link')); ?>.</p>
                                    <?php endif; ?><!--endif user is logged in-->
												
                                    <?php endif; ?><!--endif is today's date-->
                                    </div>
                                <?php endif; ?><!--endif has $livesession-->
                                
                                <?php 
                                // EO BigBlueButton Meeting room link and instructions
								$livebbbsession = get_field('bbb_meeting');
                                if ( is_array( $livebbbsession ) && in_array('yes', $livebbbsession)): ?>
                                    <div class="cf" itemprop="workshopSynchronous">
                                        <?php 
                                            $eventDate = tribe_get_start_date( null, false, 'Y-m-d' );
                                            
                                            // from http://stackoverflow.com/questions/8006692/get-current-date-given-a-timezone-in-php
                                            $datehere = new DateTime("now", new DateTimeZone('America/Winnipeg'));
                                            $todayDate = $datehere->format('Y-m-d');
                                        
                                            if( $todayDate === $eventDate ): //only shows 'Join' on day of event
                                                //only for logged in users ?>

                                            <?php if ( is_user_logged_in() ): ?>
                                        
                                            <?php $recordedbbbsession = get_field('bbb_meeting_recorded');
                                            if ( is_array( $recordedbbbsession ) && in_array('yes', $recordedbbbsession)): ?>
                                                <p><?php echo do_shortcode('[bigbluebutton token="b38c0d54f6f2"]'); ?></p>
                                            <?php elseif ( is_array( $recordedbbbsession ) && in_array('outreach', $recordedbbbsession)): ?>
                                                <p><?php echo do_shortcode('[bigbluebutton token="cf72414bc056"]'); ?></p>
                                        
                                        <?php else : ?>
                                                
                                                <p><?php echo do_shortcode('[bigbluebutton token="2363d792a045"]'); ?></p>
                                                <!-- this bigbluebutton token is from the list of meeting rooms, details found in Dashboard > Settings > BigBlueButton. 2363d792a045 for drop-in workshops, cf72414bc056 for outreach sessions, and b38c0d54f6f2 for guest speakers  -->
		
                                            <?php endif; ?>
                                        
                                            <div class="standout-block">		
                                                <p>We are using BigBlueButton to deliver this event. You will need a computer with internet access and a headset with a microphone.</p>

                                                <ul><li>Click on the "Join Event" button above to open the virtual classroom. Please have a headset with a microphone ready if you want to speak during the workshop.</li>
                                                    <li>The virtual meeting will load in this window. When you log out of the virtual meeting, you will be returned to this page on livelearn.ca.</li>

                                                <li>You can test your setup ahead of time - instructions are on our <a href="/joining-events-with-bigbluebutton/" target="_blank">"Joining Events with BigBlueButton"</a> page.</li>
                                                </ul>
                                            </div>
                                            
                                                    
                                        <?php else: ?> <!--else if user not logged in-->

                                            <p><a href="<?php echo wp_login_url( get_permalink() ); ?>" class="blue-btn join-synchronous">Log in to join</a></p>

                                        <p class="clear">Please log in to join live sessions. If you are not yet registered with us, <a href="<?php echo home_url(); ?>/register" title="Register">find out how to register</a>.</p>
                                        <div class="standout-block">		
                                            <p>We are using BigBlueButton to deliver this event. You will need a computer with internet access and a headset with a microphone.</p>

                                            <ul><li>Login to access the "Join Event" button.</li>
                                                <li>Please have a headset with a microphone ready if you want to speak during the workshop.</li>
                                            <li>The virtual meeting will load in this window. When you log out of the virtual meeting, you will be returned to this page on livelearn.ca.</li>

                                            <li>You can test your setup ahead of time - instructions are on our <a href="/joining-events-with-bigbluebutton/" target="_blank">"Joining Events with BigBlueButton"</a> page.</li>
                                            </ul>
                                        </div>
                                        <?php endif; ?>  <!--endif user logged in-->

                                        
                                    <?php else: ?><!--else if not today's date-->
                                        <h3>How to Join the Session</h3>
                                        <p>We are using BigBlueButton to deliver this event. You will need a computer with internet access and a headset with a microphone.</p>

                                        <ul>
                                            <li>Login to this site on the day of the event to access the "Join Event" button.</li>
                                            <li>You can test your setup ahead of time - instructions are on our <a href="/joining-events-with-bigbluebutton/" target="_blank">"Joining Events with BigBlueButton"</a> page.</li>
                                            <li>Only on the date of the event will the "Join Event" button be visible here. Click the button to open the virtual classroom. Please have a headset with a microphone ready if you want to speak during the workshop.</li>
                                           
                                        </ul>
												
                                    <?php endif; ?><!--endif is today's date-->
                                    </div>
                                <?php endif; ?><!--endif has $livebbbsession-->
                                
								<?php $skypesession = get_field('skype_session');
								if ( is_array($skypesession) && in_array('yes', $skypesession)): ?>

										<h3>How to join the Skype sessions</h3>
										<ul>
											<li>Log in</li>
											<li>Scroll down and add the eFacilitator to your contacts on Skype</li>
											<li>Send a message to the eFacilitator to say you will attend a virtual coffee chat. Send a message each week to declare your availability.</li>
											<li>Test your computer well BEFORE the live meeting on Skype</li>
											<li>The eFacilitator will start a group Skype call</li>
										</ul>
									<?php endif; ?>
								<?php
										$facilitator = get_field('efacilitator');
										if( $facilitator ): ?>
										<div class="cf" itemprop="workshopContact">
											
											<?php echo '<h2>e-Facilitator</h2>'; ?>
											<?php if ( is_user_logged_in() ):
											foreach($facilitator as $facilitate) { ?>
												
												<div class="m-all t-all d-all">
													
													<div class="profile-avatar">
														<?php echo $facilitate['user_avatar']; ?>
													</div>
													
													<div class="profile-details">
														<?php echo '<strong>Name: </strong>' . esc_html($facilitate['user_firstname']) . ' ' . esc_html($facilitate['user_lastname']) . '<br><strong>Email:</strong> <a href="mailto:' . antispambot($facilitate['user_email']) . '">' . antispambot($facilitate['user_email']) . '</a>'; ?>
														<?php echo '<p>' . esc_html($facilitate['user_description']) . '</p>' ;?>
													</div>
													
												</div>
												
											<?php }
											endif; // end if is_user_logged_in
											
											if ( ! is_user_logged_in() ): ?>
												<p>Please <a href="<?php echo wp_login_url( get_permalink() ); ?>">login</a> to view e-facilitator contact information.</p>
											<?php endif; ?>
											
										</div><!-- end article-section .e-facilitator -->
										<?php endif; ?><!--  end if $facilitator  -->

                                <!-- end EO custom fields 'Event Links' -->

							</div>
                            <div class="after-event">
                                <!-- .tribe-events-single-event-description -->
                                <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

                                <!-- Event meta -->
                                <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
                                <?php
                                /**
                                 * The tribe_events_single_event_meta() function has been deprecated and has been
                                 * left in place only to help customers with existing meta factory customizations
                                 * to transition: if you are one of those users, please review the new meta templates
                                 * and make the switch!
                                 */
                                if ( ! apply_filters( 'tribe_events_single_event_meta_legacy_mode', false ) ) {
                                    tribe_get_template_part( 'modules/meta' );
                                } else {
                                    echo tribe_events_single_event_meta();
                                }
                                ?>
                                <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
						  </div>
						<?php if ( get_post_type() == TribeEvents::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
					<?php endwhile; ?>
                        </section>
				
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
                            </div><!-- #tribe-events-footer -->
                        </footer>

				    </div> <!-- #post-x -->
			</article><!-- end .hentry -->
		</main>
		<aside class="m-all t-1of4 d-1of4 cf">
			<?php get_sidebar( 'events' ); ?>
		</aside>
	</div><!-- end #inner-content-->
</div><!-- end #content-->
