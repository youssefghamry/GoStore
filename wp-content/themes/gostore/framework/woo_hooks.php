<?php
/*************************************************
* WooCommerce Custom Hook                        *
**************************************************/

/*** Shop - Category ***/

/* Remove hook */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);

/* Add new hook */

add_action('woocommerce_before_shop_loop_item_title', 'gostore_template_loop_product_thumbnail', 10);
add_action('woocommerce_after_shop_loop_item_title', 'gostore_template_loop_product_label', 1);

add_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_brands', 5);
add_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_categories', 10);
add_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_product_title', 20);
add_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_product_sku', 30);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 40);
add_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_short_description', 50);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 60);
add_action('woocommerce_after_shop_loop_item', 'gostore_template_loop_add_to_cart', 70);

add_action('woocommerce_archive_description', 'gostore_best_selling_products', 20);

add_action('woocommerce_before_shop_loop', 'gostore_product_per_page_form', 40);
add_action('woocommerce_before_shop_loop', 'gostore_add_filter_button', 15);
add_action('woocommerce_before_shop_loop', 'gostore_product_on_sale_form', 50);
add_filter('loop_shop_per_page', 'gostore_change_products_per_page_shop' ); 

add_filter('loop_shop_post_in', 'gostore_show_only_products_on_sales');

add_action('woocommerce_after_shop_loop', 'gostore_shop_load_more_html', 20);

add_filter('woocommerce_get_stock_html', 'gostore_empty_woocommerce_stock_html', 10, 2);

add_filter('woocommerce_before_output_product_categories', 'gostore_before_output_product_categories');
add_filter('woocommerce_after_output_product_categories', 'gostore_after_output_product_categories');

add_filter('woocommerce_pagination_args', 'gostore_woocommerce_pagination_args');
function gostore_woocommerce_pagination_args( $args ){
	$args['prev_text'] = esc_html__('Prev', 'gostore');
	$args['next_text'] = esc_html__('Next', 'gostore');
	return $args;
}

function gostore_template_loop_product_label(){
	global $product;
	$theme_options = gostore_get_theme_options();
	?>
	<div class="product-label">
	<?php 
	if( $product->is_in_stock() ){
		/* New label */
		if( $theme_options['ts_product_show_new_label'] ){
			$now = current_time( 'timestamp', true );
			$post_date = get_post_time('U', true);
			$num_day = (int)( ( $now - $post_date ) / ( 3600*24 ) );
			$num_day_setting = absint( $theme_options['ts_product_show_new_label_time'] );
			if( $num_day <= $num_day_setting ){
				echo '<span class="new"><span>'.esc_html($theme_options['ts_product_new_label_text']).'</span></span>';
			}
		}
		
		/* Sale label */
		if( $product->is_on_sale() ){
			if( $theme_options['ts_show_sale_label_as'] != 'text' ){
				if( $product->get_type() == 'variable' ){
					$regular_price = $product->get_variation_regular_price('max');
					$sale_price = $product->get_variation_sale_price('min');
				}
				else{
					$regular_price = $product->get_regular_price();
					$sale_price = $product->get_price();
				}
				if( $regular_price ){
					if( $theme_options['ts_show_sale_label_as'] == 'number' ){
						$_off_price = round($regular_price - $sale_price, wc_get_price_decimals());
						$price_display = '-' . sprintf(get_woocommerce_price_format(), get_woocommerce_currency_symbol(), $_off_price);
						echo '<span class="onsale amount" data-original="'.$price_display.'"><span>'.$price_display.'</span></span>';
					}
					if( $theme_options['ts_show_sale_label_as'] == 'percent' ){
						echo '<span class="onsale percent"><span>-'.gostore_calc_discount_percent($regular_price, $sale_price).'%</span></span>';
					}
				}
			}
			else{
				echo '<span class="onsale"><span>'.esc_html($theme_options['ts_product_sale_label_text']).'</span></span>';
			}
		}
		
		/* Hot label */
		if( $product->is_featured() ){
			echo '<span class="featured"><span>'.esc_html($theme_options['ts_product_feature_label_text']).'</span></span>';
		}
	}
	else{ /* Out of stock */
		echo '<span class="out-of-stock"><span>'.esc_html($theme_options['ts_product_out_of_stock_label_text']).'</span></span>';
	}
	?>
	</div>
	<?php
}

function gostore_template_loop_product_thumbnail(){
	global $product;
	$lazy_load = gostore_get_theme_options('ts_prod_lazy_load') && !( defined( 'DOING_AJAX' ) && DOING_AJAX );
	$placeholder_img_src = gostore_get_theme_options('ts_prod_placeholder_img')['url'];
	
	$prod_galleries = $product->get_gallery_image_ids();
	
	$image_size = apply_filters('gostore_loop_product_thumbnail', 'woocommerce_thumbnail');
	
	$dimensions = wc_get_image_size( $image_size );
	
	$has_back_image = gostore_get_theme_options('ts_effect_product');
	
	if( !is_array($prod_galleries) || ( is_array($prod_galleries) && count($prod_galleries) == 0 ) ){
		$has_back_image = false;
	}
	 
	if( wp_is_mobile() ){
		$has_back_image = false;
	}
	
	echo '<figure class="' . ($has_back_image?'has-back-image':'no-back-image') . '">';
		if( !$lazy_load ){
			echo woocommerce_get_product_thumbnail( $image_size );
			
			if( $has_back_image ){
				echo wp_get_attachment_image( $prod_galleries[0], $image_size, 0, array('class' => 'product-image-back') );
			}
		}
		else{
			$front_img_src = '';
			$alt = '';
			if( has_post_thumbnail( $product->get_id() ) ){
				$post_thumbnail_id = get_post_thumbnail_id($product->get_id());
				$image_obj = wp_get_attachment_image_src($post_thumbnail_id, $image_size, 0);
				if( isset($image_obj[0]) ){
					$front_img_src = $image_obj[0];
				}
				$alt = trim(strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) ));
			}
			else{
				$front_img_src = wc_placeholder_img_src();
			}
			
			echo '<img src="'.esc_url($placeholder_img_src).'" data-src="'.esc_url($front_img_src).'" class="attachment-shop_catalog wp-post-image ts-lazy-load" alt="'.esc_attr($alt).'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'" />';
		
			if( $has_back_image ){
				$back_img_src = '';
				$alt = '';
				$image_obj = wp_get_attachment_image_src($prod_galleries[0], $image_size, 0);
				if( isset($image_obj[0]) ){
					$back_img_src = $image_obj[0];
					$alt = trim(strip_tags( get_post_meta($prod_galleries[0], '_wp_attachment_image_alt', true) ));
				}
				else{
					$back_img_src = wc_placeholder_img_src();
				}
				
				echo '<img src="'.esc_url($placeholder_img_src).'" data-src="'.esc_url($back_img_src).'" class="product-image-back ts-lazy-load" alt="'.esc_attr($alt).'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'" />';
			}
		}
	echo '</figure>';
}

function gostore_template_loop_product_variable_color(){
	global $product;
	if( $product->get_type() == 'variable' ){
		$attribute_color = wc_attribute_taxonomy_name( 'color' ); // pa_color
		$attribute_color_name = wc_variation_attribute_name( $attribute_color ); // attribute_pa_color
		
		$color_terms = wc_get_product_terms( $product->get_id(), $attribute_color, array( 'fields' => 'all' ) );
		if( empty($color_terms) || is_wp_error($color_terms) ){
			return;
		}
		$color_term_ids = wp_list_pluck( $color_terms, 'term_id' );
		$color_term_slugs = wp_list_pluck( $color_terms, 'slug' );
		
		$color_html = array();
		$price_html = array();
		
		$added_colors = array();
		$count = 0;
		$number = apply_filters('gostore_loop_product_variable_color_number', 3);
		
		$children = $product->get_children();
		if( is_array($children) && count($children) > 0 ){
			foreach( $children as $children_id ){
				$variation_attributes = wc_get_product_variation_attributes( $children_id );
				foreach( $variation_attributes as $attribute_name => $attribute_value ){
					if( $attribute_name == $attribute_color_name ){
						if( in_array($attribute_value, $added_colors) ){
							break;
						}
						
						$term_id = 0;
						$found_slug = array_search($attribute_value, $color_term_slugs);
						if( $found_slug !== false ){
							$term_id = $color_term_ids[ $found_slug ];
						}
						
						if( $term_id !== false && absint( $term_id ) > 0 ){
							$thumbnail_id = get_post_meta( $children_id, '_thumbnail_id', true );
							if( $thumbnail_id ){
								$image_src = wp_get_attachment_image_src($thumbnail_id, 'woocommerce_thumbnail');
								if( $image_src ){
									$thumbnail = $image_src[0];
								}
								else{
									$thumbnail = wc_placeholder_img_src();
								}
							}
							else{
								$thumbnail = wc_placeholder_img_src();
							}
							
							$color_datas = get_term_meta( $term_id, 'ts_product_color_config', true );
							if( $color_datas ){
								$color_datas = unserialize( $color_datas );	
							}else{
								$color_datas = array('ts_color_color' => '#ffffff', 'ts_color_image' => 0);
							}
							$color_datas['ts_color_image'] = absint($color_datas['ts_color_image']);
							if( $color_datas['ts_color_image'] ){
								$color_html[] = '<div class="color-image" data-thumb="'.$thumbnail.'" data-term_id="'.$term_id.'"><span>'.wp_get_attachment_image( $color_datas['ts_color_image'], 'ts_prod_color_thumb', true, array('alt' => $attribute_value) ).'</span></div>';
							}
							else{
								$color_html[] = '<div class="color" data-thumb="'.$thumbnail.'" data-term_id="'.$term_id.'"><span style="background-color: '.$color_datas['ts_color_color'].'"></span></div>';
							}
							$variation = wc_get_product( $children_id );
							$price_html[] = '<span class="price" data-term_id="'.$term_id.'">' . $variation->get_price_html() . '</span>';
							$count++;
						}
						
						$added_colors[] = $attribute_value;
						break;
					}
				}
				
				if( $count == $number ){
					break;
				}
			}
		}
		
		if( $color_html ){
			echo '<div class="color-swatch">'. implode('', $color_html) . '</div>';
			echo '<span class="variable-prices hidden">' . implode('', $price_html) . '</span>';
		}
	}
}

function gostore_template_loop_product_title(){
	global $product;
	echo '<h3 class="heading-title product-name">';
	echo '<a href="' . esc_url($product->get_permalink()) . '">' . esc_html($product->get_title()) . '</a>';
	echo '</h3>';
}

function gostore_template_loop_add_to_cart(){
	if( gostore_get_theme_options('ts_enable_catalog_mode') ){
		return;
	}
	
	echo '<div class="loop-add-to-cart">';
	woocommerce_template_loop_add_to_cart();
	echo '</div>';
}

function gostore_template_loop_product_sku(){
	global $product;
	echo '<div class="product-sku">' . esc_html($product->get_sku()) . '</div>';
}

function gostore_template_loop_short_description(){
	global $product;
	if( !$product->get_short_description() ){
		return;
	}
	
	$grid_limit_words = (int) gostore_get_theme_options('ts_prod_cat_desc_words');
	?>
	<div class="short-description">
		<?php gostore_the_excerpt_max_words($grid_limit_words, '', true, '', true); ?>
	</div>
	<?php
}

function gostore_template_loop_brands(){
	global $product;
	if( gostore_get_theme_options('ts_prod_cat_brand') && taxonomy_exists('ts_product_brand') ){
		echo get_the_term_list($product->get_id(), 'ts_product_brand', '<div class="product-brands">', ', ', '</div>');
	}
}

function gostore_template_loop_categories(){
	global $product;
	$categories_label = esc_html__('Categories: ', 'gostore');
	echo wc_get_product_category_list($product->get_id(), ', ', '<div class="product-categories"><span>'.$categories_label.'</span>', '</div>');
}

function gostore_best_selling_products(){
	$theme_options = gostore_get_theme_options();
	if( !$theme_options['ts_prod_cat_bestsellers'] || !is_tax('product_cat') ){
		return;
	}
	
	if( is_paged() && $theme_options['ts_prod_cat_loading_type'] != 'default' ){
		return;
	}
	
	$term = get_queried_object();
	if( !isset($term->term_id) ){
		return;
	}
	
	$total_products = wc_get_loop_prop( 'total', 0 );
	$limit = apply_filters('gostore_best_selling_products_limit', 7);
	if( $total_products < $limit * 2 ){
		return;
	}
	
	$product_cats = array( $term->term_id );
	
	$term_children = get_term_children( $term->term_id, 'product_cat' );
	if( is_array( $term_children ) && count( $term_children ) > 0 ){
		$product_cats = array_merge( $product_cats, $term_children );
	}
	
	$args = array(
		'post_type'				=> 'product'
		,'post_status' 			=> 'publish'
		,'posts_per_page' 		=> $limit
		,'meta_key' 			=> 'total_sales'
		,'orderby' 				=> 'meta_value_num'
		,'order' 				=> 'desc'
		,'meta_query' 			=> WC()->query->get_meta_query()
		,'tax_query'           	=> WC()->query->get_tax_query()
	);
	
	$args['tax_query'][] = array(
								'taxonomy' 	=> 'product_cat'
								,'terms' 	=> $product_cats
								,'field' 	=> 'term_id'
							);
							
	$products = new WP_Query( $args );
	if( !$products->have_posts() ){
		return;
	}
	
	wc_set_loop_prop( 'is_shortcode', true );
	
	add_action('woocommerce_after_shop_loop_item_title', 'gostore_best_selling_product_label', 2);
	
	$columns = $theme_options['ts_prod_cat_columns'];

	?>
	<div class="ts-product-wrapper ts-shortcode ts-product woocommerce ts-slider nav-middle middle-thumbnail category-best-selling" data-nav="0" data-columns="<?php echo esc_attr($columns); ?>">
		<header class="shortcode-heading-wrapper">
			<h2 class="shortcode-title"><?php esc_html_e('Best Sellers!', 'gostore'); ?></h2>
		</header>
		
		<div class="content-wrapper loading">
			<?php
			woocommerce_product_loop_start();
			while( $products->have_posts() ){ 
				$products->the_post();	
				wc_get_template_part( 'content', 'product' );
			}
			woocommerce_product_loop_end();
			?>
		</div>
	</div>
	<?php
	
	remove_action('woocommerce_after_shop_loop_item_title', 'gostore_best_selling_product_label', 2);
	
	wc_set_loop_prop( 'is_shortcode', false );
	
	wp_reset_postdata();
}

function gostore_best_selling_product_label(){
	static $best_selling_label_number = 1;
	?>
	<div class="product-label best-selling-label">
		<span><?php esc_html_e('Top', 'gostore'); ?></span>
		<span><?php echo zeroise($best_selling_label_number, 2); ?></span>
	</div>
	<?php
	$best_selling_label_number++;
}

function gostore_change_products_per_page_shop(){
    if( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ){
		if( isset($_GET['per_page']) && absint($_GET['per_page']) > 0 ){
			return absint($_GET['per_page']);
		}
		$per_page = absint( gostore_get_theme_options('ts_prod_cat_per_page') );
        if( $per_page ){
            return $per_page;
        }
    }
}

function gostore_product_per_page_form(){
	if( !gostore_get_theme_options('ts_prod_cat_per_page_dropdown') ){
		return;
	}
	if( function_exists('woocommerce_products_will_display') && !woocommerce_products_will_display() ){
		return;
	}
	
	$per_page = absint( gostore_get_theme_options('ts_prod_cat_per_page') );
	if( !$per_page ){
		return;
	}
	
	$options = array();
	for( $i = 1; $i <= 4; $i++ ){
		$options[] = $per_page * $i;
	}
	$selected = isset($_GET['per_page'])?absint($_GET['per_page']):$per_page;
	
	$action = '';
	$cat 	= get_queried_object();
	if( isset( $cat->term_id ) && isset( $cat->taxonomy ) ){
		$action = get_term_link( $cat->term_id, $cat->taxonomy );
	}
	else{
		$action = wc_get_page_permalink('shop');
	}
?>
	<form method="get" action="<?php echo esc_url($action) ?>" class="product-per-page-form">
		<span><?php esc_html_e('Show', 'gostore'); ?></span>
		<select name="per_page" class="perpage">
			<?php foreach( $options as $option ): ?>
			<option value="<?php echo esc_attr($option) ?>" <?php selected($selected, $option) ?>><?php echo esc_html($option) ?></option>
			<?php endforeach; ?>
		</select>
		<ul class="perpage">
			<li>
				<span class="perpage-current"><?php echo esc_html($selected) ?></span>
				<ul class="dropdown">
					<?php foreach( $options as $option ): ?>
					<li><a href="#" data-perpage="<?php echo esc_attr($option) ?>" class="<?php echo esc_attr($option == $selected?'current':''); ?>"><?php echo esc_html($option) ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
		</ul>
		<?php wc_query_string_form_fields( null, array( 'per_page', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
<?php
}

function gostore_show_only_products_on_sales( $array ){
	if( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ){
		if( isset($_GET['onsale']) && 'yes' == $_GET['onsale'] ){
			return array_merge($array, wc_get_product_ids_on_sale());
		}
	}
	return $array;
}

function gostore_product_on_sale_form(){
	if( !gostore_get_theme_options('ts_prod_cat_onsale_checkbox') ){
		return;
	}
	if( function_exists('woocommerce_products_will_display') && !woocommerce_products_will_display() ){
		return;
	}
	
	$checked = isset($_GET['onsale']) && 'yes' == $_GET['onsale'] ? true : false;
	
	$action = '';
	$cat 	= get_queried_object();
	if( isset( $cat->term_id ) && isset( $cat->taxonomy ) ){
		$action = get_term_link( $cat->term_id, $cat->taxonomy );
	}
	else{
		$action = wc_get_page_permalink('shop');
	}
	?>
	<form method="get" action="<?php echo esc_url($action); ?>" class="product-on-sale-form <?php echo esc_attr( $checked?'checked':'' ); ?>">
		<label>
			<input type="checkbox" name="onsale" value="yes" <?php echo esc_attr( $checked?'checked':'' ); ?> />
			<?php esc_html_e('Show only products on sale', 'gostore'); ?>
		</label>
		<?php wc_query_string_form_fields( null, array( 'onsale', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
	<?php
}

function gostore_is_active_filter_area(){
	return is_active_sidebar('filter-widget-area') && gostore_get_theme_options('ts_filter_widget_area') && woocommerce_products_will_display();
}

function gostore_show_filter_area_by_default(){
	return !wp_is_mobile() && gostore_get_theme_options('ts_show_filter_widget_area_by_default');
}

function gostore_add_filter_button(){
	if( gostore_is_active_filter_area() ){
		$show_by_default = gostore_show_filter_area_by_default();
	?>
		<div class="filter-widget-area-button">
			<a href="#" class="<?php echo esc_attr( $show_by_default?'active':'' ); ?>"><?php esc_html_e('Filter', 'gostore') ?></a>
		</div>
		
		<div id="ts-filter-widget-area" class="ts-floating-sidebar <?php echo esc_attr( $show_by_default?'active':'' ); ?>">
			<div class="overlay"></div>
			<div class="ts-sidebar-content">
				<span class="close"></span>
				<aside class="filter-widget-area">
					<?php dynamic_sidebar( 'filter-widget-area' ); ?>
				</aside>
			</div>
		</div>
		<?php
	}
}

function gostore_shop_load_more_html(){
	if( wc_get_loop_prop( 'total_pages' ) == 1 || !woocommerce_products_will_display() ){
		return;
	}
	$loading_type = gostore_get_theme_options('ts_prod_cat_loading_type');
	if( in_array($loading_type, array('infinity-scroll', 'load-more-button')) ){
		$total = wc_get_loop_prop( 'total' );
		$per_page = wc_get_loop_prop( 'per_page' );
		$current = wc_get_loop_prop( 'current_page' );
		$showing = min($current * $per_page, $total);
	?>
	<div class="ts-shop-result-count">
		<?php 
		if( $showing < $total ){
			printf( esc_html__('You\'re viewed %s of %s products', 'gostore'), $showing, $total );
		}
		else{
			printf( esc_html__('You\'re viewed all %s products', 'gostore'), $total );
		}
		?>
	</div>
	<div class="ts-shop-load-more">
		<a class="load-more button"><?php esc_html_e('LOAD MORE...', 'gostore'); ?></a>
	</div>
	<?php
	}
}

function gostore_empty_woocommerce_stock_html( $html, $product ){
	if( $product->get_type() == 'simple' ){
		return '';
	}
	return $html;
}

function gostore_before_output_product_categories(){
	return '<div class="list-categories">';
}

function gostore_after_output_product_categories(){
	return '</div>';
}
/*** End Shop - Category ***/



/*** Single Product ***/

/* Remove hook */
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);		
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/* Add hook */
add_action('woocommerce_before_single_product_summary', 'gostore_before_single_product_summary_images', 1);
add_action('woocommerce_after_single_product_summary', 'gostore_after_single_product_summary_images', 0);

add_action('woocommerce_product_thumbnails', 'gostore_template_loop_product_label', 99);
add_action('woocommerce_product_thumbnails', 'gostore_template_single_product_video_360_buttons', 99);

add_action('woocommerce_single_product_summary', 'gostore_template_single_navigation', 1);
add_action('woocommerce_single_product_summary', 'gostore_template_single_countdown_availability', 1);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 70);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
add_action('woocommerce_single_product_summary', 'gostore_template_single_variation_price', 21);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 15);

add_action('woocommerce_single_product_summary', 'gostore_single_product_buy_now_button', 31);

add_action('woocommerce_single_product_summary', 'gostore_template_single_meta', 60);

add_action('woocommerce_after_single_product_summary', 'gostore_product_ads_banner', 12);

if( function_exists('ts_template_social_sharing') ){
	add_action('woocommerce_share', 'ts_template_social_sharing', 10);
}

add_action('init', 'gostore_change_woocommerce_tab_headings', 20);

add_filter('woocommerce_grouped_product_columns', 'gostore_woocommerce_grouped_product_columns');

add_filter('woocommerce_output_related_products_args', 'gostore_output_related_products_args_filter');

add_filter('woocommerce_single_product_image_gallery_classes', 'gostore_add_classes_to_single_product_thumbnail');
add_filter('woocommerce_gallery_thumbnail_size', 'gostore_product_gallery_thumbnail_size');

add_filter('woocommerce_dropdown_variation_attribute_options_args', 'gostore_variation_attribute_options_args');
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'gostore_variation_attribute_options_html', 10, 2);

add_filter('woocommerce_add_to_cart_redirect', 'gostore_product_buy_now_redirect');

if( !is_admin() ){ /* Fix for WooCommerce Tab Manager plugin */
	add_filter( 'woocommerce_product_tabs', 'gostore_product_remove_tabs', 999 );
	add_filter( 'woocommerce_product_tabs', 'gostore_add_product_custom_tab', 90 );
}

function gostore_calc_discount_percent($regular_price, $sale_price){
	return ( 1 - round($sale_price / $regular_price, 2) ) * 100;
}

add_action('wp_ajax_gostore_load_product_video', 'gostore_load_product_video_callback' );
add_action('wp_ajax_nopriv_gostore_load_product_video', 'gostore_load_product_video_callback' );
/*** End Product ***/

function gostore_before_single_product_summary_images(){
	echo '<div class="product-images-summary">';
}

function gostore_after_single_product_summary_images(){
		gostore_product_summary_extra_content();
	echo '</div>';
}

function gostore_product_summary_extra_content(){
	if( $extra_content = gostore_get_theme_options('ts_prod_summary_extra_content') ){
		echo '<div class="summary-extra-content">';
			echo do_shortcode( wp_kses_post( $extra_content ) ); /* Allowed html as post content */
		echo '</div>';
	}
}

function gostore_template_single_product_video_360_buttons(){
	if( !is_singular('product') ){
		return;
	}
	
	global $product;
	$video_url = get_post_meta($product->get_id(), 'ts_prod_video_url', true);
	if( $video_url ){
		echo '<a class="ts-product-video-button" href="#" data-product_id="'.$product->get_id().'">'.esc_html__('Video', 'gostore').'</a>';
		add_action('wp_footer', 'gostore_add_product_video_popup_modal', 999);
	}
	
	$gallery_360 = get_post_meta($product->get_id(), 'ts_prod_360_gallery', true);
	if( $gallery_360 ){
		$galleries = array_map('trim', explode(',', $gallery_360));
		$image_array = array();
		foreach($galleries as $gallery ){
			$image_src = wp_get_attachment_image_url($gallery, 'woocommerce_single');
			if( $image_src ){
				$image_array[] = "'" . $image_src . "'";
			}
		}
		wp_enqueue_script('threesixty');
		wp_add_inline_script('threesixty', 'var _ts_product_360_image_array = ['.implode(',', $image_array).'];');
		
		echo '<a class="ts-product-360-button" href="#">'.esc_html__('360', 'gostore').'</a>';
		add_action('wp_footer', 'gostore_add_product_360_popup_modal', 999);
	}
}

function gostore_add_product_video_popup_modal(){
	?>
	<div id="ts-product-video-modal" class="ts-popup-modal">
		<div class="overlay"></div>
		<div class="product-video-container popup-container">
			<span class="close"></span>
			<div class="product-video-content"></div>
		</div>
	</div>
	<?php
}

function gostore_add_product_360_popup_modal(){
	global $product;
	?>
	<div id="ts-product-360-modal" class="ts-popup-modal">
		<div class="overlay"></div>
		<span class="close"></span>
		<h3 class="product-title"><?php echo esc_html( $product->get_title() ); ?></h3>
		<div class="product-360-container popup-container">
			<div class="product-360-content"><?php gostore_load_product_360(); ?></div>
		</div>
	</div>
	<?php
}

function gostore_add_product_size_chart_popup_modal(){
	?>
	<div id="ts-product-size-chart-modal" class="ts-popup-modal">
		<div class="overlay"></div>
		<div class="product-size-chart-container popup-container">
			<span class="close"></span>
			<div class="product-size-chart-content">
				<?php gostore_product_size_chart_content(); ?>
			</div>
		</div>
	</div>
	<?php
}

function gostore_add_classes_to_single_product_thumbnail( $classes ){
	global $product;
	$video_url = get_post_meta($product->get_id(), 'ts_prod_video_url', true);
	if( $video_url ){
		$classes[] = 'has-video';
	}
	$gallery_360 = get_post_meta($product->get_id(), 'ts_prod_360_gallery', true);
	if( $gallery_360 ){
		$classes[] = 'has-360-gallery';
	}
	
	return $classes;
}

function gostore_product_gallery_thumbnail_size(){
	return 'woocommerce_thumbnail';
}

/* Single Product Video - Register ajax */
function gostore_load_product_video_callback(){
	if( empty($_POST['product_id']) ){
		die( esc_html__('Invalid Product', 'gostore') );
	}
	
	$prod_id = absint($_POST['product_id']);

	if( $prod_id <= 0 ){
		die( esc_html__('Invalid Product', 'gostore') );
	}
	
	$video_url = get_post_meta($prod_id, 'ts_prod_video_url', true);
	ob_start();
	if( !empty($video_url) ){
		echo do_shortcode('[ts_video src='.esc_url($video_url).']');
	}
	die( ob_get_clean() );
}

function gostore_load_product_360(){
	?>
	<div class="threesixty ts-product-360">
		<div class="spinner">
			<span>0%</span>
		</div>
		<ol class="threesixty_images"></ol>
	</div>
	<?php
}

function gostore_template_single_countdown_availability(){
	global $product;
	$show_counter = gostore_get_theme_options('ts_prod_count_down') && function_exists('ts_template_loop_time_deals');
	$show_availability = gostore_get_theme_options('ts_prod_availability') && function_exists('ts_product_availability_bar');
	if( $show_counter || $show_availability ){
	?>
	<div class="single-counter-wrapper">
		<?php
			if( $show_counter ){
				ts_template_loop_time_deals();
			}
			
			if( $show_availability ){
				ts_product_availability_bar();
			}
		?>
	</div>
	<?php
	}
}

function gostore_template_single_navigation(){
	if( !gostore_get_theme_options('ts_prod_next_prev_navigation') ){
		return;
	}
	$prev_post = get_adjacent_post(false, '', true, 'product_cat');
	$next_post = get_adjacent_post(false, '', false, 'product_cat');
	?>
	<div class="single-navigation">
	<?php 
		if( $prev_post ){
			$post_id = $prev_post->ID;
			$product = wc_get_product($post_id);
			?>
			<a href="<?php echo esc_url(get_permalink($post_id)); ?>" rel="prev">
				<div class="product-info prev-product-info">
					<?php echo wp_kses( $product->get_image(), 'gostore_product_image' ); ?>
				</div>
				<span class="prev-title"><?php esc_html_e('Prev product', 'gostore'); ?></span>
			</a>
			<?php
		}
		
		if( $next_post ){
			$post_id = $next_post->ID;
			$product = wc_get_product($post_id);
			?>
			<a href="<?php echo esc_url(get_permalink($post_id)); ?>" rel="next">
				<div class="product-info next-product-info">
					<?php echo wp_kses( $product->get_image(), 'gostore_product_image' ); ?>
				</div>
				<span class="next-title"><?php esc_html_e('Next product', 'gostore'); ?></span>
			</a>
			<?php
		}
	?>
	</div>
	<?php
}

function gostore_template_single_variation_price(){
	if( gostore_get_theme_options('ts_prod_price') ){
		echo '<div class="ts-variation-price hidden"></div>';
	}
}

function gostore_variation_attribute_options_args( $args ){
	if( !gostore_get_theme_options('ts_prod_attr_dropdown') ){
		$args['class'] = 'hidden';
	}
	if( $args['attribute'] ){
		$args['show_option_none'] = esc_html__('Choose your', 'gostore') . ' ' . wc_attribute_label( $args['attribute'] );
	}
	return $args;
}

function gostore_variation_attribute_options_html( $html, $args ){
	$theme_options = gostore_get_theme_options();
	if( gostore_get_theme_options('ts_prod_attr_dropdown') ){
		return $html;
	}
	
	global $product;
	
	$attr_color_text = gostore_get_theme_options('ts_prod_attr_color_text');
	
	$options = $args['options'];
	$attribute_name = $args['attribute'];
	
	ob_start();
	
	if( is_array( $options ) ){
	?>
		<div class="ts-product-attribute">
		<?php 
		$selected_key = 'attribute_' . sanitize_title( $attribute_name );
		
		$selected_value = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $product->get_variation_default_attribute( $attribute_name );
		
		// Get terms if this is a taxonomy - ordered
		if( taxonomy_exists( $attribute_name ) ){
			
			$class = 'option';
			$is_attr_color = false;
			$attribute_color = wc_sanitize_taxonomy_name( 'color' );
			if( $attribute_name == wc_attribute_taxonomy_name( $attribute_color ) ){
				if( !$attr_color_text ){
					$is_attr_color = true;
					$class .= ' color';
				}
				else{
					$class .= ' text';
				}
			}
			$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );

			foreach ( $terms as $term ) {
				if ( ! in_array( $term->slug, $options ) ) {
					continue;
				}
				$term_name = apply_filters( 'woocommerce_variation_option_name', $term->name );
				
				if( $is_attr_color ){
					$datas = get_term_meta( $term->term_id, 'ts_product_color_config', true );
					if( $datas ){
						$datas = unserialize( $datas );	
					}else{
						$datas = array(
									'ts_color_color' 				=> "#ffffff"
									,'ts_color_image' 				=> 0
								);
					}
				}
				
				$selected_class = sanitize_title( $selected_value ) == sanitize_title( $term->slug ) ? 'selected' : '';
				
				echo '<div data-value="' . esc_attr( $term->slug ) . '" class="'. $class .' '. $selected_class .'">';
				
				if( $is_attr_color ){
					if( absint($datas['ts_color_image']) > 0 ){
						echo '<a href="#">' . wp_get_attachment_image( absint($datas['ts_color_image']), 'ts_prod_color_thumb', true, array('title' => $term_name, 'alt' => $term_name) ) . '<span class="ts-tooltip button-tooltip">' . $term_name . '</span></a>';
					}
					else{
						echo '<a href="#" style="background-color:' . $datas['ts_color_color'] . '"><span class="ts-tooltip button-tooltip">' . $term_name . '</span></a>';
					}
				}
				else{
					echo '<a href="#">' . $term_name . '</a>';
				}
				
				echo '</div>';
			}

		} else {
			foreach( $options as $option ){
				$class = 'option';
				$class .= sanitize_title( $selected_value ) == sanitize_title( $option ) ? ' selected' : '';
				echo '<div data-value="' . esc_attr( $option ) . '" class="' . $class . '"><a href="#">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</a></div>';
			}
		}
		?>
	</div>
	<?php
		if( $theme_options['ts_prod_size_chart'] && $theme_options['ts_prod_size_chart_style'] == 'popup' && is_singular('product') ){
			$show_size_chart = false;
			if( taxonomy_exists( $attribute_name ) ){
				if( $attribute_name == wc_attribute_taxonomy_name( wc_sanitize_taxonomy_name('size') ) ){
					$show_size_chart = true;
				}
			}
			else if( sanitize_title( $attribute_name ) == 'size' ){ /* Custom attribute */
				$show_size_chart = true;
			}
		
			if( $show_size_chart && gostore_get_product_size_chart_id() ){
				echo '<a class="ts-product-size-chart-button" href="#">' . esc_html__('Size Chart', 'gostore') . '</a>';
				add_action('wp_footer', 'gostore_add_product_size_chart_popup_modal', 999);
				wp_cache_set('ts_size_chart_added', 1); /* show in tabs if not added */
			}
		}
	}
	
	return ob_get_clean() . $html;
}

function gostore_template_single_sku(){
	global $product;
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ){
		echo '<div class="sku-wrapper product_meta"><span>' . esc_html__( 'SKU:', 'gostore' ) . '</span><span class="sku">' . (( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'gostore' )) . '</span></div>';
	}
}
function gostore_template_single_availability(){
	global $product;

	$product_stock = $product->get_availability();
	$availability_text = empty($product_stock['availability'])?esc_html__('In Stock', 'gostore'):esc_attr($product_stock['availability']);
	?>	
		<div class="availability stock <?php echo esc_attr($product_stock['class']); ?>" data-original="<?php echo esc_attr($availability_text) ?>" data-class="<?php echo esc_attr($product_stock['class']) ?>">
			<span><?php esc_html_e('Availability:', 'gostore') ?></span>
			<span class="availability-text"><?php echo esc_html($availability_text); ?></span>
		</div>	
	<?php
}

function gostore_single_product_buy_now_button(){
	global $product;
	if( !gostore_get_theme_options('ts_enable_catalog_mode') && gostore_get_theme_options('ts_prod_buy_now') && in_array( $product->get_type(), array('simple', 'variable') ) && $product->is_purchasable() && $product->is_in_stock() ){
	?>
		<a href="#" class="button ts-buy-now-button"><?php esc_html_e('Buy Now', 'gostore'); ?></a>
	<?php
	}
}

function gostore_product_buy_now_redirect( $url ){
	if( isset($_REQUEST['ts_buy_now']) && $_REQUEST['ts_buy_now'] == 1 ){
		return apply_filters( 'gostore_product_buy_now_redirect_url', wc_get_checkout_url() );
	}
	return $url;
}

function gostore_template_single_meta(){
	global $product;
	$theme_options = gostore_get_theme_options();
	
	echo '<div class="meta-content">';
		do_action( 'woocommerce_product_meta_start' );
		if( $theme_options['ts_prod_availability'] ){
			gostore_template_single_availability();
		}
		if( $theme_options['ts_prod_sku'] ){
			gostore_template_single_sku();
		}
		if( $theme_options['ts_prod_cat'] ){
			echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="cats-link"><span>' . esc_html__( 'Categories:', 'gostore' ) . '</span><span class="cat-links">', '</span></div>' );
		}
		if( $theme_options['ts_prod_tag'] ){
			echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="tags-link"><span>' . esc_html__( 'Tags:', 'gostore' ) . '</span><span class="tag-links">', '</span></div>' );	
		}
		if( $theme_options['ts_prod_brand'] && taxonomy_exists('ts_product_brand') ){
			echo get_the_term_list($product->get_id(), 'ts_product_brand', '<div class="brands-link"><span>' . esc_html__( 'Brands:', 'gostore' ) . '</span><span class="brand-links">', ', ', '</span></div>');
		}
		do_action( 'woocommerce_product_meta_end' );
	echo '</div>';
}

function gostore_mysql_version_greater_8(){
	if( function_exists('wc_get_server_database_version') ){
		$database_version = wc_get_server_database_version();
		$number = isset($database_version['number']) ? $database_version['number'] : '';
		if( $number ){
			if( version_compare( $number, '8.0.0', '>=' ) ){
				return true;
			}
		}
	}
	return false;
}

/*** Product size chart ***/
function gostore_get_product_size_chart_id(){
	global $product;
	$product_id = $product->get_id();
	$cache_key = 'gostore_size_chart_id_of_' . $product_id;
	$size_chart_id = wp_cache_get($cache_key);
	if( false !== $size_chart_id ){
		return $size_chart_id;
	}
	$size_chart_id = get_post_meta($product_id, 'ts_prod_size_chart', true);
	if( $size_chart_id ){
		wp_cache_set($cache_key, $size_chart_id);
		return $size_chart_id;
	}
	$product_cats = wc_get_product_term_ids( $product_id, 'product_cat' );
	if( !empty($product_cats) && is_array($product_cats) ){
		$args = array(
                    'posts_per_page'         => 1,
                    'order'                  => 'DESC',
                    'post_type'              => 'ts_size_chart',
                    'post_status'            => 'publish',
                    'no_found_rows'          => true,
                    'update_post_term_cache' => false,
                    'fields'                 => 'ids',
                );
				
		if( count( $product_cats ) > 1 ){
			$args['meta_query']['relation'] = 'OR';
		}
		
		foreach( $product_cats as $product_cat ){
			$args['meta_query'][] = array(
				'key'     => 'ts_chart_categories',
				'value'   => gostore_mysql_version_greater_8() ? "\\b{$product_cat}\\b" : "[[:<:]]{$product_cat}[[:>:]]",
				'compare' => 'RLIKE',
			);
		}
		
		$size_charts = new WP_Query( $args );
		if( $size_charts->have_posts() ){
			foreach( $size_charts->posts as $id ){
				$size_chart_id = $id;
			}
		}
		wp_reset_postdata();
	}
	wp_cache_set($cache_key, $size_chart_id);
	
	return $size_chart_id;
}

function gostore_product_size_chart_content(){
	$chart_id = gostore_get_product_size_chart_id();
	$chart_content = apply_filters( 'the_content', get_the_content( null, false, $chart_id ) );
	$chart_label = get_post_meta( $chart_id, 'ts_chart_label', true );
	$chart_image = get_post_meta( $chart_id, 'ts_chart_image', true );
	$chart_table = get_post_meta( $chart_id, 'ts_chart_table', true );
	
	if( $chart_table ){
		$chart_table = json_decode( $chart_table, true );
		if( is_array($chart_table) ){
			$chart_table = array_filter($chart_table, function($v, $k){
				return is_array($v) && array_filter($v);
			}, ARRAY_FILTER_USE_BOTH);
		}
	}
	
	$classes = array();
	if( $chart_image ){
		$classes[] = 'has-image';
	}
	
	if( !empty($chart_table) && is_array($chart_table) ){
		$classes[] = 'has-table';
	}
	
	if( gostore_get_theme_options('ts_prod_tabs_show_content_default') ){
	?>
	<h2><?php esc_html_e('Size Chart', 'gostore'); ?></h2>
	<?php } ?>
	
	<div class="ts-size-chart-content <?php echo implode(' ', $classes); ?>">
		<?php
		if( $chart_label ){
			echo '<h5 class="chart-label">'.esc_html($chart_label).'</h5>';
		}
		
		if( $chart_content ){
			echo '<div class="chart-content">';
				echo wp_kses_post( $chart_content ); /* Allowed html as post content */
			echo '</div>';
		}
		
		if( $chart_image ){
			echo '<div class="chart-image">';
				echo '<img src="'.esc_url($chart_image).'" alt="'.esc_attr($chart_label).'" />';
			echo '</div>';
		}
		
		if( !empty($chart_table) && is_array($chart_table) ){
			echo '<table class="chart-table"><tbody>';
			foreach( $chart_table as $row ){
				echo '<tr>';
				foreach( $row as $col ){
					echo '<td>'.esc_html($col).'</td>';
				}
				echo '</tr>';
			}
			echo '</tbody></table>';
		}
		?>
	</div>
	<?php
}

/*** Product tab ***/
function gostore_product_remove_tabs( $tabs = array() ){
	if( !gostore_get_theme_options('ts_prod_tabs') ){
		return array();
	}
	return $tabs;
}

function gostore_add_product_custom_tab( $tabs = array() ){
	global $post;
	$theme_options = gostore_get_theme_options();
	$size_chart_style = $theme_options['ts_prod_size_chart_style'];
	$show_size_chart = $theme_options['ts_prod_size_chart'] 
						&& ( $size_chart_style == 'tab' || ( $size_chart_style == 'popup' && wp_cache_get('ts_size_chart_added') === false ) );
	
	if( $show_size_chart && gostore_get_product_size_chart_id() ){
		$tabs['ts_size_chart'] = array(
			'title'    	=> esc_html__('Size Chart', 'gostore')
			,'priority' => 25
			,'callback' => 'gostore_product_size_chart_content'
		);
	}
	
	$override_custom_tab = get_post_meta( $post->ID, 'ts_prod_custom_tab', true );
	if( $theme_options['ts_prod_custom_tab'] || $override_custom_tab ){
		if( $override_custom_tab ){
			$custom_tab_title = get_post_meta( $post->ID, 'ts_prod_custom_tab_title', true );
			$custom_tab_content = get_post_meta( $post->ID, 'ts_prod_custom_tab_content', true );
			gostore_change_theme_options( 'ts_prod_custom_tab_title', $custom_tab_title );
			gostore_change_theme_options( 'ts_prod_custom_tab_content', $custom_tab_content );
		}
		else{
			$custom_tab_title = $theme_options['ts_prod_custom_tab_title'];
		}

		$tabs['ts_custom'] = array(
			'title'    	=> esc_html( $custom_tab_title )
			,'priority' => 26
			,'callback' => 'gostore_product_custom_tab_content'
		);
	} 
	return $tabs;
}

function gostore_product_custom_tab_content(){
	global $post;
	
	$theme_options = gostore_get_theme_options();
	
	$custom_tab_title = $theme_options['ts_prod_custom_tab_title'];
	$custom_tab_content = $theme_options['ts_prod_custom_tab_content'];
	
	if( $custom_tab_title && $theme_options['ts_prod_tabs_show_content_default'] ){
		echo '<h2>' . esc_html($custom_tab_title) . '</h2>';
	}
	
	echo do_shortcode( stripslashes( wp_specialchars_decode( $custom_tab_content ) ) );
}

function gostore_change_woocommerce_tab_headings(){
	if( !gostore_get_theme_options('ts_prod_tabs_show_content_default') ){
		add_filter('woocommerce_product_description_heading', '__return_empty_string');
		add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');
	}
	else{
		add_filter('woocommerce_reviews_title', 'gostore_woocommerce_reviews_title', 10, 3);
	}
}

function gostore_woocommerce_reviews_title( $reviews_title, $count, $product ){
	$reviews_title = esc_html__('Reviews', 'gostore') . ' (' . $count . ')';
	return $reviews_title;
}

/* Ads Banner */
function gostore_product_ads_banner(){
	if( gostore_get_theme_options('ts_prod_ads_banner') ){
		echo '<div class="ads-banner">';
		echo do_shortcode( stripslashes( wp_specialchars_decode( gostore_get_theme_options('ts_prod_ads_banner_content') ) ) );
		echo '</div>';
	}
}

/* Related Products */
function gostore_output_related_products_args_filter( $args ){
	$args['posts_per_page'] = 6;
	$args['columns'] = 5;
	return $args;
}

/* Change grouped product columns */
function gostore_woocommerce_grouped_product_columns( $columns ){
	$columns = array('label', 'price', 'quantity');
	return $columns;
}

/*** General hook ***/

/*************************************************************
* Custom group button on product (quickshop, wishlist, compare) 
* Begin tag: 	10000
* Quickshop: 	10001
* Compare:   	10002
* Wishlist:  	10003
* Add To Cart: 	10004
* End tag:   	10005
**************************************************************/
function gostore_product_group_button_start(){	
	echo '<div class="product-group-button">';
}

function gostore_product_group_button_end(){
	echo '</div>';
}

add_action('init', 'gostore_wrap_product_group_button', 20);
function gostore_wrap_product_group_button(){
	add_action('woocommerce_after_shop_loop_item_title', 'gostore_product_group_button_start', 10000 );
	add_action('woocommerce_after_shop_loop_item_title', 'gostore_product_group_button_end', 10005 );
	
	if( gostore_get_theme_options('ts_product_hover_style') == 'hover-vertical-style' ){
		add_action('woocommerce_after_shop_loop_item_title', 'gostore_template_loop_add_to_cart', 10004 );
	}
}

/* Wishlist */
if( class_exists('YITH_WCWL') ){
	function gostore_add_wishlist_button_to_product_list(){
		echo '<div class="button-in wishlist">';
		echo do_shortcode('[yith_wcwl_add_to_wishlist]');
		echo '</div>';
	}
	
	if( 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' ) ){
		add_action( 'woocommerce_after_shop_loop_item_title', 'gostore_add_wishlist_button_to_product_list', 10003 );
		if( wp_is_mobile() ){
			add_action( 'woocommerce_after_shop_loop_item', 'gostore_add_wishlist_button_to_product_list', 80 );
		}
		
		add_filter( 'yith_wcwl_loop_positions', '__return_empty_array' ); /* Remove button which added by plugin */
	}
	
	add_filter('yith_wcwl_add_to_wishlist_params', 'gostore_yith_wcwl_add_to_wishlist_params');
	function gostore_yith_wcwl_add_to_wishlist_params( $additional_params ){
		if( isset($additional_params['container_classes']) && $additional_params['exists'] ){
			$additional_params['container_classes'] .= ' added';
		}
		$additional_params['label'] = '<span class="ts-tooltip button-tooltip">' . esc_html__('Wishlist', 'gostore') . '</span>';
		return $additional_params;
	}
	
	add_filter('yith_wcwl_browse_wishlist_label', 'gostore_yith_wcwl_browse_wishlist_label', 10, 2);
	function gostore_yith_wcwl_browse_wishlist_label( $text = '', $product_id = 0 ){
		if( $product_id ){
			return '<span class="ts-tooltip button-tooltip">' . esc_html__('Wishlist', 'gostore') . '</span>';
		}
		return $text;
	}
}

/* Compare */
if( class_exists('YITH_Woocompare') ){
	global $yith_woocompare;
	$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
	if( $yith_woocompare->is_frontend() || $is_ajax ){
		if( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ){
			if( $is_ajax ){
				if( defined('YITH_WOOCOMPARE_DIR') && !class_exists('YITH_Woocompare_Frontend') ){
					$compare_frontend_class = YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php';
					if( file_exists($compare_frontend_class) ){
						require_once $compare_frontend_class;
					}
					$yith_woocompare->obj = new YITH_Woocompare_Frontend();
				}
			}
			remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
			function gostore_add_compare_button_to_product_list(){
				global $yith_woocompare, $product;
				echo '<div class="button-in compare">';
				echo '<a class="compare" href="'.$yith_woocompare->obj->add_product_url( $product->get_id() ).'" data-product_id="'.$product->get_id().'">'.get_option('yith_woocompare_button_text').'</a>';
				echo '</div>';
			}
			add_action( 'woocommerce_after_shop_loop_item_title', 'gostore_add_compare_button_to_product_list', 10002 );
		}
		
		add_filter( 'option_yith_woocompare_button_text', 'gostore_compare_button_text_filter', 99 );
		function gostore_compare_button_text_filter( $button_text ){
			return '<span class="ts-tooltip button-tooltip">'.esc_html($button_text).'</span>';
		}
	}
}

/*************************************************************
* Group button on product meta (add to cart, wishlist, compare) 
* Begin tag: 69
* Add to cart: 70
* Compare: 70
* quicklist: 80
* End tag: 81
*************************************************************/
add_action('woocommerce_after_shop_loop_item', 'gostore_product_group_button_meta_start', 69);
add_action('woocommerce_after_shop_loop_item', 'gostore_product_group_button_meta_end', 81);
function gostore_product_group_button_meta_start(){
	echo '<div class="product-group-button-meta">';
}
function gostore_product_group_button_meta_end(){
	echo '</div>';
}

/*************************************************************
* Group price and buttons on product meta
* Begin tag: 59
* Price: 60
* Buttons: 69 -> 81
* End tag: 82
*************************************************************/
add_action('woocommerce_after_shop_loop_item', 'gostore_product_group_price_button_meta_start', 59);
add_action('woocommerce_after_shop_loop_item', 'gostore_product_group_price_button_meta_end', 82);
function gostore_product_group_price_button_meta_start(){
	echo '<div class="product-group-price-button-meta-wrapper">';
		echo '<div class="product-group-price-button-meta">';
}
function gostore_product_group_price_button_meta_end(){
		echo '</div>';
	echo '</div>';
}
/*** End General hook ***/

/*** Quantity Input hooks ***/
add_action('woocommerce_before_quantity_input_field', 'gostore_before_quantity_input_field', 1);
function gostore_before_quantity_input_field(){
	?>
	<div class="number-button">
		<input type="button" value="-" class="minus" />
	<?php
}

add_action('woocommerce_after_quantity_input_field', 'gostore_after_quantity_input_field', 99);
function gostore_after_quantity_input_field(){
	?>
		<input type="button" value="+" class="plus" />
	</div>
	<?php
}

/*** Cart - Checkout hooks ***/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );

add_action('woocommerce_cart_actions', 'gostore_empty_cart_button');
function gostore_empty_cart_button(){
?>
	<button type="submit" class="button empty-cart-button" name="ts_empty_cart" value="<?php esc_attr_e('Empty cart', 'gostore'); ?>"><?php esc_html_e('Empty cart', 'gostore'); ?></button>
<?php
}

add_action('init', 'gostore_empty_woocommerce_cart');
function gostore_empty_woocommerce_cart(){
	if( isset($_POST['ts_empty_cart']) ){
		WC()->cart->empty_cart();
	}
}

add_action('woocommerce_before_checkout_form', 'gostore_before_checkout_form_start', 1);
add_action('woocommerce_before_checkout_form', 'gostore_before_checkout_form_end', 999);
function gostore_before_checkout_form_start(){
	echo '<div class="checkout-login-coupon-wrapper">';
}
function gostore_before_checkout_form_end(){
	echo '</div>';
}

remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
add_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 20);

remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
add_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 1000);

if( !( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) ){
	add_action('woocommerce_before_checkout_form', function(){
		echo '<div class="checkout-login-wrapper">';
	}, 9);
	add_action('woocommerce_before_checkout_form', function(){
		echo '</div>';
	}, 11);
}

if( function_exists('wc_coupons_enabled') && wc_coupons_enabled() ){
	add_action('woocommerce_before_checkout_form', function(){
		echo '<div class="checkout-coupon-wrapper">';
	}, 19);
	add_action('woocommerce_before_checkout_form', function(){
		echo '</div>';
	}, 21);
}

add_action('woocommerce_before_cart', 'gostore_cart_checkout_process_bar', 1);
add_action('woocommerce_before_checkout_form', 'gostore_cart_checkout_process_bar', 1);
add_action('woocommerce_before_thankyou', 'gostore_cart_checkout_process_bar', 1);
function gostore_cart_checkout_process_bar(){
	if( !gostore_get_theme_options('ts_cart_checkout_process_bar') ){
		return;
	}
	
	global $wp;
	$is_checkout = is_checkout();
	$is_thankyou = $is_checkout && isset( $wp->query_vars['order-received'] );
	?>
	<div class="ts-cart-checkout-process-bar">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="process-cart active">
			<span class="status"></span>
			<h6><?php esc_html_e('SHOPPING BAG', 'gostore'); ?></h6>
			<span><?php esc_html_e('View your items', 'gostore'); ?></span>
		</a>

		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="process-checkout <?php echo esc_attr($is_checkout?'active':''); ?>">
			<span class="status"><?php esc_html_e('2', 'gostore'); ?></span>
			<h6><?php esc_html_e('SHIPPING AND CHECKOUT', 'gostore'); ?></h6>
			<span><?php esc_html_e('Enter your details', 'gostore'); ?></span>
		</a>

		<a href="javascript: void(0)" class="process-confirm <?php echo esc_attr($is_thankyou?'active':''); ?>">
			<span class="status"><?php esc_html_e('3', 'gostore'); ?></span>
			<h6><?php esc_html_e('COMFIRMATION', 'gostore'); ?></h6>
			<span><?php esc_html_e('Review your order!', 'gostore'); ?></span>
		</a>
	</div>
	<?php
}
?>