<?php
/**
 * Mobile Header - Dynamic CSS
 *
 * @package Astra Addon
 */

/**
 * Mobile Header options.
 */
add_filter( 'astra_dynamic_css', 'astra_ext_mobile_header_dynamic_css' );

/**
 * Dynamic CSS
 *
 * @param  string $dynamic_css          Astra Dynamic CSS.
 * @param  string $dynamic_css_filtered Astra Dynamic CSS Filters.
 * @return string
 */
function astra_ext_mobile_header_dynamic_css( $dynamic_css, $dynamic_css_filtered = '' ) {

	$menu_style            = astra_get_option( 'mobile-menu-style' );
	$flayout_sidebar_width = apply_filters( 'astra_flayout_sidebar_width', 325 );
	$primary_menu_spacing  = astra_get_option( 'primary-menu-spacing' );

	$theme_color                          = astra_get_option( 'theme-color' );
	$link_color                           = astra_get_option( 'link-color', $theme_color );
	$text_color                           = astra_get_option( 'text-color' );
	$btn_bg_color                         = astra_get_option( 'button-bg-color', $theme_color );
	$mobile_header_toggle_btn_style_color = astra_get_option( 'mobile-header-toggle-btn-style-color', $btn_bg_color );
	$mobile_header_toggle_btn_style       = astra_get_option( 'mobile-header-toggle-btn-style' );

	$disable_primary_menu = astra_get_option( 'disable-primary-nav' );
	$merge_above_header   = astra_get_option( 'above-header-merge-menu' );
	$merge_below_header   = astra_get_option( 'below-header-merge-menu' );

	$mobile_header_menu_all_border = astra_get_option( 'mobile-header-menu-all-border' );
	$mobile_header_menu_b_color    = astra_get_option( 'mobile-header-menu-b-color', '#dadada' );

	$css_output = '';

	/**
	 * Responsive Colors options
	 * [2]. Primary Menu Responsive Colors only for Full Screen menu style
	 */
	if ( 'fullscreen' == $menu_style ) {
		/**
		 * Border only for resopnsive devices
		 */
		if ( '' !== $mobile_header_menu_all_border['top'] || '' !== $mobile_header_menu_all_border['right'] || '' !== $mobile_header_menu_all_border['bottom'] || '' !== $mobile_header_menu_all_border['left'] ) {
			$mobile_header_border = array(
				'.ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu > .menu-item, .ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu > .page_item' => array(
					'border-right-width' => astra_get_css_value( $mobile_header_menu_all_border['right'], 'px' ),
					'border-left-width'  => astra_get_css_value( $mobile_header_menu_all_border['left'], 'px' ),
					'border-style'       => 'solid',
					'border-color'       => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu > .menu-item:not(:first-child):not(:last-child), .ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu > .page_item:not(:first-child):not(:last-child)' => array(
					'border-top-width'    => ( ! empty( $mobile_header_menu_all_border['top'] ) && ! empty( $mobile_header_menu_all_border['bottom'] ) ) ? astra_calc_spacing( $mobile_header_menu_all_border['top'] . 'px', '/', '2' ) : astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-bottom-width' => ( ! empty( $mobile_header_menu_all_border['bottom'] ) && ! empty( $mobile_header_menu_all_border['top'] ) ) ? astra_calc_spacing( $mobile_header_menu_all_border['bottom'] . 'px', '/', '2' ) : astra_get_css_value( $mobile_header_menu_all_border['bottom'], 'px' ),
					'border-style'        => 'solid',
					'border-color'        => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu .menu-item:first-child, .ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu .page_item:first-child' => array(
					'border-top-width'    => astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-bottom-width' => ( ! empty( $mobile_header_menu_all_border['bottom'] ) && ! empty( $mobile_header_menu_all_border['top'] ) ) ? astra_calc_spacing( $mobile_header_menu_all_border['bottom'] . 'px', '/', '2' ) : astra_get_css_value( $mobile_header_menu_all_border['bottom'], 'px' ),
					'border-style'        => 'solid',
					'border-color'        => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu .menu-item:last-child, .ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu .page_item:last-child' => array(
					'border-top-width'    => ( ! empty( $mobile_header_menu_all_border['top'] ) && ! empty( $mobile_header_menu_all_border['bottom'] ) ) ? astra_calc_spacing( $mobile_header_menu_all_border['top'] . 'px', '/', '2' ) : astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-bottom-width' => astra_get_css_value( $mobile_header_menu_all_border['bottom'], 'px' ),
					'border-style'        => 'solid',
					'border-color'        => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu .menu-item.ast-submenu-expanded .sub-menu .menu-item, .ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu .page_item.ast-submenu-expanded .children .page_item' => array(
					'border-top-width'    => astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-bottom-width' => 0,
					'border-style'        => 'solid',
					'border-color'        => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-fullscreen-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu .ast-masthead-custom-menu-items' => array(
					'border-top-width'    => ( ! empty( $mobile_header_menu_all_border['top'] ) && ! empty( $mobile_header_menu_all_border['bottom'] ) ) ? astra_calc_spacing( $mobile_header_menu_all_border['top'] . 'px', '/', '2' ) : astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-bottom-width' => astra_get_css_value( $mobile_header_menu_all_border['bottom'], 'px' ),
					'border-right-width'  => astra_get_css_value( $mobile_header_menu_all_border['right'], 'px' ),
					'border-left-width'   => astra_get_css_value( $mobile_header_menu_all_border['left'], 'px' ),
					'border-style'        => 'solid',
					'border-color'        => esc_attr( $mobile_header_menu_b_color ),
				),
			);
			$css_output          .= astra_parse_css( $mobile_header_border );
		}
	} elseif ( 'no-toggle' == $menu_style ) {

		// Border only for responsive devices.
		if ( '' !== $mobile_header_menu_all_border['top'] || '' !== $mobile_header_menu_all_border['right'] || '' !== $mobile_header_menu_all_border['bottom'] || '' !== $mobile_header_menu_all_border['left'] ) {
			$mobile_header_border = array(
				'.ast-no-toggle-menu-enable.ast-header-break-point .main-header-bar-navigation ul li' => array(
					'border-top-width'   => astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-left-width'  => astra_get_css_value( $mobile_header_menu_all_border['left'], 'px' ),
					'border-right-width' => astra_get_css_value( $mobile_header_menu_all_border['right'], 'px' ),
					'border-color'       => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-no-toggle-menu-enable.ast-header-break-point .main-navigation > ul > li, .ast-no-toggle-menu-enable.ast-header-break-point .main-header-bar-navigation .sub-menu li:last-child' => array(
					'border-bottom-width' => astra_get_css_value( $mobile_header_menu_all_border['bottom'], 'px' ),
				),
				'.ast-no-toggle-menu-enable.ast-header-break-point .main-navigation > ul.ast-above-header-menu > li:last-child, .ast-no-toggle-menu-enable.ast-header-break-point .main-navigation > ul > li:last-child' => array(
					'border-right-width' => astra_get_css_value( $mobile_header_menu_all_border['right'], 'px' ),
					'border-color'       => esc_attr( $mobile_header_menu_b_color ),
					'border-style'       => 'solid',
				),
				'.ast-no-toggle-menu-enable.ast-header-break-point .main-header-bar-navigation ul > li:first-child' => array(
					'border-top-width' => astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-color'     => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-no-toggle-menu-enable.ast-header-break-point .main-navigation > ul > li:first-child, .ast-no-toggle-menu-enable.ast-header-break-point .main-navigation > ul > li' => array(
					'border-right-width' => astra_get_css_value( $mobile_header_menu_all_border['right'], 'px' ),
					'border-color'       => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-no-toggle-menu-enable.ast-header-break-point .main-navigation > ul > li' => array(
					'margin-right' => '-' . astra_get_css_value( $mobile_header_menu_all_border['right'], 'px' ),
				),
				'.ast-no-toggle-menu-enable.ast-header-break-point .main-navigation > ul > li > .sub-menu' => array(
					'margin-left' => '-' . astra_get_css_value( $mobile_header_menu_all_border['left'], 'px' ),
				),

			);
			$css_output .= astra_parse_css( $mobile_header_border );
		}
	} else {
		/**
		 * Border only for responsive devices
		 */
		if ( '' !== $mobile_header_menu_all_border['top'] || '' !== $mobile_header_menu_all_border['right'] || '' !== $mobile_header_menu_all_border['bottom'] || '' !== $mobile_header_menu_all_border['left'] ) {
			$mobile_header_border = array(
				'.ast-header-break-point .main-header-bar .main-header-bar-navigation .main-header-menu' => array(
					'border-top-width'   => astra_get_css_value( $mobile_header_menu_all_border['top'], 'px' ),
					'border-left-width'  => astra_get_css_value( $mobile_header_menu_all_border['left'], 'px' ),
					'border-right-width' => astra_get_css_value( $mobile_header_menu_all_border['right'], 'px' ),
					'border-color'       => esc_attr( $mobile_header_menu_b_color ),
				),
				'.ast-header-break-point .main-navigation ul li a' => array(
					'border-bottom-width' => astra_get_css_value( $mobile_header_menu_all_border['bottom'], 'px' ),
					'border-color'        => esc_attr( $mobile_header_menu_b_color ),
					'border-style'        => esc_attr( 'solid' ),
				),
				'.ast-header-break-point li.ast-masthead-custom-menu-items' => array(
					'border-bottom-width' => astra_get_css_value( $mobile_header_menu_all_border['bottom'], 'px' ),
					'border-color'        => esc_attr( $mobile_header_menu_b_color ),
					'border-style'        => esc_attr( 'solid' ),
					'margin-top'          => esc_attr( '0' ),
					'margin-bottom'       => esc_attr( '0' ),
				),
			);
			$css_output          .= astra_parse_css( $mobile_header_border );
		}
	}

	/**
	 * Responsive Colors options
	 * [3]. Primary Menu Responsive Colors only for Flyout menu style
	 */
	if ( 'flyout' == $menu_style ) {
		$desktop_colors = array(
			'.ast-flyout-menu-enable.ast-header-break-point .main-header-bar .main-header-bar-navigation #site-navigation,  .ast-flyout-menu-enable.ast-header-break-point .ast-primary-menu-disabled .ast-merge-header-navigation-wrap' => array(
				'width' => astra_get_css_value( $flayout_sidebar_width, 'px' ),
			),
		);

		/* Parse CSS from array() */
		$css_output .= astra_parse_css( $desktop_colors );
	}

	/**
	 * Responsive Colors options
	 * [4]. Below Header Menu Responsive Colors only for No Toggle menu style
	 */
	if ( 'no-toggle' == $menu_style ) {

		$link_colors = array(
			'.ast-no-toggle-menu-enable.ast-header-break-point .main-header-menu li:hover' => array(
				'color' => esc_attr( $link_color ),
			),
		);
		$css_output .= astra_parse_css( $link_colors );

		/**
		 * Responsive Colors options
		 * [4]. Below Header Menu Responsive Colors general
		 */
		$desktop_colors = array();

		$desktop_colors['.ast-header-break-point .main-header-menu'] =
				array(
					'background-color' => esc_attr( '#FFFFFF' ),
				);

		/* Parse CSS from array() */
		$css_output .= astra_parse_css( $desktop_colors );
	}

	/**
	 * Responsive Devices Border
	 * Border only for resopnsive devices When primay menu is desabled & Header section is merged
	 */
	if ( $disable_primary_menu && ( $merge_above_header || $merge_below_header ) ) {
		$mobile_header_border = array(
			'.ast-header-break-point .ast-primary-menu-disabled .ast-merge-header-navigation-wrap .ast-above-header-menu-items' => array(
				'border-top' => $mobile_header_menu_b_color,
			),
			'.ast-header-break-point .ast-above-header-menu-items li a,.ast-header-break-point .ast-above-header-navigation ul li a, .ast-header-break-point .ast-above-header-menu-items ul li a,.ast-header-break-point .ast-below-header-menu-items li a,.ast-header-break-point .ast-below-header-actual-nav ul li a, .ast-header-break-point .ast-below-header-menu-items ul li a, .ast-fullscreen-menu-enable.ast-header-break-point .ast-merge-header-navigation-wrap .ast-above-header-menu-items li a:before, .ast-fullscreen-menu-enable.ast-header-break-point .ast-merge-header-navigation-wrap .ast-above-header-menu-items li.menu-item-has-children a:before, .ast-fullscreen-menu-enable.ast-header-break-point .ast-merge-header-navigation-wrap .ast-below-header-menu-items li a:before, .ast-fullscreen-menu-enable.ast-header-break-point .ast-merge-header-navigation-wrap .ast-below-header-menu-items li.menu-item-has-children a:before' => array(
				'border-bottom' => $mobile_header_menu_b_color,
			),
		);
		$css_output          .= astra_parse_css( $mobile_header_border );
	}

	return $dynamic_css . $css_output;
}
