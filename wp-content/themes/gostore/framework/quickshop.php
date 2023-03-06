<?php 
if( class_exists('WooCommerce') && !class_exists('GoStore_Quickshop') && !wp_is_mobile() ){
		
	class GoStore_Quickshop{
	
		public $id;
		
		function __construct(){
			add_action('init', array($this, 'init'));
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 2000);
		}
		
		function add_quickshop_button(){
			global $product;
			echo '<div class="button-in quickshop">';
			echo '<a class="quickshop" href="#" data-product_id="'.$product->get_id().'"><span class="ts-tooltip button-tooltip">'.esc_html__('Quick view', 'gostore').'</span></a>';
			echo '</div>';
		}
		
		function init(){
			$theme_options = gostore_get_theme_options();
			if( empty($theme_options['ts_enable_quickshop']) ){
				return;
			}
			
			add_action('wp_footer', array($this, 'add_quickshop_modal'), 999);
			
			if( $theme_options['ts_product_hover_style'] == 'hover-vertical-style-2' ){
				add_action('woocommerce_after_shop_loop_item', array($this, 'add_quickshop_button'), 80);
			}
			else{
				add_action('woocommerce_after_shop_loop_item_title', array($this, 'add_quickshop_button'), 10001);
			}
			
			/* Register ajax */
			add_action('wp_ajax_gostore_load_quickshop_content', array( $this, 'load_quickshop_content_callback') );
			add_action('wp_ajax_nopriv_gostore_load_quickshop_content', array( $this, 'load_quickshop_content_callback') );
		}
		
		function add_hooks(){
			$theme_options = gostore_get_theme_options();
			
			add_action('gostore_quickshop_single_product_summary', 'gostore_template_single_countdown_availability', 1);
			
			if( $theme_options['ts_prod_rating'] ){
				add_action('gostore_quickshop_single_product_summary', 'woocommerce_template_single_rating', 10);
			}
			
			if( $theme_options['ts_prod_title'] ){
				add_action('gostore_quickshop_single_product_summary', array($this, 'product_title'), 20);
			}
			
			if( $theme_options['ts_prod_excerpt'] ){
				add_action('gostore_quickshop_single_product_summary', 'woocommerce_template_single_excerpt', 30);
			}
			
			if( $theme_options['ts_prod_price'] ){
				add_action('gostore_quickshop_single_product_summary', 'woocommerce_template_single_price', 40);
				add_action('gostore_quickshop_single_product_summary', 'gostore_template_single_variation_price', 45);
			}
			else{
				remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
			}
			
			if( $theme_options['ts_prod_add_to_cart'] && !$theme_options['ts_enable_catalog_mode'] ){
				add_action('gostore_quickshop_single_product_summary', 'woocommerce_template_single_add_to_cart', 50); 
			}
			
			add_action('gostore_quickshop_single_product_summary', array($this, 'before_product_meta'), 59);
			
			if( $theme_options['ts_prod_sku'] ){
				add_action('gostore_quickshop_single_product_summary', 'gostore_template_single_sku', 60);
			}
			
			if( $theme_options['ts_prod_availability'] ){
				add_action('gostore_quickshop_single_product_summary', 'gostore_template_single_availability', 70);
			}
			
			add_action('gostore_quickshop_single_product_summary', array($this, 'after_product_meta'), 71);	
		}
		
		function before_product_meta(){
			echo '<div class="meta-content">';
		}
		
		function after_product_meta(){
			echo '</div>';
		}
		
		function enqueue_scripts(){
			$theme_options = gostore_get_theme_options();
			if( !empty($theme_options['ts_enable_quickshop']) ){
				wp_enqueue_script( 'flexslider' );
				wp_enqueue_script( 'wc-add-to-cart-variation' );
				if( $theme_options['ts_prod_cloudzoom'] ){
					wp_enqueue_script( 'zoom' );
				}
			}
		}
		
		function add_quickshop_modal(){
		?>
		<div id="ts-quickshop-modal" class="ts-popup-modal">
			<div class="overlay"></div>
			<div class="quickshop-container popup-container">
				<span class="close"></span>
				<div class="quickshop-content"></div>
			</div>
		</div>
		<?php
		}
		
		function product_title(){
			?>
			<h1 itemprop="name" class="product_title entry-title">
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h1>
			<?php
		}
		
		function filter_add_to_cart_url(){
			$ref_url = wp_get_referer();
			$ref_url = remove_query_arg( array('added-to-cart','add-to-cart'), $ref_url );
			$ref_url = add_query_arg( array( 'add-to-cart' => $this->id ), $ref_url );
			return esc_url( $ref_url );
		}
		
		function filter_review_link( $review_link = '#reviews' ){
			global $product;
			$link = get_permalink( $product->get_id() );
			if( $link ){
				return trailingslashit($link) . $review_link;
			}
			else{
				return $review_link;
			}
		}
		
		function load_quickshop_content_callback(){
			global $post, $product;
			$prod_id = absint($_POST['product_id']);
			$post = get_post( $prod_id );
			$product = wc_get_product( $prod_id );

			if( $prod_id <= 0 ){
				die( esc_html__('Invalid Product', 'gostore') );
			}
			if( !isset($post->post_type) || $post->post_type != 'product' ){
				die( esc_html__('Invalid Product', 'gostore') );
			}
			
			$this->id = $prod_id;
			
			$this->add_hooks();
			
			gostore_change_theme_options('ts_prod_sharing', 0);
			
			add_filter( 'woocommerce_add_to_cart_url', array($this, 'filter_add_to_cart_url'), 10 );
			add_filter( 'gostore_woocommerce_review_link_filter', array($this, 'filter_review_link'), 10 );
			
			$classes = array('ts-quickshop-wrapper product');
			
			if( !has_action('gostore_quickshop_single_product_summary', 'woocommerce_template_single_add_to_cart') ){
				$classes[] = 'no-addtocart';
			}
			
			ob_start();	
			?>
			<div class="woocommerce">
				<div itemscope itemtype="http://schema.org/Product" <?php post_class( implode(' ', $classes) ); ?>>
					
					<?php woocommerce_show_product_images(); ?>
					
					<!-- Product summary -->
					<div class="summary entry-summary">
						<?php do_action('gostore_quickshop_single_product_summary'); ?>
					</div>
				
				</div>
			</div>
			<?php

			wp_reset_postdata();
			die( ob_get_clean() );
		}
	}
	new GoStore_Quickshop();
}
?>