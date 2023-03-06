<?php
$gostore_theme_options = gostore_get_theme_options();

$header_classes = array();
if( $gostore_theme_options['ts_enable_sticky_header'] ){
	$header_classes[] = 'has-sticky';
}

if( !$gostore_theme_options['ts_enable_tiny_shopping_cart'] ){
	$header_classes[] = 'hidden-cart';
}

if( !$gostore_theme_options['ts_enable_tiny_wishlist'] || !class_exists('WooCommerce') || !class_exists('YITH_WCWL') ){
	$header_classes[] = 'hidden-wishlist';
}

if( !$gostore_theme_options['ts_header_currency'] ){
	$header_classes[] = 'hidden-currency';
}

if( !$gostore_theme_options['ts_header_language'] ){
	$header_classes[] = 'hidden-language';
}

if( !$gostore_theme_options['ts_enable_search'] ){
	$header_classes[] = 'hidden-search';
}
?>

<div id="vertical-menu-sidebar" class="menu-wrapper">
	<div class="overlay"></div>
	<div class="vertical-menu-content">
		<span class="close"></span>
		<div class="ts-menu">
			<?php 
			if ( has_nav_menu( 'vertical' ) ) {
			?>
			
			<h3 class="theme-title"><?php echo gostore_get_vertical_menu_heading(); ?></h3>
			
			<div class="vertical-menu-wrapper">
				<?php
				wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'vertical-menu pc-menu ts-mega-menu-wrapper','theme_location' => 'vertical','walker' => new GoStore_Walker_Nav_Menu() ) );
				?>
			</div>
			<?php
			}
			?>
		</div>	
	</div>
</div>

<header class="ts-header <?php echo esc_attr(implode(' ', $header_classes)); ?>">
	<div class="header-container">
		<div class="header-template">
		
			<div class="header-sticky">
			
				<div class="header-middle">
					
					<div class="container">
					
						<div class="ts-mobile-icon-toggle">
							<span class="icon"></span>
						</div>
						
						<div class="logo-wrapper hidden-phone"><?php gostore_theme_logo(); ?></div>
						
						<div class="icon-menu-sticky-header hidden-phone">
							<span class="icon"></span>
						</div>
						
						<?php if( $gostore_theme_options['ts_enable_search'] ): ?>
						<div class="search-wrapper"><?php gostore_get_search_form_by_category(); ?></div>
						<?php endif; ?>
						
						<div class="header-right">
							<?php if( $gostore_theme_options['ts_enable_tiny_shopping_cart'] ): ?>					
							<div class="shopping-cart-wrapper">
								<?php echo gostore_tiny_cart(); ?>
							</div>
							<?php endif; ?>
							
							<?php if( class_exists('YITH_WCWL') && $gostore_theme_options['ts_enable_tiny_wishlist'] ): ?>
							<div class="my-wishlist-wrapper hidden-phone"><?php echo gostore_tini_wishlist(); ?></div>
							<?php endif; ?>
							
							<?php if( $gostore_theme_options['ts_enable_tiny_account'] ): ?>
							<div class="my-account-wrapper hidden-phone">
								<?php echo gostore_tiny_account(); ?>
							</div>
							<?php endif; ?>
							
							<?php if( $gostore_theme_options['ts_header_currency'] ): ?>
							<div class="header-currency hidden-phone"><?php gostore_woocommerce_multilingual_currency_switcher(); ?></div>
							<?php endif; ?>
							
							<?php if( $gostore_theme_options['ts_header_language'] ): ?>
							<div class="header-language hidden-phone"><?php gostore_wpml_language_selector(); ?></div>
							<?php endif; ?>
						</div>
						
					</div>
					
				</div>
				
				<div class="header-bottom hidden-phone">
					<div class="container">
					
						<div class="menu-wrapper">
							
							<?php if ( has_nav_menu( 'vertical' ) ):?>			
							<span class="vertical-menu-button"></span>
							<?php endif; ?>
							
							<div class="ts-menu">
								<?php 
									if ( has_nav_menu( 'primary' ) ) {
										wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu pc-menu ts-mega-menu-wrapper','theme_location' => 'primary','walker' => new GoStore_Walker_Nav_Menu() ) );
									}
									else{
										wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu pc-menu ts-mega-menu-wrapper' ) );
									}
								?>
							</div>
							
						</div>
						
						<?php if( $gostore_theme_options['ts_header_info'] ): ?>
						<div class="info"><?php echo do_shortcode(stripslashes($gostore_theme_options['ts_header_info'])); ?></div>
						<?php endif; ?>
						
						<?php gostore_header_recently_viewed_products(); ?>
						
					</div>
				</div>
				
			</div>

			<div class="logo-wrapper visible-phone"><?php gostore_theme_logo(); ?></div>			
			
		</div>	
	</div>
</header>