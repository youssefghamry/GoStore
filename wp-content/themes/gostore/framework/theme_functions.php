<?php 
/*** Activate Theme ***/
function gostore_theme_activation(){
	global $pagenow;
	if( is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']) )
	{
		if( get_option( 'woocommerce_single_image_width' ) === false ){
			/* Single Image */
			update_option('woocommerce_single_image_width', 600);
			
			/* Thumbnail Image */
			update_option('woocommerce_thumbnail_image_width', 450);
			update_option('woocommerce_thumbnail_cropping', 'custom');
			update_option('woocommerce_thumbnail_cropping_custom_width', 450);
			update_option('woocommerce_thumbnail_cropping_custom_height', 450);
		}
		
		if( get_option( 'yith_woocompare_image_size' ) === false ){
			update_option( 'yith_woocompare_image_size', array( 'width' => '450', 'height' => '450', 'crop' => 1 ) );
		}
		
		$elementor_cpt_support = get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
		if( !in_array( 'ts_footer_block', $elementor_cpt_support ) ){
			$elementor_cpt_support[] = 'ts_footer_block';
		}
		if( !in_array( 'ts_mega_menu', $elementor_cpt_support ) ){
			$elementor_cpt_support[] = 'ts_mega_menu';
		}
		update_option( 'elementor_cpt_support', $elementor_cpt_support );
	}
}
add_action('admin_init', 'gostore_theme_activation');

/*** Theme Setup ***/
function gostore_theme_setup(){
	/* Add editor-style.css file*/
	add_editor_style();
	
	/* Add Theme Support */
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'quote', 'video' ) );		
	
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'title-tag' );
	
	add_theme_support( 'custom-header' );
	
	$defaults = array(
		'default-color'         => ''
		,'default-image'        => ''
	);
	add_theme_support( 'custom-background', $defaults );
	
	add_theme_support( 'woocommerce' );
	
	add_theme_support( 'wc-product-gallery-slider' );
	
	remove_theme_support( 'widgets-block-editor' );
	
	if ( ! isset( $content_width ) ){ $content_width = 1200; }
	
	/* Translation */
	load_theme_textdomain( 'gostore', get_template_directory() . '/languages' );
	
	/* Register Menu Location */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Navigation', 'gostore' ),
	) );
	register_nav_menus( array(
		'vertical' => esc_html__( 'Vertical Navigation', 'gostore' ),
	) );
	register_nav_menus( array(
		'mobile' => esc_html__( 'Mobile Navigation', 'gostore' ),
	) );
}
add_action( 'after_setup_theme', 'gostore_theme_setup');

add_action('init', 'gostore_support_wc_product_gallery_lightbox', 20);
function gostore_support_wc_product_gallery_lightbox(){
	if( gostore_get_theme_options('ts_prod_cloudzoom') ){
		add_theme_support( 'wc-product-gallery-zoom' );
	}
	if( gostore_get_theme_options('ts_prod_lightbox') ){
		add_theme_support( 'wc-product-gallery-lightbox' );
	}
}

/*** Add Image Size ***/
function gostore_add_image_size(){
	add_image_size('gostore_menu_icon_thumb', (int) gostore_get_theme_options('ts_menu_thumb_width'), (int) gostore_get_theme_options('ts_menu_thumb_height'), true);
	
	add_image_size('gostore_blog_thumb', 1300, 0, false);
	
	add_image_size('gostore_product_cat', 700, 700, true);
}
add_action('init', 'gostore_add_image_size');

add_filter('subcategory_archive_thumbnail_size', 'gostore_product_categories_thumbnail_size');
function gostore_product_categories_thumbnail_size(){
	return 'gostore_product_cat';
}

/*** Get Theme Version ***/
function gostore_get_theme_version(){
	$theme = wp_get_theme();
	if( $theme->parent() ){
		return $theme->parent()->get('Version');
	}
	else{
		return $theme->get('Version');
	}
}

/*** Register Front End Scripts  ***/
function gostore_register_scripts(){
	$theme_version = gostore_get_theme_version();
	
	wp_enqueue_style( 'font-awesome-5', get_template_directory_uri() . '/css/fontawesome.min.css', array(), $theme_version );
	
	wp_enqueue_style( 'font-themify-icon', get_template_directory_uri() . '/css/themify-icons.css', array(), $theme_version );
	
	wp_enqueue_style( 'gostore-reset', get_template_directory_uri() . '/css/reset.css', array(), $theme_version );
	
	wp_enqueue_style( 'gostore-style', get_stylesheet_uri(), array(), $theme_version );
	
	if( !get_option('ts_load_dynamic_style') ){
		wp_enqueue_style( 'gostore-font-color', get_template_directory_uri() . '/css/font-color.css', array(), $theme_version );
	}
	
	if( gostore_load_dokan_style() ){
		wp_enqueue_style( 'gostore-dokan', get_template_directory_uri() . '/css/dokan.css', array(), $theme_version );
	}
	
	wp_enqueue_style( 'gostore-responsive', get_template_directory_uri() . '/css/responsive.css', array(), $theme_version );
	
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), $theme_version );
	
	if( is_singular('ts_portfolio') ){
		if( !wp_style_is('woocommerce_prettyPhoto_css', 'enqueued') ){
			wp_enqueue_style( 'prettyphoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), $theme_version );
		} else {
			wp_enqueue_style( 'woocommerce_prettyPhoto_css' );
		}
	}
	
	if( gostore_get_theme_options('ts_enable_rtl') ){
		wp_enqueue_style( 'gostore-rtl', get_template_directory_uri() . '/css/rtl.css', array(), $theme_version );
	}
	
	if( gostore_enable_loading_screen() ){
		wp_enqueue_script( 'gostore-loading-screen', get_template_directory_uri() . '/js/loading-screen.js', array('jquery'), $theme_version, false );
		wp_localize_script( 'gostore-loading-screen', 'ts_loading_screen_opt', array('loading_image' => gostore_get_loading_screen_image()) );
	}
	
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), $theme_version, true );
	
	wp_register_script( 'prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), $theme_version, true );
	
	wp_enqueue_script( 'gostore-script', get_template_directory_uri() . '/js/main.js', array('jquery'), $theme_version, true );
	
	if( wp_is_mobile() && gostore_get_theme_options('ts_add_to_cart_effect') == 'fly_to_cart' ){
		gostore_change_theme_options('ts_add_to_cart_effect', '');
	}
	
	if( defined('ICL_LANGUAGE_CODE') ){
		$ajax_url = admin_url('admin-ajax.php?lang='.ICL_LANGUAGE_CODE, 'relative');
	}
	else{
		$ajax_url = admin_url('admin-ajax.php', 'relative');
	}
	
	$script_params = array(
		'ajax_url'					=> $ajax_url
		,'sticky_header'			=> (int)gostore_get_theme_options('ts_enable_sticky_header')
		,'ajax_search'				=> (int)( gostore_get_theme_options('ts_ajax_search') && gostore_get_theme_options('ts_header_layout') != 'v5' )
		,'show_cart_after_adding'	=> (int)( gostore_get_theme_options('ts_show_shopping_cart_after_adding') && gostore_get_theme_options('ts_shopping_cart_sidebar') )
		,'ajax_add_to_cart'			=> (int)gostore_get_theme_options('ts_prod_ajax_add_to_cart')
		,'add_to_cart_effect'		=> gostore_get_theme_options('ts_add_to_cart_effect')
		,'shop_loading_type'		=> gostore_get_theme_options('ts_prod_cat_loading_type')
		,'flexslider' 				=> apply_filters(
						'gostore_quickshop_product_carousel_options',
						array(
							'rtl'             => is_rtl()
							,'animation'      => 'slide'
							,'smoothHeight'   => true
							,'directionNav'   => false
							,'controlNav'     => 'thumbnails'
							,'slideshow'      => false
							,'animationSpeed' => 500
							,'animationLoop'  => false // Breaks photoswipe pagination if true.
							,'allowOneSlide'  => false
						)
					)
		,'zoom_options'				=> apply_filters( 'gostore_quickshop_product_zoom_options', array() )
		,'product_name_min_height'	=> apply_filters( 'gostore_product_name_min_height', 1 )
	);
	
	wp_localize_script( 'gostore-script', 'gostore_params', $script_params );
	
	if( is_singular('product') ){
		wp_enqueue_script( 'gostore-single-product', get_template_directory_uri() . '/js/single-product.js', array('jquery'), $theme_version, true );
	}
	
	wp_register_script( 'threesixty', get_template_directory_uri() . '/js/threesixty.js', array(), $theme_version, true );
	
	if( !wp_is_mobile() && gostore_get_theme_options('ts_smooth_scroll') ){
		wp_enqueue_script( 'smooth-scroll', get_template_directory_uri() . '/js/SmoothScroll.min.js', array(), $theme_version, true );
	}
	
	if( gostore_get_theme_options('ts_enable_sticky_header') ){
		wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array(), $theme_version, true );
	}
	
	if( ( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ) && gostore_get_theme_options('ts_prod_cat_loading_type') != 'default' ){
		wp_enqueue_script( 'gostore-shop-load-more', get_template_directory_uri() . '/js/shop-load-more.js', array(), $theme_version, true );
	}
	
	if( is_singular() && comments_open() && get_option( 'thread_comments' ) ){ 	
		wp_enqueue_script( 'comment-reply' );
	}
	
	/* Load default google fonts */
	if( !class_exists('ReduxFramework') ){
		wp_enqueue_style( 'gostore-google-fonts', '//fonts.googleapis.com/css?family=Poppins:400|Rubik:400,600,700' );
	}
	
	/* Custom JS */
	if( $custom_js = gostore_get_theme_options('ts_custom_javascript_code') ){
		wp_add_inline_script( 'gostore-script', stripslashes( trim( $custom_js ) ) );
	}
}
add_action('wp_enqueue_scripts', 'gostore_register_scripts', 1000);

/* Loading Screen */
function gostore_enable_loading_screen(){
	global $post;
	$theme_options = gostore_get_theme_options();
	if( empty($theme_options['ts_loading_screen']) ){
		return false;
	}
	
	$enabled = false;
	
	$loading_screen_in = $theme_options['ts_display_loading_screen_in'];
	switch( $loading_screen_in ){
		case 'all-pages':
			if( is_page() ){
				$exclude_pages = !empty($theme_options['ts_loading_screen_exclude_pages'])?$theme_options['ts_loading_screen_exclude_pages']:array();
				if( isset($post->ID) && !in_array($post->ID, $exclude_pages) ){
					$enabled = true;
				}
			}
			else{
				$enabled = true;
			}
		break;
		case 'homepage-only':
			if( is_home() || is_front_page() ){
				$enabled = true;
			}
		break;
		case 'specific-pages':
			if( is_page() ){
				$specific_pages = !empty($theme_options['ts_loading_screen_specific_pages'])?$theme_options['ts_loading_screen_specific_pages']:array();
				if( isset($post->ID) && in_array($post->ID, $specific_pages) ){
					$enabled = true;
				}
			}
		break;
	}

	return apply_filters('gostore_enable_loading_screen', $enabled);
}

function gostore_get_loading_screen_image(){
	$theme_options = gostore_get_theme_options();
	$loading_image = $theme_options['ts_custom_loading_image']['url'];
	if( !$loading_image ){
		$loading_image = get_template_directory_uri() . '/images/loading/loading_' . $theme_options['ts_loading_image'] . '.svg';
	}
	return $loading_image;
}

function gostore_get_last_save_theme_options(){
	$transients = get_option('gostore_theme_options-transients', array());
	if( isset($transients['last_save']) ){
		return $transients['last_save'];
	}
	return time();
}

function gostore_register_custom_style(){
	$upload_dir = wp_get_upload_dir();
	$theme_name = strtolower( str_replace( ' ', '', wp_get_theme()->get('Name') ) );
	$filename = trailingslashit($upload_dir['baseurl']) . $theme_name . '.css';
	$filename_dir = trailingslashit($upload_dir['basedir']) . $theme_name . '.css';

	$custom_css = gostore_get_theme_options('ts_custom_css_code');
	if( file_exists( $filename_dir ) ){ 
		wp_enqueue_style( 'gostore-dynamic-css', $filename, array(), gostore_get_last_save_theme_options() );
		if( $custom_css ){
			wp_add_inline_style( 'gostore-dynamic-css', $custom_css );
		}
	}
	else{
		ob_start();
		include_once get_template_directory() . '/framework/dynamic_style.php';
		$dynamic_css = ob_get_contents();
		ob_end_clean();
		wp_add_inline_style( 'gostore-style', $dynamic_css );
		if( $custom_css ){
			wp_add_inline_style( 'gostore-style', $custom_css );
		}
	}
}
add_action('wp_enqueue_scripts', 'gostore_register_custom_style', 9999);

/* Add font style to compare popup - can not use wp_enqueue_scripts hook */
if( isset($_GET['action']) && $_GET['action'] == 'yith-woocompare-view-table' ){
	add_action('wp_print_styles', 'gostore_add_font_style_to_compare_popup', 1000);
}
function gostore_add_font_style_to_compare_popup(){
	wp_enqueue_style( 'redux-google-fonts-gostore_theme_options' ); /* gostore_theme_options is the variable/key of theme options, so it has to use _ */
	wp_enqueue_style( 'gostore-reset' );
	wp_enqueue_style( 'gostore-style' );
	wp_enqueue_style( 'font-awesome-5' );
	wp_enqueue_style( 'font-themify-icon' );
	wp_enqueue_style( 'gostore-font-color' );
	if( gostore_get_theme_options('ts_enable_rtl') ){
		wp_enqueue_style( 'gostore-rtl' );
	}
	wp_enqueue_style( 'gostore-dynamic-css' );
}

/*** Register Back End Scripts ***/
function gostore_register_admin_scripts(){
	$theme_version = gostore_get_theme_version();
	
	wp_enqueue_media();
	
	wp_enqueue_style( 'font-awesome-5', get_template_directory_uri() . '/css/fontawesome.min.css', array(), $theme_version );
	
	wp_enqueue_style( 'gostore-admin-style', get_template_directory_uri() . '/css/admin_style.css', array(), $theme_version );
	
	wp_enqueue_script( 'gostore-admin-script', get_template_directory_uri() . '/js/admin_main.js', array('jquery'), $theme_version, true );
	
	$admin_texts = array(
		'select_images' 			=> esc_html__('Select Images', 'gostore')
		,'use_images' 				=> esc_html__('Use images', 'gostore')
		,'choose_an_image' 			=> esc_html__('Choose an image', 'gostore')
		,'use_image' 				=> esc_html__('Use image', 'gostore')
		,'delete_sidebar_confirm' 	=> esc_html__('Do you want to delete this sidebar?', 'gostore')
		,'delete_sidebar_failed' 	=> esc_html__('Cant delete the sidebar. Please try again!', 'gostore')
	);
	wp_localize_script('gostore-admin-script', 'gostore_admin_texts', $admin_texts);
}
add_action('admin_enqueue_scripts', 'gostore_register_admin_scripts');

/*** Global Page Options ***/
if( !function_exists('gostore_set_global_page_options') ){
	function gostore_set_global_page_options( $page_id = 0 ){
		global $gostore_page_options;
		$post_custom = get_post_custom( $page_id );
		if( !is_array($post_custom) ){
			$post_custom = array();
		}
		foreach( $post_custom as $key => $value ){
			if( isset($value[0]) ){
				$gostore_page_options[$key] = $value[0];
			}
		}
		
		$default_options = array(
							'ts_layout_fullwidth'					=> 'default'
							,'ts_header_layout_fullwidth'			=> 1
							,'ts_main_content_layout_fullwidth'		=> 1
							,'ts_footer_layout_fullwidth'			=> 1
							,'ts_layout_style'						=> 'default'
							,'ts_page_layout'						=> '0-1-0'
							,'ts_left_sidebar'						=> ''
							,'ts_right_sidebar'						=> ''
							,'ts_header_layout'						=> 'default'
							,'ts_menu_id'							=> 0
							,'ts_vertical_menu_id'					=> 0
							,'ts_display_vertical_menu_by_default'	=> 0
							,'ts_breadcrumb_layout'					=> 'default'
							,'ts_breadcrumb_bg_parallax'			=> 'default'
							,'ts_bg_breadcrumbs'					=> ''
							,'ts_logo'								=> ''
							,'ts_logo_mobile'						=> ''
							,'ts_logo_sticky'						=> ''
							,'ts_show_breadcrumb'					=> 1
							,'ts_show_page_title'					=> 1
							,'ts_page_slider'						=> 0
							,'ts_page_slider_position'				=> 'before_main_content'
							,'ts_rev_slider'						=> 0
							,'ts_footer_block'						=> 0
							);
		$gostore_page_options = array_merge($default_options, (array) $gostore_page_options);
		return $gostore_page_options;
	}
}

if( !function_exists('gostore_get_page_options') ){
	function gostore_get_page_options( $key = '', $default = '' ){
		global $gostore_page_options;
		if( !$key ){
			return $gostore_page_options;
		}
		else if( isset($gostore_page_options[$key]) ){
			return $gostore_page_options[$key];
		}
		else{
			return $default;
		}
	}
}

/*** Vertical Menu Heading ***/
if( !function_exists ('gostore_get_vertical_menu_heading') ){
	function gostore_get_vertical_menu_heading(){
		if( is_page() ){
			global $post;
			$menu_id = get_post_meta($post->ID, 'ts_vertical_menu_id', true);
			if( $menu_id ){
				$menu = wp_get_nav_menu_object($menu_id);
				if( isset( $menu->name ) ){
					return $menu->name;
				}
			}	
		}
		
		$locations = get_nav_menu_locations();
		if( isset($locations['vertical']) ){
			$menu = wp_get_nav_menu_object($locations['vertical']);
			if( isset( $menu->name ) ){
				return $menu->name;
			}
		}
		return esc_html__('Shop by category', 'gostore');
	}
}

/*** Get excerpt ***/
if( !function_exists ('gostore_string_limit_words') ){
	function gostore_string_limit_words($string, $word_limit){
		$words = explode(' ', $string, ($word_limit + 1));
		if( count($words) > $word_limit ){
			array_pop($words);
		}
		return implode(' ', $words);
	}
}

if( !function_exists ('gostore_the_excerpt_max_words') ){
	function gostore_the_excerpt_max_words( $word_limit = -1, $post = '', $strip_tags = true, $extra_str = '', $echo = true ) {
		if( $post ){
			$excerpt = gostore_get_the_excerpt_by_id($post->ID);
		}
		else{
			$excerpt = get_the_excerpt();
		}
			
		if( $strip_tags ){
			$excerpt = wp_strip_all_tags($excerpt);
			$excerpt = strip_shortcodes($excerpt);
		}
			
		if( $word_limit != -1 ){
			$result = gostore_string_limit_words($excerpt, $word_limit);
			if( $result != $excerpt ){
				$result .= $extra_str;
			}
		}	
		else{
			$result = $excerpt;
		}
			
		if( $echo ){
			echo do_shortcode($result);
		}
		return $result;
	}
}

if( !function_exists('gostore_get_the_excerpt_by_id') ){
	function gostore_get_the_excerpt_by_id( $post_id = 0 )
	{
		global $wpdb;
		$query = "SELECT post_excerpt, post_content FROM $wpdb->posts WHERE ID = %d LIMIT 1";
		$result = $wpdb->get_results( $wpdb->prepare($query, $post_id), ARRAY_A );
		if( $result[0]['post_excerpt'] ){
			return $result[0]['post_excerpt'];
		}
		else{
			$content = $result[0]['post_content'];
			if( false !== strpos( $content, '<!--nextpage-->' ) ){
				$pages = explode( '<!--nextpage-->', $content );
				return $pages[0];
			}
			return $content;
		}
	}
}

/* Get User Role */
if( !function_exists('gostore_get_user_role') ){
	function gostore_get_user_role( $user_id ){
		global $wpdb;
		$user = get_userdata( $user_id );
		$capabilities = $user->{$wpdb->prefix . 'capabilities'};
		if( empty($capabilities) ){
			return '';
		}
		if ( !isset( $wp_roles ) ){
			$wp_roles = new WP_Roles();
		}
		foreach ( $wp_roles->role_names as $role => $name ) {
			if ( array_key_exists( $role, $capabilities ) ) {
				return $role;
			}
		}
		return '';
	}
}

/*** Page Layout Columns Class ***/
if( !function_exists('gostore_page_layout_columns_class') ){
	function gostore_page_layout_columns_class($page_column, $left_sidebar_name = '', $right_sidebar_name = ''){
		$data = array();
		
		if( empty($page_column) ){
			$page_column = '0-1-0';
		}
		
		$layout_config = explode('-', $page_column);
		$left_sidebar = (int)$layout_config[0];
		$right_sidebar = (int)$layout_config[2];
		
		if( $left_sidebar_name && !is_active_sidebar( $left_sidebar_name ) ){
			$left_sidebar = 0;
		}
		
		if( $right_sidebar_name && !is_active_sidebar( $right_sidebar_name ) ){
			$right_sidebar = 0;
		}
		
		$main_class = ($left_sidebar + $right_sidebar) == 2 ?'ts-col-12':( ($left_sidebar + $right_sidebar) == 1 ?'ts-col-18':'ts-col-24' );			
		
		$data['left_sidebar'] = $left_sidebar;
		$data['right_sidebar'] = $right_sidebar;
		$data['main_class'] = $main_class;
		$data['left_sidebar_class'] = 'ts-col-6';
		$data['right_sidebar_class'] = 'ts-col-6';
		
		return $data;
	}
}

/*** Show Page Slider ***/
function gostore_show_page_slider(){
	$page_options = gostore_get_page_options();
	switch( $page_options['ts_page_slider'] ){
		case 'revslider':
			if( class_exists('RevSliderSlider') && $page_options['ts_rev_slider'] ){
				echo do_shortcode('[rev_slider alias="'.$page_options['ts_rev_slider'].'"]');
			}
		break;
		default:
		break;
	}
}

/*** Get Portfolio Page Info ***/
function gostore_get_portfolio_page_info( $return_url = false ){
	$page_id = gostore_get_theme_options('ts_portfolio_page');
	if( $page_id ){
		if( $return_url ){
			return get_permalink($page_id);
		}
		else{
			$page = get_post( $page_id );
			if( $page ){
				return array( 'title' => $page->post_title, 'url' => get_permalink($page_id) );
			}
		}
	}
	return '';
}

/*** Breadcrumbs ***/
if( !function_exists('gostore_breadcrumbs') ){
	function gostore_breadcrumbs(){
		$delimiter_char = '&#8250;';
		if( class_exists('WooCommerce') ){
			if( function_exists('woocommerce_breadcrumb') && function_exists('is_woocommerce') && is_woocommerce() ){
				woocommerce_breadcrumb(array('wrap_before'=>'<div class="breadcrumbs"><div class="breadcrumbs-container">','delimiter'=>'<span>'.$delimiter_char.'</span>','wrap_after'=>'</div></div>'));
				return;
			}
		}

		$allowed_html = array(
			'a'		=> array('href' => array(), 'title' => array())
			,'span'	=> array('class' => array())
			,'div'	=> array('class' => array())
		);
		$output = '';

		$delimiter = '<span class="brn_arrow">'.$delimiter_char.'</span>';
		
		$ar_title = array(
					'home'			=> __('Home', 'gostore')
					,'search' 		=> __('Search results for ', 'gostore')
					,'404' 			=> __('Error 404', 'gostore')
					,'tagged' 		=> __('Tagged ', 'gostore')
					,'author' 		=> __('Articles posted by ', 'gostore')
					,'page' 		=> __('Page', 'gostore')
					);
	  
		$before = '<span class="current">'; /* tag before the current crumb */
		$after = '</span>'; /* tag after the current crumb */
		global $wp_rewrite, $post;
		$rewriteUrl = $wp_rewrite->using_permalinks();
		if( !is_home() && !is_front_page() || is_paged() ){
			$output .= '<div class="breadcrumbs"><div class="breadcrumbs-container">';
	 
			$homeLink = esc_url( home_url('/') ); 
			$output .= '<a href="' . $homeLink . '">' . $ar_title['home'] . '</a> ' . $delimiter . ' ';
	 
			if( is_category() ){
				global $wp_query;
				$cat_obj = $wp_query->get_queried_object();
				$thisCat = $cat_obj->term_id;
				$thisCat = get_category($thisCat);
				$parentCat = get_category($thisCat->parent);
				if( $thisCat->parent != 0 ){ 
					$output .= get_category_parents($parentCat, true, ' ' . $delimiter . ' ');
				}
				$output .= $before . single_cat_title('', false) . $after;
			}
			elseif( is_search() ){
				$output .= $before . $ar_title['search'] . '"' . get_search_query() . '"' . $after;
			}elseif( is_day() ){
				$output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				$output .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
				$output .= $before . get_the_time('d') . $after;
			}elseif( is_month() ){
				$output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				$output .= $before . get_the_time('F') . $after;
			}elseif( is_year() ){
				$output .= $before . get_the_time('Y') . $after;
			}elseif( is_single() && !is_attachment() ){
				if( get_post_type() != 'post' ){
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					$post_type_name = $post_type->labels->singular_name;
					if( is_singular('ts_portfolio') ){
						$portfolio_page_info = gostore_get_portfolio_page_info();
						if( $portfolio_page_info ){
							$post_type_name = $portfolio_page_info['title'];
							$portfolio_url = $portfolio_page_info['url'];
						}
					}
					if( $rewriteUrl ){
						$output .= '<a href="' . (isset($portfolio_url)?$portfolio_url:$homeLink . $slug['slug'] . '/') . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}else{
						$output .= '<a href="' . (isset($portfolio_url)?$portfolio_url:$homeLink . '?post_type=' . get_post_type()) . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}
					$output .= $before . get_the_title() . $after;
			    }else{
					$cat = get_the_category(); $cat = $cat[0];
					$output .= get_category_parents($cat, true, ' ' . $delimiter . ' ');
					$output .= $before . get_the_title() . $after;
			    }
			}elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$post_type_name = $post_type->labels->singular_name;
			    if( isset($slug['slug']) && $slug['slug'] == 'portfolio' ){
					$portfolio_page_info = gostore_get_portfolio_page_info();
					if( $portfolio_page_info ){
						$post_type_name = $portfolio_page_info['title'];
						$portfolio_url = $portfolio_page_info['url'];
					}
			    }
				if( is_tag() ){
					$output .= $before . $ar_title['tagged'] . '"' . single_tag_title('', false) . '"' . $after;
				}
				elseif( is_taxonomy_hierarchical(get_query_var('taxonomy')) ){
					if( $rewriteUrl ){
						$output .= '<a href="' . (isset($portfolio_url)?$portfolio_url:$homeLink . $slug['slug'] . '/') . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}else{
						$output .= '<a href="' . (isset($portfolio_url)?$portfolio_url:$homeLink . '?post_type=' . get_post_type()) . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}			
					
					$curTaxanomy = get_query_var('taxonomy');
					$curTerm = get_query_var( 'term' );
					$termNow = get_term_by( 'name', $curTerm, $curTaxanomy );
					$pushPrintArr = array();
					if( $termNow !== false ){
						while( (int)$termNow->parent != 0 ){
							$parentTerm = get_term((int)$termNow->parent,get_query_var('taxonomy'));
							array_push($pushPrintArr,'<a href="' . get_term_link((int)$parentTerm->term_id,$curTaxanomy) . '">' . $parentTerm->name . '</a> ' . $delimiter . ' ');
							$curTerm = $parentTerm->name;
							$termNow = get_term_by( 'name', $curTerm, $curTaxanomy );
						}
					}
					$pushPrintArr = array_reverse($pushPrintArr);
					array_push($pushPrintArr,$before  . get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->name  . $after);
					$output .= implode($pushPrintArr);
				}else{
					$output .= $before . $post_type_name . $after;
				}
			}elseif( is_attachment() ){
				if( (int)$post->post_parent > 0 ){
					$parent = get_post($post->post_parent);
					$cat = get_the_category($parent->ID);
					if( count($cat) > 0 ){
						$cat = $cat[0];
						$output .= get_category_parents($cat, true, ' ' . $delimiter . ' ');
					}
					$output .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
				}
				$output .= $before . get_the_title() . $after;
			}elseif( is_page() && !$post->post_parent ){
				$output .= $before . get_the_title() . $after;
			}elseif( is_page() && $post->post_parent ){
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while( $parent_id ){
					$page = get_post($parent_id);
					$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
			    }
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach( $breadcrumbs as $crumb ){
					$output .= $crumb . ' ' . $delimiter . ' ';
				}
				$output .= $before . get_the_title() . $after;
			}elseif( is_tag() ){
				$output .= $before . $ar_title['tagged'] . '"' . single_tag_title('', false) . '"' . $after;
			}elseif( is_author() ){
				global $author;
				$userdata = get_userdata($author);
				$output .= $before . $ar_title['author'] . $userdata->display_name . $after;
			}elseif( is_404() ){
				$output .= $before . $ar_title['404'] . $after;
			}
			if( get_query_var('paged') || get_query_var('page') ){
				if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page_template() ||  is_post_type_archive() || is_archive() ){ 
					$output .= $before .' ('; 
				}
				$output .= $ar_title['page'] . ' ' . ( get_query_var('paged')?get_query_var('paged'):get_query_var('page') );
				if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page_template() ||  is_post_type_archive() || is_archive() ){ 
					$output .= ')'. $after; 
				}
			}
			$output .= '</div></div>';
	    }
		
		echo wp_kses($output, $allowed_html);
		
		wp_reset_postdata();
	}
}

if( !function_exists('gostore_breadcrumbs_title') ){
	function gostore_breadcrumbs_title( $show_breadcrumb = false, $show_page_title = false, $page_title = '', $extra_class_title = '' ){
		$theme_options = gostore_get_theme_options();
		if( $show_breadcrumb || $show_page_title ){
			$breadcrumb_bg_option = is_array($theme_options['ts_bg_breadcrumbs'])?$theme_options['ts_bg_breadcrumbs']['url']:$theme_options['ts_bg_breadcrumbs'];
			$breadcrumb_bg = '';
			$classes = array();
			$classes[] = 'breadcrumb-title-wrapper breadcrumb-' . $theme_options['ts_breadcrumb_layout'];
			$classes[] = $show_breadcrumb?'':'no-breadcrumb';
			$classes[] = $show_page_title?'':'no-title';
			if( $theme_options['ts_enable_breadcrumb_background_image'] && ( $theme_options['ts_breadcrumb_layout'] == 'v3' ) ){
				if( $breadcrumb_bg_option == '' ){ /* No Override */
					$breadcrumb_bg = get_template_directory_uri() . '/images/bg_breadcrumb_'.$theme_options['ts_breadcrumb_layout'].'.jpg';
				}	
				else{
					$breadcrumb_bg = $breadcrumb_bg_option;
				}
			}
			
			$style = '';
			if( $breadcrumb_bg != '' ){
				$style = 'style="background-image: url('. esc_url($breadcrumb_bg) .')"';
				if( $theme_options['ts_breadcrumb_bg_parallax'] ){
					$classes[] = 'ts-breadcrumb-parallax';
				}
			}
			echo '<div class="'.esc_attr(implode(' ', array_filter($classes))).'" '.$style.'><div class="breadcrumb-content container"><div class="breadcrumb-title">';
			
			if( $show_page_title ){
				echo '<h1 class="heading-title page-title entry-title '.$extra_class_title.'">'.$page_title.'</h1>';
			}
			
			if( $show_breadcrumb ){
				gostore_breadcrumbs();
			}
			
			echo '</div></div></div>';
		}
	}
}

/*** Pagination ***/
if( !function_exists('gostore_pagination') ){
	function gostore_pagination( $query = null ){
		global $wp_query;
		$max_num_pages = $wp_query->max_num_pages;
		$paged = $wp_query->get( 'paged' );
		if( $query != null ){
			$max_num_pages = $query->max_num_pages;
			$paged = $query->get( 'paged' );
		}
		if( !$paged ){
			$paged = 1;
		}
		?>
		<nav class="ts-pagination">
			<?php
			echo paginate_links( array(
				'base'         	=> esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) )
				,'format'       => ''
				,'add_args'     => ''
				,'current'      => max( 1, $paged )
				,'total'        => $max_num_pages
				,'prev_text'    => esc_html__('Prev', 'gostore')
				,'next_text'    => esc_html__('Next', 'gostore')
				,'type'         => 'list'
				,'end_size'     => 3
				,'mid_size'     => 3
			) );
			?>
		</nav>
		<?php
	}
}

/*** Logo ***/
if( !function_exists('gostore_theme_logo') ){
	function gostore_theme_logo(){
		$theme_options = gostore_get_theme_options();
		$logo_image = is_array($theme_options['ts_logo'])?$theme_options['ts_logo']['url']:$theme_options['ts_logo'];
		$logo_image_mobile = is_array($theme_options['ts_logo_mobile'])?$theme_options['ts_logo_mobile']['url']:$theme_options['ts_logo_mobile'];
		$logo_image_sticky = is_array($theme_options['ts_logo_sticky'])?$theme_options['ts_logo_sticky']['url']:$theme_options['ts_logo_sticky'];
		$logo_text = stripslashes($theme_options['ts_text_logo']);
		
		if( !$logo_image_mobile ){
			$logo_image_mobile = $logo_image;
		}
		if( !$logo_image_sticky ){
			$logo_image_sticky = $logo_image;
		}
		if( !$logo_text ){
			$logo_text = get_bloginfo('name');
		}
		?>
		<div class="logo">
			<a href="<?php echo esc_url( home_url('/') ); ?>">
			<?php if( $logo_image ): ?>
				<img src="<?php echo esc_url($logo_image); ?>" alt="<?php echo esc_attr($logo_text); ?>" title="<?php echo esc_attr($logo_text); ?>" class="normal-logo" />
			<?php endif; ?>
			
			<?php if( $logo_image_mobile ): ?>
				<img src="<?php echo esc_url($logo_image_mobile); ?>" alt="<?php echo esc_attr($logo_text); ?>" title="<?php echo esc_attr($logo_text); ?>" class="mobile-logo" />
			<?php endif; ?>
			
			<?php if( $logo_image_sticky ): ?>
				<img src="<?php echo esc_url($logo_image_sticky); ?>" alt="<?php echo esc_attr($logo_text); ?>" title="<?php echo esc_attr($logo_text); ?>" class="sticky-logo" />
			<?php endif; ?>
			
			<?php 
			if( !$logo_image ){
				echo esc_html($logo_text); 
			}
			?>
			</a>
		</div>
		<?php
	}
}

/*** Pingback URL ***/
add_action('wp_head', 'gostore_pingback_header');
if( !function_exists('gostore_pingback_header') ){
	function gostore_pingback_header(){
		if( is_singular() && pings_open() ){
		?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
		}
	}
}

/*** Favicon ***/
if( !function_exists('gostore_theme_favicon') ){
	function gostore_theme_favicon(){
		if( function_exists('wp_site_icon') && function_exists('has_site_icon') && has_site_icon() ){
			return;
		}
		$favicon_option = gostore_get_theme_options('ts_favicon');
		$favicon = is_array($favicon_option)?$favicon_option['url']:$favicon_option;
		if( $favicon ):
		?>
			<link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" />
		<?php
		endif;
	}
}

/*** Header Template ***/
if( !function_exists('gostore_get_header_template') ){
	function gostore_get_header_template(){
		get_template_part('templates/headers/header', gostore_get_theme_options('ts_header_layout'));
	}
}

if( !function_exists('gostore_get_footer_content') ){
	function gostore_get_footer_content( $footer_block_id = 0 ){
		if( class_exists('Elementor\Plugin') && in_array( 'ts_footer_block', get_option( 'elementor_cpt_support', array() ) ) ){
			echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $footer_block_id );
		}
		else{
			$post = get_post( $footer_block_id );
			if( is_object( $post ) ){
				echo do_shortcode( $post->post_content );
			}
		}
	}
}

/*** Store Notice ***/
if( !function_exists('gostore_store_notice') ){
	function gostore_store_notice(){
		if( !isset($_COOKIE['ts_store_notice']) && $store_notice = gostore_get_theme_options('ts_store_notice') ){
		?>
			<div class="ts-store-notice">
				<div class="content">
					<?php echo do_shortcode( wp_kses_post( $store_notice ) ); /* Allowed html as post content */ ?>
				</div>
				<span class="close"></span>
			</div>
		<?php
		}
	}
}

/*** Product Search Form by Category ***/
if( !function_exists('gostore_get_search_form_by_category') ){
	function gostore_get_search_form_by_category(){
		$enable_category = gostore_get_theme_options('ts_search_by_category');
		
		$search_for_product = class_exists('WooCommerce');
		if( $search_for_product ){
			$taxonomy = 'product_cat';
			$post_type = 'product';
			$placeholder_text = __('Search for products', 'gostore');
		}
		else{
			$taxonomy = 'category';
			$post_type = 'post';
			$placeholder_text = __('Search', 'gostore');
		}
		
		?>
		<div class="ts-search-by-category <?php echo esc_attr($enable_category?'':'no-category'); ?>">
			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if( $enable_category ): ?>
					<select class="select-category" name="term"><?php echo gostore_search_by_category_get_option_html($taxonomy, 0, 0); ?></select>
				<?php endif; ?>
				<div class="search-content">
					<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php echo esc_attr($placeholder_text) ?>" autocomplete="off" />
					<input type="submit" title="<?php esc_attr_e( 'Search', 'gostore' ); ?>" value="<?php esc_attr_e( 'Search', 'gostore' ); ?>" />
					<input type="hidden" name="post_type" value="<?php echo esc_attr($post_type) ?>" />
					<?php if( $enable_category ): ?>
						<input type="hidden" name="taxonomy" value="<?php echo esc_attr($taxonomy) ?>" />
					<?php endif; ?>
				</div>
			</form>
		</div>
		<?php	
	}
}

if( !function_exists('gostore_search_by_category_get_option_html') ){
	function gostore_search_by_category_get_option_html($taxonomy = 'product_cat', $parent = 0, $level = 0){
		$options = '';
		$spacing = '';
		
		if( $level == 0 ){
			$options = '<option value="">'.esc_html__('All categories', 'gostore').'</option>';
		}
		
		for( $i = 0; $i < $level * 3 ; $i++ ){
			$spacing .= '&nbsp;';
		}
		
		$args = array(
			'taxonomy'		=> $taxonomy
			,'number'     	=> ''
			,'hide_empty'	=> 1
			,'orderby'		=>'name'
			,'order'		=>'asc'
			,'parent'		=> $parent
		);
		
		$select = '';
		$categories = get_terms($args);
		if( is_search() &&  isset($_GET['term']) && $_GET['term'] != '' ){
			$select = $_GET['term'];
		}
		$level++;
		if( is_array($categories) ){
			foreach( $categories as $cat ){
				$options .= '<option value="' . $cat->slug . '" ' . selected($select, $cat->slug, false) . '>' . $spacing . $cat->name . '</option>';
				$options .= gostore_search_by_category_get_option_html($taxonomy, $cat->term_id, $level);
			}
		}
		
		return $options;
	}
}

/* Ajax search */
add_action( 'wp_ajax_gostore_ajax_search', 'gostore_ajax_search' );
add_action( 'wp_ajax_nopriv_gostore_ajax_search', 'gostore_ajax_search' );
if( !function_exists('gostore_ajax_search') ){
	function gostore_ajax_search(){
		global $wpdb, $post;
		
		$search_for_product = class_exists('WooCommerce');
		if( $search_for_product ){
			$taxonomy = 'product_cat';
			$post_type = 'product';
		}
		else{
			$taxonomy = 'category';
			$post_type = 'post';
		}
		
		$num_result = (int)gostore_get_theme_options('ts_ajax_search_number_result');
		$desc_limit_words = (int)gostore_get_theme_options('ts_prod_cat_desc_words');
		
		$search_string = stripslashes($_POST['search_string']);
		$category = isset($_POST['category'])? $_POST['category']: '';
		
		$args = array(
			'post_type'			=> $post_type
			,'post_status'		=> 'publish'
			,'s'				=> $search_string
			,'posts_per_page'	=> $num_result
			,'tax_query'		=> array()
		);
		
		if( $search_for_product ){
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query'] = WC()->query->get_tax_query();
		}
		
		if( $category != '' ){
			$args['tax_query'][] = array(
					'taxonomy'  => $taxonomy
					,'terms'	=> $category
					,'field'	=> 'slug'
				);
		}
		
		$results = new WP_Query($args);
		
		if( $results->have_posts() ){
			$extra_class = '';
			if( isset($results->post_count, $results->found_posts) && $results->found_posts > $results->post_count ){
				$extra_class = 'has-view-all';
			}
			
			$html = '<ul class="product_list_widget '.$extra_class.'">';
			while( $results->have_posts() ){
				$results->the_post();
				$link = get_permalink($post->ID);
				
				$image = '';
				if( $post_type == 'product' ){
					$product = wc_get_product($post->ID);
					$image = $product->get_image();
				}
				else if( has_post_thumbnail($post->ID) ){
					$image = get_the_post_thumbnail($post->ID, 'thumbnail');
				}
				
				$html .= '<li>';
					$html .= '<div class="ts-wg-thumbnail">';
						$html .= '<a href="'.esc_url($link).'">'. $image .'</a>';
					$html .= '</div>';
					$html .= '<div class="ts-wg-meta">';
						$html .= '<a href="'.esc_url($link).'" class="title">'. gostore_search_highlight_string($post->post_title, $search_string) .'</a>';
						$html .= '<div class="description">'. gostore_the_excerpt_max_words($desc_limit_words, '', true, ' ...', false) .'</div>';
						if( $post_type == 'product' ){
							if( $price_html = $product->get_price_html() ){
								$html .= '<span class="price">'. $price_html .'</span>';
							}
						}
					$html .= '</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			
			if( isset($results->post_count, $results->found_posts) && $results->found_posts > $results->post_count ){
				$view_all_text = sprintf( esc_html__('View all %d results', 'gostore'), $results->found_posts );
				
				$html .= '<div class="view-all-wrapper">';
					$html .= '<a href="#">'. $view_all_text .'</a>';
				$html .= '</div>';
			}
			
			wp_reset_postdata();
			
			$return = array();
			$html = '<div class="search-content">'.$html.'</div>';
			$return['html'] = $html;
			$return['search_string'] = $search_string;
			die( json_encode($return) );
		}
		
		$return = array();
		$return['html'] = '<p>'.esc_html__('No products were found', 'gostore').'</p>';
		$return['search_string'] = $search_string;
		die( json_encode($return) );
	}
}

if( !function_exists('gostore_search_highlight_string') ){
	function gostore_search_highlight_string($string, $search_string){
		$new_string = '';
		$pos_left = stripos($string, $search_string);
		if( $pos_left !== false ){
			$pos_right = $pos_left + strlen($search_string);
			$new_string_right = substr($string, $pos_right);
			$search_string_insensitive = substr($string, $pos_left, strlen($search_string));
			$new_string_left = stristr($string, $search_string, true);
			$new_string = $new_string_left . '<span class="hightlight">' . $search_string_insensitive . '</span>' . $new_string_right;
		}
		else{
			$new_string = $string;
		}
		return $new_string;
	}
}

/* Get post comment count */
if( !function_exists('gostore_get_post_comment_count') ){
	function gostore_get_post_comment_count( $post_id = 0 ){
		global $post;
		if( !$post_id ){
			$post_id = $post->ID;
		}
		
		$comments_count = wp_count_comments($post_id); 
		return $comments_count->approved;
	}
}

/* Match with ajax search results */
add_filter('woocommerce_get_catalog_ordering_args', 'gostore_woocommerce_get_catalog_ordering_args_filter');
if( !function_exists('gostore_woocommerce_get_catalog_ordering_args_filter') ){
	function gostore_woocommerce_get_catalog_ordering_args_filter( $args ){
		if( is_search() && !isset($_GET['orderby']) && get_option( 'woocommerce_default_catalog_orderby' ) == 'menu_order' 
			&& gostore_get_theme_options('ts_ajax_search') ){
			$args['orderby'] = '';
			$args['order'] = '';
		}
		return $args;
	}
}

/* Add to cart popup */
add_action('wp_footer', 'gostore_add_to_cart_popup_modal');
function gostore_add_to_cart_popup_modal(){
	if( gostore_get_theme_options('ts_add_to_cart_effect') == 'show_popup' ){
	?>
	<div id="ts-add-to-cart-popup-modal" class="ts-popup-modal">
		<div class="overlay"></div>
		<div class="add-to-cart-popup-container popup-container">
			<span class="close"></span>
			<div class="add-to-cart-popup-content"></div>
		</div>
	</div>
	<?php
	}
}

add_action('wp_ajax_gostore_load_product_added_to_cart', 'gostore_load_product_added_to_cart' );
add_action('wp_ajax_nopriv_gostore_load_product_added_to_cart', 'gostore_load_product_added_to_cart' );
function gostore_load_product_added_to_cart(){
	if( isset($_POST['product_id']) ){
		$product_id = absint($_POST['product_id']);
		$product = wc_get_product( $product_id );
		if( !is_object($product) ){
			die( esc_html__('Invalid Product', 'gostore') );
		}
		ob_start();
		?>
		<div class="heading">
			<h5 class="theme-title"><?php esc_html_e('Product is added to cart', 'gostore'); ?></h5>
		</div>
		<div class="item">
			<div class="product-image">
				<?php echo wp_kses( $product->get_image(), 'gostore_product_image' ); ?>
			</div>
			<div class="product-meta">
				<h3 class="heading-title product-name"><a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-name">
					<?php echo esc_html( $product->get_title() ); ?>
				</a></h3>
				<span class="price"><?php echo wp_kses( $product->get_price_html(), 'gostore_product_price' ); ?></span>
			</div>
		</div>
		<div class="action">
			<a href="<?php echo wc_get_cart_url(); ?>" class="button view-cart"><?php esc_html_e('View Cart', 'gostore'); ?></a>
			<a href="<?php echo wc_get_checkout_url(); ?>" class="button checkout"><?php esc_html_e('Checkout', 'gostore'); ?></a>
		</div>
		<?php
		die( ob_get_clean() );
	}
}

/* Single product - Ajax add to cart message */
add_action('wp_footer', 'gostore_ajax_add_to_cart_message');
function gostore_ajax_add_to_cart_message(){
	if( gostore_get_theme_options('ts_prod_ajax_add_to_cart') ){
	?>
		<div id="ts-ajax-add-to-cart-message">
			<span><?php esc_html_e('Product has been added to your cart', 'gostore'); ?></span>
			<span class="error-message"></span>
		</div>
	<?php
	}
}

/* Support Dokan */
function gostore_load_dokan_style(){
	if( !class_exists('WeDevs_Dokan') ){
		return false;
	}
	if( ( function_exists('dokan_is_store_page') && dokan_is_store_page() ) 
		|| ( function_exists('dokan_is_product_edit_page') && dokan_is_product_edit_page() )
		|| ( function_exists('dokan_is_seller_dashboard') && dokan_is_seller_dashboard() )
		|| ( function_exists('dokan_is_store_review_page') && dokan_is_store_review_page() )
		|| ( function_exists('dokan_is_store_listing') && dokan_is_store_listing() )
		|| apply_filters( 'gostore_forced_load_dokan_style', false ) ){
		return true;	
	}
	return false;
}

add_action('dokan_dashboard_wrap_before', 'gostore_dokan_dashboard_wrap_before', 10, 2);
add_action('dokan_edit_product_wrap_before', 'gostore_dokan_dashboard_wrap_before', 10, 2);
function gostore_dokan_dashboard_wrap_before( $post, $post_id ){
	if( isset( $_GET['product_id'] ) ){
		return;
	}
	gostore_breadcrumbs_title(true, true, get_the_title());
	?>
	<div class="page-container show_breadcrumb_<?php echo gostore_get_theme_options('ts_breadcrumb_layout') ?>">
		<div id="main-content" class="ts-col-24">
	<?php
}

add_action('dokan_dashboard_wrap_after', 'gostore_dokan_dashboard_wrap_after', 10, 2);
add_action('dokan_edit_product_wrap_after', 'gostore_dokan_dashboard_wrap_after', 10, 2);
function gostore_dokan_dashboard_wrap_after( $post, $post_id ){
	if( isset( $_GET['product_id'] ) ){
		return;
	}
	?>
		</div>
	</div>
	<?php
}

/* Install Required Plugins */
add_action( 'tgmpa_register', 'gostore_register_required_plugins' );
function gostore_register_required_plugins(){
	$plugin_dir_path = get_template_directory() . '/framework/plugins/';
    $plugins = array(

        array(
            'name'                => 'ThemeSky'
            ,'slug'               => 'themesky'
            ,'source'             => $plugin_dir_path . 'themesky.zip'
            ,'required'           => true
            ,'version'            => '1.0.9'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'One Click Demo Import'
            ,'slug'               => 'one-click-demo-import'
			,'source'             => 'https://downloads.wordpress.org/plugin/one-click-demo-import.3.1.2.zip'
            ,'required'           => false
			,'version'            => '3.1.2'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'Redux Framework'
            ,'slug'               => 'redux-framework'
			,'source'             => 'https://downloads.wordpress.org/plugin/redux-framework.4.3.19.zip'
            ,'required'           => true
			,'version'            => '4.3.19'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'WooCommerce'
            ,'slug'               => 'woocommerce'
			,'source'             => 'https://downloads.wordpress.org/plugin/woocommerce.6.9.4.zip'
            ,'required'           => true
			,'version'            => '6.9.4'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'Elementor'
            ,'slug'               => 'elementor'
			,'source'             => 'https://downloads.wordpress.org/plugin/elementor.3.7.8.zip'
            ,'required'           => true
			,'version'            => '3.7.8'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'Slider Revolution'
            ,'slug'               => 'revslider'
            ,'source'             => $plugin_dir_path . 'revslider.zip'
            ,'required'           => false
            ,'version'            => '6.6.2'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'Contact Form 7'
            ,'slug'               => 'contact-form-7'
			,'source'             => 'https://downloads.wordpress.org/plugin/contact-form-7.5.6.3.zip'
            ,'required'           => false
			,'version'            => '5.6.3'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'MailChimp for WordPress'
            ,'slug'               => 'mailchimp-for-wp'
			,'source'             => 'https://downloads.wordpress.org/plugin/mailchimp-for-wp.4.8.10.zip'
            ,'required'           => false
			,'version'            => '4.8.10'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'YITH WooCommerce Wishlist'
            ,'slug'               => 'yith-woocommerce-wishlist'
			,'source'             => 'https://downloads.wordpress.org/plugin/yith-woocommerce-wishlist.3.14.0.zip'
            ,'required'           => false
			,'version'            => '3.14.0'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'YITH WooCommerce Compare'
            ,'slug'               => 'yith-woocommerce-compare'
			,'source'             => 'https://downloads.wordpress.org/plugin/yith-woocommerce-compare.2.19.0.zip'
            ,'required'           => false
			,'version'            => '2.19.0'
            ,'external_url'       => ''
        )
		,array(
            'name'                => 'Photo Reviews for WooCommerce'
            ,'slug'               => 'woo-photo-reviews'
            ,'required'           => false
        )

    );

    $config = array(
		'id'           	=> 'tgmpa'
		,'default_path' => ''
		,'menu'         => 'tgmpa-install-plugins'
		,'parent_slug'  => 'themes.php'
		,'capability'   => 'edit_theme_options'
		,'has_notices'  => true
		,'dismissable'  => true
		,'dismiss_msg'  => ''
		,'is_automatic' => false
		,'message'      => ''
	);

    tgmpa( $plugins, $config );
}
?>