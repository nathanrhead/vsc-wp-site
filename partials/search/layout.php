<?php
/**
 * Default post entry layout
 *
 * @package Responsive Child WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get post format.
$format = get_post_format();

$responsive_blog_entry_content_type = get_theme_mod( 'responsive_blog_entry_content_type', 'excerpt' );
if ( 'excerpt' === $responsive_blog_entry_content_type ) {
	add_filter( 'excerpt_length', 'responsive_custom_excerpt_length' );
	// add_filter( 'responsive_post_read_more', 'responsive_read_more_text' );
} elseif ( 'content' === $responsive_blog_entry_content_type ) {
	add_filter( 'the_content_more_link', 'responsive_modify_read_more_link' );
	// add_filter( 'responsive_post_read_more', 'responsive_read_more_text' );
}

Responsive\responsive_entry_before();

?>
<div class="entry-column">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php responsive_schema_markup( 'creativework' ); ?>>
		<?php Responsive\responsive_entry_top(); ?>

		<div class="post-entry">

		<?php
		// Get elements.
		$elements = responsive_blog_entry_elements_positioning();
		// Loop through elements.

		if ( 'blog-layout-1' === get_theme_mod( 'responsive_blog_layout_options' ) || responsive_active_blog_layout_grid() ) {      
			foreach ( $elements as $element ) {
				if ( 'meta' !== $element && 'content' !== $element ) {
					// Featured Image.
					if ( 'featured_image' === $element && ! post_password_required() ) {
						if ( has_post_thumbnail() ) {
							get_template_part( 'partials/entry/media/blog-entry', $format );
						} else {
							?>
							<div class="thumbnail">
								<a href="<?php the_permalink(); ?>" class="thumbnail-link" itemprop="url">
									<img 
										src="<?php echo esc_url( '/wp-content/uploads/2025/07/cropped-android-chrome-512x512-1.png' ); ?>" 
										alt="<?php echo esc_attr( get_the_title() ); ?>" 
										class="wp-post-image placeholder"
										itemprop="thumbnailUrl"
									/>
									<span class="overlay"></span>
								</a>
							</div>
							<?php
						}
					} else {
						get_template_part( 'partials/entry/' . $element );
					}
				}
			}
		} else {      
			// Featured Image.
			foreach ( $elements as $element ) {
				if ( 'featured_image' === $element && ! post_password_required() ) {
					if ( has_post_thumbnail() ) {
						get_template_part( 'partials/entry/media/blog-entry', $format );
					} else {
						?>
						<div class="thumbnail">
							<a href="<?php the_permalink(); ?>" class="thumbnail-link" itemprop="url">
								<img 
									src="<?php echo esc_url( '/wp-content/uploads/2025/07/cropped-android-chrome-512x512-1.png' ); ?>" 
									alt="<?php echo esc_attr( get_the_title() ); ?>" 
									class="wp-post-image placeholder"
									itemprop="thumbnailUrl"
								/>
								<span class="overlay"></span>
							</a>
						</div>
						<?php
					}
				}
			}

			echo '<div class="blog-entry-content-wrapper">';
			foreach ( $elements as $element ) {
				if ( 'featured_image' !== $element ) {
					get_template_part( 'partials/entry/' . $element );
				}
			}
			echo '</div>';
		}
		
		?>

			<?php
			wp_link_pages(
				array(
					'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
		<!-- end of .post-entry -->

		<?php
		edit_post_link( __( '<span class="post-edit">Edit</span>', 'responsive' ) );

		Responsive\responsive_entry_bottom();
		?>
	</article><!-- end of #post-<?php the_ID(); ?> -->
</div>

<?php
Responsive\responsive_entry_after();
?>
