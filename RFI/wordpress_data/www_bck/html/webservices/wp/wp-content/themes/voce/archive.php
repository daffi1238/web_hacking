<?php get_header(); ?>


			<div id="content" class="site-content">

				<div id="inner-content" class="container main-content-area">
					<?php
						the_archive_title( '<h3 class="page-title">', '</h3>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
						<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">


							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article class="post">
								<div class="blog-item-wrap">
									<div class="post-inner-content">
										<header class="entry-header page-header">
											<span class="cat-item"><time datetime="{{ article.date }}"><?php printf( ' %1$s %2$s',
                       								'<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
                       								'<span class="by">'.'</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_time(get_option('date_format') ) . '</span>'
                    							); ?></time></span>
											<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
										</header><!-- .entry-header -->
										<div class="entry-content">
											<?php the_excerpt(); ?>
							        	</div><!-- .entry-content -->
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
									</article>

							<?php endif; ?>

						</main>

				</div>

			</div>
<div id="paginator">
	<?php the_posts_pagination( array(
    'mid_size' => 2,
    'prev_text' => __( 'Prev <i class="fa fa-arrow-circle-left"></i>', 'voce' ),
    'next_text' => __( 'Next <i class="fa fa-arrow-circle-right"></i>', 'voce' ),
) ); ?>

</div>
<?php get_footer(); ?>
