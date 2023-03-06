<?php 
global $post;
$theme_options = gostore_get_theme_options();
$post_format = get_post_format(); /* Video, Audio, Gallery, Quote */
$post_class = array( 'post-item hentry' );
if( is_sticky() && !is_paged() ){
	$post_class[] = 'sticky';
}
$show_blog_thumbnail = $theme_options['ts_blog_thumbnail'];
$blog_thumb_size = 'gostore_blog_thumb';

if( $theme_options['ts_blog_excerpt_max_words'] == -1 && empty($post->post_excerpt) ){
	$theme_options['ts_blog_read_more'] = 0;
}
?>
<article <?php post_class( $post_class ) ?> >
	<?php if( $post_format != 'quote' ): ?>
		<?php 
		if( $show_blog_thumbnail ){
		?>
			<div class="<?php echo ( 'gallery' == $post_format )?'nav-middle nav-center ':'' ?>entry-format">
			<?php 
			
				if( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ){
					if( $post_format != 'gallery' ){
					?>
					<a class="thumbnail <?php echo esc_attr($post_format); ?>" href="<?php the_permalink() ?>">
					<?php }else{ ?>
					<div class="thumbnail gallery loading">	
					<?php } ?>
						<figure>
						<?php 
							if( $post_format == 'gallery' ){
								$gallery = get_post_meta($post->ID, 'ts_gallery', true);
								if( $gallery != '' ){
									$gallery_ids = explode(',', $gallery);
								}
								else{
									$gallery_ids = array();
								}
								
								if( has_post_thumbnail() ){
									array_unshift($gallery_ids, get_post_thumbnail_id());
								}
								foreach( $gallery_ids as $gallery_id ){
									echo '<a class="thumbnail gallery" href="'.esc_url(get_the_permalink()).'">';
									echo wp_get_attachment_image( $gallery_id, $blog_thumb_size, 0, array('class' => 'thumbnail-blog') );
									echo '</a>';
								}
								
								if( empty($gallery_ids) ){
									$show_blog_thumbnail = false;
								}
							}
						
							if( $post_format === false || $post_format == 'standard' ){
								if( has_post_thumbnail() ){
									the_post_thumbnail($blog_thumb_size, array('class' => 'thumbnail-blog'));
								}
								else{
									$show_blog_thumbnail = false;
								}
							}
						?>
						</figure>
					<?php 
					if( $post_format != 'gallery' ){
					?>
					</a>
					<?php }else{ ?>
					</div>
					<?php } ?>
				<?php	
				}
				
				if( $post_format == 'video' ){
					$video_url = get_post_meta($post->ID, 'ts_video_url', true);
					if( $video_url ){
						echo do_shortcode('[ts_video src="'.esc_url($video_url).'"]');
					}
					else{
						$show_blog_thumbnail = false;
					}
				}
				
				if( $post_format == 'audio' ){
					$audio_url = get_post_meta($post->ID, 'ts_audio_url', true);
					if( strlen($audio_url) > 4 ){
						$file_format = substr($audio_url, -3, 3);
						if( in_array($file_format, array('mp3', 'ogg', 'wav')) ){
							echo do_shortcode('[audio '.$file_format.'="'.$audio_url.'"]');
						}
						else{
							echo do_shortcode('[ts_soundcloud url="'.$audio_url.'" width="100%" height="166"]');
						}
					}
					else{
						$show_blog_thumbnail = false;
					}
				}
				
				if( !in_array($post_format, array('gallery', 'standard', 'video', 'audio', 'quote', false)) ){
					$show_blog_thumbnail = false;
				}
				?>
			</div>
		<?php
		}
		?>
		
		<div class="entry-content <?php echo !$show_blog_thumbnail?'no-featured-image':'' ?>">
			
			<!-- Blog Title - Author -->
			<header>
				
				<?php if( $theme_options['ts_blog_date'] || $theme_options['ts_blog_author'] || $theme_options['ts_blog_comment'] || $theme_options['ts_blog_categories'] ): ?>
				
					<div class="entry-meta-top">
				
						<!-- Blog Author -->
						<?php if( $theme_options['ts_blog_author'] ): ?>
						<span class="vcard author">
							<?php 
								the_author_posts_link();
							?>
						</span>
						<?php endif; ?>
				
						<!-- Blog Date Time -->
						<?php if( $theme_options['ts_blog_date'] ) : ?>
						<span class="date-time">
							<?php echo get_the_time( get_option('date_format') ); ?>
						</span>
						<?php endif; ?>
						
						<!-- Blog Comment -->
						<?php if( $theme_options['ts_blog_comment'] ): ?>
						<span class="comment-count">
							<?php
							echo gostore_get_post_comment_count();
							?>
						</span>
						<?php endif; ?>
						
						<!-- Blog Categories -->
						<?php if( $theme_options['ts_blog_categories'] ): ?>
						<span class="cats-link">
							<span><?php esc_html_e('In', 'gostore'); ?></span>
							<?php echo get_the_category_list(', '); ?>
						</span>
						<?php endif; ?>
					
					</div>
				
				<?php endif; ?>
				
				<?php if( $theme_options['ts_blog_title'] ): ?>
				<h2 class="heading-title entry-title">
					<a class="post-title" href="<?php the_permalink() ; ?>"><?php the_title(); ?></a>
				</h2>
				<?php endif; ?>
				
			</header>
			
			<!-- Blog Excerpt -->
			<?php if( $theme_options['ts_blog_excerpt'] ): ?>
			<div class="entry-summary">
				<div class="short-content">
					<?php 
					$max_words = (int)$theme_options['ts_blog_excerpt_max_words']?(int)$theme_options['ts_blog_excerpt_max_words']:140;
					$strip_tags = $theme_options['ts_blog_excerpt_strip_tags']?true:false;
					
					if( $max_words != '-1' ){
						gostore_the_excerpt_max_words($max_words, $post, $strip_tags, '', true);
					}
					else if( !empty($post->post_excerpt) ){
						the_excerpt();
					}
					else{
						the_content();
					}
					?>
				</div>
				<?php 
				if( $post_format === false || $post_format == 'standard' ){
					wp_link_pages();
				}
				?>
			</div>
			<?php endif; ?>
			
			<!-- Blog Read More Button -->
			<?php if( $theme_options['ts_blog_read_more'] ): ?>
			<div class="entry-meta-bottom">
				<a class="button-readmore button-text" href="<?php the_permalink() ; ?>"><?php esc_html_e('read more', 'gostore'); ?></a>
			</div>
			<?php endif; ?>
			
		</div>
	
	<?php else: ?>
		<blockquote>
			<p><?php 
			$quote_content = get_the_excerpt();
			if( !$quote_content ){
				$quote_content = get_the_content();
			}
			echo do_shortcode($quote_content);
			?>
			</p>
			
			<!-- Blog Date Time -->
			<?php if( $theme_options['ts_blog_date'] || $theme_options['ts_blog_author'] ) : ?>
			<div class="entry-meta-top-quote">
				<div class="entry-meta-top">
					
					<!-- Blog Author -->
					<?php if( $theme_options['ts_blog_author'] ): ?>
					<span class="vcard author">
						<?php
							the_author_posts_link(); 
						?>
					</span>
					<?php endif; ?>
				
					<?php if( $theme_options['ts_blog_date'] ) : ?>
					<span class="date-time">
						<?php echo get_the_time( get_option('date_format') ); ?>
					</span>
					<?php endif; ?>
					
					<!-- Blog Categories -->
					<?php if( $theme_options['ts_blog_categories'] ): ?>
					<span class="cats-link">
						<span><?php esc_html_e('In', 'gostore'); ?></span>
						<?php echo get_the_category_list(', '); ?>
					</span>
					<?php endif; ?>
					
				</div>
				<?php endif; ?>
			<div>
			
		</blockquote>
	<?php endif; ?>
	
</article>