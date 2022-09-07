<?php

namespace Essential_Addons_Elementor\Pro\Template\Content;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

trait Post_Carousel
{

    

    public static function render_template_($args, $settings)
    {
        $query = new \WP_Query($args);

        ob_start();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                echo '<div class="swiper-slide">';

                echo '<article class="eael-grid-post eael-post-grid-column">
                    <div class="eael-grid-post-holder">
                        <div class="eael-grid-post-holder-inner">';
                        
                if ( ($settings['eael_show_image'] == '0' || $settings['eael_show_image'] == 'yes') && has_post_thumbnail() ) {
                    echo '<div class="eael-entry-media eael-entry-medianone">';

                    if (isset($settings['post_block_hover_animation']) && 'none' !== $settings['post_block_hover_animation']) {
                        echo '<div class="eael-entry-overlay ' . ($settings['post_block_hover_animation']) . '">';

                        if($settings['eael_show_post_terms'] === 'yes') {                            
                            echo self::get_terms_as_list($settings['eael_post_terms'], $settings['eael_post_terms_max_length']);
                        }

                        if (isset($settings['__fa4_migrated']['eael_post_grid_bg_hover_icon_new']) || empty($settings['eael_post_grid_bg_hover_icon'])) {
                            echo '<i class="' . $settings['eael_post_grid_bg_hover_icon_new'] . '" aria-hidden="true"></i>';
                        } else {
                            echo '<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>';
                        }
                        echo '<a href="' . get_the_permalink() . '"></a></div>';
                    }

                    echo '<div class="eael-entry-thumbnail">
                        <img src="' . esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])) . '" alt="' . esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) . '">
                        <a href="' . get_the_permalink() . '"></a>
                    </div>';

                    echo '</div>';
                }

                if ($settings['eael_show_title'] || $settings['eael_show_meta'] || $settings['eael_show_excerpt']):

                    echo '<div class="eael-entry-wrapper">
		            <header class="eael-entry-header">';
                        if ($settings['eael_show_title']) {
                            echo '<'.$settings['title_tag'].' class="eael-entry-title">';

                                echo '<a class="eael-grid-post-link" href="' . get_permalink() . '" title="' . get_the_title() . '">';
                                    if(empty($settings['eael_title_length'])) {
                                        echo get_the_title();
                                    }else {
                                        echo implode(" ", array_slice(explode(" ", get_the_title() ), 0, $settings['eael_title_length']));
                                    }
                                echo '</a>';

                            echo '</'.$settings['title_tag'].'>';
                        }

                        if ($settings['eael_show_meta'] && $settings['meta_position'] == 'meta-entry-header') {
                            echo '<div class="eael-entry-meta">';
                                if($settings['eael_show_author'] === 'yes') {
                                    echo '<span class="eael-posted-by">' . get_the_author_posts_link() . '</span>';
                                }
                                if($settings['eael_show_date'] === 'yes') {
                                    echo '<span class="eael-posted-on"><time datetime="' . get_the_date() . '">' . get_the_date() . '</time></span>';
                                }
                            echo '</div>';
                        }
                    echo '</header>';

                    if ($settings['eael_show_excerpt']) {
                        echo '<div class="eael-entry-content">
                            <div class="eael-grid-post-excerpt">';

                                if(empty($settings['eael_excerpt_length'])) {
                                    echo '<p>'.strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()).'</p>';
                                }else {
                                    echo '<p>' . wp_trim_words(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()), $settings['eael_excerpt_length'], $settings['expanison_indicator']) . '</p>';
                                }
                            
                                if (class_exists('WooCommerce') && $settings['post_type'] == 'product') {
                                    echo '<p class="eael-entry-content-btn">';
                                        woocommerce_template_loop_add_to_cart();
                                    echo '</p>';
                                } else {
                                    echo '<a href="' . get_the_permalink() . '" class="eael-post-elements-readmore-btn">' . esc_attr($settings['read_more_button_text']) . '</a>';
                                }
                            echo '</div>
                        </div>';
                    }
                    echo '</div>';

                    if ($settings['eael_show_meta'] && $settings['meta_position'] == 'meta-entry-footer') {
                        echo '<div class="eael-entry-footer">';

                            if($settings['eael_show_avatar'] === 'yes') {
                                echo '<div class="eael-author-avatar">
                                    <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_avatar(get_the_author_meta('ID'), 96) . '</a>
                                </div>';
                            }
                            

                            echo '<div class="eael-entry-meta">';
                                if($settings['eael_show_author'] === 'yes') {
                                    echo '<div class="eael-posted-by">' . get_the_author_posts_link() . '</div>';
                                }

                                if($settings['eael_show_date'] === 'yes') {
                                    echo '<div class="eael-posted-on"><time datetime="' . get_the_date() . '">' . get_the_date() . '</time></div>';
                                }
                            echo '</div>';

                        echo '</div>';
                    }

                    echo '</div>';

                endif;
                echo '</div></article></div>';
            }
        } else {
            _e('<p class="no-posts-found">No posts found!</p>', 'essential-addons-elementor');
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}
