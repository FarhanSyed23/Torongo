<?php
/**
 * Blog Pro - Blog Layout 3 Template
 *
 * @todo Update this template for Default Blog Style
 *
 * @package Astra Addon
 */

?>
<div <?php astra_blog_layout_class( 'blog-layout-3' ); ?>>
	<?php $featured_item = apply_filters( 'astra_featured_image_enabled', true ); ?>
	<?php if ( $featured_item ) : ?>
		<?php
		// Blog Post Featured Image.
			astra_get_post_thumbnail( '<div class="ast-blog-featured-section post-thumb ast-col-md-6">', '</div>' );
		?>
	<?php endif; ?>

	<div class="post-content ast-col-md-6">

		<?php astra_get_blog_post_title_meta(); ?>

		<div class="entry-content clear" 
		<?php
				echo astra_attr(
					'article-entry-content-blog-layout-3',
					array(
						'class' => '',
					)
				);
				?>
				>

			<?php astra_entry_content_before(); ?>

			<?php astra_the_excerpt(); ?>

			<?php astra_entry_content_after(); ?>

			<?php
				wp_link_pages(
					array(
						'before'      => '<div class="page-links">' . esc_html( astra_default_strings( 'string-blog-page-links-before', false ) ),
						'after'       => '</div>',
						'link_before' => '<span class="page-link">',
						'link_after'  => '</span>',
					)
				);
				?>
		</div><!-- .entry-content .clear -->
	</div><!-- .post-content -->
</div> <!-- .blog-layout-3 -->
