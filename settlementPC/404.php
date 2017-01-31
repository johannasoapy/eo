<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

                    <main id="main" class="m-all t-3of4 d-3of4 last-col cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<article id="post-not-found" class="hentry type-post cf">

							<header class="article-header">

								<h1><?php _e( '404: Sorry, we couldn&rsquo;t find this page', 'bonestheme' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'The content you were looking for was not found. Try the header, footer, or sidebar links, <a href="/">return to the homepage</a>, check our <a href="/articles-index">Articles Index</a> page for a full list of article titles or our <a href="/activities-index">Activities Index</a> page for a full list of activities and lessons, or search other terms here.', 'bonestheme' ); ?></p>
								<p><?php get_search_form(); ?></p>

							</section>

							<footer class="article-footer">
                                <p>Thank you for your patience!</p>

							</footer>

						</article>

					</main>

					<aside class="m-all t-1of4 d-1of4 cf">
						<?php get_sidebar(); ?>
					</aside>

				</div>

			</div>

<?php get_footer(); ?>
