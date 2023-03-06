<?php get_header(); ?>
	<div class="fullwidth-template">
		<div id="main-content">	
			<div id="primary" class="site-content">
				<article>
					<h1 class="heading-font-1"><?php esc_html_e('404', 'gostore'); ?></h1>
					<h3 class="heading-font-2"><?php esc_html_e('Page Not Found', 'gostore'); ?></h3>
					<p class="ts-description-2"><?php esc_html_e('It looks like nothing was found at this location. Try another link or click the button below.', 'gostore'); ?></p>
					<?php if( $referer = wp_get_referer() ): ?>
					<a href="<?php echo esc_url( $referer ) ?>" class="button"><?php esc_html_e('Go Back', 'gostore'); ?></a>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url('/') ) ?>" class="button"><?php esc_html_e('Homepage', 'gostore'); ?></a>
				</article>
			</div>
		</div>
	</div>
<?php
get_footer();