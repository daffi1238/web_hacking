<?php get_header(); ?>

			<div id="content" class="site-content">

				<div id="inner-content" class="container main-content-area">

					<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			              	<article class="post">
								<div class="blog-item-wrap">
									<div class="post-inner-content">
										<header class="entry-header page-header">
											<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
										</header><!-- .entry-header -->
										<div class="entry-content">
											<?php the_content(); ?>
							        	</div><!-- .entry-content -->
							        	<br />
							        	<?php wp_link_pages(); ?>
							        	<br />
							        	<?php comments_template(); ?>	
								    </div>
								</div>
							</article><!-- #post-## -->


						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'voce' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'voce' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'voce' ); ?></p>
									</footer>
							</article>

						<?php endif; ?>

					</main>

				</div>

			</div>

<?php get_footer(); ?>
