<!doctype html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- title tag is added by Wordpress, enabled in functions.php -->
        
        <?php if (is_page('Finduser') || is_page_template('Admin only') || is_page_template('Hidden')) { echo '<meta name="robots" content="noindex,nofollow">'; } ?>
        
		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <!-- Bing Webmaster validation -->
        <meta name="msvalidate.01" content="546BB48CEBAB6F6812A9F1D23EAEB6DB" />
        
		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
            <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
        <?php wp_enqueue_script("jquery"); ?>
		
		<?php // end of wordpress head ?>
		<meta name="google-translate-customization" content="d41921589db3bcb-17f43b308daaa353-gac55f61cf1292b68-12">
		<?php // Google analytics script ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		      
			ga('create', 'UA-61352141-1', 'auto');
			ga('send', 'pageview');
		      
		</script>
		<?php // end analytics ?>
        <style type="text/css"> 
            @media print {
                .article-header h1 {
                    margin-right: 150px;
                    margin-bottom: 50px;
                    line-height: 1.2;
                }
               .article-header h1:after {
                  content: url(https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl=http://thenewcode.com/613/Create-A-SilkScreen-Effect&choe=UTF-8);
                  position: absolute;
                  right: 0;
                  top: 0;
                   display: block;
                   width: 150px;
                   height: 150px;
                   background: white;
               }
            }
        </style>
        <?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
        

		<div class="content-wrap-mobile" id="container-mobile"></div>
		<div class="content-wrap" id="container">

			<header class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
                <span style="display: none;">Live &amp; Learn</span>
                <a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to page content', 'bonestheme' ); ?></a> <!--Accessibility feature-->
                <div class="project-links"><!-- top nav bar -->
                    <div class="wrap cf">
                        <a class="eo-parent m-3of7" href="http://myenglishonline.ca" title="English Online website" target="_blank">English Online</a>
                        <div class="m-4of7 t-1of2 last-col user-links cf">
                            <?php if ( is_user_logged_in() ): ?>
                            <?php $current_user = wp_get_current_user(); ?>

                            <span id="profile-toggle">
                                    <span class="poptrigger">Hi, <?php echo $current_user->user_firstname; ?></span>
                                    <ul class="sub-menu popup">
                                        <li><a href="<?php echo home_url(); ?>/profile" title="My Learning Activities">My Activities</a></li>
                                        <li><a href="<?php echo home_url(); ?>/my-articles" title="My Bookmarked Articles">My Articles</a></li>
                                        <li><a href="<?php echo bbp_get_user_profile_url( get_current_user_id() ); ?>subscriptions" title="My Forum Discussions">My Discussions</a></li>
                                        <li><a href="<?php echo bbp_get_user_profile_url( get_current_user_id() ); ?>edit" >Edit Profile</a></li>
                                    </ul>
                            </span>
                            <a id="logout" class="logout" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Learner Logout">Logout</a>
                            <?php else: ?> <!--if user is not logged in-->

                                <a class="register" href="<?php echo home_url(); ?>/register" title="Registration Information">Register</a>
                                <a id="login" class="login" href="<?php echo wp_login_url( get_permalink() ); ?>" title="Learner Login">Login</a>

                            <?php endif; ?><!--end if user is logged in or not-->
                        </div> <!--end .m-1of2 last-col-->
                    </div>
                </div><!-- end .project-links, top nav bar -->
                
				<div id="inner-header" class="wrap cf">
					<div class="site-identity m-all t-1of2 d-1of3">
						<h1 id="logo" class="h1" itemscope itemtype="http://schema.org/Organization">
							
							<a href="<?php echo home_url(); ?>" rel="nofollow" title="Live &amp; Learn homepage">
                                <img class="svgimg" src="<?php echo get_template_directory_uri(); ?>/library/images/eo-livelearn-light.svg" alt="Live &amp; Learn from English Online">
                                <img style="display:none;" class="no-svgimg" src="<?php echo get_template_directory_uri(); ?>/library/images/eo-livelearn-light300.png" alt="Live &amp; Learn from English Online">
							</a>
                            
						</h1><!-- end .site-identity-->
	
						<p id="site-tagline" class="site-tagline"><?php bloginfo('description'); ?></p>
					</div>
                    <noscript style="color: white;">To use all the features of this site, please enable Javascript. If you can't, you can access the different areas and pages of the site using the Footer Menu, but may not be able to take advantage of some site features.</noscript>
                    <div class="header-links m-all t-1of2 d-1of3 last-col">
                        
                            
						<button class="header-link search-toggle" title="Open Search form" aria-owns="search-container" aria-haspopup="true" aria-expanded="false">Search</button> <!-- triggers shorter header for search bar only -->
                            
                        <button id="live-trigger" class="header-link menu-toggle live" aria-owns="settlement-menu" aria-haspopup="true" aria-expanded="false">Live</button>
                        <button id="learn-trigger" class="header-link menu-toggle learn" aria-owns="learner-menu" aria-haspopup="true" aria-expanded="false">Learn</button>
                        <button id="calendar" class="header-link menu-toggle calendar" aria-owns="events-menu" aria-haspopup="true" aria-expanded="false">Events</button>
						<button class="header-link menu-toggle more" aria-owns="supporting-menu" aria-haspopup="true" aria-expanded="false">More</button>
					</div>
					<div id="search-container" class="search-box m-all cf">
						<?php get_search_form();?>
					</div>

					<nav id="settlement-menu" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" class="primary-navigation">
						<?php wp_nav_menu(array(
						'container' => false,                           // remove nav container
						'container_class' => 'menu cf',                 // class of container (should you choose to use it)
						'menu' => __( 'Settlement Menu', 'bonestheme' ),  // nav name
						'menu_class' => 'nav-menu settlement-nav cf',               // adding custom nav class
						'theme_location' => 'settlement-nav',                 // where it's located in the theme
						)); ?>

					</nav>

					<nav id="learner-menu" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" class="primary-navigation">
						<?php wp_nav_menu(array(
						'container' => false,                           // remove nav container
						'container_class' => 'menu cf',                 // class of container (should you choose to use it)
						'menu' => __( 'Learner Menu', 'bonestheme' ),  // nav name
						'menu_class' => 'nav-menu learner-nav cf',               // adding custom nav class
						'theme_location' => 'learner-nav',                 // where it's located in the theme
						)); ?>

					</nav>

					<nav id="events-menu" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" class="primary-navigation">
						<?php wp_nav_menu(array(
						'container' => false,                           // remove nav container
						'container_class' => 'menu cf',                 // class of container (should you choose to use it)
						'menu' => __( 'Events Menu', 'bonestheme' ),  // nav name
						'menu_class' => 'nav-menu events-nav cf',               // adding custom nav class
						'theme_location' => 'events-nav',                 // where it's located in the theme
						)); ?>

					</nav>

					<nav id="supporting-menu" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" class="primary-navigation">
						<?php wp_nav_menu(array(
						'container' => false,                           // remove nav container
						'container_class' => 'menu cf',                 // class of container (should you choose to use it)
						'menu' => __( 'Supporting Pages Menu', 'bonestheme' ),  // nav name
						'menu_class' => 'nav-menu supporting-nav cf',               // adding custom nav class
						'theme_location' => 'supporting-nav',                 // where it's located in the theme
						)); ?>
						<ul class="nav-menu social-media">
							<li><a href="https://twitter.com/englishonlinemb" target="_blank" class="twitter" title="Follow us on Twitter">Twitter</a></li>
							<li><a href="https://www.facebook.com/myEnglishOnlineMB" target="_blank" class="facebook" title="Follow us on Facebook">Facebook</a></li>
							<li><a href="https://www.youtube.com/user/myenglishonline" target="_blank" class="youtube" title="Subscribe to our YouTube channel">YouTube</a></li>
							
						</ul>
					</nav>
					
                    <a title="Close All" id="closemenu">Close</a>
				</div>
                

			</header>
                
				<?php
                    $classes = get_body_class();
                    if (in_array('home',$classes)) {
                        if ( is_user_logged_in() ): ?>
                            <?php if( get_field('important_notice') ): ?>
                                <div class="important-notice cf clear">
                                    <p><?php echo the_field('important_notice'); ?></p>
                                    <?php if( get_field('important_action') && get_field('action_text') ): ?>
                                            <p><a id="important-action" class="orange-btn" href="<?php echo the_field('important_action'); ?>" target="_blank" title="<?php echo the_field('important_action'); ?>"><?php echo the_field('action_text'); ?></a></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                    <?php endif;
                    }
                ?>
                