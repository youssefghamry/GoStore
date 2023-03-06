<?php 
/*** Tiny account ***/
if( !function_exists('gostore_tiny_account') ){
	function gostore_tiny_account( $show_dropdown = true ){
		$login_url = '#';
		$register_url = '#';
		$profile_url = '#';
		$logout_url = wp_logout_url(get_permalink());
		
		if( class_exists('WooCommerce') ){
			$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( $myaccount_page_id ) {
			  $login_url = get_permalink( $myaccount_page_id );
			  $register_url = $login_url;
			  $profile_url = $login_url;
			}		
		}
		else{
			$login_url = wp_login_url();
			$register_url = wp_registration_url();
			$profile_url = admin_url( 'profile.php' );
		}
		
		$_user_logged = is_user_logged_in();
		ob_start();
		
		?>
		<div class="ts-tiny-account-wrapper">
			<div class="account-control">
			
				<?php if( !$_user_logged ): ?>
					<a  class="login" href="<?php echo esc_url($login_url); ?>" title="<?php esc_attr_e('Login', 'gostore'); ?>">
						<span><?php esc_html_e('Login', 'gostore'); ?></span>
					</a>
				<?php else: ?>
					<a class="my-account" href="<?php echo esc_url($profile_url); ?>" title="<?php esc_attr_e('My Account', 'gostore'); ?>">
						<span><?php esc_html_e( 'Account', 'gostore' ); ?></span>
					</a>
				<?php endif; ?>
				
				<?php if( $show_dropdown ): ?>
				<div class="account-dropdown-form dropdown-container">
					<div class="form-content">
						<?php if( !$_user_logged ): ?>
							<h2 class="dropdown-title"><?php esc_attr_e('Login', 'gostore'); ?></h2>
							<?php wp_login_form( array('form_id' => 'ts-login-form') ); ?>
						<?php else: ?>
						<ul>
							<li><a class="my-account" href="<?php echo esc_url($profile_url); ?>" title="<?php esc_attr_e('My Account', 'gostore'); ?>"><?php esc_html_e('My Account', 'gostore'); ?></a></li>
							<li><a class="log-out" href="<?php echo esc_url($logout_url); ?>"><?php esc_html_e( 'Logout', 'gostore' ); ?></a></li>
						</ul>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				
			</div>
		</div>
		
		<?php
		return ob_get_clean();
	}
}

/*** Tiny Cart ***/
if( !function_exists('gostore_tiny_cart') ){
	function gostore_tiny_cart( $show_cart_control = true, $show_cart_dropdown = true ){
		if( !class_exists('WooCommerce') ){
			return '';
		}
		$cart_empty = WC()->cart->is_empty();
		$cart_url = wc_get_cart_url();
		$checkout_url = wc_get_checkout_url();
		$cart_number = WC()->cart->get_cart_contents_count();
		ob_start();
		?>
			<div class="ts-tiny-cart-wrapper">
				<?php if( $show_cart_control ): ?>
				<div class="cart-icon">
					<a class="cart-control" href="<?php echo esc_url($cart_url); ?>" title="<?php esc_attr_e('View your shopping cart', 'gostore'); ?>">
						<span class="ic-cart"><span class="cart-number"><?php echo esc_html($cart_number) ?></span></span>
					</a>
				</div>
				<?php endif; ?>
				
				<?php if( $show_cart_dropdown ): ?>
				<div class="cart-dropdown-form dropdown-container woocommerce">
					<div class="form-content <?php echo esc_attr( $cart_empty?'cart-empty':'' ); ?>">
						<?php if( $cart_empty ): ?>
							<h3 class="emty-title"><?php echo sprintf( esc_html__('Cart (%d)', 'gostore'), $cart_number ) ?></h3>
							<div>
								<label><?php esc_html_e('Your cart is currently empty', 'gostore'); ?></label>
								<a class="continue-shopping-button button-text" href="<?php echo wc_get_page_permalink('shop'); ?>"><?php esc_html_e('Continue Shopping', 'gostore'); ?></a>
							</div>
						<?php else: ?>
							<h2 class="dropdown-title"><?php echo sprintf( esc_html__('Cart (%d)', 'gostore'), $cart_number ) ?></h2>
							<a class="clear-cart-button" href="#"><?php esc_html_e('Clear All', 'gostore'); ?></a>
							<div class="cart-wrapper">
								<div class="cart-content">
									<ul class="cart_list">
										<?php 
										foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
											$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
											if ( !( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) ){
												continue;
											}
											$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
											<li class="woocommerce-mini-cart-item">
												<a class="thumbnail" href="<?php echo esc_url($product_permalink); ?>">
													<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>
												</a>
												<div class="cart-item-wrapper">	
													<h3 class="product-name">
														<a href="<?php echo esc_url($product_permalink); ?>">
															<?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
														</a>
													</h3>
													
													<span class="price"><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></span>
													
													<?php 
													if( $_product->is_sold_individually() ){
														$product_quantity = '<span class="quantity">1</span>';
													}else{
														$product_quantity = woocommerce_quantity_input( array(
															'input_name'  	=> "cart[{$cart_item_key}][qty]",
															'input_value' 	=> $cart_item['quantity'],
															'max_value'   	=> $_product->get_max_purchase_quantity(),
															'min_value'   	=> '0',
															'product_name'  => $_product->get_name()
														), $_product, false );
													}

													echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
													
													echo '<div class="subtotal">'. apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) . '</div>';
													?>
													
													<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-cart_item_key="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'gostore' ), $cart_item_key ), $cart_item_key ); ?>
												</div>
											</li>
										
										<?php endforeach; ?>
									</ul>
									<div class="dropdown-footer">
										<div class="total"><span class="total-title primary-text"><?php esc_html_e('Subtotal : ', 'gostore');?></span><?php echo WC()->cart->get_cart_subtotal(); ?></div>
										
										<a href="<?php echo esc_url($cart_url); ?>" class="button view-cart"><?php esc_html_e('View Cart', 'gostore'); ?></a>
										<a href="<?php echo esc_url($checkout_url); ?>" class="button checkout-button"><?php esc_html_e('Checkout', 'gostore'); ?></a>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		<?php
		return ob_get_clean();
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'gostore_tiny_cart_filter');
function gostore_tiny_cart_filter($fragments){
	$cart_sidebar = gostore_get_theme_options('ts_shopping_cart_sidebar');
	$fragments['.ts-tiny-cart-wrapper'] = gostore_tiny_cart(true, !$cart_sidebar);
	if( $cart_sidebar ){
		$fragments['#ts-shopping-cart-sidebar .ts-tiny-cart-wrapper'] = gostore_tiny_cart(false, true);
	}
	return $fragments;
}

add_action('wp_ajax_gostore_update_cart_quantity', 'gostore_update_cart_quantity');
add_action('wp_ajax_nopriv_gostore_update_cart_quantity', 'gostore_update_cart_quantity');
function gostore_update_cart_quantity(){
	if( isset($_POST['cart_item_key'], $_POST['qty']) ){
		$cart_item_key = $_POST['cart_item_key'];
		$qty = $_POST['qty'];
		$cart =  WC()->cart->get_cart();
		if( isset($cart[$cart_item_key]) ){
			$qty = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( '/[^0-9\.]/', '', $qty ) ), $cart_item_key );
			if( !($qty === '' || $qty === $cart[$cart_item_key]['quantity']) ){
				if( !($cart[$cart_item_key]['data']->is_sold_individually() && $qty > 1) ){
					WC()->cart->set_quantity( $cart_item_key, $qty, false );
					$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', true );
					if( $cart_updated ){
						WC()->cart->calculate_totals();
					}
				}
			}
		}
	}
	else if( isset($_POST['clear_cart']) ){
		WC()->cart->empty_cart();
	}
	WC_AJAX::get_refreshed_fragments();
}

/** Tini wishlist **/
function gostore_tini_wishlist(){
	if( !(class_exists('WooCommerce') && class_exists('YITH_WCWL')) ){
		return;
	}
	
	ob_start();
	
	$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
	if( function_exists( 'wpml_object_id_filter' ) ){
		$wishlist_page_id = wpml_object_id_filter( $wishlist_page_id, 'page', true );
	}
	$wishlist_page = get_permalink( $wishlist_page_id );
	
	?>
	<a title="<?php esc_attr_e('Wishlist', 'gostore'); ?>" href="<?php echo esc_url($wishlist_page); ?>" class="tini-wishlist"><span><?php esc_html_e('Wishlist', 'gostore'); ?></span><span class="count-number"><?php echo yith_wcwl_count_products(); ?></span>
	</a>
	<?php
	return ob_get_clean();
}

function gostore_update_tini_wishlist() {
	die(gostore_tini_wishlist());
}

add_action('wp_ajax_gostore_update_tini_wishlist', 'gostore_update_tini_wishlist');
add_action('wp_ajax_nopriv_gostore_update_tini_wishlist', 'gostore_update_tini_wishlist');

/* Recently Viewed Products */
if( !function_exists('gostore_header_recently_viewed_products') ){
	function gostore_header_recently_viewed_products(){
		if( !class_exists('WooCommerce') ){
			return;
		}
		if( !function_exists('ts_get_recently_viewed_products') ){
			return;
		}
		$theme_options = gostore_get_theme_options();
		if( !$theme_options['ts_header_recently_viewed_products'] ){
			return;
		}
		
		$viewed_by_all_users = $theme_options['ts_header_recently_viewed_products_by_all_user'];
		$viewed_products = ts_get_recently_viewed_products( $viewed_by_all_users );
		
		$viewed_products = array_filter( $viewed_products );
		
		if( !$viewed_products ){
			return;
		}
		
		global $post;
		
		$args = array(
			'post_type'				=> 'product'
			,'post_status' 			=> 'publish'
			,'posts_per_page' 		=> (int) $theme_options['ts_header_number_recently_viewed_products']
			,'post__in' 			=> $viewed_products
			,'orderby' 				=> 'post__in'
			,'meta_query' 			=> WC()->query->get_meta_query()
			,'tax_query'           	=> WC()->query->get_tax_query()
		);
		
		$products = new WP_Query($args);
		
		if( $products->have_posts() ){
			$show_rating = apply_filters('gostore_header_recently_viewed_products_show_rating', false);
			?>
			<div class="ts-header-recently-viewed-products woocommerce">
				<div class="recently-viewed-products-control">
					<span><?php esc_html_e('Recently Viewed', 'gostore'); ?></span>
				</div>
				<div class="recently-viewed-products-dropdown dropdown-container">
					<ul class="product_list_widget">
					<?php
					while( $products->have_posts() ){
						$products->the_post();
						$product = wc_get_product( $post->ID );
						?>
						<li>
							<a class="ts-wg-thumbnail" href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo wp_kses( $product->get_image(), 'gostore_product_image' ); ?>
							</a>
							<div class="ts-wg-meta">
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo wp_kses( $product->get_name(), 'gostore_product_name' ); ?>
								</a>
								<?php
								if( $show_rating ){
									echo wc_get_rating_html( $product->get_average_rating() );
								}
								?>
								<span class="price"><?php echo wp_kses( $product->get_price_html(), 'gostore_product_price' ); ?></span>
							</div>
						</li>
						<?php
					}
					?>
					</ul>
				</div>
			</div>
			<?php
		}
		wp_reset_postdata();
	}
}

if( !function_exists('gostore_woocommerce_multilingual_currency_switcher') ){
	function gostore_woocommerce_multilingual_currency_switcher(){
		if( class_exists('woocommerce_wpml') && class_exists('WooCommerce') && class_exists('SitePress') ){
			global $sitepress, $woocommerce_wpml;
			
			if( !isset($woocommerce_wpml->multi_currency) ){
				return;
			}
			
			$settings = $woocommerce_wpml->get_settings();
			
			$format = isset($settings['wcml_curr_template']) && $settings['wcml_curr_template'] != '' ? $settings['wcml_curr_template']:'%code%';
			$wc_currencies = get_woocommerce_currencies();
			if( !isset($settings['currencies_order']) ){
				$currencies = $woocommerce_wpml->multi_currency->get_currency_codes();
			}else{
				$currencies = $settings['currencies_order'];
			}
			
			$selected_html = '';
			foreach( $currencies as $currency ){
				if($woocommerce_wpml->settings['currency_options'][$currency]['languages'][$sitepress->get_current_language()] == 1 ){
					$currency_format = preg_replace(array('#%name%#', '#%symbol%#', '#%code%#'),
													array($wc_currencies[$currency], get_woocommerce_currency_symbol($currency), $currency), $format);
						
					if( $currency == $woocommerce_wpml->multi_currency->get_client_currency() ){
						$selected_html = '<a href="javascript: void(0)" class="wcml-cs-active-currency">'.$currency_format.'</a>';
						break;
					}
				}
			}
			
			echo '<div class="wcml_currency_switcher">';
				echo wp_kses( $selected_html, 'gostore_link' );
				echo '<ul>';
			
				foreach( $currencies as $currency ){
					if($woocommerce_wpml->settings['currency_options'][$currency]['languages'][$sitepress->get_current_language()] == 1 ){
						$currency_format = preg_replace(array('#%name%#', '#%symbol%#', '#%code%#'),
														array($wc_currencies[$currency], get_woocommerce_currency_symbol($currency), $currency), $format);
						echo '<li><a rel="' . $currency . '">' . $currency_format . '</a></li>';
					}
				}
				
				echo '</ul>';
			echo '</div>';
		}
		else if( class_exists('WOOCS') && class_exists('WooCommerce') ){ /* Support WooCommerce Currency Switcher */
			global $WOOCS;
			$currencies = $WOOCS->get_currencies();
			if( !is_array($currencies) ){
				return;
			}
			?>
			<div class="wcml_currency_switcher">
				<a href="javascript: void(0)" class="wcml-cs-active-currency"><?php echo esc_html($WOOCS->current_currency); ?></a>
				<ul>
					<?php 
					foreach( $currencies as $key => $currency ){
						$link = add_query_arg('currency', $currency['name']);
						echo '<li rel="'.$currency['name'].'"><a href="'.esc_url($link).'">'.esc_html($currency['name']).'</a></li>';
					}
					?>
				</ul>
			</div>
			<?php
		}else{
			do_action('gostore_header_currency_switcher'); /* Allow use another currency switcher */
		}
	}
}

add_filter( 'wcml_multi_currency_ajax_actions', 'gostore_wcml_multi_currency_ajax_actions_filter' );
if( !function_exists('gostore_wcml_multi_currency_ajax_actions_filter') ){
	function gostore_wcml_multi_currency_ajax_actions_filter( $actions ){
		$actions[] = 'remove_from_wishlist';
		$actions[] = 'gostore_ajax_search';
		$actions[] = 'gostore_load_quickshop_content';
		$actions[] = 'gostore_update_cart_quantity';
		$actions[] = 'gostore_load_product_added_to_cart';
		$actions[] = 'ts_get_product_content_in_category_tab';
		return $actions;
	}
}

if( !function_exists('gostore_wpml_language_selector') ){
	function gostore_wpml_language_selector(){
		if( class_exists('SitePress') ){
			do_action('wpml_add_language_selector');
		}
		else{
			do_action('gostore_header_language_switcher'); /* Allow use another language switcher */
		}
	}
}