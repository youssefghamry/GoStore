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
						
						<?php if( $gostore_theme_options['ts_header_feature_text_1'] || $gostore_theme_options['ts_header_feature_text_2'] || $gostore_theme_options['ts_header_feature_text_3'] ): ?>
						<div class="header-right-2 visible-ipad">
							<div class="right-content">
								<?php for( $i = 1 ; $i <= 3; $i++ ){
									if( !empty($gostore_theme_options['ts_header_feature_text_' . $i]) ){
									?>
										<div>
											<a href="<?php echo esc_url($gostore_theme_options['ts_header_feature_link_' . $i]); ?>">
												<?php if( $gostore_theme_options['ts_header_feature_icon_' . $i]['url'] ){ ?>
												<span><img src="<?php echo esc_url($gostore_theme_options['ts_header_feature_icon_' . $i]['url']); ?>" alt="<?php echo esc_attr($gostore_theme_options['ts_header_feature_text_' . $i]); ?>" /></span>
												<?php } ?>
												<span><?php echo wp_kses($gostore_theme_options['ts_header_feature_text_' . $i], 'gostore_header_feature'); ?></span>
											</a>
										</div>
									<?php
									}
								}
								?>
							</div>
						</div>
						<?php endif; ?>
						
						<?php if( $gostore_theme_options['ts_enable_search'] ): ?>
						<div class="search-wrapper"><?php gostore_get_search_form_by_category(); ?></div>
						<?php endif; ?>
						
						<?php if( $gostore_theme_options['ts_enable_tiny_shopping_cart'] ): ?>
						<div class="header-right">				
							<div class="shopping-cart-wrapper mobile-cart">
								<?php echo gostore_tiny_cart(); ?>
							</div>
						</div>
						<?php endif; ?>
						
						<?php 
						$number = '0';
						for( $i = 1 ; $i <= 3; $i++ ){
							if( !empty($gostore_theme_options['ts_header_feature_text_' . $i]) ){
								$number++;
							}
						}
						
						if( $gostore_theme_options['ts_header_feature_text_1'] || $gostore_theme_options['ts_header_feature_text_2'] || $gostore_theme_options['ts_header_feature_text_3'] ): ?>
						<div class="header-right-2 hidden-phone <?php echo 'feature-'.$number ?>">
							<div class="right-content">
								<?php for( $i = 1 ; $i <= 3; $i++ ){
									if( !empty($gostore_theme_options['ts_header_feature_text_' . $i]) ){
									?>
										<div>
											<a href="<?php echo esc_url($gostore_theme_options['ts_header_feature_link_' . $i]); ?>">
												<?php if( $gostore_theme_options['ts_header_feature_icon_' . $i]['url'] ){ ?>
												<span><img src="<?php echo esc_url($gostore_theme_options['ts_header_feature_icon_' . $i]['url']); ?>" alt="<?php echo esc_attr($gostore_theme_options['ts_header_feature_text_' . $i]); ?>" /></span>
												<?php } ?>
												<span><?php echo wp_kses($gostore_theme_options['ts_header_feature_text_' . $i], 'gostore_header_feature'); ?></span>
											</a>
										</div>
									<?php
									}
								}
								?>
							</div>
						</div>
						<?php endif; ?>
					
					</div>
					
				</div>
				
				<div class="header-bottom hidden-phone">
					<div class="container">
					
						<div class="menu-wrapper">
							
							<?php 
							if ( has_nav_menu( 'vertical' ) ) {
							?>
							<div class="vertical-menu-wrapper">			
								<div class="vertical-menu-heading"><?php echo gostore_get_vertical_menu_heading(); ?></div>
								<?php
								wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'vertical-menu pc-menu ts-mega-menu-wrapper','theme_location' => 'vertical','walker' => new GoStore_Walker_Nav_Menu() ) );
								?>
							</div>
							<?php
							}
							?>
							
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
							
							<?php gostore_header_recently_viewed_products(); ?>
							
						</div>
						
					</div>
				</div>
				
			</div>

			<div class="logo-wrapper visible-phone"><?php gostore_theme_logo(); ?></div>			
			
		</div>	
	</div>
</header>