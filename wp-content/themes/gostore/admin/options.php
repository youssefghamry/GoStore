<?php
$redux_url = '';
if( class_exists('ReduxFramework') ){
	$redux_url = ReduxFramework::$_url;
}

$logo_url 					= get_template_directory_uri() . '/images/logo.png'; 
$favicon_url 				= get_template_directory_uri() . '/images/favicon.ico';

$color_image_folder = get_template_directory_uri() . '/admin/assets/images/colors/';
$list_colors = array('red', 'red2', 'red3', 'red4', 'red5', 'red6', 'red7', 'red8');
$preset_colors_options = array();
foreach( $list_colors as $color ){
	$preset_colors_options[$color] = array(
					'alt'      => $color
					,'img'     => $color_image_folder . $color . '.jpg'
					,'presets' => gostore_get_preset_color_options( $color )
	);
}

$family_fonts = array(
	"Arial, Helvetica, sans-serif"                          => "Arial, Helvetica, sans-serif"
	,"'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif"
	,"'Bookman Old Style', serif"                           => "'Bookman Old Style', serif"
	,"'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive"
	,"Courier, monospace"                                   => "Courier, monospace"
	,"Garamond, serif"                                      => "Garamond, serif"
	,"Georgia, serif"                                       => "Georgia, serif"
	,"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif"
	,"'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace"
	,"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"
	,"'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif"
	,"'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif"
	,"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif"
	,"Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif"
	,"'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif"
	,"'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif"
	,"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif"
	,"CustomFont"                          					=> "CustomFont"
);

$header_layout_options = array();
$header_image_folder = get_template_directory_uri() . '/admin/assets/images/headers/';
for( $i = 1; $i <= 4; $i++ ){
	$header_layout_options['v' . $i] = array(
		'alt'  => sprintf(esc_html__('Header Layout %s', 'gostore'), $i)
		,'img' => $header_image_folder . 'header_v'.$i.'.jpg'
	);
}

$loading_screen_options = array();
$loading_image_folder = get_template_directory_uri() . '/images/loading/';
for( $i = 1; $i <= 10; $i++ ){
	$loading_screen_options[$i] = array(
		'alt'  => sprintf(esc_html__('Loading Image %s', 'gostore'), $i)
		,'img' => $loading_image_folder . 'loading_'.$i.'.svg'
	);
}

$footer_block_options = gostore_get_footer_block_options();

$breadcrumb_layout_options = array();
$breadcrumb_image_folder = get_template_directory_uri() . '/admin/assets/images/breadcrumbs/';
for( $i = 1; $i <= 3; $i++ ){
	$breadcrumb_layout_options['v' . $i] = array(
		'alt'  => sprintf(esc_html__('Breadcrumb Layout %s', 'gostore'), $i)
		,'img' => $breadcrumb_image_folder . 'breadcrumb_v'.$i.'.jpg'
	);
}

$sidebar_options = array();
$default_sidebars = gostore_get_list_sidebars();
if( is_array($default_sidebars) ){
	foreach( $default_sidebars as $key => $_sidebar ){
		$sidebar_options[$_sidebar['id']] = $_sidebar['name'];
	}
}

$product_loading_image = get_template_directory_uri() . '/images/prod_loading.gif';

$option_fields = array();

/*** General Tab ***/
$option_fields['general'] = array(
	array(
		'id'        => 'section-logo-favicon'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Logo - Favicon', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_logo'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Logo', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Select an image file for the main logo', 'gostore' )
		,'readonly' => false
		,'default'  => array( 'url' => $logo_url )
	)
	,array(
		'id'        => 'ts_logo_mobile'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Mobile Logo', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Display this logo on mobile', 'gostore' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'ts_logo_sticky'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Sticky Logo', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Display this logo on sticky header', 'gostore' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'ts_logo_width'
		,'type'     => 'text'
		,'url'      => true
		,'title'    => esc_html__( 'Logo Width', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Set width for logo (in pixels)', 'gostore' )
		,'default'  => '160'
	)
	,array(
		'id'        => 'ts_device_logo_width'
		,'type'     => 'text'
		,'url'      => true
		,'title'    => esc_html__( 'Logo Width on Device', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Set width for logo (in pixels)', 'gostore' )
		,'default'  => '136'
	)
	,array(
		'id'        => 'ts_favicon'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Favicon', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Select a PNG, GIF or ICO image', 'gostore' )
		,'readonly' => false
		,'default'  => array( 'url' => $favicon_url )
	)
	,array(
		'id'        => 'ts_text_logo'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Text Logo', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'GoStore'
	)
	
	,array(
		'id'        => 'section-layout-style'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Layout Style', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Layout Fullwidth', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
	)
	,array(
		'id'        => 'ts_header_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Header Layout Fullwidth', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'ts_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_main_content_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Main Content Layout Fullwidth', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'ts_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_footer_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Footer Layout Fullwidth', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'ts_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'       	=> 'ts_layout_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Layout Style', 'gostore' )
		,'subtitle' => esc_html__( 'You can override this option for the individual page', 'gostore' )
		,'desc'     => ''
		,'options'  => array(
			'wide' 		=> 'Wide'
			,'boxed' 	=> 'Boxed'
		)
		,'default'  => 'wide'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
		,'required'	=> array( 'ts_layout_fullwidth', 'equals', '0' )
	)
	
	,array(
		'id'        => 'section-rtl'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Right To Left', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_enable_rtl'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Right To Left', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
	)
	
	,array(
		'id'        => 'section-smooth-scroll'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Smooth Scroll', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_smooth_scroll'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Smooth Scroll', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
	)
	
	,array(
		'id'        => 'section-back-to-top-button'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Back To Top Button', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_back_to_top_button'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Back To Top Button', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'ts_back_to_top_button_on_mobile'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Back To Top Button On Mobile', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	
	,array(
		'id'        => 'section-loading-screen'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Loading Screen', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_loading_screen'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Loading Screen', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
	)
	,array(
		'id'        => 'ts_loading_image'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Loading Image', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $loading_screen_options
		,'default'  => '1'
	)
	,array(
		'id'        => 'ts_custom_loading_image'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Custom Loading Image', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'       	=> 'ts_display_loading_screen_in'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Display Loading Screen In', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'all-pages' 		=> esc_html__( 'All Pages', 'gostore' )
			,'homepage-only' 	=> esc_html__( 'Homepage Only', 'gostore' )
			,'specific-pages' 	=> esc_html__( 'Specific Pages', 'gostore' )
		)
		,'default'  => 'all-pages'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'ts_loading_screen_exclude_pages'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Exclude Pages', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'data'     => 'pages'
		,'multi'    => true
		,'default'	=> ''
		,'required'	=> array( 'ts_display_loading_screen_in', 'equals', 'all-pages' )
	)
	,array(
		'id'       	=> 'ts_loading_screen_specific_pages'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Specific Pages', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'data'     => 'pages'
		,'multi'    => true
		,'default'	=> ''
		,'required'	=> array( 'ts_display_loading_screen_in', 'equals', 'specific-pages' )
	)
);

/*** Color Scheme Tab ***/
$option_fields['color-scheme'] = array(
	array(
		'id'          => 'ts_color_scheme'
		,'type'       => 'image_select'
		,'presets'    => true
		,'full_width' => false
		,'title'      => esc_html__( 'Select Color Scheme of Theme', 'gostore' )
		,'subtitle'   => ''
		,'desc'       => ''
		,'options'    => $preset_colors_options
		,'default'    => 'red'
	)
	,array(
		'id'        => 'section-general-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'General Colors', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'      => 'info-primary-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Primary Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_primary_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Primary Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_text_color_in_bg_primary'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Text Color In Background Primary Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-heading-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Heading Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'      => 'info-main-content-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Main Content Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_main_content_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Main Content Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#707070'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_text_bold_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Text Bold Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_text_bold_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Text Bold Hover Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_link_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Link Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_link_color_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Link Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#e5e5e5'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_border_product_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#efefef'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-input-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Input Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_input_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Input Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_input_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Input Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d1d1d1'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_input_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Input Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_input_border_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Input Border Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-button-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Button Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_button_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_button_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> 'transparent'
			,'alpha'	=> 0
			,'rgba'		=> 'rgba(0,0,0,0)'
		)
	)
	,array(
		'id'       => 'ts_button_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_button_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_button_background_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Background Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_button_border_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Border Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-special-button-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Special Button Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_special_button_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Special Button Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-breadcrumb-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Breadcrumb Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_breadcrumb_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f6f9fc'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_breadcrumb_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#707070'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_breadcrumb_heading_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Heading Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_breadcrumb_link_color_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Link Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_breadcrumb_img_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Has Background Image - Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_breadcrumb_img_heading_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Has Background Image - Heading Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_breadcrumb_img_link_color_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Has Background Image - Link Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f1f1f1'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'        => 'section-header-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Header Colors', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       => 'ts_header_notice_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Notice Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f6f9fc'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-middle-header-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Middle Header Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_middle_header_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Middle Header Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_middle_header_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Middle Header Text Hover Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_middle_header_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Middle Header Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#131f35'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-header-cart-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Header Cart Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_header_cart_number_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Number Of Cart Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_cart_number_bg_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Number Of Cart Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-header-search-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Header Search Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_header_search_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Search Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#707070'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_search_placeholder_text'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Search Placeholder Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#999999'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_search_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Search Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_search_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Search Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_search_line_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Search Line Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#e5e5e5'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_search_button_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Search Button Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-bottom-header-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Bottom Header Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_bottom_header_info_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Infomation Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#a7a9ae'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_bottom_header_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Bottom Header Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#131f35'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_bottom_header_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Bottom Header Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#2b364a'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'        => 'section-menu-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Menu Colors', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       => 'ts_menu_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_menu_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#cdced1'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-sub-menu-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Sub Menu Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_sub_menu_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sub Menu Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#707070'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_sub_menu_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sub Menu Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_sub_menu_heading_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sub Menu Heading Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_sub_menu_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sub Menu Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-vertical-menu-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Vertical Menu Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_vertical_headding_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Menu Heading Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_vertical_headding_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Menu Heading Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#131f35'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_vertical_menu_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Menu Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_vertical_menu_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Menu Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_vertical_menu_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Menu Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#e5e5e5'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_vertical_menu_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Menu Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_vertical_sub_menu_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Sub Menu Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#707070'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_vertical_sub_menu_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Vertical Sub Menu Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-header-mobile-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Menu Header Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_header_mobile_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Mobile Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#131f35'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_mobile_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Mobile Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_mobile_search_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Mobile Search Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_mobile_search_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Mobile Search Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_mobile_search_button_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Mobile Search Button Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_mobile_cart_number_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Mobile Cart Number Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_header_mobile_cart_number_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Mobile Cart Number Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-menu-mobile-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Menu Mobile Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_tab_menu_mobile_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Tab Mobile Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_tab_menu_mobile_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Tab Mobile Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#131f35'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_tab_menu_mobile_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Tab Mobile Text Hover Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_tab_menu_mobile_background_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Tab Mobile Background Hover Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#1f2a3f'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_menu_mobile_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Mobile Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_menu_mobile_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Mobile Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_menu_mobile_heading_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Mobile Heading Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_menu_mobile_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Mobile Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_menu_mobile_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Menu Mobile Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#e5e5e5'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_bottom_menu_mobile_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Bottom Menu Mobile Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#707070'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_bottom_menu_mobile_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Bottom Menu Mobile Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f6f9fc'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'        => 'section-footer-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Footer Colors', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       => 'ts_footer_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#131f35'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_footer_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#b7b9bc'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_footer_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_footer_heading_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Heading Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_footer_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Border Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#2b364a'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_footer_border_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Border Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_footer_tags_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Heading Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#1a263b'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'        => 'section-product-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Colors', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       => 'ts_product_name_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Name Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_name_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Name Text Hover Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_price_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Price Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_del_price_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Del Price Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#848484'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_sale_price_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Sale Price Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_rating_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Rating Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f9ac00'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_rating_fill_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Rating Fill Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f9ac00'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-product-button-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Thumbnail Product Button Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_product_button_thumbnail_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Thumbnail Button Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_button_thumbnail_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Thumbnail Button Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_button_thumbnail_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Thumbnail Button Text Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_button_thumbnail_background_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Thumbnail Button Background Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_button_thumbnail_tooltip_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Tooltip Thumbnail Button Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_button_thumbnail_tooltip_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Tooltip Thumbnail Button Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-product-label-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Product Label Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_product_sale_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sale Label Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_sale_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sale Label Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#39b54a'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_new_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'New Label Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_new_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'New Label Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#0b5fb5'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_feature_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Feature Label Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_feature_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Feature Label Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#f50000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_outstock_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'OutStock Label Text Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_product_outstock_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'OutStock Label Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#989898'
			,'alpha'	=> 1
		)
	)
	
	,array(
		'id'      => 'info-product-nav-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Product Navigation Colors', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'ts_nav_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Navigation Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_nav_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Navigation Background Color', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_nav_text_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Navigation Color Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'ts_nav_background_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Navigation Background Hover', 'gostore' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#161616'
			,'alpha'	=> 1
		)
	)
);

/*** Typography Tab ***/
$option_fields['typography'] = array(
	array(
		'id'        => 'section-fonts'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Fonts', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       			=> 'ts_body_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Body Font', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> true
		,'text-align'   	=> false
		,'color'   			=> false
		,'letter-spacing' 	=> true
		,'preview'			=> array('always_display' => true)
		,'default'  		=> array(
			'font-family'  		=> 'Rubik'
			,'font-weight' 		=> '400'
			,'font-size'   		=> '14px'
			,'line-height' 		=> '26px'
			,'letter-spacing' 	=> '0'
			,'font-style'   	=> ''
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'ts_body_font_bold'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Body Font Bold', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> true
		,'text-align'   	=> false
		,'line-height'  	=> false
		,'font-size'  		=> false
		,'letter-spacing' 	=> true
		,'color'   			=> false
		,'preview'			=> array('always_display' => true)
		,'default'  		=> array(
			'font-family'  		=> 'Rubik'
			,'font-weight' 		=> '600'
			,'letter-spacing' 	=> '0'
			,'font-style'   	=> ''
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'ts_heading_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Heading Font', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'line-height'  	=> false
		,'font-size'    	=> false
		,'letter-spacing' 	=> true
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Rubik'
			,'font-weight' 		=> '700'
			,'letter-spacing' 	=> '0'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'ts_menu_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Menu Font', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'letter-spacing' 	=> true
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Rubik'
			,'font-weight' 		=> '400'
			,'font-size'   		=> '14px'
			,'line-height' 		=> '20px'
			,'letter-spacing' 	=> '0'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'ts_menu_font_active'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Menu Font Active', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'letter-spacing' 	=> false
		,'font-size'		=> false
		,'line-height'		=> false
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Rubik'
			,'font-weight' 		=> '600'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'ts_sub_menu_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Sub Menu Font', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'letter-spacing' 	=> true
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Rubik'
			,'font-weight' 		=> '400'
			,'font-size'   		=> '14px'
			,'line-height' 		=> '22px'
			,'letter-spacing' 	=> '0'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'ts_mobile_menu_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Mobile Menu Font', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'font-size'		=> false
		,'line-height'		=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'letter-spacing' 	=> true
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Rubik'
			,'font-weight' 		=> '400'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'        => 'section-custom-font'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Custom Font', 'gostore' )
		,'subtitle' => esc_html__( 'If you get the error message \'Sorry, this file type is not permitted for security reasons\', you can add this line define(\'ALLOW_UNFILTERED_UPLOADS\', true); to the wp-config.php file', 'gostore' )
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_custom_font_ttf'
		,'type'     => 'media'
		,'url'      => true
		,'preview'  => false
		,'title'    => esc_html__( 'Custom Font ttf', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Upload the .ttf font file. To use it, you select CustomFont in the Standard Fonts group', 'gostore' )
		,'default'  => array( 'url' => '' )
		,'mode'		=> 'application'
	)
	
	,array(
		'id'        => 'section-font-sizes'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Font Sizes', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'      => 'info-font-size-pc'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Font size on PC', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       		=> 'ts_h1_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H1 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   => '72px'
			,'line-height' => '82px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h2_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H2 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   => '42px'
			,'line-height' => '48px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h3_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H3 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   => '32px'
			,'line-height' => '44px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h4_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H4 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   => '24px'
			,'line-height' => '34px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h5_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H5 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   		=> '18px'
			,'line-height' 		=> '26px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'ts_h6_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H6 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   	=> '16px'
			,'line-height' 	=> '24px'
			,'google'	  	=> false
		)
	)
	,array(
		'id'       		=> 'ts_small_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Small Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'line-height'	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   => '13px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_mini_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Mini Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'line-height'	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   => '12px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_button_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Button Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'line-height'  => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-size'   => '13px'
			,'google'	   => false
		)
	)
	,array(
		'id'      => 'info-font-size-ipad'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Font size on Ipad', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       		=> 'ts_body_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Body Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '13px'
			,'line-height' => '24px'
			,'google'	   => false
		)
	)
	,array(
		'id'       			=> 'ts_menu_ipad_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Menu Font Size', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> false
		,'font-family'  	=> false
		,'font-weight'  	=> false
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  			=> array(
			'font-size'   		=> '13px'
			,'line-height' 		=> '20px'
			,'google'	   		=> false
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'ts_sub_menu_ipad_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Sub Menu Font Size', 'gostore' )
		,'subtitle' 		=> ''
		,'google'   		=> false
		,'font-family'  	=> false
		,'font-weight'  	=> false
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  			=> array(
			'font-size'   		=> '13px'
			,'line-height' 		=> '20px'
			,'google'	   		=> false
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       		=> 'ts_h1_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H1 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '52px'
			,'line-height' => '56px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h2_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H2 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '32px'
			,'line-height' => '40px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h3_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H3 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '24px'
			,'line-height' => '34px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h4_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H4 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '18px'
			,'line-height' => '24px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h5_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H5 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '16px'
			,'line-height' => '22px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h6_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H6 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '14px'
			,'line-height' => '20px'
			,'google'	   => false
		)
	)
	
	,array(
		'id'      => 'info-font-size-mobile'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Font size on Mobile', 'gostore' )
		,'desc'   => ''
	)
	,array(
		'id'       		=> 'ts_h1_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H1 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '42px'
			,'line-height' => '48px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h2_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H2 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '28px'
			,'line-height' => '34px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h3_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H3 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '20px'
			,'line-height' => '28px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h4_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H4 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '18px'
			,'line-height' => '24px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h5_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H5 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '16px'
			,'line-height' => '22px'
			,'google'	   => false
		)
	)
	,array(
		'id'       		=> 'ts_h6_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H6 Font Size', 'gostore' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'text-align'   => false
		,'color'   		=> false
		,'preview'		=> array('always_display' => false)
		,'default'  	=> array(
			'font-family'  => ''
			,'font-weight' => ''
			,'font-size'   => '14px'
			,'line-height' => '20px'
			,'google'	   => false
		)
	)
);

/*** Header Tab ***/
$option_fields['header'] = array(
	array(
		'id'        => 'section-header-options'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Header Options', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_header_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Header Layout', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $header_layout_options
		,'default'  => 'v1'
	)
	,array(
		'id'        => 'ts_enable_sticky_header'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Sticky Header', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_enable_search'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Search Bar', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_search_by_category'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Search By Category', 'gostore' )
		,'subtitle' => esc_html__( 'Enable or disable category dropdown in search bar. Please note that it is only available on some header layouts', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
		,'required'	=> array( 'ts_enable_search', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_enable_tiny_wishlist'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Wishlist', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_header_currency'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Header Currency', 'gostore' )
		,'subtitle' => esc_html__( 'Only available on some header layouts. If you don\'t install WooCommerce Multilingual plugin, it may display demo html', 'gostore' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_header_language'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Header Language', 'gostore' )
		,'subtitle' => esc_html__( 'Only available on some header layouts. If you don\'t install WPML plugin, it may display demo html', 'gostore' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_enable_tiny_account'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'My Account', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_enable_tiny_shopping_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Shopping Cart', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_shopping_cart_sidebar'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Shopping Cart Sidebar', 'gostore' )
		,'subtitle' => esc_html__( 'Show shopping cart in sidebar instead of dropdown. You need to update cart after changing', 'gostore' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
		,'required'	=> array( 'ts_enable_tiny_shopping_cart', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_show_shopping_cart_after_adding'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Show Shopping Cart After Adding Product To Cart', 'gostore' )
		,'subtitle' => esc_html__( 'You need to enable Ajax add to cart in WooCommerce > Settings > Products', 'gostore' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
		,'required'	=> array( 'ts_shopping_cart_sidebar', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_add_to_cart_effect'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Add To Cart Effect', 'gostore' )
		,'subtitle' => esc_html__( 'You need to enable Ajax add to cart in WooCommerce > Settings > Products. If "Show Shopping Cart After Adding Product To Cart" is enabled, this option will be disabled', 'gostore' )
		,'options'  => array(
			'0'				=> esc_html__( 'None', 'gostore' )
			,'fly_to_cart'	=> esc_html__( 'Fly To Cart', 'gostore' )
			,'show_popup'	=> esc_html__( 'Show Popup', 'gostore' )
		)
		,'default'  => '0'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_header_info'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Contact Information', 'gostore' )
		,'subtitle' => ''
		,'desc'          => esc_html__( 'Hotline +84 777 890 999', 'gostore' )
		,'default'  => ''
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
	,array(
		'id'        => 'ts_store_notice'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Store Notice', 'gostore' )
		,'subtitle' => ''
		,'desc'     => esc_html__( 'Add a notice at the top of header', 'gostore' )
		,'default'  => ''
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
	
	,array(
		'id'        => 'section-header-features'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Header Features', 'gostore' )
		,'subtitle' => esc_html__( '(Only support for Header Layout 3 and Header Layout 4)', 'gostore' )
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_header_feature_icon_1'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Feature Icon 1', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'ts_header_feature_text_1'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Feature Text 1', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'ts_header_feature_link_1'
		,'type'     => 'text'
		,'url'      => true
		,'title'    => esc_html__( 'Feature Link 1', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'ts_header_feature_icon_2'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Feature Icon 2', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'ts_header_feature_text_2'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Feature Text 2', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'ts_header_feature_link_2'
		,'type'     => 'text'
		,'url'      => true
		,'title'    => esc_html__( 'Feature Link 2', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'ts_header_feature_icon_3'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Feature Icon 3', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'ts_header_feature_text_3'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Feature Text 3', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'ts_header_feature_link_3'
		,'type'     => 'text'
		,'url'      => true
		,'title'    => esc_html__( 'Feature Link 3', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'default'  => ''
	)
	
	,array(
		'id'        => 'section-recently-viewed-products'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Recently Viewed Products', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_header_recently_viewed_products'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Recently Viewed Products', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_header_recently_viewed_products_by_all_user'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Viewed By All Users', 'gostore' )
		,'subtitle' => esc_html__( 'Get products which were viewed by all users or only the current user', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'gostore' )
		,'off'		=> esc_html__( 'Disable', 'gostore' )
	)
	,array(
		'id'        => 'ts_header_number_recently_viewed_products'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Number of products', 'gostore' )
		,'subtitle' => esc_html__( 'Number of products to show', 'gostore' )
		,'desc'     => ''
		,'default'  => '4'
	)
	
	,array(
		'id'        => 'section-breadcrumb-options'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Breadcrumb Options', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_breadcrumb_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Breadcrumb Layout', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $breadcrumb_layout_options
		,'default'  => 'v1'
	)
	,array(
		'id'        => 'ts_enable_breadcrumb_background_image'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Breadcrumbs Background Image', 'gostore' )
		,'subtitle' => esc_html__( 'You can set background color by going to Color Scheme tab > Breadcrumb Colors section', 'gostore' )
		,'default'  => true
	)
	,array(
		'id'        => 'ts_bg_breadcrumbs'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Breadcrumbs Background Image', 'gostore' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Select a new image to override the default background image', 'gostore' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'ts_breadcrumb_bg_parallax'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Breadcrumbs Background Parallax', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
	)
	
	,array(
		'id'        => 'section-mobile-bottom-bar'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Mobile Bottom Bar', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_mobile_bottom_bar_custom_content'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Mobile Bottom Bar Custom Content', 'gostore' )
		,'subtitle' => esc_html__( 'You can add more buttons or custom content to bottom bar on mobile', 'gostore' )
		,'desc'     => ''
		,'default'  => ''
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
);

/*** Footer Tab ***/
$option_fields['footer'] = array(
	array(
		'id'       	=> 'ts_footer_block'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Footer Block', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $footer_block_options
		,'default'  => '0'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
);

/*** Menu Tab ***/
$option_fields['menu'] = array(
	array(
		'id'             => 'ts_menu_thumb_width'
		,'type'          => 'slider'
		,'title'         => esc_html__( 'Menu Thumbnail Width', 'gostore' )
		,'subtitle'      => ''
		,'desc'          => esc_html__( 'Min: 5, max: 50, step: 1, default value: 46', 'gostore' )
		,'default'       => 46
		,'min'           => 5
		,'step'          => 1
		,'max'           => 50
		,'display_value' => 'text'
	)
	,array(
		'id'             => 'ts_menu_thumb_height'
		,'type'          => 'slider'
		,'title'         => esc_html__( 'Menu Thumbnail Height', 'gostore' )
		,'subtitle'      => ''
		,'desc'          => esc_html__( 'Min: 5, max: 50, step: 1, default value: 46', 'gostore' )
		,'default'       => 46
		,'min'           => 5
		,'step'          => 1
		,'max'           => 50
		,'display_value' => 'text'
	)
);

/*** Blog Tab ***/
$option_fields['blog'] = array(
	array(
		'id'        => 'section-blog'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Blog', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_blog_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Blog Layout', 'gostore' )
		,'subtitle' => esc_html__( 'This option is available when Front page displays the latest posts', 'gostore' )
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'gostore')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-1'
	)
	,array(
		'id'       	=> 'ts_blog_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'ts_blog_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_blog_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Thumbnail', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_date'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Date', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Title', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_author'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Author', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_comment'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Comment', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_read_more'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Read More Button', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_categories'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Categories', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_excerpt'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Excerpt', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_excerpt_strip_tags'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Excerpt Strip All Tags', 'gostore' )
		,'subtitle' => esc_html__( 'Strip all html tags in Excerpt', 'gostore' )
		,'default'  => false
	)
	,array(
		'id'        => 'ts_blog_excerpt_max_words'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Blog Excerpt Max Words', 'gostore' )
		,'subtitle' => esc_html__( 'Input -1 to show full excerpt', 'gostore' )
		,'desc'     => ''
		,'default'  => '-1'
	)
	
	,array(
		'id'        => 'section-blog-details'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Blog Details', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_blog_details_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Blog Details Layout', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'gostore')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-1'
	)
	,array(
		'id'       	=> 'ts_blog_details_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'ts_blog_details_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_blog_details_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Thumbnail', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_date'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Date', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Title', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_author'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Author', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_comment'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Comment', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_content'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Content', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_tags'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Tags', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_categories'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Categories', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_sharing'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Sharing', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_sharing_sharethis'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Sharing - Use ShareThis', 'gostore' )
		,'subtitle' => esc_html__( 'Use share buttons from sharethis.com. You need to add key below', 'gostore')
		,'default'  => true
		,'required'	=> array( 'ts_blog_details_sharing', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_blog_details_sharing_sharethis_key'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Blog Sharing - ShareThis Key', 'gostore' )
		,'subtitle' => esc_html__( 'You get it from script code. It is the value of "property" attribute', 'gostore' )
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'ts_blog_details_sharing', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_blog_details_author_box'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Author Box', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_navigation'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Navigation', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_related_posts'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Related Posts', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_blog_details_comment_form'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Comment Form', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
);

/*** Portfolio Details Tab ***/
$option_fields['portfolio-details'] = array(
	array(
		'id'       	=> 'ts_portfolio_page'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Portfolio Page', 'gostore' )
		,'subtitle' => esc_html__( 'Select the page which displays the list of portfolios. You also need to add our portfolio shortcode to that page', 'gostore' )
		,'desc'     => ''
		,'data'     => 'pages'
		,'default'	=> ''
	)
	,array(
		'id'       	=> 'ts_portfolio_thumbnail_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Thumbnail Style', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'slider'	=> esc_html__( 'Slider', 'gostore' )
			,'gallery'	=> esc_html__( 'Gallery', 'gostore' )
		)
		,'default'	=> 'slider'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'ts_portfolio_thumbnail_columns'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Thumbnail Columns', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			1	=> 1
			,2	=> 2
		)
		,'default'  => '2'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_portfolio_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Thumbnail', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Title', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_likes'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Likes', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_content'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Content', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_client'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Client', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_year'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Year', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_url'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio URL', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_categories'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Categories', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_sharing'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Sharing', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_related_posts'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Related Posts', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_custom_field'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Portfolio Custom Field', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_portfolio_custom_field_title'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Portfolio Custom Field Title', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Custom Field'
		,'required'	=> array( 'ts_portfolio_custom_field', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_portfolio_custom_field_content'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Portfolio Custom Field Content', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Custom content goes here'
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
		,'required'	=> array( 'ts_portfolio_custom_field', 'equals', '1' )
	)
);

/*** WooCommerce Tab ***/
$option_fields['woocommerce'] = array(
	array(
		'id'        => 'section-product-label'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Label', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       	=> 'ts_product_label_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Label Style', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'rectangle' 	=> esc_html__( 'Rectangle', 'gostore' )
			,'circle' 		=> esc_html__( 'Circle', 'gostore' )
		)
		,'default'  => 'rectangle'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_product_show_new_label'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product New Label', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_product_new_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product New Label Text', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'New'
		,'required'	=> array( 'ts_product_show_new_label', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_product_show_new_label_time'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product New Label Time', 'gostore' )
		,'subtitle' => esc_html__( 'Number of days which you want to show New label since product is published', 'gostore' )
		,'desc'     => ''
		,'default'  => '30'
		,'required'	=> array( 'ts_product_show_new_label', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_product_sale_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Sale Label Text', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Sale'
	)
	,array(
		'id'        => 'ts_product_feature_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Feature Label Text', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Hot'
	)
	,array(
		'id'        => 'ts_product_out_of_stock_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Out Of Stock Label Text', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Sold out'
	)
	,array(
		'id'       	=> 'ts_show_sale_label_as'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Show Sale Label As', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'text' 		=> esc_html__( 'Text', 'gostore' )
			,'number' 	=> esc_html__( 'Number', 'gostore' )
			,'percent' 	=> esc_html__( 'Percent', 'gostore' )
		)
		,'default'  => 'text'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	
	,array(
		'id'        => 'section-product-rating'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Rating', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       	=> 'ts_product_rating_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Rating Style', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'border' 		=> esc_html__( 'Border', 'gostore' )
			,'fill' 		=> esc_html__( 'Fill', 'gostore' )
		)
		,'default'  => 'fill'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	
	,array(
		'id'        => 'section-product-hover'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Hover', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       	=> 'ts_product_hover_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Hover Style', 'gostore' )
		,'subtitle' => esc_html__( 'Select the style of buttons/icons when hovering on product. Vertical Style 2 use only when showing product price', 'gostore' )
		,'desc'     => ''
		,'options'  => array(
			'hover-vertical-style' 			=> esc_html__( 'Vertical Style', 'gostore' )
			,'hover-vertical-style-2' 		=> esc_html__( 'Vertical Style 2', 'gostore' )
		)
		,'default'  => 'hover-vertical-style-2'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_effect_product'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Back Product Image', 'gostore' )
		,'subtitle' => esc_html__( 'Show another product image on hover. It will show an image from Product Gallery', 'gostore' )
		,'default'  => false
	)
	,array(
		'id'        => 'ts_product_tooltip'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Tooltip', 'gostore' )
		,'subtitle' => esc_html__( 'Show tooltip when hovering on buttons/icons on product', 'gostore' )
		,'default'  => true
	)
	
	,array(
		'id'        => 'section-lazy-load'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Lazy Load', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_prod_lazy_load'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Activate Lazy Load', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'ts_prod_placeholder_img'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Placeholder Image', 'gostore' )
		,'desc'     => ''
		,'subtitle' => ''
		,'readonly' => false
		,'default'  => array( 'url' => $product_loading_image )
	)
	
	,array(
		'id'        => 'section-quickshop'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Quickshop', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_enable_quickshop'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Activate Quickshop', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	
	,array(
		'id'        => 'section-catalog-mode'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Catalog Mode', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_enable_catalog_mode'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Catalog Mode', 'gostore' )
		,'subtitle' => esc_html__( 'Hide all Add To Cart buttons on your site. You can also hide Shopping cart by going to Header tab > turn Shopping Cart option off', 'gostore' )
		,'default'  => false
	)
	
	,array(
		'id'        => 'section-ajax-search'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Ajax Search', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_ajax_search'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Ajax Search', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'ts_ajax_search_number_result'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Number Of Results', 'gostore' )
		,'subtitle' => esc_html__( 'Input -1 to show all results', 'gostore' )
		,'desc'     => ''
		,'default'  => '4'
	)
	
	,array(
		'id'        => 'section-cart-checkout'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Cart Checkout', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_cart_checkout_process_bar'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Cart Checkout Process Bar', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
);

/*** Shop/Product Category Tab ***/
$option_fields['shop-product-category'] = array(
	array(
		'id'        => 'ts_prod_cat_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Shop/Product Category Layout', 'gostore' )
		,'subtitle' => esc_html__( 'Sidebar is only available if Filter Widget Area is disabled', 'gostore' )
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'gostore')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-0'
	)
	,array(
		'id'       	=> 'ts_prod_cat_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-category-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'ts_prod_cat_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-category-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'ts_prod_cat_columns'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Columns', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			3	=> 3
			,4	=> 4
			,5	=> 5
			,6	=> 6
		)
		,'default'  => '4'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_prod_cat_per_page'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Products Per Page', 'gostore' )
		,'subtitle' => esc_html__( 'Number of products per page', 'gostore' )
		,'desc'     => ''
		,'default'  => '20'
	)
	,array(
		'id'       	=> 'ts_prod_cat_loading_type'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Loading Type', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'default'			=> esc_html__( 'Default', 'gostore' )
			,'infinity-scroll'	=> esc_html__( 'Infinity Scroll', 'gostore' )
			,'load-more-button'	=> esc_html__( 'Load More Button', 'gostore' )
			,'ajax-pagination'	=> esc_html__( 'Ajax Pagination', 'gostore' )
		)
		,'default'  => 'load-more-button'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_prod_cat_per_page_dropdown'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Products Per Page Dropdown', 'gostore' )
		,'subtitle' => esc_html__( 'Allow users to select number of products per page', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_onsale_checkbox'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Products On Sale Checkbox', 'gostore' )
		,'subtitle' => esc_html__( 'Allow users to view only the discounted products', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_filter_widget_area'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Filter Widget Area', 'gostore' )
		,'subtitle' => esc_html__( 'Display Filter Widget Area on the Shop/Product Category page. If enabled, sidebar will be removed', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_show_filter_widget_area_by_default'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Show Filter Widget Area By Default', 'gostore' )
		,'subtitle' => esc_html__( 'Show Filter Widget Area by default and hide the Filter button on Desktop', 'gostore' )
		,'default'  => true
		,'required'	=> array( 'ts_filter_widget_area', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_prod_cat_bestsellers'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Best Selling Products', 'gostore' )
		,'subtitle' => esc_html__( 'Show best selling products at the top of product category page. It only shows if total products is more than double the maximum best selling products (default is 7)', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Thumbnail', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_label'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Label', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_brand'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Brands', 'gostore' )
		,'subtitle' => esc_html__( 'Add brands to product list on all pages', 'gostore' )
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_cat'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Categories', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Title', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_sku'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product SKU', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_rating'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Rating', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_price'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Price', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_add_to_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Add To Cart Button', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_desc'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Short Description', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat_desc_words'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Short Description - Limit Words', 'gostore' )
		,'subtitle' => esc_html__( 'It is also used for product shortcode', 'gostore' )
		,'desc'     => ''
		,'default'  => '8'
	)
	,array(
		'id'        => 'ts_prod_cat_color_swatch'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Color Swatches', 'gostore' )
		,'subtitle' => esc_html__( 'Show the color attribute of variations. The slug of the color attribute has to be "color"', 'gostore' )
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'       	=> 'ts_prod_cat_number_color_swatch'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Number Of Color Swatches', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			2	=> 2
			,3	=> 3
			,4	=> 4
			,5	=> 5
			,6	=> 6
		)
		,'default'  => '3'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
		,'required'	=> array( 'ts_prod_cat_color_swatch', 'equals', '1' )
	)
);

/*** Product Details Tab ***/
$option_fields['product-details'] = array(
	array(
		'id'        => 'ts_prod_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Product Layout', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'gostore')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'gostore')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-0'
	)
	,array(
		'id'       	=> 'ts_prod_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'ts_prod_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'ts_prod_breadcrumb'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Breadcrumb', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'ts_prod_cloudzoom'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Cloud Zoom', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'ts_prod_lightbox'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Lightbox', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'ts_prod_attr_dropdown'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Attribute Dropdown', 'gostore' )
		,'subtitle' => esc_html__( 'If you turn it off, the dropdown will be replaced by image or text label', 'gostore' )
		,'default'  => true
	)
	,array(
		'id'        => 'ts_prod_attr_color_text'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Attribute Color Text', 'gostore' )
		,'subtitle' => esc_html__( 'Show text for the Color attribute instead of color/color image', 'gostore' )
		,'default'  => false
		,'required'	=> array( 'ts_prod_attr_dropdown', 'equals', '0' )
	)
	,array(
		'id'        => 'ts_prod_next_prev_navigation'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Next/Prev Product Navigation', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Thumbnail', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_label'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Label', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Title', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_title_in_content'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Title In Content', 'gostore' )
		,'subtitle' => esc_html__( 'Display the product title in the page content instead of above the breadcrumbs', 'gostore' )
		,'default'  => true
	)
	,array(
		'id'        => 'ts_prod_rating'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Rating', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_excerpt'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Excerpt', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_count_down'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Count Down', 'gostore' )
		,'subtitle' => esc_html__( 'You have to activate ThemeSky plugin', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_price'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Price', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_add_to_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Add To Cart Button', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_ajax_add_to_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Ajax Add To Cart', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'required'	=> array( 'ts_prod_add_to_cart', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_prod_buy_now'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Buy Now Button', 'gostore' )
		,'subtitle' => esc_html__( 'Only support the simple and variable products', 'gostore' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_sku'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product SKU', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_availability'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Availability', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_brand'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Brands', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_cat'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Categories', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_tag'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Tags', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_sharing'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Sharing', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_sharing_sharethis'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Sharing - Use ShareThis', 'gostore' )
		,'subtitle' => esc_html__( 'Use share buttons from sharethis.com. You need to add key below', 'gostore' )
		,'default'  => false
		,'required'	=> array( 'ts_prod_sharing', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_prod_sharing_sharethis_key'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Sharing - ShareThis Key', 'gostore' )
		,'subtitle' => esc_html__( 'You get it from script code. It is the value of "property" attribute', 'gostore' )
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'ts_prod_sharing', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_prod_summary_extra_content'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Product Summary Extra Content', 'gostore' )
		,'subtitle' => esc_html__( 'Add extra content next to summary, ex: banner', 'gostore' )
		,'desc'     => ''
		,'default'  => ''
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
	,array(
		'id'        => 'ts_prod_size_chart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Size Chart', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'       	=> 'ts_prod_size_chart_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Size Chart Style', 'gostore' )
		,'subtitle' => esc_html__( 'Modal Popup is only available if the slug of the Size attribute is "size" and Attribute Dropdown is disabled', 'gostore' )
		,'desc'     => ''
		,'options'  => array(
			'popup'		=> esc_html__( 'Modal Popup', 'gostore' )
			,'tab'		=> esc_html__( 'Additional Tab', 'gostore' )
		)
		,'default'  => 'popup'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
		,'required'	=> array( 'ts_prod_size_chart', 'equals', '1' )
	)
	,array(
		'id'        => 'ts_prod_more_less_content'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product More/Less Content', 'gostore' )
		,'subtitle' => esc_html__( 'Show more/less content in the Description tab', 'gostore' )
		,'default'  => true
	)
	
	,array(
		'id'        => 'section-product-tabs'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Tabs', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_prod_tabs'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Tabs', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_tabs_show_content_default'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Show Product Tabs Content By Default', 'gostore' )
		,'subtitle' => esc_html__( 'Show the content of all tabs by default and hide the tab headings', 'gostore' )
		,'default'  => false
	)
	,array(
		'id'       	=> 'ts_prod_tabs_position'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Tabs Position', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'after_summary'		=> esc_html__( 'After Summary', 'gostore' )
			,'inside_summary'	=> esc_html__( 'Inside Summary', 'gostore' )
		)
		,'default'  => 'after_summary'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
		,'required'	=> array( 'ts_prod_tabs_show_content_default', 'equals', '0' )
	)
	,array(
		'id'        => 'ts_prod_custom_tab'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Custom Tab', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_custom_tab_title'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Custom Tab Title', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Custom tab'
	)
	,array(
		'id'        => 'ts_prod_custom_tab_content'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Product Custom Tab Content', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => esc_html__( 'Your custom content goes here. You can add the content for individual product', 'gostore' )
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
	
	,array(
		'id'        => 'section-ads-banner'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Ads Banner', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_prod_ads_banner'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Ads Banner', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_ads_banner_content'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Ads Banner Content', 'gostore' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => ''
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
	
	,array(
		'id'        => 'section-related-up-sell-products'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Related - Up-Sell Products', 'gostore' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'ts_prod_upsells'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Up-Sell Products', 'gostore' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
	,array(
		'id'        => 'ts_prod_related'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Related Products', 'gostore' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'gostore' )
		,'off'		=> esc_html__( 'Hide', 'gostore' )
	)
);

/*** Custom Code Tab ***/
$option_fields['custom-code'] = array(
	array(
		'id'        => 'ts_custom_css_code'
		,'type'     => 'ace_editor'
		,'title'    => esc_html__( 'Custom CSS Code', 'gostore' )
		,'subtitle' => ''
		,'mode'     => 'css'
		,'theme'    => 'monokai'
		,'desc'     => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'ts_custom_javascript_code'
		,'type'     => 'ace_editor'
		,'title'    => esc_html__( 'Custom Javascript Code', 'gostore' )
		,'subtitle' => ''
		,'mode'     => 'javascript'
		,'theme'    => 'monokai'
		,'desc'     => ''
		,'default'  => ''
	)
);