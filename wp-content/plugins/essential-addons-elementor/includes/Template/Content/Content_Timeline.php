<?php

namespace Essential_Addons_Elementor\Pro\Template\Content;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

trait Content_Timeline
{
    public static function render_template_($args, $settings)
    {
        $html = '';
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $html .= '<div class="eael-content-timeline-block">
                    <div class="eael-content-timeline-line">
                        <div class="eael-content-timeline-inner"></div>
                    </div>
                    <div class="eael-content-timeline-img eael-picture '.(('bullet' === $settings['eael_show_image_or_icon']) ? 'eael-content-timeline-bullet': '').'">';
                    
                        if( "img" === $settings["eael_show_image_or_icon"] ) {
                            $html .= '<img src="'. esc_url( $settings['eael_icon_image']['url'] ).'" alt="'.esc_attr(get_post_meta($settings['eael_icon_image']['id'], '_wp_attachment_image_alt', true)).'">';
                        }

                        if( 'icon' === $settings['eael_show_image_or_icon'] ) {
                            if( isset($settings['eael_content_timeline_circle_icon']['url'])) {
                                $html .= '<img class="content-timeline-bullet-svg" src="'.esc_attr( $settings['eael_content_timeline_circle_icon']['url'] ).'" alt="'.esc_attr(get_post_meta($settings['eael_content_timeline_circle_icon']['id'], '_wp_attachment_image_alt', true)).'"/>';
                            }else {
                                $html .= '<i class="'.esc_attr( $settings['eael_content_timeline_circle_icon'] ).'"></i>';
                            }
                        }
                    $html .= '</div>';

                    $html .= '<div class="eael-content-timeline-content">';
                        if( 'yes' == $settings['eael_show_title'] ) {
                            $html .= '<h2><a href="'.esc_url( get_the_permalink() ).'">'.get_the_title().'</a></h2>';
                        }

                        if( 'yes' == $settings['eael_show_excerpt'] ) {
                            if(empty($settings['eael_excerpt_length'])) {
                                $html .= '<p>'.strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()).'</p>';
                            }else {
                                $html .= '<p>' . wp_trim_words(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()), $settings['eael_excerpt_length'], $settings['expanison_indicator']) . '</p>';
                            }
                        }

                        if( 'yes' == $settings['eael_show_read_more'] && !empty( $settings['eael_read_more_text'] ) ) {
                            $html .= '<a href="'.esc_url( get_the_permalink() ).'" class="eael-read-more">'.esc_html__( $settings['eael_read_more_text'], 'essential-addons-elementor' ).'</a>';
                        }

                        $html .= '<span class="eael-date">'.get_the_date().'</span>';
                $html .= '</div></div>';
            }
        } else {
            $html .= __('<p class="no-posts-found">No posts found!</p>', 'essential-addons-elementor');
        }

        wp_reset_postdata();

        return $html;
    }
}
