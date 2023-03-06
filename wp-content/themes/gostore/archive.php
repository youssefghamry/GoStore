<?php
get_header();

$theme_options = gostore_get_theme_options();

$page_column_class = gostore_page_layout_columns_class( $theme_options['ts_blog_layout'], $theme_options['ts_blog_left_sidebar'], $theme_options['ts_blog_right_sidebar'] );

$show_breadcrumb = apply_filters('gostore_show_breadcrumb_on_archive_post', true);
$show_page_title = apply_filters('gostore_show_page_title_on_archive_post', true);
$page_title = '';
$extra_class = '';
if( $show_breadcrumb || $show_page_title ){
	$extra_class = 'show_breadcrumb_'.$theme_options['ts_breadcrumb_layout'];
}

if( $show_page_title ){
	switch( true ){
		case is_day():
			$page_title = esc_html__( 'Day: ', 'gostore' ) . get_the_date();
		break;
		case is_month():
			$page_title = esc_html__( 'Month: ', 'gostore' ) . get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'gostore' ) );
		break;
		case is_year():
			$page_title = esc_html__( 'Year: ', 'gostore' ) . get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'gostore' ) );
		break;
		case is_search():
			$page_title = esc_html__( 'Search Results for: ', 'gostore' ) . get_search_query();
		break;
		case is_tag():
			$page_title = esc_html__( 'Tag: ', 'gostore' ) . single_tag_title( '', false );
		break;
		case is_category():
			$page_title = esc_html__( 'Category: ', 'gostore' ) . single_cat_title( '', false );
		break;
		case is_404():
			$page_title = esc_html__( 'OOPS! FILE NOT FOUND', 'gostore' );
		break;
		default:
			$page_title = esc_html__( 'Archives', 'gostore' );
		break;
	}
}

gostore_breadcrumbs_title($show_breadcrumb, $show_page_title, $page_title);
?>

<div class="page-container page-template archive-template <?php echo esc_attr($extra_class) ?>">
	
	<!-- Left Sidebar -->
	<?php if( $page_column_class['left_sidebar'] ): ?>
		<div id="left-sidebar" class="ts-sidebar <?php echo esc_attr($page_column_class['left_sidebar_class']); ?>">
			<aside>
				<?php dynamic_sidebar( $theme_options['ts_blog_left_sidebar'] ); ?>
			</aside>
		</div>
	<?php endif; ?>	
	
	<!-- Main Content -->
	<div id="main-content" class="<?php echo esc_attr($page_column_class['main_class']); ?>">	
		<div id="primary" class="site-content">
		
			<?php	
				if( have_posts() ):
					echo '<div class="list-posts">';
					while( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() ); 
					endwhile;
					echo '</div>';
				else:
					echo '<div class="alert alert-error">'.esc_html__('Sorry. There are no posts to display', 'gostore').'</div>';
				endif;
				
				gostore_pagination();
			?>
			
		</div>
	</div>
	
	<!-- Right Sidebar -->
	<?php if( $page_column_class['right_sidebar'] ): ?>
		<div id="right-sidebar" class="ts-sidebar <?php echo esc_attr($page_column_class['right_sidebar_class']); ?>">
			<aside>
				<?php dynamic_sidebar( $theme_options['ts_blog_right_sidebar'] ); ?>
			</aside>
		</div>
	<?php endif; ?>
	
</div>

<?php
get_footer();
