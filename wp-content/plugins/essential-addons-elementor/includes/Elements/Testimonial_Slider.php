<?php
namespace Essential_Addons_Elementor\Pro\Elements;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Testimonial_Slider extends Widget_Base {

	public function get_name() {
		return 'eael-testimonial-slider';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Slider', 'essential-addons-elementor' );
	}

	public function get_icon() {
		return 'eaicon-testimonial-slider';
	}

    public function get_categories() {
		return [ 'essential-addons-elementor' ];
    }

    public function get_keywords()
    {
        return [
            'testimonial slider',
            'ea testimonial slider',
            'ea testimonial carousel',
            'endorsement',
            'review',
            'feedback',
            'quote',
            'testimonial carousel',
            'ea',
            'essential addons'
        ];
    }

   public function get_custom_help_url()
   {
       return 'https://essential-addons.com/elementor/docs/testimonial-slider/';
   }

   public function get_style_depends()
   {
       return [
           'font-awesome-5-all',
           'font-awesome-4-shim',
       ];
   }

   public function get_script_depends()
   {
       return [
           'font-awesome-4-shim'
       ];
   }


	protected function _register_controls() {


  		$this->start_controls_section(
  			'eael_section_testimonial_content',
  			[
  				'label' => esc_html__( 'Testimonial Content', 'essential-addons-elementor' )
  			]
  		);


		$this->add_control(
			'eael_testimonial_slider_item',
			[
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'eael_testimonial_name' => 'John Doe',
					],
					[
						'eael_testimonial_name' => 'Jane Doe',
					],

				],
				'fields' => [

					[
						'name' => 'eael_testimonial_enable_avatar',
						'label' => esc_html__( 'Display Avatar?', 'essential-addons-elementor' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => 'yes',
					],
					[
						'name' => 'eael_testimonial_image',
						'label' => esc_html__( 'Testimonial Avatar', 'essential-addons-elementor' ),
						'type' => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'condition' => [
							'eael_testimonial_enable_avatar' => 'yes',
						],
					],
					[
						'name' => 'eael_testimonial_name',
						'label' => esc_html__( 'User Name', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'John Doe', 'essential-addons-elementor' ),
						'dynamic' => [ 'active' => true ]
					],
					[
						'name' => 'eael_testimonial_company_title',
						'label' => esc_html__( 'Company Name', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Codetic', 'essential-addons-elementor' ),
						'dynamic' => [ 'active' => true ]
					],
					[
						'name' => 'eael_testimonial_description',
						'label' => esc_html__( 'Testimonial Description', 'essential-addons-elementor' ),
						'type' => Controls_Manager::WYSIWYG,
						'default' => esc_html__( 'Add testimonial description here. Edit and place your own text.', 'essential-addons-elementor' ),
					],

					[
						'name' => 'eael_testimonial_enable_rating',
						'label' => esc_html__( 'Display Rating?', 'essential-addons-elementor' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => 'yes',
					],

				   [
					     'name' => 'eael_testimonial_rating_number',
					     'label'       => __( 'Rating Number', 'essential-addons-elementor' ),
					     'type' => Controls_Manager::SELECT,
					     'default' => 'rating-five',
					     'options' => [
					     	'rating-one'  => __( '1', 'essential-addons-elementor' ),
					     	'rating-two' => __( '2', 'essential-addons-elementor' ),
					     	'rating-three' => __( '3', 'essential-addons-elementor' ),
					     	'rating-four' => __( '4', 'essential-addons-elementor' ),
					     	'rating-five'   => __( '5', 'essential-addons-elementor' ),
					     ],
						'condition' => [
							'eael_testimonial_enable_rating' => 'yes',
						],
				   ],


				],
				'title_field' => 'Testimonial Item',
			]
		);



		$this->end_controls_section();

		/**
         * Content Tab: Carousel Settings
         */
        $this->start_controls_section(
            'section_additional_options',
            [
                'label'                 => __( 'Carousel Settings', 'essential-addons-elementor' ),
            ]
        );
        
        $this->add_control(
            'carousel_effect',
            [
                'label'                 => __( 'Effect', 'essential-addons-elementor' ),
                'description'           => __( 'Sets transition effect', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'slide',
                'options'               => [
                    'slide'     => __( 'Slide', 'essential-addons-elementor' ),
                    'fade'      => __( 'Fade', 'essential-addons-elementor' ),
                    'cube'      => __( 'Cube', 'essential-addons-elementor' ),
                    'coverflow' => __( 'Coverflow', 'essential-addons-elementor' ),
                    'flip'      => __( 'Flip', 'essential-addons-elementor' ),
                ],
            ]
        );
        
        $this->add_responsive_control(
            'items',
            [
                'label'                 => __( 'Visible Items', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 1 ],
                'tablet_default'        => [ 'size' => 1 ],
                'mobile_default'        => [ 'size' => 1 ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 10,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'condition' => [
                    'carousel_effect' => ['slide', 'coverflow']
                ]
            ]
        );
        
        $this->add_responsive_control(
            'margin',
            [
                'label'                 => __( 'Items Gap', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 10 ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'condition' => [
                    'carousel_effect' => ['slide', 'coverflow']
                ]
            ]
        );
        
        $this->add_control(
            'slider_speed',
            [
                'label'                 => __( 'Slider Speed', 'essential-addons-elementor' ),
                'description'           => __( 'Duration of transition between slides (in ms)', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 1000 ],
                'range'                 => [
                    'px' => [
                        'min'   => 100,
                        'max'   => 3000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
            ]
        );
        
        $this->add_control(
            'autoplay',
            [
                'label'                 => __( 'Autoplay', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'essential-addons-elementor' ),
                'label_off'             => __( 'No', 'essential-addons-elementor' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'autoplay_speed',
            [
                'label'                 => __( 'Autoplay Speed', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 2000 ],
                'range'                 => [
                    'px' => [
                        'min'   => 500,
                        'max'   => 5000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'condition'         => [
                    'autoplay'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'                 => __( 'Pause On Hover', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Yes', 'essential-addons-elementor' ),
                'label_off'             => __( 'No', 'essential-addons-elementor' ),
                'return_value'          => 'yes',
                'condition'         => [
                    'autoplay'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'                 => __( 'Infinite Loop', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'essential-addons-elementor' ),
                'label_off'             => __( 'No', 'essential-addons-elementor' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'grab_cursor',
            [
                'label'                 => __( 'Grab Cursor', 'essential-addons-elementor' ),
                'description'           => __( 'Shows grab cursor when you hover over the slider', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'          => __( 'Show', 'essential-addons-elementor' ),
                'label_off'         => __( 'Hide', 'essential-addons-elementor' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'navigation_heading',
            [
                'label'                 => __( 'Navigation', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'arrows',
            [
                'label'                 => __( 'Arrows', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'essential-addons-elementor' ),
                'label_off'             => __( 'No', 'essential-addons-elementor' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'dots',
            [
                'label'                 => __( 'Dots', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'essential-addons-elementor' ),
                'label_off'             => __( 'No', 'essential-addons-elementor' ),
                'return_value'          => 'yes',
            ]
        );

        $this->end_controls_section();


		$this->start_controls_section(
			'eael_section_testimonial_styles_general',
			[
				'label' => esc_html__( 'Testimonial Styles', 'essential-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
        );
        
		$this->add_control(
			'eael_testimonial_style',
			[
				'label'		=> __( 'Select Style', 'essential-addons-elementor' ),
				'type'		=> Controls_Manager::SELECT,
				'default'	=> 'default-style',
				'options'	=> [
					'default-style'						=> __( 'Default', 'essential-addons-elementor' ),
					'classic-style'						=> __( 'Classic', 'essential-addons-elementor' ),
					'middle-style'						=> __( 'Content | Icon/Image | Bio', 'essential-addons-elementor' ),
					'icon-img-left-content'				=> __( 'Icon/Image | Content', 'essential-addons-elementor' ),
					'icon-img-right-content'			=> __( 'Content | Icon/Image', 'essential-addons-elementor' ),
					'content-top-icon-title-inline'		=> __( 'Content Top | Icon Title Inline', 'essential-addons-elementor' ),
					'content-bottom-icon-title-inline'	=> __( 'Content Bottom | Icon Title Inline', 'essential-addons-elementor' )
				]
			]
		);

		$this->add_control(
			'eael_testimonial_background',
			[
				'label' => esc_html__( 'Testimonial Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eael_testimonial_alignment',
			[
				'label' => esc_html__( 'Set Alignment', 'essential-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
				'options' => [
					'eael-testimonial-align-default' => [
						'title' => __( 'Default', 'essential-addons-elementor' ),
						'icon' => 'fa fa-ban',
					],
					'eael-testimonial-align-left' => [
						'title' => esc_html__( 'Left', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'eael-testimonial-align-center' => [
						'title' => esc_html__( 'Center', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'eael-testimonial-align-right' => [
						'title' => esc_html__( 'Right', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-right',
					],
				],
                'default' => 'eael-testimonial-align-left'
			]
		);

		$this->add_control(
			'eael_testimonial_user_display_block',
			[
				'label' => esc_html__( 'Display User & Company Block?', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);


		$this->add_responsive_control(
			'eael_testimonial_margin',
			[
				'label' => esc_html__( 'Margin', 'essential-addons-elementor' ),
				'description' => 'Need to refresh the page to see the change properly',
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_testimonial_padding',
			[
				'label' => esc_html__( 'Padding', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'eael_testimonial_border',
				'label' => esc_html__( 'Border', 'essential-addons-elementor' ),
				'selector' => '{{WRAPPER}} .eael-testimonial-item',
			]
		);

		$this->add_control(
			'eael_testimonial_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'eael_section_testimonial_image_styles',
			[
				'label' => esc_html__( 'Testimonial Image Style', 'essential-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
        );
        
		$this->add_responsive_control(
			'eael_testimonial_image_max_width',
			[
				'label' => esc_html__( 'Image Max Width', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 25,
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-image' => 'max-width:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_testimonial_image_width',
			[
				'label' => esc_html__( 'Image Width', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 150,
					'unit' => 'px',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-image img' => 'width:{{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'eael_testimonial_image_margin',
			[
				'label' => esc_html__( 'Margin', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eael_testimonial_image_padding',
			[
				'label' => esc_html__( 'Padding', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'eael_testimonial_image_border',
				'label' => esc_html__( 'Border', 'essential-addons-elementor' ),
				'selector' => '{{WRAPPER}} .eael-testimonial-image img',
			]
		);

		$this->add_control(
			'eael_testimonial_image_rounded',
			[
				'label' => esc_html__( 'Rounded Avatar?', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'testimonial-avatar-rounded',
				'default' => '',
			]
		);


		$this->add_control(
			'eael_testimonial_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-image img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'eael_testimonial_image_rounded!' => 'testimonial-avatar-rounded',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'eael_section_testimonial_typography',
			[
				'label' => esc_html__( 'Content Style', 'essential-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'eael_testimonial_name_heading',
			[
				'label' => __( 'User Name', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'eael_testimonial_name_color',
			[
				'label' => esc_html__( 'User Name Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-content .eael-testimonial-user' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'eael_testimonial_name_typography',
				'selector' => '{{WRAPPER}} .eael-testimonial-content .eael-testimonial-user',
			]
		);

		$this->add_control(
			'eael_testimonial_company_heading',
			[
				'label' => __( 'Company Name', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);


		$this->add_control(
			'eael_testimonial_company_color',
			[
				'label' => esc_html__( 'Company Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-content .eael-testimonial-user-company' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'eael_testimonial_position_typography',
				'selector' => '{{WRAPPER}} .eael-testimonial-content .eael-testimonial-user-company',
			]
		);

		$this->add_control(
			'eael_testimonial_description_heading',
			[
				'label' => __( 'Testimonial Text', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'eael_testimonial_description_color',
			[
				'label' => esc_html__( 'Testimonial Text Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7a7a7a',
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-content .eael-testimonial-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'eael_testimonial_description_typography',
				'selector' => '{{WRAPPER}} .eael-testimonial-content .eael-testimonial-text',
			]
        );

		$this->add_control(
			'eael_testimonial_quotation_heading',
			[
				'label' => __( 'Quotation Mark', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'eael_testimonial_quotation_color',
			[
				'label' => esc_html__( 'Quotation Mark Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.15)',
				'selectors' => [
					'{{WRAPPER}} .eael-testimonial-quote' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'eael_testimonial_quotation_typography',
				'selector' => '{{WRAPPER}} .eael-testimonial-quote',
			]
		);


		$this->end_controls_section();

		/**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label'                 => __( 'Arrows', 'essential-addons-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'arrow',
            [
                'label'                 => __( 'Choose Arrow', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SELECT,
                'label_block'           => true,
                'default'               => 'fa fa-angle-right',
                'options'               => [
                    'fa fa-angle-right'             => __( 'Angle', 'essential-addons-elementor' ),
                    'fa fa-angle-double-right'      => __( 'Double Angle', 'essential-addons-elementor' ),
                    'fa fa-chevron-right'           => __( 'Chevron', 'essential-addons-elementor' ),
                    'fa fa-chevron-circle-right'    => __( 'Chevron Circle', 'essential-addons-elementor' ),
                    'fa fa-arrow-right'             => __( 'Arrow', 'essential-addons-elementor' ),
                    'fa fa-long-arrow-right'        => __( 'Long Arrow', 'essential-addons-elementor' ),
                    'fa fa-caret-right'             => __( 'Caret', 'essential-addons-elementor' ),
                    'fa fa-caret-square-o-right'    => __( 'Caret Square', 'essential-addons-elementor' ),
                    'fa fa-arrow-circle-right'      => __( 'Arrow Circle', 'essential-addons-elementor' ),
                    'fa fa-arrow-circle-o-right'    => __( 'Arrow Circle O', 'essential-addons-elementor' ),
                    'fa fa-toggle-right'            => __( 'Toggle', 'essential-addons-elementor' ),
                    'fa fa-hand-o-right'            => __( 'Hand', 'essential-addons-elementor' ),
                ],
            ]
        );
        
        $this->add_responsive_control(
            'arrows_size',
            [
                'label'                 => __( 'Arrows Size', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '22' ],
                'range'                 => [
                    'px' => [
                        'min'   => 15,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
            'left_arrow_position',
            [
                'label'                 => __( 'Align Left Arrow', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'         => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
            'right_arrow_position',
            [
                'label'                 => __( 'Align Right Arrow', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'         => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label'                 => __( 'Normal', 'essential-addons-elementor' ),
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label'                 => __( 'Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'arrows_border_normal',
				'label'                 => __( 'Border', 'essential-addons-elementor' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev'
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'essential-addons-elementor' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label'                 => __( 'Hover', 'essential-addons-elementor' ),
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label'                 => __( 'Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'                 => __( 'Padding', 'essential-addons-elementor' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'             => 'before',
			]
		);
        
        $this->end_controls_section();
        
        /**
         * Style Tab: Dots
         */
        $this->start_controls_section(
            'section_dots_style',
            [
                'label'                 => __( 'Dots', 'essential-addons-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'dots'      => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label'                 => __( 'Position', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'inside'     => __( 'Inside', 'essential-addons-elementor' ),
                   'outside'    => __( 'Outside', 'essential-addons-elementor' ),
                ],
                'default'               => 'outside',
            ]
        );
        
        $this->add_responsive_control(
            'dots_size',
            [
                'label'                 => __( 'Size', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 2,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'dots_spacing',
            [
                'label'                 => __( 'Spacing', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_dots_style' );

        $this->start_controls_tab(
            'tab_dots_normal',
            [
                'label'                 => __( 'Normal', 'essential-addons-elementor' ),
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label'                 => __( 'Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label'                 => __( 'Active Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'dots_border_normal',
				'label'                 => __( 'Border', 'essential-addons-elementor' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet',
			]
		);

		$this->add_control(
			'dots_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'essential-addons-elementor' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_padding',
			[
				'label'                 => __( 'Padding', 'essential-addons-elementor' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
                'allowed_dimensions'    => 'vertical',
				'placeholder'           => [
					'top'      => '',
					'right'    => 'auto',
					'bottom'   => '',
					'left'     => 'auto',
				],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullets' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            [
                'label'                 => __( 'Hover', 'essential-addons-elementor' ),
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label'                 => __( 'Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();


    }

    protected function _render_user_meta( $item ) {
        $settings = $this->get_settings();
        ob_start();
        ?>
        <p class="eael-testimonial-user" <?php if ( ! empty( $settings['eael_testimonial_user_display_block'] ) ) : ?> style="display: block; float: none;"<?php endif;?>><?php echo esc_attr( $item['eael_testimonial_name'] ); ?></p>
        <p class="eael-testimonial-user-company"><?php echo esc_attr( $item['eael_testimonial_company_title'] ); ?></p>
        <?php
        echo ob_get_clean();
    }

    protected function _render_user_avatar( $item ) {
        if ( $item['eael_testimonial_enable_avatar'] != 'yes' ) return;
        $settings = $this->get_settings();
        ob_start();
        ?>
        <div class="eael-testimonial-image">
            <?php if('default-style' == $settings['eael_testimonial_style']) : ?>
            <span class="eael-testimonial-quote"></span>
            <?php endif; ?>
            <figure>
                <img src="<?php echo $item['eael_testimonial_image']['url'];?>" alt="<?php echo esc_attr(get_post_meta($item['eael_testimonial_image']['id'], '_wp_attachment_image_alt', true)); ?>">
            </figure>
        </div>
        <?php
        echo ob_get_clean();
    }

    protected function _render_user_ratings( $item ) {
        if ( empty($item['eael_testimonial_enable_rating'] ) ) return;
        ob_start();
    ?>
        <ul class="testimonial-star-rating">
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
        </ul>
        <?php
        echo ob_get_clean();
    }

    protected function _render_user_description( $item ) {
        echo '<div class="eael-testimonial-text">'.wpautop($item["eael_testimonial_description"]).'</div>';
    }


    protected function _render_quote() {
        echo '<span class="eael-testimonial-quote"></span>';
    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        $testimonial_classes = $this->get_settings('eael_testimonial_image_rounded') . " " . $this->get_settings('eael_testimonial_alignment');
        $navigation_type = $this->get_settings('eael_testimonial_slider_navigation');

        $this->add_render_attribute( 'testimonial-slider-wrap', 'class', 'swiper-container-wrap' );

        if ( $settings['dots_position'] ) {
            $this->add_render_attribute( 'testimonial-slider-wrap', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position'] );
        }

        $this->add_render_attribute('testimonial-slider-wrap', [
            'class' => ['eael-testimonial-slider', $settings['eael_testimonial_style']],
            'id'    => 'eael-testimonial-'.esc_attr($this->get_id()),
        ]);

        $this->add_render_attribute( 'testimonial-slider', [
            'class' => [
                'swiper-container',
                'eael-testimonial-slider-main',
                'swiper-container-'.esc_attr( $this->get_id() )
            ],
            'data-pagination'   => '.swiper-pagination-'.esc_attr( $this->get_id() ),
            'data-arrow-next'   => '.swiper-button-next-'.esc_attr( $this->get_id() ),
            'data-arrow-prev'   => '.swiper-button-prev-'.esc_attr( $this->get_id() )
        ]);

        if ( ! empty( $settings['items']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-items', $settings['items']['size'] );
        }

        if ( ! empty( $settings['items_tablet']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-items-tablet', $settings['items_tablet']['size'] );
        }

        if ( ! empty( $settings['items_mobile']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-items-mobile', $settings['items_mobile']['size'] );
        }

        if ( ! empty( $settings['margin']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-margin', $settings['margin']['size'] );
        }
        
        if ( ! empty( $settings['margin_tablet']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-margin-tablet', $settings['margin_tablet']['size'] );
        }
        
        if ( ! empty( $settings['margin_mobile']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-margin-mobile', $settings['margin_mobile']['size'] );
        }
        
        if ( $settings['carousel_effect'] ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-effect', $settings['carousel_effect'] );
        }
        
        if ( ! empty( $settings['slider_speed']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-speed', $settings['slider_speed']['size'] );
        }
        
        if ( $settings['infinite_loop'] == 'yes' ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-loop', 1 );
        }
        
        if ( $settings['grab_cursor'] == 'yes' ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-grab-cursor', 1 );
        }
        
        if ( $settings['arrows'] == 'yes' ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-arrows', 1 );
        }
        
        if ( $settings['dots'] == 'yes' ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-dots', 1 );
        }
        
        if ( $settings['autoplay'] == 'yes' && ! empty( $settings['autoplay_speed']['size'] ) ) {
            $this->add_render_attribute( 'testimonial-slider', 'data-autoplay_speed', $settings['autoplay_speed']['size'] );
        }

        if( $settings['pause_on_hover'] == 'yes' ) {
            $this->add_render_attribute('testimonial-slider', 'data-pause-on-hover', 'true');
        }
	?>

	<div <?php echo $this->get_render_attribute_string( 'testimonial-slider-wrap' ); ?>>
        <div <?php echo $this->get_render_attribute_string( 'testimonial-slider' ); ?>>

            <div class="swiper-wrapper">
                <?php
                    $i = 0;
                    foreach ( $settings['eael_testimonial_slider_item'] as $item ) :
                        $this->add_render_attribute('testimonial-content-wrapper'.$i, [
                            'class' => ['eael-testimonial-content', $item['eael_testimonial_rating_number']],
                            'style' => $item['eael_testimonial_enable_avatar'] == '' ? 'width: 100%;' : ''
                        ]);

                        $this->add_render_attribute('testimonial-slide'.$i, [
                            'class' => ['eael-testimonial-item', 'clearfix', 'swiper-slide', $testimonial_classes]
                        ]);
                ?>


                <?php if('classic-style' == $settings['eael_testimonial_style']) { ?>
                <div <?php echo $this->get_render_attribute_string('testimonial-slide'.$i); ?>>
                    <div <?php echo $this->get_render_attribute_string('testimonial-content-wrapper'.$i); ?>>
                        <?php $this->_render_quote(); ?>
                        <div class="testimonial-classic-style-content">
                            <?php
                                $this->_render_user_description( $item ); 
                                $this->_render_user_ratings( $item );
                                $this->_render_user_meta( $item );
                            ?>
                        </div>
                        <?php $this->_render_user_avatar($item); ?>
                    </div>
                </div>
                <?php } ?>

                <?php if('middle-style' == $settings['eael_testimonial_style']) { ?>
                <div <?php echo $this->get_render_attribute_string('testimonial-slide'.$i); ?>>
                    <div <?php echo $this->get_render_attribute_string('testimonial-content-wrapper'.$i); ?>>
                        <?php
                            
                            $this->_render_quote();
                            $this->_render_user_description( $item );
                        ?>
                        <?php $this->_render_user_avatar($item); ?>
                        <div class="middle-style-content">
                            <?php
                                $this->_render_user_ratings( $item );
                                $this->_render_user_meta( $item );
                            ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if('icon-img-left-content' == $settings['eael_testimonial_style']) { ?>
                <div <?php echo $this->get_render_attribute_string('testimonial-slide'.$i); ?>>
                    <?php $this->_render_user_avatar($item); ?>
                    <div <?php echo $this->get_render_attribute_string('testimonial-content-wrapper'.$i); ?>>
                        <?php
                            $this->_render_quote();
                            $this->_render_user_description( $item ); 
                            $this->_render_user_ratings( $item );
                            $this->_render_user_meta( $item );
                        ?>
                    </div>
                </div>
                <?php } ?>

                <?php if('icon-img-right-content' == $settings['eael_testimonial_style']) { ?>
                <div <?php echo $this->get_render_attribute_string('testimonial-slide'.$i); ?>>
                    <div <?php echo $this->get_render_attribute_string('testimonial-content-wrapper'.$i); ?>>
                        <?php
                            $this->_render_quote();
                            $this->_render_user_description( $item ); 
                            $this->_render_user_ratings( $item );
                            $this->_render_user_meta( $item );
                            ?>
                    </div>
                    <?php $this->_render_user_avatar($item); ?>
                </div>
                <?php } ?>


                <?php if('content-top-icon-title-inline' == $settings['eael_testimonial_style']) { ?>
                <div <?php echo $this->get_render_attribute_string('testimonial-slide'.$i); ?>>
                    <div <?php echo $this->get_render_attribute_string('testimonial-content-wrapper'.$i); ?>>
                        <?php
                            $this->_render_quote();
                            $this->_render_user_description( $item ); 
                        ?>
                        <div class="testimonial-inline-style">
                            <?php
                                $this->_render_user_avatar($item);
                                $this->_render_user_meta( $item );
                                $this->_render_user_ratings( $item );
                            ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if('content-bottom-icon-title-inline' == $settings['eael_testimonial_style']) { ?>
                    <div <?php echo $this->get_render_attribute_string('testimonial-slide'.$i); ?>>
                    <div <?php echo $this->get_render_attribute_string('testimonial-content-wrapper'.$i); ?>>
                        <div class="testimonial-inline-style">
                            <?php
                                $this->_render_user_avatar($item);
                                $this->_render_user_meta( $item );
                                $this->_render_user_ratings( $item );
                            ?>
                        </div>
                        <?php
                            $this->_render_quote();
                            $this->_render_user_description( $item ); 
                        ?>
                    </div>
                </div>
                <?php } ?>


                <?php if('default-style' == $settings['eael_testimonial_style']) { ?>
                <div <?php echo $this->get_render_attribute_string('testimonial-slide'.$i); ?>>
                    <?php $this->_render_user_avatar($item); ?>
                    <div <?php echo $this->get_render_attribute_string('testimonial-content-wrapper'.$i); ?>>
                        <?php //$this->_render_quote(); ?>
                        <div class="default-style-testimonial-content">
                            <?php
                                $this->_render_user_description( $item ); 
                                $this->_render_user_ratings( $item );
                                $this->_render_user_meta( $item );
                            ?>
                        </div>
                    </div>
                </div>
                <?php } ?>


                <?php $i++; endforeach; ?>
            </div>
            <?php
                $this->render_dots();

                $this->render_arrows();
            ?>
		</div>
	</div>

	<?php

	}

	/**
	 * Render logo carousel dots output on the frontend.
	 */
    protected function render_dots() {
        $settings = $this->get_settings_for_display();

        if ( $settings['dots'] == 'yes' ) { ?>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ); ?>"></div>
        <?php }
    }

    /**
	 * Render logo carousel arrows output on the frontend.
	 */
    protected function render_arrows() {
        $settings = $this->get_settings_for_display();

        if ( $settings['arrows'] == 'yes' ) { ?>
            <?php
                if ( $settings['arrow'] ) {
                    $pa_next_arrow = $settings['arrow'];
                    $pa_prev_arrow = str_replace("right","left",$settings['arrow']);
                }
                else {
                    $pa_next_arrow = 'fa fa-angle-right';
                    $pa_prev_arrow = 'fa fa-angle-left';
                }
            ?>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-next-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $pa_next_arrow ); ?>"></i>
            </div>
            <div class="swiper-button-prev swiper-button-prev-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $pa_prev_arrow ); ?>"></i>
            </div>
        <?php }
    }

	protected function content_template() {}
}