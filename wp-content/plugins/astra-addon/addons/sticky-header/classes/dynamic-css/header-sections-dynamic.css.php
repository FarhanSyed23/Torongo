<?php
/**
 * Transparent Header - Dynamic CSS
 *
 * @package Astra Addon
 */

add_filter( 'astra_dynamic_css', 'astra_ext_above_header_sections_dynamic_css', 30 );

/**
 * Dynamic CSS
 *
 * @param  string $dynamic_css          Astra Dynamic CSS.
 * @param  string $dynamic_css_filtered Astra Dynamic CSS Filters.
 * @return string
 */
function astra_ext_above_header_sections_dynamic_css( $dynamic_css, $dynamic_css_filtered = '' ) {

	/**
	 * Set colors
	 *
	 * If colors extension is_active then get color from it.
	 * Else set theme default colors.
	 */
	$stick_header            = astra_get_option_meta( 'stick-header-meta' );
	$stick_header_above_meta = astra_get_option_meta( 'header-above-stick-meta' );

	$stick_header_above = astra_get_option( 'header-above-stick' );

	$sticky_header_style   = astra_get_option( 'sticky-header-style' );
	$sticky_hide_on_scroll = astra_get_option( 'sticky-hide-on-scroll' );

	/**
	 * Above Header.
	 */
	$desktop_sticky_above_header_bg_color = astra_get_prop( astra_get_option( 'sticky-above-header-bg-color-responsive' ), 'desktop', '#ffffff' );

	$tablet_sticky_above_header_bg_color = astra_get_prop( astra_get_option( 'sticky-above-header-bg-color-responsive' ), 'tablet' );
	$mobile_sticky_above_header_bg_color = astra_get_prop( astra_get_option( 'sticky-above-header-bg-color-responsive' ), 'mobile' );

	$sticky_above_header_menu_bg_color_responsive     = astra_get_option( 'sticky-above-header-menu-bg-color-responsive' );
	$sticky_above_header_menu_color_responsive        = astra_get_option( 'sticky-above-header-menu-color-responsive' );
	$sticky_above_header_menu_h_color_responsive      = astra_get_option( 'sticky-above-header-menu-h-color-responsive' );
	$sticky_above_header_menu_h_a_bg_color_responsive = astra_get_option( 'sticky-above-header-menu-h-a-bg-color-responsive' );

	$sticky_above_header_submenu_bg_color_responsive     = astra_get_option( 'sticky-above-header-submenu-bg-color-responsive' );
	$sticky_above_header_submenu_color_responsive        = astra_get_option( 'sticky-above-header-submenu-color-responsive' );
	$sticky_above_header_submenu_h_color_responsive      = astra_get_option( 'sticky-above-header-submenu-h-color-responsive' );
	$sticky_above_header_submenu_h_a_bg_color_responsive = astra_get_option( 'sticky-above-header-submenu-h-a-bg-color-responsive' );

	$sticky_above_content_section_text_color   = astra_get_option( 'sticky-above-header-content-section-text-color-responsive' );
	$sticky_above_content_section_link_color   = astra_get_option( 'sticky-above-header-content-section-link-color-responsive' );
	$sticky_above_content_section_link_h_color = astra_get_option( 'sticky-above-header-content-section-link-h-color-responsive' );

	if ( ! $stick_header_above && ( 'disabled' !== $stick_header && empty( $stick_header ) && ( empty( $stick_header_above_meta ) ) ) ) {
		return $dynamic_css;
	}

	$parse_css = '';

	/**
	 * Sticky Header
	 *
	 * [1]. Sticky Header Above colors options.
	 */

		/**
		 * Above Header.
		 */
	if ( 'none' === $sticky_header_style && ! $sticky_hide_on_scroll ) {
		$desktop_above_header_css_output = array(
			'.ast-above-sticky-header-active .ast-above-header-wrap .ast-above-header' => array(
				'background-color' => esc_attr( $desktop_sticky_above_header_bg_color ),
			),
			'.ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation > ul' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['desktop'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header .ast-search-menu-icon .search-field, .ast-above-sticky-header-active .ast-above-header .ast-search-menu-icon .search-field:focus' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['desktop'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu,.ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation ul.ast-above-header-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['desktop'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation .ast-above-header-menu a, .ast-header-break-point .ast-above-header-navigation > ul.ast-above-header-menu > .menu-item-has-children:not(.current-menu-item) > .ast-menu-toggle'                => array(
				'color' => esc_attr( $sticky_above_header_menu_color_responsive['desktop'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation li:hover > a, .ast-above-sticky-header-active .ast-above-header-navigation .menu-item.focus > a'     => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation li.current-menu-item > a,.ast-above-sticky-header-active .ast-above-header-navigation li.current-menu-ancestor > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			/**
			 * Above Header Dropdown Navigation
			 */
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.focus > a,.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.focus > .ast-menu-toggle' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_submenu_h_color_responsive['desktop'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-navigation .ast-above-header-menu .sub-menu, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation .sub-menu, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation .submenu'            => array(
				'background-color' => esc_attr( $sticky_above_header_submenu_bg_color_responsive['desktop'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation ul.ast-above-header-menu .sub-menu a, .ast-above-sticky-header-active .ast-above-header-navigation ul.sub-menu' => array(
				'color' => esc_attr( $sticky_above_header_submenu_color_responsive['desktop'] ),
			),

			// Content Section text color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select, .ast-above-sticky-header-active .ast-above-header-section .widget, .ast-above-sticky-header-active .ast-above-header-section .widget-title' => array(
				'color' => esc_attr( $sticky_above_content_section_text_color['desktop'] ),
			),
			// Content Section link color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select a, .ast-above-sticky-header-active .ast-above-header-section .widget a' => array(
				'color' => esc_attr( $sticky_above_content_section_link_color['desktop'] ),
			),
			// Content Section link hover color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select a:hover, .ast-above-sticky-header-active .ast-above-header-section .widget a:hover' => array(
				'color' => esc_attr( $sticky_above_content_section_link_h_color['desktop'] ),
			),
		);
		$tablet_above_header_css_output = array(

			'.ast-above-sticky-header-active .ast-above-header-wrap .ast-above-header' => array(
				'background-color' => esc_attr( $tablet_sticky_above_header_bg_color ),
			),
			'.ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation > ul' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['tablet'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header .ast-search-menu-icon .search-field, .ast-above-sticky-header-active .ast-above-header .ast-search-menu-icon .search-field:focus' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['tablet'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu,.ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation ul.ast-above-header-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['tablet'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation .ast-above-header-menu a, .ast-header-break-point .ast-above-header-navigation > ul.ast-above-header-menu > .menu-item-has-children:not(.current-menu-item) > .ast-menu-toggle'                => array(
				'color' => esc_attr( $sticky_above_header_menu_color_responsive['tablet'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation li:hover > a, .ast-above-sticky-header-active .ast-above-header-navigation .menu-item.focus > a'     => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation li.current-menu-item > a,.ast-above-sticky-header-active .ast-above-header-navigation li.current-menu-ancestor > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			/**
			 * Above Header Dropdown Navigation
			 */
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.focus > a,.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.focus > .ast-menu-toggle' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_submenu_h_color_responsive['tablet'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-navigation .ast-above-header-menu .sub-menu, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation .sub-menu, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation .submenu'            => array(
				'background-color' => esc_attr( $sticky_above_header_submenu_bg_color_responsive['tablet'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation ul.ast-above-header-menu .sub-menu a, .ast-above-sticky-header-active .ast-above-header-navigation ul.sub-menu' => array(
				'color' => esc_attr( $sticky_above_header_submenu_color_responsive['tablet'] ),
			),

			// Content Section text color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select, .ast-above-sticky-header-active .ast-above-header-section .widget, .ast-above-sticky-header-active .ast-above-header-section .widget-title' => array(
				'color' => esc_attr( $sticky_above_content_section_text_color['tablet'] ),
			),
			// Content Section link color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select a, .ast-above-sticky-header-active .ast-above-header-section .widget a' => array(
				'color' => esc_attr( $sticky_above_content_section_link_color['tablet'] ),
			),
			// Content Section link hover color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select a:hover, .ast-above-sticky-header-active .ast-above-header-section .widget a:hover' => array(
				'color' => esc_attr( $sticky_above_content_section_link_h_color['tablet'] ),
			),
		);
		$mobile_above_header_css_output = array(

			'.ast-above-sticky-header-active .ast-above-header-wrap .ast-above-header' => array(
				'background-color' => esc_attr( $mobile_sticky_above_header_bg_color ),
			),
			'.ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation > ul' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['mobile'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header .ast-search-menu-icon .search-field, .ast-above-sticky-header-active .ast-above-header .ast-search-menu-icon .search-field:focus' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['mobile'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu,.ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation ul.ast-above-header-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['mobile'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation .ast-above-header-menu a, .ast-header-break-point .ast-above-header-navigation > ul.ast-above-header-menu > .menu-item-has-children:not(.current-menu-item) > .ast-menu-toggle'                => array(
				'color' => esc_attr( $sticky_above_header_menu_color_responsive['mobile'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation li:hover > a, .ast-above-sticky-header-active .ast-above-header-navigation .menu-item.focus > a'     => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['mobile'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation li.current-menu-item > a,.ast-above-sticky-header-active .ast-above-header-navigation li.current-menu-ancestor > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['mobile'] ),
			),

			/**
			 * Above Header Dropdown Navigation
			 */
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.focus > a,.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.focus > .ast-menu-toggle' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > .ast-menu-toggle, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_submenu_h_color_responsive['mobile'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > a, .ast-above-sticky-header-active .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),
			'.ast-above-sticky-header-active .ast-above-header-navigation .ast-above-header-menu .sub-menu, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation .sub-menu, .ast-header-break-point.ast-above-sticky-header-active .ast-above-header-section-separated .ast-above-header-navigation .submenu'            => array(
				'background-color' => esc_attr( $sticky_above_header_submenu_bg_color_responsive['mobile'] ),
			),

			'.ast-above-sticky-header-active .ast-above-header-navigation ul.ast-above-header-menu .sub-menu a, .ast-above-sticky-header-active .ast-above-header-navigation ul.sub-menu' => array(
				'color' => esc_attr( $sticky_above_header_submenu_color_responsive['mobile'] ),
			),
			// Content Section text color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select, .ast-above-sticky-header-active .ast-above-header-section .widget, .ast-above-sticky-header-active .ast-above-header-section .widget-title' => array(
				'color' => esc_attr( $sticky_above_content_section_text_color['mobile'] ),
			),
			// Content Section link color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select a, .ast-above-sticky-header-active .ast-above-header-section .widget a' => array(
				'color' => esc_attr( $sticky_above_content_section_link_color['mobile'] ),
			),
			// Content Section link hover color.
			'.ast-above-sticky-header-active .ast-above-header-section .user-select a:hover, .ast-above-sticky-header-active .ast-above-header-section .widget a:hover' => array(
				'color' => esc_attr( $sticky_above_content_section_link_h_color['mobile'] ),
			),
		);
	} else {
		// Only when Fixed Header Merkup added.
		$desktop_above_header_css_output = array(

			'#ast-fixed-header .ast-above-header' => array(
				'background-color' => esc_attr( $desktop_sticky_above_header_bg_color ),
			),
			'.ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation, .ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation ul' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['desktop'] ),
			),
			'#ast-fixed-header .ast-above-header .ast-search-menu-icon .search-field, #ast-fixed-header .ast-above-header .ast-search-menu-icon .search-field:focus' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['desktop'] ),
			),
			'#ast-fixed-header .ast-above-header-menu,.ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation ul.ast-above-header-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation .ast-above-header-menu a, #ast-fixed-header .ast-above-header-navigation > ul.ast-above-header-menu > .menu-item-has-children:not(.current-menu-item) > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_menu_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation li:hover > a, #ast-fixed-header .ast-above-header-navigation .menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation li.current-menu-item > a,#ast-fixed-header .ast-above-header-navigation li.current-menu-ancestor > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			/**
			 * Above Header Dropdown Navigation
			 */
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.focus > a,#ast-fixed-header .ast-above-header-menu ul.sub-menu li:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.focus > .ast-menu-toggle' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_submenu_h_color_responsive['desktop'] ),
			),
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),
			'#ast-fixed-header .ast-above-header-navigation .ast-above-header-menu .sub-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_submenu_bg_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation ul.ast-above-header-menu .sub-menu a, #ast-fixed-header .ast-above-header-navigation .sub-menu' => array(
				'color' => esc_attr( $sticky_above_header_submenu_color_responsive['desktop'] ),
			),
			// Content Section text color.
			'#ast-fixed-header .ast-above-header-section .user-select, #ast-fixed-header .ast-above-header-section .widget, #ast-fixed-header .ast-above-header-section .widget-title' => array(
				'color' => esc_attr( $sticky_above_content_section_text_color['desktop'] ),
			),
			// Content Section link color.
			'#ast-fixed-header .ast-above-header-section .user-select a, #ast-fixed-header .ast-above-header-section .widget a' => array(
				'color' => esc_attr( $sticky_above_content_section_link_color['desktop'] ),
			),
			// Content Section link hover color.
			'#ast-fixed-header .ast-above-header-section .user-select a:hover, #ast-fixed-header .ast-above-header-section .widget a:hover' => array(
				'color' => esc_attr( $sticky_above_content_section_link_h_color['desktop'] ),
			),
		);
		$tablet_above_header_css_output = array(

			'#ast-fixed-header .ast-above-header' => array(
				'background-color' => esc_attr( $tablet_sticky_above_header_bg_color ),
			),
			'.ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation, .ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation ul' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['tablet'] ),
			),
			'#ast-fixed-header .ast-above-header .ast-search-menu-icon .search-field, #ast-fixed-header .ast-above-header .ast-search-menu-icon .search-field:focus' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['tablet'] ),
			),
			'#ast-fixed-header .ast-above-header-menu,.ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation ul.ast-above-header-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation .ast-above-header-menu a, #ast-fixed-header .ast-above-header-navigation > ul.ast-above-header-menu > .menu-item-has-children:not(.current-menu-item) > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_menu_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation li:hover > a, #ast-fixed-header .ast-above-header-navigation .menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation li.current-menu-item > a,#ast-fixed-header .ast-above-header-navigation li.current-menu-ancestor > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			/**
			 * Above Header Dropdown Navigation
			 */
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.focus > a,#ast-fixed-header .ast-above-header-menu ul.sub-menu li:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.focus > .ast-menu-toggle' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_submenu_h_color_responsive['tablet'] ),
			),
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),
			'#ast-fixed-header .ast-above-header-navigation .ast-above-header-menu .sub-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_submenu_bg_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation ul.ast-above-header-menu .sub-menu a, #ast-fixed-header .ast-above-header-navigation .sub-menu' => array(
				'color' => esc_attr( $sticky_above_header_submenu_color_responsive['tablet'] ),
			),
			// Content Section text color.
			'#ast-fixed-header .ast-above-header-section .user-select, #ast-fixed-header .ast-above-header-section .widget, #ast-fixed-header .ast-above-header-section .widget-title' => array(
				'color' => esc_attr( $sticky_above_content_section_text_color['tablet'] ),
			),
			// Content Section link color.
			'#ast-fixed-header .ast-above-header-section .user-select a, #ast-fixed-header .ast-above-header-section .widget a' => array(
				'color' => esc_attr( $sticky_above_content_section_link_color['tablet'] ),
			),
			// Content Section link hover color.
			'#ast-fixed-header .ast-above-header-section .user-select a:hover, #ast-fixed-header .ast-above-header-section .widget a:hover' => array(
				'color' => esc_attr( $sticky_above_content_section_link_h_color['tablet'] ),
			),
		);
		$mobile_above_header_css_output = array(

			'#ast-fixed-header .ast-above-header' => array(
				'background-color' => esc_attr( $mobile_sticky_above_header_bg_color ),
			),
			'.ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation, .ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation ul' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['mobile'] ),
			),
			'#ast-fixed-header .ast-above-header .ast-search-menu-icon .search-field, #ast-fixed-header .ast-above-header .ast-search-menu-icon .search-field:focus' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['mobile'] ),
			),
			'#ast-fixed-header .ast-above-header-menu,.ast-header-break-point #ast-fixed-header .ast-above-header-section-separated .ast-above-header-navigation ul.ast-above-header-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_menu_bg_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation .ast-above-header-menu a, #ast-fixed-header .ast-above-header-navigation > ul.ast-above-header-menu > .menu-item-has-children:not(.current-menu-item) > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_menu_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation li:hover > a, #ast-fixed-header .ast-above-header-navigation .menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['mobile'] ),
			),
			'#ast-fixed-header .ast-above-header-navigation li.current-menu-item > a,#ast-fixed-header .ast-above-header-navigation li.current-menu-ancestor > a' => array(
				'color'            => esc_attr( $sticky_above_header_menu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_menu_h_a_bg_color_responsive['mobile'] ),
			),

			/**
			 * Above Header Dropdown Navigation
			 */
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.focus > a,#ast-fixed-header .ast-above-header-menu .sub-menu li:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.focus > .ast-menu-toggle' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu .sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > .ast-menu-toggle, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_above_header_submenu_h_color_responsive['mobile'] ),
			),
			'#ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-above-header-menu ul.sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_above_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_above_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),
			'#ast-fixed-header .ast-above-header-navigation .ast-above-header-menu .sub-menu' => array(
				'background-color' => esc_attr( $sticky_above_header_submenu_bg_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-above-header-navigation ul.ast-above-header-menu .sub-menu a, #ast-fixed-header .ast-above-header-navigation .sub-menu' => array(
				'color' => esc_attr( $sticky_above_header_submenu_color_responsive['mobile'] ),
			),
			// Content Section text color.
			'#ast-fixed-header .ast-above-header-section .user-select, #ast-fixed-header .ast-above-header-section .widget, #ast-fixed-header .ast-above-header-section .widget-title' => array(
				'color' => esc_attr( $sticky_above_content_section_text_color['mobile'] ),
			),
			// Content Section link color.
			'#ast-fixed-header .ast-above-header-section .user-select a, #ast-fixed-header .ast-above-header-section .widget a' => array(
				'color' => esc_attr( $sticky_above_content_section_link_color['mobile'] ),
			),
			// Content Section link hover color.
			'#ast-fixed-header .ast-above-header-section .user-select a:hover, #ast-fixed-header .ast-above-header-section .widget a:hover' => array(
				'color' => esc_attr( $sticky_above_content_section_link_h_color['mobile'] ),
			),
		);
	}

		/* Parse CSS from array() */
		$parse_css .= astra_parse_css( $desktop_above_header_css_output );
		$parse_css .= astra_parse_css( $tablet_above_header_css_output, '', astra_addon_get_tablet_breakpoint() );
		$parse_css .= astra_parse_css( $mobile_above_header_css_output, '', astra_addon_get_mobile_breakpoint() );

	return $dynamic_css .= $parse_css;

}


add_filter( 'astra_dynamic_css', 'astra_ext_below_header_sections_dynamic_css', 30 );

/**
 * Dynamic CSS
 *
 * @param  string $dynamic_css          Astra Dynamic CSS.
 * @param  string $dynamic_css_filtered Astra Dynamic CSS Filters.
 * @return string
 */
function astra_ext_below_header_sections_dynamic_css( $dynamic_css, $dynamic_css_filtered = '' ) {

	/**
	 * Set colors
	 *
	 * If colors extension is_active then get color from it.
	 * Else set theme default colors.
	 */
	$stick_header            = astra_get_option_meta( 'stick-header-meta' );
	$stick_header_below_meta = astra_get_option_meta( 'header-below-stick-meta' );

	$stick_header_below = astra_get_option( 'header-below-stick' );

	$sticky_header_style   = astra_get_option( 'sticky-header-style' );
	$sticky_hide_on_scroll = astra_get_option( 'sticky-hide-on-scroll' );
	/**
	 * Below Header.
	 */
	$desktop_sticky_below_header_bg_color = astra_get_prop( astra_get_option( 'sticky-below-header-bg-color-responsive' ), 'desktop', '#414042' );
	$tablet_sticky_below_header_bg_color  = astra_get_prop( astra_get_option( 'sticky-below-header-bg-color-responsive' ), 'tablet' );
	$mobile_sticky_below_header_bg_color  = astra_get_prop( astra_get_option( 'sticky-below-header-bg-color-responsive' ), 'mobile' );

	$sticky_below_header_menu_bg_color_responsive     = astra_get_option( 'sticky-below-header-menu-bg-color-responsive' );
	$sticky_below_header_menu_color_responsive        = astra_get_option( 'sticky-below-header-menu-color-responsive' );
	$sticky_below_header_menu_h_color_responsive      = astra_get_option( 'sticky-below-header-menu-h-color-responsive' );
	$sticky_below_header_menu_h_a_bg_color_responsive = astra_get_option( 'sticky-below-header-menu-h-a-bg-color-responsive' );

	$sticky_below_header_submenu_bg_color_responsive     = astra_get_option( 'sticky-below-header-submenu-bg-color-responsive' );
	$sticky_below_header_submenu_color_responsive        = astra_get_option( 'sticky-below-header-submenu-color-responsive' );
	$sticky_below_header_submenu_h_color_responsive      = astra_get_option( 'sticky-below-header-submenu-h-color-responsive' );
	$sticky_below_header_submenu_h_a_bg_color_responsive = astra_get_option( 'sticky-below-header-submenu-h-a-bg-color-responsive' );

	$sticky_below_content_section_text_color   = astra_get_option( 'sticky-below-header-content-section-text-color-responsive' );
	$sticky_below_content_section_link_color   = astra_get_option( 'sticky-below-header-content-section-link-color-responsive' );
	$sticky_below_content_section_link_h_color = astra_get_option( 'sticky-below-header-content-section-link-h-color-responsive' );

	if ( ! $stick_header_below && ( 'disabled' !== $stick_header && empty( $stick_header ) && ( empty( $stick_header_below_meta ) ) ) ) {
		return $dynamic_css;
	}

	$parse_css = '';

	/**
	 * Sticky Header
	 *
	 * [1]. Sticky Header Below colors options.
	 */

		/**
		 * Below Header.
		 */
	if ( 'none' === $sticky_header_style && ! $sticky_hide_on_scroll ) {
		$desktop_below_header_css_output = array(
			'.ast-below-sticky-header-active .ast-below-header-wrap .ast-below-header' => array(
				'background-color' => esc_attr( $desktop_sticky_below_header_bg_color ),
			),

			'.ast-below-sticky-header-active .ast-below-header-actual-nav, .ast-flyout-below-menu-enable.ast-header-break-point.ast-below-sticky-header-active .ast-below-header-actual-nav.ast-below-header-actual-nav, .ast-header-break-point .ast-below-header-section-separated .ast-below-header-actual-nav' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_bg_color_responsive['desktop'] ),
			),

			'.ast-fullscreen-below-menu-enable.ast-header-break-point .ast-below-header-navigation-wrap' => array(
				'background' => esc_attr( $sticky_below_header_menu_bg_color_responsive['desktop'] ),
			),

			/**
			 * Below Header Navigation
			 */
			'.ast-below-sticky-header-active .ast-below-header-menu, .ast-below-sticky-header-active .ast-below-header-menu a' => array(
				'color' => esc_attr( $sticky_below_header_menu_color_responsive['desktop'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li:hover > a, .ast-below-sticky-header-active .ast-below-header-menu li:focus > a, .ast-below-sticky-header-active .ast-below-header-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_menu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_below_header_menu_h_color_responsive['desktop'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			/**
			 * Below Header Dropdown Navigation
			 */

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),

			'.ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:hover, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:focus, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.focus' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),

			'.ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:hover > a, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:focus > a, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.focus > a' => array(
				'background-color' => 'transparent',
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu'               => array(
				'background-color' => esc_attr( $sticky_below_header_submenu_bg_color_responsive['desktop'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu a' => array(
				'color' => esc_attr( $sticky_below_header_submenu_color_responsive['desktop'] ),
			),

			// Content Section text color.
			'.ast-below-sticky-header-active .below-header-user-select, .ast-below-sticky-header-active .below-header-user-select .widget,.ast-below-sticky-header-active .below-header-user-select .widget-title' => array(
				'color' => esc_attr( $sticky_below_content_section_text_color['desktop'] ),
			),
			// Content Section link color.
			'.ast-below-sticky-header-active .below-header-user-select a, .ast-below-sticky-header-active .below-header-user-select .widget a' => array(
				'color' => esc_attr( $sticky_below_content_section_link_color['desktop'] ),
			),
			// Content Section link hover color.
			'.ast-below-sticky-header-active .below-header-user-select a:hover, .ast-below-sticky-header-active .below-header-user-select .widget a:hover' => array(
				'color' => esc_attr( $sticky_below_content_section_link_h_color['desktop'] ),
			),
		);
		$tablet_below_header_css_output = array(

			'.ast-below-sticky-header-active .ast-below-header-wrap .ast-below-header' => array(
				'background-color' => esc_attr( $tablet_sticky_below_header_bg_color ),
			),

			'.ast-below-sticky-header-active .ast-below-header-actual-nav, .ast-flyout-below-menu-enable.ast-header-break-point.ast-below-sticky-header-active .ast-below-header-actual-nav.ast-below-header-actual-nav, .ast-header-break-point .ast-below-header-section-separated .ast-below-header-actual-nav' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_bg_color_responsive['tablet'] ),
			),

			'.ast-fullscreen-below-menu-enable.ast-header-break-point .ast-below-header-navigation-wrap' => array(
				'background' => esc_attr( $sticky_below_header_menu_bg_color_responsive['tablet'] ),
			),

			/**
			 * Below Header Navigation
			 */
			'.ast-below-sticky-header-active .ast-below-header-menu, .ast-below-sticky-header-active .ast-below-header-menu a' => array(
				'color' => esc_attr( $sticky_below_header_menu_color_responsive['tablet'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li:hover > a, .ast-below-sticky-header-active .ast-below-header-menu li:focus > a, .ast-below-sticky-header-active .ast-below-header-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_menu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_below_header_menu_h_color_responsive['tablet'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			/**
			 * Below Header Dropdown Navigation
			 */

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),

			'.ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:hover, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:focus, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.focus' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu'               => array(
				'background-color' => esc_attr( $sticky_below_header_submenu_bg_color_responsive['tablet'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu a' => array(
				'color' => esc_attr( $sticky_below_header_submenu_color_responsive['tablet'] ),
			),

			// Content Section text color.
			'.ast-below-sticky-header-active .below-header-user-select, .ast-below-sticky-header-active .below-header-user-select .widget,.ast-below-sticky-header-active .below-header-user-select .widget-title' => array(
				'color' => esc_attr( $sticky_below_content_section_text_color['tablet'] ),
			),
			// Content Section link color.
			'.ast-below-sticky-header-active .below-header-user-select a, .ast-below-sticky-header-active .below-header-user-select .widget a' => array(
				'color' => esc_attr( $sticky_below_content_section_link_color['tablet'] ),
			),
			// Content Section link hover color.
			'.ast-below-sticky-header-active .below-header-user-select a:hover, .ast-below-sticky-header-active .below-header-user-select .widget a:hover' => array(
				'color' => esc_attr( $sticky_below_content_section_link_h_color['tablet'] ),
			),
		);
		$mobile_below_header_css_output = array(

			'.ast-below-sticky-header-active .ast-below-header-wrap .ast-below-header' => array(
				'background-color' => esc_attr( $mobile_sticky_below_header_bg_color ),
			),

			'.ast-below-sticky-header-active .ast-below-header-actual-nav, .ast-flyout-below-menu-enable.ast-header-break-point.ast-below-sticky-header-active .ast-below-header-actual-nav.ast-below-header-actual-nav, .ast-header-break-point .ast-below-header-section-separated .ast-below-header-actual-nav' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_bg_color_responsive['mobile'] ),
			),

			'.ast-fullscreen-below-menu-enable.ast-header-break-point .ast-below-header-navigation-wrap' => array(
				'background' => esc_attr( $sticky_below_header_menu_bg_color_responsive['mobile'] ),
			),

			/**
			 * Below Header Navigation
			 */
			'.ast-below-sticky-header-active .ast-below-header-menu, .ast-below-sticky-header-active .ast-below-header-menu a' => array(
				'color' => esc_attr( $sticky_below_header_menu_color_responsive['mobile'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li:hover > a, .ast-below-sticky-header-active .ast-below-header-menu li:focus > a, .ast-below-sticky-header-active .ast-below-header-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_menu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['mobile'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > .ast-menu-toggle, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_below_header_menu_h_color_responsive['mobile'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['mobile'] ),
			),

			/**
			 * Below Header Dropdown Navigation
			 */

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),

			'.ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:hover, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li:focus, .ast-fullscreen-below-menu-enable.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.focus' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu'               => array(
				'background-color' => esc_attr( $sticky_below_header_submenu_bg_color_responsive['mobile'] ),
			),

			'.ast-below-sticky-header-active .ast-below-header-menu .sub-menu, .ast-below-sticky-header-active .ast-below-header-menu .sub-menu a' => array(
				'color' => esc_attr( $sticky_below_header_submenu_color_responsive['mobile'] ),
			),

			// Content Section text color.
			'.ast-below-sticky-header-active .below-header-user-select, .ast-below-sticky-header-active .below-header-user-select .widget,.ast-below-sticky-header-active .below-header-user-select .widget-title' => array(
				'color' => esc_attr( $sticky_below_content_section_text_color['mobile'] ),
			),
			// Content Section link color.
			'.ast-below-sticky-header-active .below-header-user-select a, .ast-below-sticky-header-active .below-header-user-select .widget a' => array(
				'color' => esc_attr( $sticky_below_content_section_link_color['mobile'] ),
			),
			// Content Section link hover color.
			'.ast-below-sticky-header-active .below-header-user-select a:hover, .ast-below-sticky-header-active .below-header-user-select .widget a:hover' => array(
				'color' => esc_attr( $sticky_below_content_section_link_h_color['mobile'] ),
			),
		);
	} else {
		// Only when Fixed Header Merkup added.
		$desktop_below_header_css_output = array(

			'#ast-fixed-header .ast-below-header' => array(
				'background-color' => esc_attr( $desktop_sticky_below_header_bg_color ),
			),

			'#ast-fixed-header .ast-below-header-actual-nav' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_bg_color_responsive['desktop'] ),
			),

			/**
			 * Below Header Navigation
			 */
			'#ast-fixed-header .ast-below-header-menu, #ast-fixed-header .ast-below-header-menu a' => array(
				'color' => esc_attr( $sticky_below_header_menu_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li:hover > a, #ast-fixed-header .ast-below-header-menu li:focus > a, #ast-fixed-header .ast-below-header-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_menu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu li.current-menu-item > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_below_header_menu_h_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['desktop'] ),
			),

			/**
			 * Below Header Dropdown Navigation
			 */

			'#ast-fixed-header .ast-below-header-menu .sub-menu li:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['desktop'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu' => array(
				'background-color' => esc_attr( $sticky_below_header_submenu_bg_color_responsive['desktop'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu, #ast-fixed-header .ast-below-header-menu .sub-menu a' => array(
				'color' => esc_attr( $sticky_below_header_submenu_color_responsive['desktop'] ),
			),

			// Content Section text color.
			'#ast-fixed-header .below-header-user-select, #ast-fixed-header .below-header-user-select .widget,#ast-fixed-header .below-header-user-select .widget-title' => array(
				'color' => esc_attr( $sticky_below_content_section_text_color['desktop'] ),
			),
			// Content Section link color.
			'#ast-fixed-header .below-header-user-select a, #ast-fixed-header .below-header-user-select .widget a' => array(
				'color' => esc_attr( $sticky_below_content_section_link_color['desktop'] ),
			),
			// Content Section link hover color.
			'#ast-fixed-header .below-header-user-select a:hover, #ast-fixed-header .below-header-user-select .widget a:hover' => array(
				'color' => esc_attr( $sticky_below_content_section_link_h_color['desktop'] ),
			),
		);
		$tablet_below_header_css_output = array(

			'#ast-fixed-header .ast-below-header' => array(
				'background-color' => esc_attr( $tablet_sticky_below_header_bg_color ),
			),

			'#ast-fixed-header .ast-below-header-actual-nav' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_bg_color_responsive['tablet'] ),
			),

			/**
			 * Below Header Navigation
			 */
			'#ast-fixed-header .ast-below-header-menu, #ast-fixed-header .ast-below-header-menu a' => array(
				'color' => esc_attr( $sticky_below_header_menu_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li:hover > a, #ast-fixed-header .ast-below-header-menu li:focus > a, #ast-fixed-header .ast-below-header-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_menu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu li.current-menu-item > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_below_header_menu_h_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['tablet'] ),
			),

			/**
			 * Below Header Dropdown Navigation
			 */

			'#ast-fixed-header .ast-below-header-menu .sub-menu li:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['tablet'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu' => array(
				'background-color' => esc_attr( $sticky_below_header_submenu_bg_color_responsive['tablet'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu, #ast-fixed-header .ast-below-header-menu .sub-menu a' => array(
				'color' => esc_attr( $sticky_below_header_submenu_color_responsive['tablet'] ),
			),

			// Content Section text color.
			'#ast-fixed-header .below-header-user-select, #ast-fixed-header .below-header-user-select .widget,#ast-fixed-header .below-header-user-select .widget-title' => array(
				'color' => esc_attr( $sticky_below_content_section_text_color['tablet'] ),
			),
			// Content Section link color.
			'#ast-fixed-header .below-header-user-select a, #ast-fixed-header .below-header-user-select .widget a' => array(
				'color' => esc_attr( $sticky_below_content_section_link_color['tablet'] ),
			),
			// Content Section link hover color.
			'#ast-fixed-header .below-header-user-select a:hover, #ast-fixed-header .below-header-user-select .widget a:hover' => array(
				'color' => esc_attr( $sticky_below_content_section_link_h_color['tablet'] ),
			),
		);
		$mobile_below_header_css_output = array(

			'#ast-fixed-header .ast-below-header' => array(
				'background-color' => esc_attr( $mobile_sticky_below_header_bg_color ),
			),

			'#ast-fixed-header .ast-below-header-actual-nav' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_bg_color_responsive['mobile'] ),
			),

			/**
			 * Below Header Navigation
			 */
			'#ast-fixed-header .ast-below-header-menu, #ast-fixed-header .ast-below-header-menu a' => array(
				'color' => esc_attr( $sticky_below_header_menu_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li:hover > a, #ast-fixed-header .ast-below-header-menu li:focus > a, #ast-fixed-header .ast-below-header-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_menu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu li.current-menu-item > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > .ast-menu-toggle, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > .ast-menu-toggle' => array(
				'color' => esc_attr( $sticky_below_header_menu_h_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-below-header-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'background-color' => esc_attr( $sticky_below_header_menu_h_a_bg_color_responsive['mobile'] ),
			),

			/**
			 * Below Header Dropdown Navigation
			 */

			'#ast-fixed-header .ast-below-header-menu .sub-menu li:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-ancestor.focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:hover > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item:focus > a, #ast-fixed-header .ast-below-header-menu .sub-menu li.current-menu-item.focus > a' => array(
				'color'            => esc_attr( $sticky_below_header_submenu_h_color_responsive['mobile'] ),
				'background-color' => esc_attr( $sticky_below_header_submenu_h_a_bg_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu' => array(
				'background-color' => esc_attr( $sticky_below_header_submenu_bg_color_responsive['mobile'] ),
			),

			'#ast-fixed-header .ast-below-header-menu .sub-menu, #ast-fixed-header .ast-below-header-menu .sub-menu a' => array(
				'color' => esc_attr( $sticky_below_header_submenu_color_responsive['mobile'] ),
			),

			// Content Section text color.
			'#ast-fixed-header .below-header-user-select, #ast-fixed-header .below-header-user-select .widget,#ast-fixed-header .below-header-user-select .widget-title' => array(
				'color' => esc_attr( $sticky_below_content_section_text_color['mobile'] ),
			),
			// Content Section link color.
			'#ast-fixed-header .below-header-user-select a, #ast-fixed-header .below-header-user-select .widget a' => array(
				'color' => esc_attr( $sticky_below_content_section_link_color['mobile'] ),
			),
			// Content Section link hover color.
			'#ast-fixed-header .below-header-user-select a:hover, #ast-fixed-header .below-header-user-select .widget a:hover' => array(
				'color' => esc_attr( $sticky_below_content_section_link_h_color['mobile'] ),
			),
		);
	}
		/* Parse CSS from array() */
		$parse_css .= astra_parse_css( $desktop_below_header_css_output );
		$parse_css .= astra_parse_css( $tablet_below_header_css_output, '', astra_addon_get_tablet_breakpoint() );
		$parse_css .= astra_parse_css( $mobile_below_header_css_output, '', astra_addon_get_mobile_breakpoint() );

	return $dynamic_css .= $parse_css;

}
