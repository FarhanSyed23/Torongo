<?php

namespace Essential_Addons_Elementor\Pro\Template\Content;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

trait Dynamic_Filterable_Gallery
{
    public static function render_template_($args, $settings)
    {
        $html = '';
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $classes = [];

                // collect post class
                if ($categories = get_the_category(get_the_ID())) {
                    foreach ($categories as $category) {
                        $classes[] = $category->slug;
                    }
                }

                if ($tags = get_the_tags()) {
                    foreach ($tags as $tag) {
                        $classes[] = $tag->slug;
                    }
                }

                if ($product_cats = get_the_terms(get_the_ID(), 'product_cat')) {
                    foreach ($product_cats as $cat) {
                        if(is_object($cat)) {
                            $classes[] = $cat->slug;
                        }
                    }
                }

                if ($settings['eael_fg_grid_style'] == 'eael-hoverer') {
                        $html .= '<div class="dynamic-gallery-item ' . esc_attr(implode(' ', $classes)) . '">
                            <div class="dynamic-gallery-item-inner">
                                <div class="dynamic-gallery-thumbnail">';

                                    if(has_post_thumbnail()) {
                                        $html .= '<img src="' . wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']) . '" alt="' . esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) . '">';
                                    }else {
                                        $html .= '<img src="'.\Elementor\Utils::get_placeholder_image_src().'">';
                                    }

                                    if ('eael-none' !== $settings['eael_fg_grid_hover_style']) {
                                        $html .=  '<div class="caption ' . esc_attr($settings['eael_fg_grid_hover_style']) . ' ">';
                                            if ('true' == $settings['eael_fg_show_popup']) {
                                                if ('media' == $settings['eael_fg_show_popup_styles']) {
                                                    $html .= '<a href="' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . '" class="popup-media eael-magnific-link"></a>';
                                                } elseif ('buttons' == $settings['eael_fg_show_popup_styles']) {
                                                    $html .= '<div class="item-content">';
                                                        if($settings['eael_show_hover_title']) {
                                                            $html .= '<h2 class="title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                                                        }
                                                        if($settings['eael_show_hover_excerpt']) {
                                                            $html .= '<p>' . wp_trim_words(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()), $settings['eael_post_excerpt'], '...') . '...</p>';
                                                        }
                                                    $html .= '</div>';
                                                    $html .= '<div class="buttons">';
                                                        if (!empty($settings['eael_section_fg_zoom_icon'])) {
                                                            if(has_post_thumbnail()) {
                                                                $html .=  '<a href="' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . '" class="eael-magnific-link">';
                                                            }else { // If there is no real image on this post/page then change of anchor tag with placeholder image src
                                                                $html .= '<a href="'.\Elementor\Utils::get_placeholder_image_src().'" class="eael-magnific-link">';
                                                            }
                                                                if( isset($settings['eael_section_fg_zoom_icon']['url']) ) {
                                                                    $html .= '<img class="eael-dnmcg-svg-icon" src="'.esc_url($settings['eael_section_fg_zoom_icon']['url']).'" alt="'.esc_attr(get_post_meta($settings['eael_section_fg_zoom_icon']['id'], '_wp_attachment_image_alt', true)).'" />';
                                                                }else {
                                                                    $html .= '<i class="' . esc_attr($settings['eael_section_fg_zoom_icon']) . '"></i>';
                                                                }
                                                            $html .= '</a>';
                                                        }

                                                        if (!empty($settings['eael_section_fg_link_icon'])) {
                                                            $html .=  '<a href="' . get_the_permalink() . '">';
                                                                if( isset($settings['eael_section_fg_link_icon']['url'])) {
                                                                    $html .= '<img class="eael-dnmcg-svg-icon" src="'.esc_url($settings['eael_section_fg_link_icon']['url']).'" alt="'.esc_attr(get_post_meta($settings['eael_section_fg_link_icon']['id'], '_wp_attachment_image_alt', true)).'" />';
                                                                }else {
                                                                    $html .= '<i class="' . esc_attr($settings['eael_section_fg_link_icon']) . '"></i>';
                                                                }
                                                            $html .= '</a>';
                                                        }
                                                    $html .= '</div>';
                                                }
                                            }
                                        $html .= '</div>';
                                    }
                                $html .= '</div>
                            </div>
                        </div>';
                } else if ($settings['eael_fg_grid_style'] == 'eael-cards') {
                    $html .= '<div class="dynamic-gallery-item ' . esc_attr(implode(' ', $classes)) . '">
                        <div class="dynamic-gallery-item-inner">
                            <div class="dynamic-gallery-thumbnail">';
                                if(has_post_thumbnail()) {
                                    $html .= '<img src="' . wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']) . '" alt="' . esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) . '">';
                                }else {
                                    $html .= '<img src="'.\Elementor\Utils::get_placeholder_image_src().'">';
                                }

                                if ('media' == $settings['eael_fg_show_popup_styles'] && 'eael-none' == $settings['eael_fg_grid_hover_style']) {
                                    if(has_post_thumbnail()) {
                                        $html .= '<a href="' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . '" class="popup-only-media eael-magnific-link"></a>';
                                    }else {
                                        $html .= '<a href="'.\Elementor\Utils::get_placeholder_image_src().'" class="popup-only-media eael-magnific-link"></a>';
                                    }
                                }

                                if ('eael-none' !== $settings['eael_fg_grid_hover_style']) {
                                    if ('media' == $settings['eael_fg_show_popup_styles']) {
                                        $html .= '<div class="caption media-only-caption">';
                                    } else {
                                        $html .= '<div class="caption ' . esc_attr($settings['eael_fg_grid_hover_style']) . ' ">';
                                    }
                                    if ('true' == $settings['eael_fg_show_popup']) {
                                        if ('media' == $settings['eael_fg_show_popup_styles']) {
                                            if(has_post_thumbnail()) { // If there is no real image on this post/page then change of anchor tag with placeholder image src
                                                $html .= '<a href="' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . '" class="popup-media eael-magnific-link"></a>';
                                            }else {
                                                $html .= '<a href="'.\Elementor\Utils::get_placeholder_image_src().'" class="popup-media eael-magnific-link"></a>';
                                            }
                                        } elseif ('buttons' == $settings['eael_fg_show_popup_styles']) {
                                            $html .= '<div class="buttons">';
                                                if (!empty($settings['eael_section_fg_zoom_icon'])) {
                                                    if( has_post_thumbnail() ) {
                                                        $html .=  '<a href="' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . '" class="eael-magnific-link">';
                                                    }else {
                                                        $html .=  '<a href="'.\Elementor\Utils::get_placeholder_image_src().'" class="eael-magnific-link">';
                                                    }
                                                        if( isset($settings['eael_section_fg_zoom_icon']['url']) ) {
                                                            $html .= '<img class="eael-dnmcg-svg-icon" src="'.esc_url($settings['eael_section_fg_zoom_icon']['url']).'" alt="'.esc_attr(get_post_meta($settings['eael_section_fg_zoom_icon']['id'], '_wp_attachment_image_alt', true)).'" />';
                                                        }else {
                                                            $html .= '<i class="' . esc_attr($settings['eael_section_fg_zoom_icon']) . '"></i>';
                                                        }
                                                    $html .= '</a>';
                                                }

                                                if (!empty($settings['eael_section_fg_link_icon'])) {
                                                    $html .=  '<a href="' . get_the_permalink() . '">';
                                                        if( isset($settings['eael_section_fg_link_icon']['url'])) {
                                                            $html .= '<img class="eael-dnmcg-svg-icon" src="'.esc_url($settings['eael_section_fg_link_icon']['url']).'" alt="'.esc_attr(get_post_meta($settings['eael_section_fg_link_icon']['id'], '_wp_attachment_image_alt', true)).'" />';
                                                        }else {
                                                            $html .= '<i class="' . esc_attr($settings['eael_section_fg_link_icon']) . '"></i>';
                                                        }
                                                    $html .= '</a>';
                                                }
                                            $html .= '</div>';
                                        }
                                    }
                                    $html .= '</div>';
                                }
                            $html .= '</div>

                            <div class="item-content">
                                <h2 class="title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                                <p>' . wp_trim_words(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()), $settings['eael_post_excerpt'], '...') . '...</p>';

                                if (('buttons' == $settings['eael_fg_show_popup_styles']) && ('eael-none' == $settings['eael_fg_grid_hover_style'])) {
                                    $html .= '<div class="buttons entry-footer-buttons">';
                                        if (!empty($settings['eael_section_fg_zoom_icon'])) {
                                            $html .= '<a href="' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . '" class="eael-magnific-link"><i class="' . esc_attr($settings['eael_section_fg_zoom_icon']) . '"></i></a>';
                                        }
                                        if (!empty($settings['eael_section_fg_link_icon'])) {
                                            $html .= '<a href="' . get_the_permalink() . '"><i class="' . esc_attr($settings['eael_section_fg_link_icon']) . '"></i></a>';
                                        }
                                    $html .= '</div>';
                                }
                            $html .= '</div>
                        </div>
                    </div>';
                }
            }
        } else {
            $html .= __('<p class="no-posts-found">No posts found!</p>', 'essential-addons-elementor');
        }

        wp_reset_postdata();

        return $html;
    }
}
