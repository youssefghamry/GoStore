<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php 
	$gostore_theme_options = gostore_get_theme_options();
	?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />

	<link rel="profile" href="//gmpg.org/xfn/11" />
	<?php 
	gostore_theme_favicon();
	wp_head(); 
	?>
</head>
<body <?php body_class(); ?>>
<?php
if( function_exists('wp_body_open') ){
	wp_body_open();
}
?>

<!-- Group Header Button -->
<div id="group-icon-header" class="ts-floating-sidebar">
	<div class="overlay"></div>
	<div class="ts-sidebar-content <?php echo has_nav_menu( 'vertical' )?'':'no-tab'; ?>">
		
		<div class="sidebar-content">
			<ul class="tab-mobile-menu">
				<li id="main-menu" class="active"><span><?php esc_html_e('Main Menu', 'gostore'); ?></span></li>
				<li id="vertical-menu"><span><?php echo gostore_get_vertical_menu_heading(); ?></span></li>
			</ul>
			
			<h6 class="menu-title"><span><?php esc_html_e('Main Menu', 'gostore'); ?></span></h6>
			
			<div class="mobile-menu-wrapper ts-menu tab-menu-mobile">
				<?php 
				if( has_nav_menu( 'mobile' ) ){
						wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu', 'theme_location' => 'mobile', 'walker' => new GoStore_Walker_Nav_Menu() ) );
					}else if( has_nav_menu( 'primary' ) ){
						wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu', 'theme_location' => 'primary', 'walker' => new GoStore_Walker_Nav_Menu() ) );
					}
					else{
						wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu' ) );
					}
				?>
			</div>
			
			<?php if( has_nav_menu( 'vertical' ) ){ ?>
			<div class="mobile-menu-wrapper ts-menu tab-vertical-menu">
				<?php
				wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'vertical-menu pc-menu ts-mega-menu-wrapper','theme_location' => 'vertical', 'walker' => new GoStore_Walker_Nav_Menu() ) );
				?>
			</div>
			<?php } ?>
			
			<?php if( $gostore_theme_options['ts_header_currency'] || $gostore_theme_options['ts_header_language'] ): ?>
			<div class="group-button-header">
				
				<div class="group-bottom-1">
				
					<?php if( $gostore_theme_options['ts_header_currency'] ): ?>
					<div class="header-currency"><?php gostore_woocommerce_multilingual_currency_switcher(); ?></div>
					<?php endif; ?>
					
					<?php if( $gostore_theme_options['ts_header_language'] ): ?>
					<div class="header-language"><?php gostore_wpml_language_selector(); ?></div>
					<?php endif; ?>
					
				</div>
				
			</div>
			<?php endif; ?>
			
		</div>	
		
	</div>
	

</div>

<!-- Mobile Group Button -->
<div id="ts-mobile-button-bottom">

	<?php if( $gostore_theme_options['ts_mobile_bottom_bar_custom_content'] ): ?>
	<div class="mobile-button-custom"><?php echo do_shortcode(stripslashes($gostore_theme_options['ts_mobile_bottom_bar_custom_content'])); ?></div>
	<?php endif; ?>
	
	<div class="mobile-button-home"><a href="<?php echo esc_url( home_url('/') ) ?>"><span><?php esc_html_e('Home', 'gostore'); ?></span></a></div>
	
	<?php if( class_exists('WooCommerce') ): ?>
	<div class="mobile-button-shop"><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><span><?php esc_html_e('Shop', 'gostore'); ?></span></a></div>
	<?php endif; ?>
	
	<?php if( $gostore_theme_options['ts_enable_tiny_account'] ): ?>
	<div class="my-account-wrapper"><?php echo gostore_tiny_account( false ); ?></div>
	<?php endif; ?>

	<?php if( class_exists('YITH_WCWL') && $gostore_theme_options['ts_enable_tiny_wishlist'] ): ?>
	<div class="my-wishlist-wrapper"><?php echo gostore_tini_wishlist(); ?></div>
	<?php endif; ?>
	
</div>

<!-- Shopping Cart Floating Sidebar -->
<?php if( class_exists('WooCommerce') && $gostore_theme_options['ts_enable_tiny_shopping_cart'] && $gostore_theme_options['ts_shopping_cart_sidebar'] && !is_cart() && !is_checkout() ): ?>
<div id="ts-shopping-cart-sidebar" class="ts-floating-sidebar">
	<div class="overlay"></div>
	<div class="ts-sidebar-content">
		<span class="close"></span>
		<div class="ts-tiny-cart-wrapper"></div>
	</div>
</div>
<?php endif; ?>

<div id="page" class="hfeed site">

	<?php if( !is_page_template('page-templates/blank-page-template.php') ): ?>
	
		<?php gostore_store_notice(); ?>
		
		<!-- Page Slider -->
		<?php if( is_page() ): ?>
			<?php if( gostore_get_page_options('ts_page_slider') && gostore_get_page_options('ts_page_slider_position') == 'before_header' ): ?>
			<div class="top-slideshow">
				<div class="top-slideshow-wrapper">
					<?php gostore_show_page_slider(); ?>
				</div>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php gostore_get_header_template(); ?>
		
	<?php endif; ?>
	
	<?php do_action('gostore_before_main_content'); ?>

	<div id="main" class="wrapper">