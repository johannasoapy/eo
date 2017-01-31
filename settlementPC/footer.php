			<footer class="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
				<div class="footer-top">
				    <div class="wrap">
					<p class="cic-brand"><a href="http://www.cic.gc.ca/english/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/library/images/cic-logo.png" alt="Citizenship and Immigration Canada Logo"></a></p>
				    </div>
				</div>
				<div id="inner-footer" class="inner-footer wrap clear">
                    <div class="translate-group">
                        <h5>Translate</h5>

                        <!-- Google Translate button -->
                        <div class="translate-not-ie"><p style="margin-bottom:0;">Google Translate

                            <div id="google_translate_element"></div><script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({pageLanguage: 'en', gaTrack: true, gaId: 'UA-61352141-1'}, 'google_translate_element');
    }
    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                            </p>
                        </div><!-- end .ie-recommended -->

                        <!-- Bing Translate button -->
                        <div class="translate-ie"><p style="margin-bottom:0;">Bing (recommended for IE)
                        <div id='MicrosoftTranslatorWidget' class='Light' style='color:white;background-color:#555555' title='Click to select language'></div><script type='text/javascript'>setTimeout(function(){{var s=document.createElement('script');s.type='text/javascript';s.charset='UTF-8';s.src=((location && location.href && location.href.indexOf('https') == 0)?'https://ssl.microsofttranslator.com':'http://www.microsofttranslator.com')+'/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**&ctf=False&ui=true&settings=Manual&from=en';var p=document.getElementsByTagName('head')[0]||document.documentElement;p.insertBefore(s,p.firstChild); }},0);</script>
                            </p>
                        </div><!-- end .ie-recommended -->
                        <!-- Bing Translate button -->
                        <p>
                            Google Translate and Bing are third party providers. English Online is not responsible for inaccurate translations. Read the full <a href="/language-translation-disclaimer"><strong>Language Translation Disclaimer</strong></a>.
                        </p>
                    </div>
					<h5>Menu</h5>
					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => 'div',                           // enter '' to remove nav container (just make sure .footer-links in _base.scss isn't wrapping)
    					'container_class' => 'footer-links cf',         // class of container (should you choose to use it)
    					'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    					'menu_class' => 'nav footer-nav cf',            // adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
    					'after' => '',                                  // after the menu
    					'link_before' => '',                            // before each link
    					'link_after' => '',                             // after each link
    					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
						)); ?>
					</nav>
                    <ul class="nav-menu social-media">
							<li><a href="https://twitter.com/englishonlinemb" target="_blank" class="twitter" title="Follow us on Twitter">Twitter</a></li>
							<li><a href="https://www.facebook.com/myEnglishOnlineMB" target="_blank" class="facebook" title="Follow us on Facebook">Facebook</a></li>
							<li><a href="https://www.youtube.com/user/myenglishonline" target="_blank" class="youtube" title="Subscribe to our YouTube channel">YouTube</a></li>
						</ul>
                        <a class="rss-subscribe orange-btn" href="<?php esc_url( bloginfo('rss2_url') ); ?>" target="_blank" title="Live & Learn RSS feed">RSS</a>

                                                    
                                                
					<?php if ( current_user_can( 'edit_posts' ) ) { ?>
						<a class="clear" href="/eo-staff-how-to">EO Staff: How to...</a>
					<?php } ?>
				</div>
				
				<div class="footer-bottom wrap clear">
					<p class="eo-brand m-all t-1of2 d-1of2"><a href="http://myenglishonline.ca" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/library/images/eo-logo-lg.png" alt="English Online Logo"></a> Live &amp; Learn is an <a href="http://myenglishonline.ca" target="_blank">English Online Inc.</a> project.</p>
					<p class="source-org copyright m-all t-1of2 d-1of2 last-col">&copy; <?php echo date('Y'); ?> English Online Inc. &nbsp;&nbsp;<a href="<?php echo home_url(); ?>/copyright" target="_blank">Additional Copyright Information</a>
				</div>
			</footer>

		</div> <!--end .content-wrap #container-->

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

</html> <!-- end of site. what a ride! -->