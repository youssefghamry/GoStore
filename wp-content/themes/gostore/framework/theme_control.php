<?php 
/*** Template Redirect ***/
add_action('template_redirect', 'gostore_template_redirect');
function gostore_template_redirect(){
	global $wp_query, $post;
	
	/* Get Page Options */
	if( is_page() || is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ){
		if( is_page() ){
			$page_id = $post->ID;
		}
		if( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ){
			$page_id = get_option('woocommerce_shop_page_id', 0);
		}
		$page_options = gostore_set_global_page_options( $page_id );
		
		if( $page_options['ts_layout_fullwidth'] != 'default' ){
			gostore_change_theme_options('ts_layout_fullwidth', $page_options['ts_layout_fullwidth']);
			if( $page_options['ts_layout_fullwidth'] ){
				gostore_change_theme_options('ts_header_layout_fullwidth', $page_options['ts_header_layout_fullwidth']);
				gostore_change_theme_options('ts_main_content_layout_fullwidth', $page_options['ts_main_content_layout_fullwidth']);
				gostore_change_theme_options('ts_footer_layout_fullwidth', $page_options['ts_footer_layout_fullwidth']);
			}
		}
		
		if( $page_options['ts_layout_style'] != 'default' ){
			gostore_change_theme_options('ts_layout_style', $page_options['ts_layout_style']);
		}
		
		if( $page_options['ts_header_layout'] != 'default' ){
			gostore_change_theme_options('ts_header_layout', $page_options['ts_header_layout']);
		}
		
		if( $page_options['ts_breadcrumb_layout'] != 'default' ){
			gostore_change_theme_options('ts_breadcrumb_layout', $page_options['ts_breadcrumb_layout']);
		}
		
		if( $page_options['ts_breadcrumb_bg_parallax'] != 'default' ){
			gostore_change_theme_options('ts_breadcrumb_bg_parallax', $page_options['ts_breadcrumb_bg_parallax']);
		}
		
		if( trim($page_options['ts_bg_breadcrumbs']) != '' ){
			gostore_change_theme_options('ts_bg_breadcrumbs', $page_options['ts_bg_breadcrumbs']);
		}
		
		if( trim($page_options['ts_logo']) != '' ){
			gostore_change_theme_options('ts_logo', $page_options['ts_logo']);
		}
		
		if( trim($page_options['ts_logo_mobile']) != '' ){
			gostore_change_theme_options('ts_logo_mobile', $page_options['ts_logo_mobile']);
		}
		
		if( trim($page_options['ts_logo_sticky']) != '' ){
			gostore_change_theme_options('ts_logo_sticky', $page_options['ts_logo_sticky']);
		}
		
		if( $page_options['ts_menu_id'] || $page_options['ts_vertical_menu_id'] ){
			add_filter('wp_nav_menu_args', 'gostore_filter_wp_nav_menu_args');
		}
		
		if( $page_options['ts_footer_block'] ){
			gostore_change_theme_options('ts_footer_block', $page_options['ts_footer_block']);
		}
	}
	
	/* Archive - Category product */
	if( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') || (function_exists('dokan_is_store_page') && dokan_is_store_page()) ){
		gostore_set_header_breadcrumb_layout_woocommerce_page( 'shop' );
		
		add_action('woocommerce_before_main_content', 'gostore_remove_hooks_from_shop_loop');
		
		/* Update product category layout */
		if( is_tax('product_cat') ){
			$term = $wp_query->queried_object;
			if( !empty($term->term_id) ){
				$bg_breadcrumbs_id = get_term_meta($term->term_id, 'bg_breadcrumbs_id', true);
				$layout = get_term_meta($term->term_id, 'layout', true);
				$left_sidebar = get_term_meta($term->term_id, 'left_sidebar', true);
				$right_sidebar = get_term_meta($term->term_id, 'right_sidebar', true);
				
				if( $bg_breadcrumbs_id != '' ){
					$bg_breadcrumbs_src = wp_get_attachment_url( $bg_breadcrumbs_id );
					if( $bg_breadcrumbs_src !== false ){
						gostore_change_theme_options('ts_bg_breadcrumbs', $bg_breadcrumbs_src);
					}
				}
				if( $layout != '' ){
					gostore_change_theme_options('ts_prod_cat_layout', $layout);
				}
				if( $left_sidebar != '' ){
					gostore_change_theme_options('ts_prod_cat_left_sidebar', $left_sidebar);
				}
				if( $right_sidebar != '' ){
					gostore_change_theme_options('ts_prod_cat_right_sidebar', $right_sidebar);
				}
			}
		}
	}
	
	/* Single post */
	if( is_singular('post') ){
		$post_data = array();
		$post_custom = get_post_custom();
		foreach( $post_custom as $key => $value ){
			if( isset($value[0]) ){
				$post_data[$key] = $value[0];
			}
		}
		
		if( isset($post_data['ts_post_layout']) && $post_data['ts_post_layout'] != '0' ){
			gostore_change_theme_options('ts_blog_details_layout', $post_data['ts_post_layout']);
		}
		if( isset($post_data['ts_post_left_sidebar']) && $post_data['ts_post_left_sidebar'] != '0' ){
			gostore_change_theme_options('ts_blog_details_left_sidebar', $post_data['ts_post_left_sidebar']);
		}
		if( isset($post_data['ts_post_right_sidebar']) && $post_data['ts_post_right_sidebar'] != '0' ){
			gostore_change_theme_options('ts_blog_details_right_sidebar', $post_data['ts_post_right_sidebar']);
		}
		if( isset($post_data['ts_bg_breadcrumbs']) && $post_data['ts_bg_breadcrumbs'] != '' ){
			gostore_change_theme_options('ts_bg_breadcrumbs', $post_data['ts_bg_breadcrumbs']);
		}
	}
	
	/* Single product */
	if( is_singular('product') ){
		/* Remove hooks on Related and Up-Sell products */
		add_action('woocommerce_before_main_content', 'gostore_remove_hooks_from_shop_loop');
		
		$theme_options = gostore_get_theme_options();
	
		$prod_data = array();
		$post_custom = get_post_custom();
		foreach( $post_custom as $key => $value ){
			if( isset($value[0]) ){
				$prod_data[$key] = $value[0];
			}
		}
		if( isset($prod_data['ts_prod_layout']) && $prod_data['ts_prod_layout'] != '0' ){
			gostore_change_theme_options('ts_prod_layout', $prod_data['ts_prod_layout']);
		}
		if( isset($prod_data['ts_prod_left_sidebar']) && $prod_data['ts_prod_left_sidebar'] != '0' ){
			gostore_change_theme_options('ts_prod_left_sidebar', $prod_data['ts_prod_left_sidebar']);
		}
		if( isset($prod_data['ts_prod_right_sidebar']) && $prod_data['ts_prod_right_sidebar'] != '0' ){
			gostore_change_theme_options('ts_prod_right_sidebar', $prod_data['ts_prod_right_sidebar']);
		}
		
		if( !empty($prod_data['ts_prod_summary_extra_content']) ){
			gostore_change_theme_options('ts_prod_summary_extra_content', $prod_data['ts_prod_summary_extra_content']);
		}
		
		if( !$theme_options['ts_prod_thumbnail'] ){
			remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
		}
		
		if( $theme_options['ts_prod_title'] && $theme_options['ts_prod_title_in_content'] ){
			gostore_change_theme_options('ts_prod_title', 0); /* remove title above breadcrumb */
			add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 10);
		}
		
		if( !$theme_options['ts_prod_label'] ){
			remove_action('woocommerce_product_thumbnails', 'gostore_template_loop_product_label', 99);
		}
		
		if( !$theme_options['ts_prod_rating'] ){
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);
		}
		
		if( !$theme_options['ts_prod_sharing'] ){
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 70);
		}
		
		if( !$theme_options['ts_prod_price'] ){
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
			remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
		}
		
		if( !$theme_options['ts_prod_excerpt'] ){
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 15);
		}
		
		if( !$theme_options['ts_prod_add_to_cart'] || $theme_options['ts_enable_catalog_mode'] ){
			$terms        = get_the_terms( $post->ID, 'product_type' );
			$product_type = ! empty( $terms ) ? sanitize_title( current( $terms )->name ) : 'simple';
			if( $product_type != 'variable' ){
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
			}
			else{
				remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
			}
		}
		
		/* Breadcrumb */
		if( isset($prod_data['ts_bg_breadcrumbs']) && $prod_data['ts_bg_breadcrumbs'] != '' ){
			gostore_change_theme_options('ts_bg_breadcrumbs', $prod_data['ts_bg_breadcrumbs']);
		}
		
		/* Product tabs */
		if( $theme_options['ts_prod_tabs_show_content_default'] ){
			gostore_change_theme_options('ts_prod_tabs_position', 'after_summary');
		}
		else{
			if( $theme_options['ts_prod_tabs_position'] == 'inside_summary' ){
				remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
				add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 50);
			}
		}
		
		/* Add extra classes to post */
		add_action('woocommerce_before_single_product', 'gostore_woocommerce_before_single_product');
	}
	
	/* Single Portfolio */
	if( is_singular('ts_portfolio') ){
		$portfolio_data = array();
		$post_custom = get_post_custom();
		foreach( $post_custom as $key => $value ){
			if( isset($value[0]) ){
				$portfolio_data[$key] = $value[0];
			}
		}
		
		if( isset($portfolio_data['ts_portfolio_custom_field']) && $portfolio_data['ts_portfolio_custom_field'] == 1 ){
			if( isset($portfolio_data['ts_portfolio_custom_field_title']) ){
				gostore_change_theme_options('ts_portfolio_custom_field_title', $portfolio_data['ts_portfolio_custom_field_title']);
			}
			if( isset($portfolio_data['ts_portfolio_custom_field_content']) ){
				gostore_change_theme_options('ts_portfolio_custom_field_content', $portfolio_data['ts_portfolio_custom_field_content']);
			}
		}
		
		if( gostore_get_theme_options('ts_portfolio_thumbnail_style') == 'gallery' && wp_is_mobile() ){
			gostore_change_theme_options('ts_portfolio_thumbnail_style', 'slider');
		}
	}
	
	/* WooCommerce - Other pages */
	if( class_exists('WooCommerce') ){
		if( is_cart() ){
			gostore_set_header_breadcrumb_layout_woocommerce_page( 'cart' );
			
			add_action('woocommerce_before_cart', 'gostore_remove_hooks_from_shop_loop');
		}
		
		if( is_checkout() ){
			gostore_set_header_breadcrumb_layout_woocommerce_page( 'checkout' );
		}
		
		if( is_account_page() ){
			gostore_set_header_breadcrumb_layout_woocommerce_page( 'myaccount' );
		}
	}

	/* Header Cart - Wishlist */
	if( !class_exists('WooCommerce') ){
		gostore_change_theme_options('ts_enable_tiny_shopping_cart', 0);
	}
	
	if( !class_exists('WooCommerce') || !class_exists('YITH_WCWL') ){
		gostore_change_theme_options('ts_enable_tiny_wishlist', 0);
	}
	
	/* Right to left */
	if( is_rtl() ){
		gostore_change_theme_options('ts_enable_rtl', 1);
	}
	
	/* Remove background image if not necessary */
	$load_bg = true;
	if( gostore_get_theme_options('ts_layout_fullwidth') ){
		$load_bg = false;
	}
	if( is_page() && $load_bg && $layout_style = gostore_get_page_options('ts_layout_style') ){
		if( $layout_style == 'wide' || ( $layout_style == 'default' && gostore_get_theme_options('ts_layout_style') == 'wide' ) ){
			$load_bg = false;
		}
	}
	
	if( !$load_bg ){
		add_filter('theme_mod_background_image', '__return_empty_string');
	}
}

function gostore_filter_wp_nav_menu_args( $args ){
	global $post;
	if( is_page() && !is_admin() && !empty($args['theme_location']) ){
		if( $args['theme_location'] == 'primary' ){
			$menu = get_post_meta($post->ID, 'ts_menu_id', true);
			if( $menu ){
				$args['menu'] = $menu;
			}
		}
		
		if( $args['theme_location'] == 'vertical' ){
			$menu = get_post_meta($post->ID, 'ts_vertical_menu_id', true);
			if( $menu ){
				$args['menu'] = $menu;
			}
		}
	}
	return $args;
}

add_filter('single_template', 'gostore_change_single_portfolio_template');
function gostore_change_single_portfolio_template( $single_template ){
	
	if( is_singular('ts_portfolio') && locate_template('single-portfolio.php') ){
		$single_template = locate_template('single-portfolio.php');
	}
	
	return $single_template;
}

function gostore_remove_hooks_from_shop_loop(){
	$theme_options = gostore_get_theme_options();
	
	if( ! $theme_options['ts_prod_cat_thumbnail'] ){
		remove_action('woocommerce_before_shop_loop_item_title', 'gostore_template_loop_product_thumbnail', 10);
	}
	if( ! $theme_options['ts_prod_cat_label'] ){
		remove_action('woocommerce_after_shop_loop_item_title', 'gostore_template_loop_product_label', 1);
	}
	
	if( ! $theme_options['ts_prod_cat_cat'] ){
		remove_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_categories', 10);
	}
	if( ! $theme_options['ts_prod_cat_sku'] ){
		remove_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_product_sku', 30);
	}
	if( ! $theme_options['ts_prod_cat_title'] ){
		remove_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_product_title', 20);
	}
	if( ! $theme_options['ts_prod_cat_price'] ){
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 60);
	}
	if( ! $theme_options['ts_prod_cat_rating'] ){
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 40);
	}
	if( ! $theme_options['ts_prod_cat_desc'] ){
		remove_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_short_description', 50);
	}
	if( ! $theme_options['ts_prod_cat_add_to_cart'] ){
		remove_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_add_to_cart', 70); 
		remove_action('woocommerce_after_shop_loop_item_title', 'gostore_template_loop_add_to_cart', 10004 );
	}
	
	if( $theme_options['ts_prod_cat_color_swatch'] ){
		add_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_product_variable_color', 3);
		$number_color_swatch = absint( $theme_options['ts_prod_cat_number_color_swatch'] );
		add_filter('gostore_loop_product_variable_color_number', function() use ($number_color_swatch){
			return $number_color_swatch;
		});
	}
	
	if( in_array( $theme_options['ts_prod_cat_loading_type'], array('infinity-scroll', 'load-more-button') ) ){
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		gostore_change_theme_options('ts_prod_cat_per_page_dropdown', 0);
	}
}

function gostore_set_header_breadcrumb_layout_woocommerce_page( $page = 'shop' ){
	/* Header Layout */
	$header_layout = get_post_meta(wc_get_page_id( $page ), 'ts_header_layout', true);
	if( $header_layout != 'default' && $header_layout != '' ){
		gostore_change_theme_options('ts_header_layout', $header_layout);
	}
	
	/* Breadcrumb Layout */
	$breadcrumb_layout = get_post_meta(wc_get_page_id( $page ), 'ts_breadcrumb_layout', true);
	if( $breadcrumb_layout != 'default' && $breadcrumb_layout != '' ){
		gostore_change_theme_options('ts_breadcrumb_layout', $breadcrumb_layout);
	}
}

function gostore_woocommerce_before_single_product(){
	add_filter('post_class', 'gostore_single_product_post_class_filter');
}

function gostore_single_product_post_class_filter( $classes ){
	global $product;
	
	$theme_options = gostore_get_theme_options();
	
	if( $theme_options['ts_prod_tabs_show_content_default'] ){
		$classes[] = 'show-tabs-content-default';
	}
	
	if( $theme_options['ts_prod_summary_extra_content'] ){
		$classes[] = 'summary-has-extra-content';
	}
	
	if( $theme_options['ts_prod_size_chart'] && $theme_options['ts_prod_size_chart_style'] == 'popup' ){
		$classes[] = 'summary-has-size-chart';
	}
	
	if( $theme_options['ts_prod_tabs_position'] == 'inside_summary' ){
		$classes[] = 'tabs-in-summary';
	}
	
	if( !$theme_options['ts_prod_add_to_cart'] || $theme_options['ts_enable_catalog_mode'] ){
		$classes[] = 'no-addtocart';
	}
	
	if( !$theme_options['ts_prod_thumbnail'] ){
		$classes[] = 'no-product-thumbnail';
	}
	
	remove_filter('post_class', 'gostore_single_product_post_class_filter');
	return $classes;
}
?>