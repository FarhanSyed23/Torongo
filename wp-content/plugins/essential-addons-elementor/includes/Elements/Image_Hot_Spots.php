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
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Hotspots Widget
 */
class Image_Hot_Spots extends Widget_Base {

    /**
	 * Retrieve image hotspots widget name.
	 */
    public function get_name() {
        return 'eael-image-hotspots';
    }

    /**
	 * Retrieve image hotspots widget title.
	 */
    public function get_title() {
        return __( 'Image Hotspots', 'essential-addons-elementor' );
    }

    /**
	 * Retrieve the list of categories the image hotspots widget belongs to.
	 */
    public function get_categories() {
        return [ 'essential-addons-elementor' ];
    }

    /**
	 * Retrieve image hotspots widget icon.
	 */
    public function get_icon() {
        return 'eaicon-image-hotspots';
    }

    public function get_keywords()
    {
        return [
            'image',
            'ea image hotspots',
            'ea image hot spots',
            'preview window',
            'tooltip',
            'ea tooltip',
            'pointers',
            'ea pointers',
            'ea',
            'essential addons'
        ];
    }

    public function get_custom_help_url()
    {
		return 'https://essential-addons.com/elementor/docs/image-hotspots/';
	}
    

    /**
	 * Register image hotspots widget controls.
	 */
    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	CONTENT TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Content Tab: Image
         */
        $this->start_controls_section(
            'section_image',
            [
                'label'                 => __( 'Image', 'essential-addons-elementor' ),
            ]
        );

		$this->add_control(
			'image',
			[
				'label'                 => __( 'Image', 'essential-addons-elementor' ),
				'type'                  => Controls_Manager::MEDIA,
				'default'               => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'image',
                'label'                 => __( 'Image Size', 'essential-addons-elementor' ),
                'default'               => 'full',
            ]
        );
        
        $this->end_controls_section();
        
        /**
         * Content Tab: Hotspots
         */
        $this->start_controls_section(
            'section_hotspots',
            [
                'label'                 => __( 'Hotspots', 'essential-addons-elementor' ),
            ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->start_controls_tabs( 'hot_spots_tabs' );

        $repeater->start_controls_tab( 'tab_content', [ 'label' => __( 'Content', 'essential-addons-elementor' ) ] );
        
            $repeater->add_control(
                'hotspot_type',
                [
                    'label'           => __( 'Type', 'essential-addons-elementor' ),
                    'type'            => Controls_Manager::SELECT,
                    'default'         => 'icon',
                    'options'         => [
                        'icon'  => __( 'Icon', 'essential-addons-elementor' ),
                        'text'  => __( 'Text', 'essential-addons-elementor' ),
                        'blank' => __( 'Blank', 'essential-addons-elementor' ),
                     ],
                ]
            );
        
            $repeater->add_control(
                'hotspot_icon_new',
                [
                    'label'           => __( 'Icon', 'essential-addons-elementor' ),
                    'type'            => Controls_Manager::ICONS,
                    'fa4compatibility' => 'hotspot_icon',
                    'default' => [
                        'value' => 'fas fa-plus',
                        'library' => 'fa-solid',
                    ],
                    'condition'       => [
                        'hotspot_type'   => 'icon',
                    ],
                ]
            );
        
            $repeater->add_control(
                'hotspot_text',
                [
                    'label'           => __( 'Text', 'essential-addons-elementor' ),
                    'type'            => Controls_Manager::TEXT,
                    'label_block'     => true,
                    'default'         => 'Go',
                    'condition'       => [
                        'hotspot_type'   => 'text',
                    ],
                ]
            );
            
            $repeater->add_control(
                'hotspot_link',
                [
                    'label'           => __( 'Link', 'essential-addons-elementor' ),
                    'type'            => Controls_Manager::TEXT,
                    'label_block'     => true,
                    'default'         => '#',
                ]
            );

            $repeater->add_control(
                'hotspot_link_target',
                [
                    'label'           => __( 'Open Link in New Tab', 'essential-addons-elementor' ),
                    'type'            => Controls_Manager::SWITCHER,
                    'default'         => 'yes',
                    'label_on'        => __( 'Yes', 'essential-addons-elementor' ),
                    'label_off'       => __( 'No', 'essential-addons-elementor' ),
                    'return_value'    => 'yes',
                ]
            );
        
        $repeater->end_controls_tab();
        
        $repeater->start_controls_tab( 'tab_position', [ 'label' => __( 'Position', 'essential-addons-elementor' ) ] );

            $repeater->add_responsive_control(
                'left_position',
                [
                    'label'         => __( 'Left Position', 'essential-addons-elementor' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range'         => [
                        'px' 	=> [
                            'min' 	=> 0,
                            'max' 	=> 100,
                            'step'	=> 0.1,
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}%;',
                    ],
                ]
            );

            $repeater->add_responsive_control(
                'top_position',
                [
                    'label'         => __( 'Top Position', 'essential-addons-elementor' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range'         => [
                        'px' 	=> [
                            'min' 	=> 0,
                            'max' 	=> 100,
                            'step'	=> 0.1,
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}%;',
                    ],
                ]
            );
        
        $repeater->end_controls_tab();
        
        $repeater->start_controls_tab( 'tab_tooltip', [ 'label' => __( 'Tooltip', 'essential-addons-elementor' ) ] );
        
            $repeater->add_control(
                'tooltip',
                [
                    'label'           => __( 'Tooltip', 'essential-addons-elementor' ),
                    'type'            => Controls_Manager::SWITCHER,
                    'default'         => '',
                    'label_on'        => __( 'Show', 'essential-addons-elementor' ),
                    'label_off'       => __( 'Hide', 'essential-addons-elementor' ),
                    'return_value'    => 'yes',
                ]
            );

            $repeater->add_control(
                'tooltip_position_local',
                [
                    'label'                 => __( 'Tooltip Position', 'essential-addons-elementor' ),
                    'type'                  => Controls_Manager::SELECT,
                    'default'               => 'global',
                    'options'               => [
                        'global'        => __( 'Global', 'essential-addons-elementor' ),
                        'top'           => __( 'Top', 'essential-addons-elementor' ),
                        'bottom'        => __( 'Bottom', 'essential-addons-elementor' ),
                        'left'          => __( 'Left', 'essential-addons-elementor' ),
                        'right'         => __( 'Right', 'essential-addons-elementor' ),
                        'top-left'      => __( 'Top Left', 'essential-addons-elementor' ),
                        'top-right'     => __( 'Top Right', 'essential-addons-elementor' ),
                        'bottom-left'   => __( 'Bottom Left', 'essential-addons-elementor' ),
                        'bottom-right'  => __( 'Bottom Right', 'essential-addons-elementor' ),
                    ],
                    'condition'       => [
                        'tooltip'   => 'yes',
                    ],
                ]
            );
        
            $repeater->add_control(
                'tooltip_content',
                [
                    'label'           => __( 'Tooltip Content', 'essential-addons-elementor' ),
                    'type'            => Controls_Manager::WYSIWYG,
                    'default'         => __( 'Tooltip Content', 'essential-addons-elementor' ),
                    'condition'       => [
                        'tooltip'   => 'yes',
                    ],
                ]
            );
        
        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'hot_spots',
            [
                'label'                 => '',
                'type'                  => Controls_Manager::REPEATER,
                'default'               => [
                    [
                        'feature_text'    => __( 'Hotspot #1', 'essential-addons-elementor' ),
						'feature_icon'    => 'fa fa-plus',
                        'left_position'   => 20,
                        'top_position'    => 30,
                    ],
                ],
                'fields'                => array_values( $repeater->get_controls() ),
                'title_field'           => '{{{ hotspot_text }}}',
            ]
        );
        
        $this->add_control(
            'hotspot_pulse',
            [
                'label'                 => __( 'Glow Effect', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'essential-addons-elementor' ),
                'label_off'             => __( 'No', 'essential-addons-elementor' ),
                'return_value'          => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Tooltip Settings
         */
        $this->start_controls_section(
            'section_tooltip',
            [
                'label'                 => __( 'Tooltip Settings', 'essential-addons-elementor' ),
            ]
        );
        
        $this->add_control(
            'tooltip_arrow',
            [
                'label'                 => __( 'Show Arrow', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'essential-addons-elementor' ),
                'label_off'             => __( 'No', 'essential-addons-elementor' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'tooltip_size',
            [
                'label'                 => __( 'Size', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'default',
                'options'               => [
                    'default'       => __( 'Default', 'essential-addons-elementor' ),
                    'tiny'          => __( 'Tiny', 'essential-addons-elementor' ),
                    'small'         => __( 'Small', 'essential-addons-elementor' ),
                    'large'         => __( 'Large', 'essential-addons-elementor' )
                ],
            ]
        );
        
        $this->add_control(
            'tooltip_position',
            [
                'label'                 => __( 'Global Position', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'top',
                'options'               => [
                    'top'           => __( 'Top', 'essential-addons-elementor' ),
                    'bottom'        => __( 'Bottom', 'essential-addons-elementor' ),
                    'left'          => __( 'Left', 'essential-addons-elementor' ),
                    'right'         => __( 'Right', 'essential-addons-elementor' ),
                    'top-left'      => __( 'Top Left', 'essential-addons-elementor' ),
                    'top-right'     => __( 'Top Right', 'essential-addons-elementor' ),
                    'bottom-left'   => __( 'Bottom Left', 'essential-addons-elementor' ),
                    'bottom-right'  => __( 'Bottom Right', 'essential-addons-elementor' ),
                ],
            ]
        );
        
        $this->add_control(
            'tooltip_animation_in',
            [
                'label'                 => __( 'Animation In', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SELECT2,
                'default'               => '',
                'label_block'            => true,
                'options'               => [
                    'bounce'            => __( 'Bounce', 'essential-addons-elementor' ),
                    'flash'             => __( 'Flash', 'essential-addons-elementor' ),
                    'pulse'             => __( 'Pulse', 'essential-addons-elementor' ),
                    'rubberBand'        => __( 'rubberBand', 'essential-addons-elementor' ),
                    'shake'             => __( 'Shake', 'essential-addons-elementor' ),
                    'swing'             => __( 'Swing', 'essential-addons-elementor' ),
                    'tada'              => __( 'Tada', 'essential-addons-elementor' ),
                    'wobble'            => __( 'Wobble', 'essential-addons-elementor' ),
                    'bounceIn'          => __( 'bounceIn', 'essential-addons-elementor' ),
                    'bounceInDown'      => __( 'bounceInDown', 'essential-addons-elementor' ),
                    'bounceInLeft'      => __( 'bounceInLeft', 'essential-addons-elementor' ),
                    'bounceInRight'     => __( 'bounceInRight', 'essential-addons-elementor' ),
                    'bounceInUp'        => __( 'bounceInUp', 'essential-addons-elementor' ),
                    'bounceOut'         => __( 'bounceOut', 'essential-addons-elementor' ),
                    'bounceOutDown'     => __( 'bounceOutDown', 'essential-addons-elementor' ),
                    'bounceOutLeft'     => __( 'bounceOutLeft', 'essential-addons-elementor' ),
                    'bounceOutRight'    => __( 'bounceOutRight', 'essential-addons-elementor' ),
                    'bounceOutUp'       => __( 'bounceOutUp', 'essential-addons-elementor' ),
                    'fadeIn'            => __( 'fadeIn', 'essential-addons-elementor' ),
                    'fadeInDown'        => __( 'fadeInDown', 'essential-addons-elementor' ),
                    'fadeInDownBig'     => __( 'fadeInDownBig', 'essential-addons-elementor' ),
                    'fadeInLeft'        => __( 'fadeInLeft', 'essential-addons-elementor' ),
                    'fadeInLeftBig'     => __( 'fadeInLeftBig', 'essential-addons-elementor' ),
                    'fadeInRight'       => __( 'fadeInRight', 'essential-addons-elementor' ),
                    'fadeInRightBig'    => __( 'fadeInRightBig', 'essential-addons-elementor' ),
                    'fadeInUp'          => __( 'fadeInUp', 'essential-addons-elementor' ),
                    'fadeInUpBig'       => __( 'fadeInUpBig', 'essential-addons-elementor' ),
                    'fadeOut'           => __( 'fadeOut', 'essential-addons-elementor' ),
                    'fadeOutDown'       => __( 'fadeOutDown', 'essential-addons-elementor' ),
                    'fadeOutDownBig'    => __( 'fadeOutDownBig', 'essential-addons-elementor' ),
                    'fadeOutLeft'       => __( 'fadeOutLeft', 'essential-addons-elementor' ),
                    'fadeOutLeftBig'    => __( 'fadeOutLeftBig', 'essential-addons-elementor' ),
                    'fadeOutRight'      => __( 'fadeOutRight', 'essential-addons-elementor' ),
                    'fadeOutRightBig'   => __( 'fadeOutRightBig', 'essential-addons-elementor' ),
                    'fadeOutUp'         => __( 'fadeOutUp', 'essential-addons-elementor' ),
                    'fadeOutUpBig'      => __( 'fadeOutUpBig', 'essential-addons-elementor' ),
                    'flip'              => __( 'flip', 'essential-addons-elementor' ),
                    'flipInX'           => __( 'flipInX', 'essential-addons-elementor' ),
                    'flipInY'           => __( 'flipInY', 'essential-addons-elementor' ),
                    'flipOutX'          => __( 'flipOutX', 'essential-addons-elementor' ),
                    'flipOutY'          => __( 'flipOutY', 'essential-addons-elementor' ),
                    'lightSpeedIn'      => __( 'lightSpeedIn', 'essential-addons-elementor' ),
                    'lightSpeedOut'     => __( 'lightSpeedOut', 'essential-addons-elementor' ),
                    'rotateIn'          => __( 'rotateIn', 'essential-addons-elementor' ),
                    'rotateInDownLeft'  => __( 'rotateInDownLeft', 'essential-addons-elementor' ),
                    'rotateInDownLeft'  => __( 'rotateInDownRight', 'essential-addons-elementor' ),
                    'rotateInUpLeft'    => __( 'rotateInUpLeft', 'essential-addons-elementor' ),
                    'rotateInUpRight'   => __( 'rotateInUpRight', 'essential-addons-elementor' ),
                    'rotateOut'         => __( 'rotateOut', 'essential-addons-elementor' ),
                    'rotateOutDownLeft' => __( 'rotateOutDownLeft', 'essential-addons-elementor' ),
                    'rotateOutDownLeft' => __( 'rotateOutDownRight', 'essential-addons-elementor' ),
                    'rotateOutUpLeft'   => __( 'rotateOutUpLeft', 'essential-addons-elementor' ),
                    'rotateOutUpRight'  => __( 'rotateOutUpRight', 'essential-addons-elementor' ),
                    'hinge'             => __( 'Hinge', 'essential-addons-elementor' ),
                    'rollIn'            => __( 'rollIn', 'essential-addons-elementor' ),
                    'rollOut'           => __( 'rollOut', 'essential-addons-elementor' ),
                    'zoomIn'            => __( 'zoomIn', 'essential-addons-elementor' ),
                    'zoomInDown'        => __( 'zoomInDown', 'essential-addons-elementor' ),
                    'zoomInLeft'        => __( 'zoomInLeft', 'essential-addons-elementor' ),
                    'zoomInRight'       => __( 'zoomInRight', 'essential-addons-elementor' ),
                    'zoomInUp'          => __( 'zoomInUp', 'essential-addons-elementor' ),
                    'zoomOut'           => __( 'zoomOut', 'essential-addons-elementor' ),
                    'zoomOutDown'       => __( 'zoomOutDown', 'essential-addons-elementor' ),
                    'zoomOutLeft'       => __( 'zoomOutLeft', 'essential-addons-elementor' ),
                    'zoomOutRight'      => __( 'zoomOutRight', 'essential-addons-elementor' ),
                    'zoomOutUp'         => __( 'zoomOutUp', 'essential-addons-elementor' ),
                ],
            ]
        );
        
        $this->add_control(
            'tooltip_animation_out',
            [
                'label'                 => __( 'Animation Out', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SELECT2,
                'default'               => '',
                'label_block'            => true,
                'options'               => [
                    'bounce'            => __( 'Bounce', 'essential-addons-elementor' ),
                    'flash'             => __( 'Flash', 'essential-addons-elementor' ),
                    'pulse'             => __( 'Pulse', 'essential-addons-elementor' ),
                    'rubberBand'        => __( 'rubberBand', 'essential-addons-elementor' ),
                    'shake'             => __( 'Shake', 'essential-addons-elementor' ),
                    'swing'             => __( 'Swing', 'essential-addons-elementor' ),
                    'tada'              => __( 'Tada', 'essential-addons-elementor' ),
                    'wobble'            => __( 'Wobble', 'essential-addons-elementor' ),
                    'bounceIn'          => __( 'bounceIn', 'essential-addons-elementor' ),
                    'bounceInDown'      => __( 'bounceInDown', 'essential-addons-elementor' ),
                    'bounceInLeft'      => __( 'bounceInLeft', 'essential-addons-elementor' ),
                    'bounceInRight'     => __( 'bounceInRight', 'essential-addons-elementor' ),
                    'bounceInUp'        => __( 'bounceInUp', 'essential-addons-elementor' ),
                    'bounceOut'         => __( 'bounceOut', 'essential-addons-elementor' ),
                    'bounceOutDown'     => __( 'bounceOutDown', 'essential-addons-elementor' ),
                    'bounceOutLeft'     => __( 'bounceOutLeft', 'essential-addons-elementor' ),
                    'bounceOutRight'    => __( 'bounceOutRight', 'essential-addons-elementor' ),
                    'bounceOutUp'       => __( 'bounceOutUp', 'essential-addons-elementor' ),
                    'fadeIn'            => __( 'fadeIn', 'essential-addons-elementor' ),
                    'fadeInDown'        => __( 'fadeInDown', 'essential-addons-elementor' ),
                    'fadeInDownBig'     => __( 'fadeInDownBig', 'essential-addons-elementor' ),
                    'fadeInLeft'        => __( 'fadeInLeft', 'essential-addons-elementor' ),
                    'fadeInLeftBig'     => __( 'fadeInLeftBig', 'essential-addons-elementor' ),
                    'fadeInRight'       => __( 'fadeInRight', 'essential-addons-elementor' ),
                    'fadeInRightBig'    => __( 'fadeInRightBig', 'essential-addons-elementor' ),
                    'fadeInUp'          => __( 'fadeInUp', 'essential-addons-elementor' ),
                    'fadeInUpBig'       => __( 'fadeInUpBig', 'essential-addons-elementor' ),
                    'fadeOut'           => __( 'fadeOut', 'essential-addons-elementor' ),
                    'fadeOutDown'       => __( 'fadeOutDown', 'essential-addons-elementor' ),
                    'fadeOutDownBig'    => __( 'fadeOutDownBig', 'essential-addons-elementor' ),
                    'fadeOutLeft'       => __( 'fadeOutLeft', 'essential-addons-elementor' ),
                    'fadeOutLeftBig'    => __( 'fadeOutLeftBig', 'essential-addons-elementor' ),
                    'fadeOutRight'      => __( 'fadeOutRight', 'essential-addons-elementor' ),
                    'fadeOutRightBig'   => __( 'fadeOutRightBig', 'essential-addons-elementor' ),
                    'fadeOutUp'         => __( 'fadeOutUp', 'essential-addons-elementor' ),
                    'fadeOutUpBig'      => __( 'fadeOutUpBig', 'essential-addons-elementor' ),
                    'flip'              => __( 'flip', 'essential-addons-elementor' ),
                    'flipInX'           => __( 'flipInX', 'essential-addons-elementor' ),
                    'flipInY'           => __( 'flipInY', 'essential-addons-elementor' ),
                    'flipOutX'          => __( 'flipOutX', 'essential-addons-elementor' ),
                    'flipOutY'          => __( 'flipOutY', 'essential-addons-elementor' ),
                    'lightSpeedIn'      => __( 'lightSpeedIn', 'essential-addons-elementor' ),
                    'lightSpeedOut'     => __( 'lightSpeedOut', 'essential-addons-elementor' ),
                    'rotateIn'          => __( 'rotateIn', 'essential-addons-elementor' ),
                    'rotateInDownLeft'  => __( 'rotateInDownLeft', 'essential-addons-elementor' ),
                    'rotateInDownLeft'  => __( 'rotateInDownRight', 'essential-addons-elementor' ),
                    'rotateInUpLeft'    => __( 'rotateInUpLeft', 'essential-addons-elementor' ),
                    'rotateInUpRight'   => __( 'rotateInUpRight', 'essential-addons-elementor' ),
                    'rotateOut'         => __( 'rotateOut', 'essential-addons-elementor' ),
                    'rotateOutDownLeft' => __( 'rotateOutDownLeft', 'essential-addons-elementor' ),
                    'rotateOutDownLeft' => __( 'rotateOutDownRight', 'essential-addons-elementor' ),
                    'rotateOutUpLeft'   => __( 'rotateOutUpLeft', 'essential-addons-elementor' ),
                    'rotateOutUpRight'  => __( 'rotateOutUpRight', 'essential-addons-elementor' ),
                    'hinge'             => __( 'Hinge', 'essential-addons-elementor' ),
                    'rollIn'            => __( 'rollIn', 'essential-addons-elementor' ),
                    'rollOut'           => __( 'rollOut', 'essential-addons-elementor' ),
                    'zoomIn'            => __( 'zoomIn', 'essential-addons-elementor' ),
                    'zoomInDown'        => __( 'zoomInDown', 'essential-addons-elementor' ),
                    'zoomInLeft'        => __( 'zoomInLeft', 'essential-addons-elementor' ),
                    'zoomInRight'       => __( 'zoomInRight', 'essential-addons-elementor' ),
                    'zoomInUp'          => __( 'zoomInUp', 'essential-addons-elementor' ),
                    'zoomOut'           => __( 'zoomOut', 'essential-addons-elementor' ),
                    'zoomOutDown'       => __( 'zoomOutDown', 'essential-addons-elementor' ),
                    'zoomOutLeft'       => __( 'zoomOutLeft', 'essential-addons-elementor' ),
                    'zoomOutRight'      => __( 'zoomOutRight', 'essential-addons-elementor' ),
                    'zoomOutUp'         => __( 'zoomOutUp', 'essential-addons-elementor' ),
                ],
            ]
        );
        
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Image
         */
        $this->start_controls_section(
            'section_image_style',
            [
                'label'                 => __( 'Image', 'essential-addons-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'image_width',
            [
                'label'                 => __( 'Width', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 1200,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 1,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
			'image_alignment',
			[
				'label' => esc_html__( 'Alignment', 'essential-addons-for-elementor-lite'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'essential-addons-for-elementor-lite'),
						'icon' => 'fa fa-align-left',
					],
					'centered' => [
						'title' => esc_html__( 'Center', 'essential-addons-for-elementor-lite'),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'essential-addons-for-elementor-lite'),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'centered',
				'prefix_class' => 'eael-image-hotspot-align-'
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Hotspot
         */
        $this->start_controls_section(
            'section_hotspots_style',
            [
                'label'                 => __( 'Hotspot', 'essential-addons-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'hotspot_size',
            [
                'label'                 => __( 'Size', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '14', 'unit' => 'px' ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                    'em' => [
                        'min'   => 0,
                        'max'   => 40,
                        'step'  => 1,
                    ]
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        
        $this->add_responsive_control(
            'hotspot_icon_size',
            [
                'label'                 => __( 'Icon Size', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '14', 'unit' => 'px' ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                    'em' => [
                        'min'   => 0,
                        'max'   => 40,
                        'step'  => 1,
                    ]
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-wrap .eael-hotspot-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-hot-spot-wrap .eael-hotspot-text' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-hot-spot-wrap .hotspot-svg-icon' => 'width:{{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'icon_color_normal',
            [
                'label'                 => __( 'Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#fff',
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-wrap, {{WRAPPER}} .eael-hot-spot-inner, {{WRAPPER}} .eael-hot-spot-inner:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .eael-hot-spot-wrap, {{WRAPPER}} .eael-hot-spot-inner, {{WRAPPER}} .eael-hot-spot-inner:before, {{WRAPPER}} .eael-hotspot-icon-wrap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'icon_border_normal',
				'label'                 => __( 'Border', 'essential-addons-elementor' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .eael-hot-spot-wrap'
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'                 => __( 'Border Radius', 'essential-addons-elementor' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .eael-hot-spot-wrap, {{WRAPPER}} .eael-hot-spot-inner, {{WRAPPER}} .eael-hot-spot-inner:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'                 => __( 'Padding', 'essential-addons-elementor' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .eael-hot-spot-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'icon_box_shadow',
				'selector'              => '{{WRAPPER}} .eael-hot-spot-wrap',
				'separator'             => 'before',
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Tooltip
         */
        $this->start_controls_section(
            'section_tooltips_style',
            [
                'label'                 => __( 'Tooltip', 'essential-addons-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tooltip_bg_color',
            [
                'label'                 => __( 'Background Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
            ]
        );

        $this->add_control(
            'tooltip_color',
            [
                'label'                 => __( 'Text Color', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
            ]
        );

        $this->add_control(
            'tooltip_width',
            [
                'label'         => __( 'Width', 'essential-addons-elementor' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' 	=> [
                        'min' 	=> 50,
                        'max' 	=> 400,
                        'step'	=> 1,
                    ],
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'tooltip_typography',
                'label'                 => __( 'Typography', 'essential-addons-elementor' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '.eael-tooltip-{{ID}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}
        ?>
        <div class="eael-image-hotspots">
            <div class="eael-hot-spot-image">
                <?php
                    $i = 1;
                    foreach ( $settings['hot_spots'] as $index => $item ) :
                    $icon = ((isset($item['__fa4_migrated']['hotspot_icon_new']) || empty($item['hotspot_icon'])) ? $item['hotspot_icon_new']['value'] : $item['hotspot_icon']);
                    $this->add_render_attribute( 'hotspot' . $i, 'class', 'eael-hot-spot-wrap elementor-repeater-item-' . esc_attr( $item['_id'] ) );
        
                    if ( $item['tooltip'] == 'yes' && $item['tooltip_content'] != '' ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'class', 'eael-hot-spot-tooptip' );
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tipso', '<span class="eael-single-tooltip eael-tooltip-'.$this->get_id().'">' . $this->parse_text_editor( $item['tooltip_content'] ) . '</span>' );
                    }
        
                    $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-position-global', $settings['tooltip_position'] );
        
                    if ($item['hotspot_link'] != '#' && $item['hotspot_link'] != '') {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-link', esc_url($item['hotspot_link']));
                    }
                    
                    if ($item['hotspot_link_target']) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-link-target', '_blank');
                    }
                    
                    if ( $item['tooltip_position_local'] != 'global' ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-position-local', $item['tooltip_position_local'] );
                    }
        
                    if ( $settings['tooltip_size'] ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-size', $settings['tooltip_size'] );
                    }
        
                    if ( $settings['tooltip_width'] ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-width', $settings['tooltip_width']['size'] );
                    }
        
                    if ( $settings['tooltip_animation_in'] ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-animation-in', $settings['tooltip_animation_in'] );
                    }
        
                    if ( $settings['tooltip_animation_out'] ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-animation-out', $settings['tooltip_animation_out'] );
                    }
        
                    if ( $settings['tooltip_bg_color'] ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-background', $settings['tooltip_bg_color'] );
                    }
        
                    if ( $settings['tooltip_color'] ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-tooltip-text-color', $settings['tooltip_color'] );
                    }
        
                    if ( $settings['tooltip_arrow'] == 'yes' ) {
                        $this->add_render_attribute( 'hotspot' . $i, 'data-eael-tooltip-arrow', $settings['tooltip_arrow'] );
                    }
        
                    $this->add_render_attribute( 'hotspot_inner_' . $i, 'class', 'eael-hot-spot-inner' );
        
                    if ( $settings['hotspot_pulse'] == 'yes' ) {
                        $this->add_render_attribute( 'hotspot_inner_' . $i, 'class', 'hotspot-animation' );
                    }
                    ?>
                    <span <?php echo $this->get_render_attribute_string( 'hotspot' . $i ); ?>>
                        <span <?php echo $this->get_render_attribute_string( 'hotspot_inner_' . $i ); ?>>
                        <?php
                            if ( $item['hotspot_type'] == 'icon' ) {
                                if( isset($icon['url']) ) {
                                    printf( '<span class="eael-hotspot-icon-wrap">
                                        <img class="eael-hotspot-icon tooltip hotspot-svg-icon" src="%1$s" alt="%2$s" />
                                        </span>', esc_url( $icon['url'] ), esc_attr(get_post_meta($icon['id'], '_wp_attachment_image_alt', true)) );
                                }else {
                                    printf( '<span class="eael-hotspot-icon-wrap"><span class="eael-hotspot-icon tooltip %1$s"></span></span>', esc_attr( $icon ) );
                                }
                            }
                            elseif ( $item['hotspot_type'] == 'text' ) {
                                printf( '<span class="eael-hotspot-icon-wrap"><span class="eael-hotspot-text">%1$s</span></span>', esc_attr( $item['hotspot_text'] ) );
                            }
                        ?>
                        </span>
                    </span>
                <?php $i++; endforeach; ?>
                
                <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
            </div>
        </div>
        <?php
    }
}