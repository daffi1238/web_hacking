<?php get_header(); ?>

			<div id="content" class="site-content">

				<div id="inner-content" class="container main-content-area">

					<main id="main" class="m-all t-2of3 d-5of7 cf" role="main">
						<h1 class="archive-title"><span><?php _e( 'Search Results for:', 'voce' ); ?></span> <?php echo get_search_query(); ?></h1>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="entry-header article-header">

									<h3 class="search-title entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

                  						<p class="byline entry-meta vcard">
                    							<?php printf( __( 'Posted %1$s by %2$s', 'voce' ),
                   							    /* the time the post was published */
                   							    '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
                      							    /* the author of the post */
                       							    '<span class="by">by</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>'
                    							); ?>
                  						</p>

								</header>

								<section class="entry-content">
										<?php the_excerpt( '<span class="read-more">' . __( 'Read more &raquo;', 'voce' ) . '</span>' ); ?>

								</section>

								<footer class="article-footer">

									<?php if(get_the_category_list(', ') != ''): ?>
                  					<?php printf( __( 'Filed under: %1$s', 'voce' ), get_the_category_list(', ') ); ?>
                  					<?php endif; ?>

								</footer> <!-- end article footer -->

							</article>
							<br /><br />

						<?php endwhile; ?>

								<div id="paginator">
									<?php the_posts_pagination( array(
								    'mid_size' => 2,
								    'prev_text' => __( 'Prev <i class="fa fa-arrow-circle-left"></i>', 'voce' ),
								    'next_text' => __( 'Next <i class="fa fa-arrow-circle-right"></i>', 'voce' ),
								) ); ?>

								</div>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Sorry, No Results.', 'voce' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Try your search again.', 'voce' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the search.php template.', 'voce' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>

					</div>

			</div>

<?php get_footer(); ?>
