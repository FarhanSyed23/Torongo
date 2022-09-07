<?php

namespace Essential_Addons_Elementor\Pro\Template\Content;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

trait Post_List
{
    public static function render_template_($args, $settings)
    {
        $html = '';

        // featured
        if ($settings['eael_post_list_featured_area'] == 'yes' && !empty($settings['featured_posts'])) {
            global $post;
            $post = get_post(intval($settings['featured_posts']));
            setup_postdata($post);

            $html .= '<div class="eael-post-list-featured-wrap">
                <div class="eael-post-list-featured-inner" style="background-image: url(' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . ')">
                    <div class="featured-content">';
                        if ($settings['eael_post_list_featured_meta'] === 'yes') {
                            $html .= '<div class="meta">
                                <span>
                                    <i class="fas fa-user"></i>
                                    <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author() . '</a>
                                </span>
                                <span><i class="fas fa-calendar"></i> ' . get_the_date() . '</span>
                            </div>';
                        }

                        if ($settings['eael_post_list_featured_title'] == 'yes' && !empty($settings['eael_post_list_title_tag'])) {
                            $html .= "<{$settings['eael_post_list_title_tag']} class=\"eael-post-list-title\">";
                            $html .= '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                            $html .= "</{$settings['eael_post_list_title_tag']}>";
                        }

                        if ($settings['eael_post_list_featured_excerpt'] === 'yes') {
                            $html .= '<p>' . wp_trim_words(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()), $settings['eael_post_list_featured_excerpt_length'], $settings['eael_post_list_excerpt_expanison_indicator']) . '</p>';
                        }

                    $html .= '</div>
                </div>
            </div>';

            wp_reset_postdata();
        }
        
        // list
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            $iterator = 0;

            $html .= '<div class="eael-post-list-posts-wrap">';
                while ($query->have_posts()) {
                    $query->the_post();

                    $category = get_the_category();

                    $html .= '<div class="eael-post-list-post ' . (has_post_thumbnail() ? '' : 'eael-empty-thumbnail') . '">';
                        $html .= ($settings['eael_post_list_layout_type'] == 'advanced' ? '<div class="eael-post-list-post-inner">' : '');
                            if ($settings['eael_post_list_post_feature_image'] === 'yes') {
                                $html .= '<div class="eael-post-list-thumbnail ' . (has_post_thumbnail() ? '' : 'eael-empty-thumbnail') . '">';
                                    if (has_post_thumbnail()) {
                                        $html .= '<img src="' . wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . '" alt="' . esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) . '">';
                                    }
                                    $html .= '<a href="' . get_the_permalink() . '"></a>
                                </div>';
                            }

                            $html .= '<div class="eael-post-list-content">';
                                if ($settings['eael_post_list_layout_type'] == 'advanced' && ($iterator == 8) && $settings['eael_post_list_post_cat'] != '') {
                                    $html .= '<div class="boxed-meta">
                                        <div class="meta-categories">
                                            <a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a>
                                        </div>
                                    </div>';
                                }

                                if ($settings['eael_post_list_post_title'] == 'yes' && !empty($settings['eael_post_list_title_tag'])) {
                                    $html .= "<{$settings['eael_post_list_title_tag']} class=\"eael-post-list-title\">";
                                        $html .= '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                                    $html .= "</{$settings['eael_post_list_title_tag']}>";
                                }

                                if ($settings['eael_post_list_post_meta'] === 'yes') {
                                    $html .= '<div class="meta">
                                        <span>' . get_the_date() . '</span>
                                    </div>';
                                }

                                if ($settings['eael_post_list_post_excerpt'] === 'yes') {
                                    if ($settings['eael_post_list_layout_type'] == 'default' || ($settings['eael_post_list_layout_type'] == 'advanced' && $iterator !== 8)) {
                                        $html .= '<p>' . wp_trim_words(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()), $settings['eael_post_list_post_excerpt_length'], $settings['eael_post_list_excerpt_expanison_indicator']) . '</p>';
                                    }
                                }

                                if ( $settings['eael_show_read_more_button'] ) {
                            
                                    $html .= '<a href="' . get_the_permalink() . '" class="eael-post-elements-readmore-btn">' . esc_attr($settings['eael_post_list_read_more_text']) . '</a>';
                                
                                }

                                if ($settings['eael_post_list_layout_type'] == 'advanced') {
                                    $html .= '<div class="boxed-meta">';
                                        if ($settings['eael_post_list_author_meta'] != '') {
                                            $html .= '<div class="author-meta">
                                                <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" class="author-photo">
                                                    ' . get_avatar(get_the_author_meta('ID'), 100, false, get_the_title() . '-author') . '
                                                </a>

                                                <div class="author-info">
                                                    <h5>' . get_the_author_posts_link() . '</h5>
                                                    <a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '"><p>' . get_the_date('d.m.y') . '</p></a>
                                                </div>
                                            </div>';
                                        }

                                        if ($iterator != 8) {
                                            if ($settings['eael_post_list_post_cat'] != '') {
                                                $html .= '<div class="meta-categories">
                                                    <div class="meta-cats-wrap">
                                                        <a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a>
                                                    </div>
                                                </div>';
                                            }
                                        }
                                    $html .= '</div>';
                                }
                            $html .= '</div>';
                        $html .= ($settings['eael_post_list_layout_type'] == 'advanced' ? '</div>' : '');
                    $html .= '</div>';
                    
                    $iterator++;
                }
            $html .= '</div>';
        } else {
            $html .= __('<p class="no-posts-found">No posts found!</p>', 'essential-addons-elementor');
        }

        wp_reset_postdata();

        return $html;
    }
}
