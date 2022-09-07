<?php
namespace Essential_Addons_Elementor\Pro\Extensions;

if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Plugin;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;

class Content_Protection
{
    use \Essential_Addons_Elementor\Traits\Helper;
    use \Essential_Addons_Elementor\Pro\Traits\Helper;

    public function __construct()
    {
        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'register_controls'], 10);
        add_action('elementor/widget/render_content', [$this, 'render_content'], 10, 2);
    }

    public function register_controls($element)
    {
        $element->start_controls_section(
            'eael_ext_content_protection_section',
            [
                'label' => __('<i class="eaicon-logo"></i> Content Protection', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'eael_ext_content_protection',
            [
                'label' => __('Enable Content Protection', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_type',
            [
                'label' => esc_html__('Protection Type', 'essential-addons-elementor'),
                'label_block' => false,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'role' => esc_html__('User role', 'essential-addons-elementor'),
                    'password' => esc_html__('Password protected', 'essential-addons-elementor'),
                ],
                'default' => 'role',
                'condition' => [
                    'eael_ext_content_protection' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_role',
            [
                'label' => __('Select Roles', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $this->eael_user_roles(),
                'condition' => [
                    'eael_ext_content_protection' => 'yes',
                    'eael_ext_content_protection_type' => 'role',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_password',
            [
                'label' => esc_html__('Set Password', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'password',
                'condition' => [
                    'eael_ext_content_protection' => 'yes',
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );
        
        $element->add_control(
            'eael_ext_content_protection_password_placeholder',
            [
                'label' => esc_html__('Input Placehlder', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Enter Password',
                'condition' => [
                    'eael_ext_content_protection' => 'yes',
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );
        
        $element->add_control(
            'eael_ext_content_protection_password_submit_btn_txt',
            [
                'label' => esc_html__('Submit Button Text', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Submit',
                'condition' => [
                    'eael_ext_content_protection' => 'yes',
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->start_controls_tabs(
            'eael_ext_content_protection_tabs',
            [
                'condition' => [
                    'eael_ext_content_protection' => 'yes',
                ],
            ]
        );

        $element->start_controls_tab(
            'eael_ext_content_protection_tab_message',
            [
                'label' => __('Message', 'essential-addons-elementor'),
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_message_type',
            [
                'label' => esc_html__('Message Type', 'essential-addons-elementor'),
                'label_block' => false,
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__('Set a message or a saved template when the content is protected.', 'essential-addons-elementor'),
                'options' => [
                    'none' => esc_html__('None', 'essential-addons-elementor'),
                    'text' => esc_html__('Message', 'essential-addons-elementor'),
                    'template' => esc_html__('Saved Templates', 'essential-addons-elementor'),
                ],
                'default' => 'text',
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_message_text',
            [
                'label' => esc_html__('Public Text', 'essential-addons-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('You do not have permission to see this content.', 'essential-addons-elementor'),
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'eael_ext_content_protection_message_type' => 'text',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_message_template',
            [
                'label' => __('Choose Template', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->eael_get_page_templates(),
                'condition' => [
                    'eael_ext_content_protection_message_type' => 'template',
                ],
            ]
        );

        $element->end_controls_tab();

        $element->start_controls_tab(
            'eael_ext_content_protection_tab_style',
            [
                'label' => __('Style', 'essential-addons-elementor'),
            ]
        );

        # message
        $element->add_control(
            'eael_ext_content_protection_message_styles',
            [
                'label' => __('Message', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => [
                    'eael_ext_content_protection_message_type' => 'text',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_message_text_color',
            [
                'label' => esc_html__('Text Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-protected-content-message' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_message_type' => 'text',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_ext_content_protection_message_text_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .eael-protected-content-message, {{WRAPPER}} .protected-content-error-msg',
                'condition' => [
                    'eael_ext_content_protection_message_type' => 'text',
                ],
            ]
        );

        $element->add_responsive_control(
            'eael_ext_content_protection_message_text_alignment',
            [
                'label' => esc_html__('Text Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .eael-protected-content-message, {{WRAPPER}} .protected-content-error-msg' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_message_type' => 'text',
                ],
            ]
        );

        $element->add_responsive_control(
            'eael_ext_content_protection_message_text_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-protected-content-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_message_type' => 'text',
                ],
            ]
        );

        # password field
        $element->add_control(
            'eael_ext_content_protection_input_styles',
            [
                'label' => __('Password Field', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_input_width',
            [
                'label' => esc_html__('Input Width', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password' => 'width: {{SIZE}}px;',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_responsive_control(
            'eael_ext_content_protection_input_alignment',
            [
                'label' => esc_html__('Input Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields > form' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_responsive_control(
            'eael_ext_content_protection_password_input_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_responsive_control(
            'eael_ext_content_protection_password_input_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password' => 'border-radius: {{SIZE}}px;',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_password_input_color',
            [
                'label' => esc_html__('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_password_input_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_ext_content_protection_password_input_border',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-password',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_ext_content_protection_password_input_shadow',
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-password',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        # password field hover
        $element->add_control(
            'eael_ext_content_protection_input_styles_hover',
            [
                'label' => __('Password Field Hover', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_protected_content_password_input_hover_color',
            [
                'label' => esc_html__('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_protected_content_password_input_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields input.eael-password:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_protected_content_password_input_hover_border',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-password:hover',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_protected_content_password_input_hover_shadow',
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-password"hover',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        # submit button
        $element->add_control(
            'eael_ext_content_protection_submit_button_styles',
            [
                'label' => __('Submit Button', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_submit_button_color',
            [
                'label' => esc_html__('Text Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_submit_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_ext_content_protection_submit_button_border',
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_ext_content_protection_submit_button_box_shadow',
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_submit_button_styles_hover',
            [
                'label' => __('Submit Button Hover', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_submit_button_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_control(
            'eael_ext_content_protection_submit_button_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit:hover' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_ext_content_protection_submit_button_hover_border',
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit:hover',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_ext_content_protection_submit_button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .eael-password-protected-content-fields .eael-submit:hover',
                'condition' => [
                    'eael_ext_content_protection_type' => 'password',
                ],
            ]
        );

        $element->end_controls_tab();

        $element->end_controls_tabs();

        $element->end_controls_section();
    }

    # Check current user role exists inside of the roles array.
    protected function current_user_privileges($settings)
    {
        if (!is_user_logged_in()) {
            return;
        }

        $user_role = reset(wp_get_current_user()->roles);
        return in_array($user_role, (array) $settings['eael_ext_content_protection_role']);
    }

    # render message
    protected function render_message($settings)
    {
        $html = '<div class="eael-protected-content-message">';

        if ($settings['eael_ext_content_protection_message_type'] == 'text') {
            $html .= '<div class="eael-protected-content-message-text">' . $settings['eael_ext_content_protection_message_text'] . '</div>';
        } elseif ($settings['eael_ext_content_protection_message_type'] == 'template') {
            if (!empty($settings['eael_ext_content_protection_message_template'])) {
                $html .= Plugin::$instance->frontend->get_builder_content($settings['eael_ext_content_protection_message_template'], true);
            }
        }
        $html .= '</div>';

        return $html;
    }

    # password input form
    public function password_protected_form($widget_id, $settings)
    {
        $html = '<div class="eael-password-protected-content-fields">
            <form method="post">
                <input type="password" name="eael_ext_content_protection_password_' . $widget_id . '" class="eael-password" placeholder="' . $settings['eael_ext_content_protection_password_placeholder'] . '">
                <input type="submit" value="' . $settings['eael_ext_content_protection_password_submit_btn_txt'] . '" class="eael-submit">
            </form>';

            if (isset($_POST['eael_ext_content_protection_password_' . $widget_id])) {
                if ($settings['eael_ext_content_protection_password'] != $_POST['eael_ext_content_protection_password_' . $widget_id]) {
                    $html .= sprintf(__('<p class="protected-content-error-msg">Password does not match.</p>', 'essential-addons-elementor'));
                }
            }

        $html .= '</div>';

        return $html;
    }

    public function render_content($content, $widget)
    {
        $widget_id = $widget->get_id();
        $settings = $widget->get_settings_for_display();
        $html = '';

        if ($settings['eael_ext_content_protection'] == 'yes') {
            // inject element to loaded extensions
            add_filter('eael/section/after_render', function ($extensions) {
                $extensions[] = 'eael-content-protection';
                return $extensions;
            });

            if ($settings['eael_ext_content_protection_type'] == 'role') {
                if ($this->current_user_privileges($settings) === true) {
                    $html .= $content;
                } else {
                    $html .= '<div class="eael-protected-content">' . $this->render_message($settings) . '</div>';
                }
            } elseif ($settings['eael_ext_content_protection_type'] == 'password') {
                if (empty($settings['eael_ext_content_protection_password'])) {
                    $html .= $content;
                } else {
                    $unlocked = false;

                    if (isset($_POST['eael_ext_content_protection_password_' . $widget_id])) {
                        if ($settings['eael_ext_content_protection_password'] == $_POST['eael_ext_content_protection_password_' . $widget_id]) {
                            $unlocked = true;

                            $html .= "<script>
                                var expires = new Date();
                                expires.setTime(expires.getTime() + (1 * 60 * 60 * 1000));
                                document.cookie = 'eael_ext_content_protection_password_$widget_id=true;expires=' + expires.toUTCString();
                            </script>";
                        }
                    }

                    if (isset($_COOKIE['eael_ext_content_protection_password_' . $widget_id]) || $unlocked) {
                        $html .= $content;
                    } else {
                        $html .= '<div class="eael-protected-content">' . $this->render_message($settings) . $this->password_protected_form($widget_id, $settings) . '</div>';
                    }
                }
            }
        } else {
            $html .= $content;
        }

        return $html;
    }

}
