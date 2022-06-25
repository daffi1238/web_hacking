<?php get_header(); ?>

			<div id="content" class="site-content">

				<div id="inner-content" class="container main-content-area">

					<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<article id="post-not-found" class="hentry cf">

							<header class="article-header">

								<h1><?php _e( 'Error 404 - Article Not Found', 'voce' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'The article you were looking for was not found.', 'voce' ); ?></p>

								<?php get_search_form(); ?>

							</section>


						</article>

					</main>

				</div>

			</div>

<?php get_footer(); ?>
