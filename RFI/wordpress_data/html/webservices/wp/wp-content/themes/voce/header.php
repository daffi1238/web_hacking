<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">


		<?php // mobile meta (hooray!) ?>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

		<div id="container">

			    <header class="site-header">
			      <nav class="navbar navbar-default" role="navigation">
			        <div class="container">
			          <div class="row">
			            <div class="site-navigation-inner col-sm-12">
			              <div class="navbar-header">
			                <button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			                  <span class="sr-only"><?php _e( 'Toggle navigation', 'voce' ); ?></span>
			                  <span class="icon-bar"></span>
			                  <span class="icon-bar"></span>
			                  <span class="icon-bar"></span>
			                </button>
			              </div>
			              <div class="collapse navbar-collapse navbar-ex1-collapse">
							<?php wp_nav_menu(array(
								'container' => false,                           // remove nav container
								'menu' => __( 'The Main Menu', 'voce' ),  		// nav name
								'menu_id' => 'menu-all-pages',
								'menu_class' => 'nav navbar-nav',               // adding custom nav class
								'theme_location' => 'main-nav',                 // where it's located in the theme
								'depth' => 1,                                   // limit the depth of the nav
								'fallback_cb' => 'none'                 // fallback function (if there is one)
							)); ?>
			              </div>
			              <div class="social">
			              		<?php if (esc_url(get_theme_mod('voce_social_icon_6_link')) && esc_url(get_theme_mod('voce_social_icon_6_link')) != "<empty>"): ?>   
									<a href="<?php echo esc_url(get_theme_mod('voce_social_icon_6_link')); ?>"><i class="fa <?php echo sanitize_html_class(get_theme_mod('voce_social_icon_6')); ?> fa-lg"></i></a>
								<?php endif; ?>
								<?php if (esc_url(get_theme_mod('voce_social_icon_5_link')) && esc_url(get_theme_mod('voce_social_icon_5_link')) != "<empty>"): ?>
									<a href="<?php echo esc_url(get_theme_mod('voce_social_icon_5_link')); ?>"><i class="fa <?php echo sanitize_html_class(get_theme_mod('voce_social_icon_5')); ?> fa-lg"></i></a>
								<?php endif; ?>
								<?php if (esc_url(get_theme_mod('voce_social_icon_4_link')) && esc_url(get_theme_mod('voce_social_icon_4_link')) != "<empty>"): ?>	
									<a href="<?php echo esc_url(get_theme_mod('voce_social_icon_4_link')); ?>"><i class="fa <?php echo sanitize_html_class(get_theme_mod('voce_social_icon_4')); ?> fa-lg"></i></a>
								<?php endif; ?>
								<?php if (esc_url(get_theme_mod('voce_social_icon_3_link')) && esc_url(get_theme_mod('voce_social_icon_3_link')) != "<empty>"): ?>	
									<a href="<?php echo esc_url(get_theme_mod('voce_social_icon_3_link')); ?>"><i class="fa <?php echo sanitize_html_class(get_theme_mod('voce_social_icon_3')); ?> fa-lg"></i></a>
								<?php endif; ?>
								<?php if (esc_url(get_theme_mod('voce_social_icon_2_link')) && esc_url(get_theme_mod('voce_social_icon_2_link')) != "<empty>"): ?>	
									<a href="<?php echo esc_url(get_theme_mod('voce_social_icon_2_link')); ?>"><i class="fa <?php echo sanitize_html_class(get_theme_mod('voce_social_icon_2')); ?> fa-lg"></i></a>
								<?php endif; ?>
								<?php if (esc_url(get_theme_mod('voce_social_icon_1_link')) && esc_url(get_theme_mod('voce_social_icon_1_link')) != "<empty>"): ?>	
									<a href="<?php echo esc_url(get_theme_mod('voce_social_icon_1_link')); ?>"><i class="fa <?php echo sanitize_html_class(get_theme_mod('voce_social_icon_1')); ?> fa-lg"></i></a>
								<?php endif; ?>
			              </div>
			            </div>
			          </div>
			        </div>
			      </nav><!-- .site-navigation -->

			    <div class="container">
			      <div id="logo">
			        <span class="site-name"><a class="navbar-brand" href="<?php echo esc_url(home_url( '/' )) ?>">
			        	<?php if (get_theme_mod( 'custom_logo' )): ?>
			        		<img src="<?php $custom_logo_id = get_theme_mod( 'custom_logo' ); $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); echo $image[0]; ?>" class="attachment-full size-full">
			        	<?php else: ?>
			        		<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>
			        	<?php endif; ?>
			        	</a>
			        </span><!-- end of .site-name -->
			      </div><!-- end of #logo -->
			        <ul class="catlist">
			            <?php wp_list_categories(array(
			            		'depth' => 1,  
			            		'show_count' => 'yes',
			            		'separator' => '|',
			            		'title_li' => '',
							)); ?>
			        </ul>
			    </div>

			  </header><!-- #masthead -->
