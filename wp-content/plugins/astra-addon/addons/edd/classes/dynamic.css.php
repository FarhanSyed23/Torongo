<?php
/**
 * EDD - Dynamic CSS
 *
 * @package Astra Addon
 */

add_filter( 'astra_dynamic_css', 'astra_edd_dynamic_css' );

/**
 * Dynamic CSS
 *
 * @param  string $dynamic_css          Astra Dynamic CSS.
 * @param  string $dynamic_css_filtered Astra Dynamic CSS Filters.
 * @return string
 */
function astra_edd_dynamic_css( $dynamic_css, $dynamic_css_filtered = '' ) {

	$link_h_color = astra_get_option( 'link-h-color' );
	$theme_color  = astra_get_option( 'theme-color' );
	$link_color   = astra_get_option( 'link-color', $theme_color );

	$body_font_family = astra_body_font_family();

	$product_title_font_size      = astra_get_option( 'font-size-edd-product-title' );
	$product_title_line_height    = astra_get_option( 'line-height-edd-product-title' );
	$product_title_font_family    = astra_get_option( 'font-family-edd-product-title' );
	$product_title_font_weight    = astra_get_option( 'font-weight-edd-product-title' );
	$product_title_text_transform = astra_get_option( 'text-transform-edd-product-title' );

	// Single Product Content Typo.
	$product_content_font_size      = astra_get_option( 'font-size-edd-product-content' );
	$product_content_line_height    = astra_get_option( 'line-height-edd-product-content' );
	$product_content_font_family    = astra_get_option( 'font-family-edd-product-content' );
	$product_content_font_weight    = astra_get_option( 'font-weight-edd-product-content' );
	$product_content_text_transform = astra_get_option( 'text-transform-edd-product-content' );

	// Single Product Colors.
	$product_title_color      = astra_get_option( 'edd-single-product-title-color' );
	$product_content_color    = astra_get_option( 'edd-single-product-content-color' );
	$product_navigation_color = astra_get_option( 'edd-single-product-navigation-color' );

	// EDD archive Typo.
	$edd_archive_product_title_font_size      = astra_get_option( 'font-size-edd-archive-product-title' );
	$edd_archive_product_title_line_height    = astra_get_option( 'line-height-edd-archive-product-title' );
	$edd_archive_product_title_font_family    = astra_get_option( 'font-family-edd-archive-product-title' );
	$edd_archive_product_title_font_weight    = astra_get_option( 'font-weight-edd-archive-product-title' );
	$edd_archive_product_title_text_transform = astra_get_option( 'text-transform-edd-archive-product-title' );

	$edd_archive_product_price_font_family = astra_get_option( 'font-family-edd-archive-product-price' );
	$edd_archive_product_price_font_weight = astra_get_option( 'font-weight-edd-archive-product-price' );
	$edd_archive_product_price_font_size   = astra_get_option( 'font-size-edd-archive-product-price' );
	$edd_archive_product_price_line_height = astra_get_option( 'line-height-edd-archive-product-price' );

	$edd_archive_product_content_font_family    = astra_get_option( 'font-family-edd-archive-product-content' );
	$edd_archive_product_content_font_weight    = astra_get_option( 'font-weight-edd-archive-product-content' );
	$edd_archive_product_content_line_height    = astra_get_option( 'line-height-edd-archive-product-content' );
	$edd_archive_product_content_text_transform = astra_get_option( 'text-transform-edd-archive-product-content' );
	$edd_archive_product_content_font_size      = astra_get_option( 'font-size-edd-archive-product-content' );

	// EDD Archvive Colors.
	$edd_archive_product_title_color   = astra_get_option( 'edd-archive-product-title-color' );
	$edd_archive_product_price_color   = astra_get_option( 'edd-archive-product-price-color' );
	$edd_archive_product_content_color = astra_get_option( 'edd-archive-product-content-color' );

	$btn_v_padding = astra_get_option( 'edd-archive-button-v-padding' );
	$btn_h_padding = astra_get_option( 'edd-archive-button-h-padding' );

	$checkout_width        = astra_get_option( 'edd-checkout-content-width' );
	$checkout_custom_width = astra_get_option( 'edd-checkout-content-max-width' );

	$header_cart_icon_style  = astra_get_option( 'edd-header-cart-icon-style' );
	$header_cart_icon_color  = astra_get_option( 'edd-header-cart-icon-color', $theme_color );
	$header_cart_icon_radius = astra_get_option( 'edd-header-cart-icon-radius' );
	$cart_h_color            = astra_get_foreground_color( $header_cart_icon_color );

	// Default headings font family.
	$headings_font_family = astra_get_option( 'headings-font-family' );

	/**
	 * Set font sizes
	 */
	$css_output = array(

		'.ast-edd-archive-block-wrap .edd-add-to-cart, .ast-edd-archive-block-wrap .edd_go_to_checkout, .ast-edd-archive-block-wrap .ast-edd-variable-btn, .edd_downloads_list .edd-add-to-cart, .edd_downloads_list .edd_go_to_checkout, .edd_downloads_list .ast-edd-variable-btn' => array(
			'padding-top'    => astra_get_css_value( $btn_v_padding, 'px' ),
			'padding-bottom' => astra_get_css_value( $btn_v_padding, 'px' ),
			'padding-left'   => astra_get_css_value( $btn_h_padding, 'px' ),
			'padding-right'  => astra_get_css_value( $btn_h_padding, 'px' ),
		),

		'.ast-edd-site-header-cart span.astra-icon:after' => array(
			'background' => $theme_color,
			'color'      => astra_get_foreground_color( $theme_color ),
		),

		'.single-download .entry-title'                   => array(
			'font-size'      => astra_responsive_font( $product_title_font_size, 'desktop' ),
			'line-height'    => esc_attr( $product_title_line_height ),
			'font-weight'    => astra_get_css_value( $product_title_font_weight, 'font' ),
			'font-family'    => astra_get_css_value( $product_title_font_family, 'font', $headings_font_family ),
			'text-transform' => esc_attr( $product_title_text_transform ),
			'color'          => esc_attr( $product_title_color ),
		),
		// Single Product Content.
		'.single-download .entry-content'                 => array(
			'font-size'      => astra_responsive_font( $product_content_font_size, 'desktop' ),
			'line-height'    => esc_attr( $product_content_line_height ),
			'font-weight'    => astra_get_css_value( $product_content_font_weight, 'font' ),
			'font-family'    => astra_get_css_value( $product_content_font_family, 'font', $body_font_family ),
			'text-transform' => esc_attr( $product_content_text_transform ),
			'color'          => esc_attr( $product_content_color ),
		),

		'.ast-edd-archive-block-wrap .edd_download_title a, .edd_downloads_list .edd_download_title a' => array(
			'font-size'      => astra_responsive_font( $edd_archive_product_title_font_size, 'desktop' ),
			'line-height'    => esc_attr( $edd_archive_product_title_line_height ),
			'font-weight'    => astra_get_css_value( $edd_archive_product_title_font_weight, 'font' ),
			'font-family'    => astra_get_css_value( $edd_archive_product_title_font_family, 'font', $body_font_family ),
			'text-transform' => esc_attr( $edd_archive_product_title_text_transform ),
			'color'          => esc_attr( $edd_archive_product_title_color ),
		),

		'.ast-edd-archive-block-wrap .edd_price, .edd_downloads_list .edd_price,.ast-edd-archive-block-wrap .edd_price_options, .edd_downloads_list .edd_price_options' => array(
			'font-family' => astra_get_css_value( $edd_archive_product_price_font_family, 'font', $body_font_family ),
			'font-weight' => astra_get_css_value( $edd_archive_product_price_font_weight, 'font' ),
			'font-size'   => astra_responsive_font( $edd_archive_product_price_font_size, 'desktop' ),
			'line-height' => esc_attr( $edd_archive_product_price_line_height ),
			'color'       => esc_attr( $edd_archive_product_price_color ),
		),

		'.single-download .post-navigation a'             => array(
			'color' => esc_attr( $product_navigation_color ),
		),

		'.ast-edd-archive-block-wrap .edd_download_excerpt p, .edd_downloads_list .edd_download_excerpt p' => array(
			'font-family'    => astra_get_css_value( $edd_archive_product_content_font_family, 'font', $body_font_family ),
			'font-weight'    => astra_get_css_value( $edd_archive_product_content_font_weight, 'font' ),
			'font-size'      => astra_responsive_font( $edd_archive_product_content_font_size, 'desktop' ),
			'text-transform' => esc_attr( $edd_archive_product_content_text_transform ),
			'line-height'    => esc_attr( $edd_archive_product_content_line_height ),
			'color'          => esc_attr( $edd_archive_product_content_color ),
		),

	);

	/* Parse CSS from array() */
	$css_output = astra_parse_css( $css_output );

	/**
	 * Header Cart color
	 */
	if ( 'none' != $header_cart_icon_style ) {

		/**
		 * Header Cart Icon colors
		 */
		$header_cart_icon = array(
			'li.ast-masthead-custom-menu-items.edd-custom-menu-item, .ast-masthead-custom-menu-items.edd-custom-menu-item' => array(
				'padding' => esc_attr( 0 ),
			),
			'.ast-header-break-point li.ast-masthead-custom-menu-items.edd-custom-menu-item' => array(
				'padding-left'  => esc_attr( '20px' ),
				'padding-right' => esc_attr( '20px' ),
				'margin'        => esc_attr( '0' ),
			),
			'.ast-header-break-point .ast-masthead-custom-menu-items.edd-custom-menu-item' => array(
				'margin-left'  => esc_attr( '1em' ),
				'margin-right' => esc_attr( '1em' ),
			),
			'.ast-header-break-point .ast-above-header-mobile-inline.mobile-header-order-2 .ast-masthead-custom-menu-items.edd-custom-menu-item' => array(
				'margin-left' => esc_attr( '0' ),
			),
			'.ast-header-break-point li.ast-masthead-custom-menu-items.edd-custom-menu-item .ast-addon-cart-wrap' => array(
				'display' => esc_attr( 'inline-block' ),
			),

			'.edd-custom-menu-item .ast-addon-cart-wrap' => array(
				'padding' => esc_attr( '0 .6em' ),
			),

			// Default icon colors.
			'.ast-edd-cart-menu-wrap .count, .ast-edd-cart-menu-wrap .count:after' => array(
				'border-color' => esc_attr( $header_cart_icon_color ),
				'color'        => esc_attr( $header_cart_icon_color ),
			),
			// Outline icon hover colors.
			'.ast-edd-cart-menu-wrap:hover .count'       => array(
				'color'            => esc_attr( $cart_h_color ),
				'background-color' => esc_attr( $header_cart_icon_color ),
			),
			// Outline icon colors.
			'.ast-edd-menu-cart-outline .ast-addon-cart-wrap' => array(
				'background' => '#ffffff',
				'border'     => '1px solid ' . $header_cart_icon_color,
				'color'      => esc_attr( $header_cart_icon_color ),
			),
			// Fill icon Color.
			'.ast-edd-site-header-cart.ast-edd-menu-cart-fill .ast-edd-cart-menu-wrap .count,.ast-edd-menu-cart-fill .ast-addon-cart-wrap' => array(
				'background-color' => esc_attr( $header_cart_icon_color ),
				'color'            => esc_attr( $cart_h_color ),
			),

			// Border radius.
			'.ast-edd-site-header-cart.ast-edd-menu-cart-outline .ast-addon-cart-wrap, .ast-edd-site-header-cart.ast-edd-menu-cart-fill .ast-addon-cart-wrap' => array(
				'border-radius' => astra_get_css_value( $header_cart_icon_radius, 'px' ),
			),
		);

		$css_output .= astra_parse_css( $header_cart_icon );
	}

	/* Checkout Width */
	if ( 'custom' === $checkout_width ) :
			$checkout_css  = '@media (min-width:' . astra_addon_get_tablet_breakpoint( '', 1 ) . 'px) {';
			$checkout_css .= '.edd-checkout #edd_checkout_wrap {';
			$checkout_css .= 'max-width:' . esc_attr( $checkout_custom_width ) . 'px;';
			$checkout_css .= 'margin:' . esc_attr( '0 auto' ) . ';';
			$checkout_css .= '}';
			$checkout_css .= '}';
			$css_output   .= $checkout_css;
	endif;

	$tablet_css = array(

		'.single-download .entry-title'   => array(
			'font-size' => astra_responsive_font( $product_title_font_size, 'tablet' ),
		),
		// Single Product Content.
		'.single-download .entry-content' => array(
			'font-size' => astra_responsive_font( $product_content_font_size, 'tablet' ),
		),
		'.ast-edd-archive-block-wrap .edd_download_title a, .edd_downloads_list .edd_download_title a' => array(
			'font-size' => astra_responsive_font( $edd_archive_product_title_font_size, 'tablet' ),
		),
		'.ast-edd-archive-block-wrap .edd_price, .edd_downloads_list .edd_price,.ast-edd-archive-block-wrap .edd_price_options, .edd_downloads_list .edd_price_options' => array(
			'font-size' => astra_responsive_font( $edd_archive_product_price_font_size, 'tablet' ),
		),
		'.ast-edd-archive-block-wrap .edd_download_excerpt p, .edd_downloads_list .edd_download_excerpt p' => array(
			'font-size' => astra_responsive_font( $edd_archive_product_content_font_size, 'tablet' ),
		),
	);
	$css_output .= astra_parse_css( $tablet_css, '', astra_addon_get_tablet_breakpoint() );

	$mobile_css  = array(
		'.single-download .entry-title'   => array(
			'font-size' => astra_responsive_font( $product_title_font_size, 'mobile' ),
		),
		'.single-download .entry-content' => array(
			'font-size' => astra_responsive_font( $product_content_font_size, 'mobile' ),
		),
		'.ast-edd-archive-block-wrap .edd_download_title a, .edd_downloads_list .edd_download_title a' => array(
			'font-size' => astra_responsive_font( $edd_archive_product_title_font_size, 'mobile' ),
		),
		'.ast-edd-archive-block-wrap .edd_price, .edd_downloads_list .edd_price,.ast-edd-archive-block-wrap .edd_price_options, .edd_downloads_list .edd_price_options' => array(
			'font-size' => astra_responsive_font( $edd_archive_product_price_font_size, 'mobile' ),
		),
		'.ast-edd-archive-block-wrap .edd_download_excerpt p, .edd_downloads_list .edd_download_excerpt p' => array(
			'font-size' => astra_responsive_font( $edd_archive_product_content_font_size, 'mobile' ),
		),
	);
	$css_output .= astra_parse_css( $mobile_css, '', astra_addon_get_mobile_breakpoint() );

	return $dynamic_css . $css_output;

}

