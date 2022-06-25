			<div id="footer-area">
				<footer id="colophon" class="site-footer" role="contentinfo">
			      <div class="site-info container">
			        <div class="row">
	                	<div class="copyright col-md-12">
								<?php wp_nav_menu(array(
			    					'menu' => __( 'Footer Links', 'voce' ),   // nav name
			    					'menu_class' => 'same-row',            // adding custom nav class
			    					'theme_location' => 'footer-links',             // where it's located in the theme
			    					'depth' => 0,                                   // limit the depth of the nav
								)); ?>
		                    <span class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</span><br />
		                    <?php esc_html_e('Voce theme by&nbsp;','voce'); ?><a href="https://limbenjamin.com"><?php esc_html_e('limbenjamin', 'voce');?></a>.<?php esc_html_e('&nbsp;Powered by&nbsp;','voce'); ?><a href="https://wordpress.org"><?php esc_html_e('WordPress', 'voce');?></a>. 
		                </div>
			        </div>
			      </div><!-- .site-info -->
			      <div class="scroll-to-top" style="display: none;"><i class="fa fa-angle-up"></i></div><!-- .scroll-to-top -->
			    </footer>
			</div>
		</div>

		<?php // all js scripts are loaded in library/voce.php ?>

		<?php wp_footer(); ?>

	</body>

</html> <!-- end of site. what a ride! -->
