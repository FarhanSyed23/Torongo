/**
 * This file adds some LIVE to the Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 *
 * Use function astra_css() to generate dynamic CSS
 *
 * E.g. astra_css( CONTROL, CSS_PROPERTY, SELECTOR, UNIT )
 * 
 * @package Astra Addon
 * @since  1.0.0
 */

( function( $ ) {

	/**
	 * Primary Header Responsive Background Image
	 */
	astra_apply_responsive_background_css( 'astra-settings[header-bg-obj-responsive]', '.main-header-bar, .ast-header-break-point .main-header-bar', 'desktop' );

	astra_apply_responsive_background_css( 'astra-settings[header-bg-obj-responsive]', '.main-header-bar, .ast-header-break-point .main-header-bar', 'tablet' );

	astra_apply_responsive_background_css( 'astra-settings[header-bg-obj-responsive]', '.main-header-bar, .ast-header-break-point .main-header-bar', 'mobile' );

	/**
	 * Primary Menu + Custom Menu Items
	 */
	wp.customize( 'astra-settings[primary-menu-color-responsive]', function( value ) {
		value.bind( function( color ) {

			var DeskVal = '',
					TabletFontVal = '',
					MobileVal = '',
					mobile_style = '',
					tablet_style = '';

			if ( '' != color.desktop ) {
				DeskVal = color.desktop;
			}
			if ( '' != color.tablet ) {
				TabletFontVal = color.tablet;
			}
			if ( '' != color.mobile ) {
				MobileVal = color.mobile;
			}

			if( '' != color ) {
				var dynamicStyle = '.main-header-menu, .main-header-menu a,.ast-masthead-custom-menu-items, .ast-masthead-custom-menu-items a, .ast-header-break-point .ast-header-sections-navigation a, .ast-header-sections-navigation, .ast-header-sections-navigation a, .ast-above-header-menu-items a,.ast-below-header-menu-items, .ast-below-header-menu-items a{ color: ' + DeskVal + ';}';

				// Sticky Header colors for Custom Menu.
				dynamicStyle   += '#ast-fixed-header .main-header-menu, #ast-fixed-header .main-header-menu > li > a, #ast-fixed-header .ast-masthead-custom-menu-items, #ast-fixed-header .ast-masthead-custom-menu-items a, .main-header-bar.ast-sticky-active, .main-header-bar.ast-sticky-active .main-header-menu > li > a, .main-header-bar.ast-sticky-active .ast-masthead-custom-menu-items, .main-header-bar.ast-sticky-active .ast-masthead-custom-menu-items a{ color: ' + DeskVal + ';}';


				if( '' != TabletFontVal ) {
					tablet_style  += '@media (max-width: 768px) { .main-header-menu, .main-header-menu a,.ast-header-break-point .main-header-menu a,.ast-masthead-custom-menu-items, .ast-masthead-custom-menu-items a, .ast-header-break-point .ast-header-sections-navigation a, .ast-header-sections-navigation, .ast-header-sections-navigation a, .ast-above-header-menu-items a,.ast-below-header-menu-items, .ast-below-header-menu-items a{ color: ' + TabletFontVal + ';}';
					// Sticky Header colors for Custom Menu.
					tablet_style   += '#ast-fixed-header .main-header-menu, #ast-fixed-header .main-header-menu > li > a, #ast-fixed-header .ast-masthead-custom-menu-items, #ast-fixed-header .ast-masthead-custom-menu-items a, .main-header-bar.ast-sticky-active, .main-header-bar.ast-sticky-active .main-header-menu > li > a, .main-header-bar.ast-sticky-active .ast-masthead-custom-menu-items, .main-header-bar.ast-sticky-active .ast-masthead-custom-menu-items a{ color: ' + TabletFontVal + ';}';

				}

				if( '' != MobileVal ) {
					mobile_style  += '@media (max-width: 544px ) { .main-header-menu, .main-header-menu a,.ast-header-break-point .main-header-menu a,.ast-masthead-custom-menu-items, .ast-masthead-custom-menu-items a, .ast-header-break-point .ast-header-sections-navigation a, .ast-header-sections-navigation, .ast-header-sections-navigation a, .ast-above-header-menu-items a,.ast-below-header-menu-items, .ast-below-header-menu-items a{ color: ' + MobileVal + ';}';
					// Sticky Header colors for Custom Menu.
					mobile_style   += '#ast-fixed-header .main-header-menu, #ast-fixed-header .main-header-menu > li > a, #ast-fixed-header .ast-masthead-custom-menu-items, #ast-fixed-header .ast-masthead-custom-menu-items a, .main-header-bar.ast-sticky-active, .main-header-bar.ast-sticky-active .main-header-menu > li > a, .main-header-bar.ast-sticky-active .ast-masthead-custom-menu-items, .main-header-bar.ast-sticky-active .ast-masthead-custom-menu-items a{ color: ' + MobileVal + ';}';

				}

				dynamicStyle += tablet_style + mobile_style;

				astra_add_dynamic_css( 'primary-menu-color-responsive', dynamicStyle );
			} else {
				wp.customize.preview.send( 'refresh' );
			}
		} );
	} );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-menu-h-color-responsive]', 		'color', 				'.main-header-menu a:hover, .main-header-menu li:hover > a, .main-header-menu li.focus > a,  .main-header-menu li:hover > .ast-menu-toggle, .main-header-menu li.focus > .ast-menu-toggle, .main-header-menu .ast-masthead-custom-menu-items a:hover, .ast-header-sections-navigation li.current-menu-item > a' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-menu-h-bg-color-responsive]', 	'background-color', 	'.main-header-menu a:hover, .main-header-menu li:hover > a, .main-header-menu li.focus > a, .ast-header-sections-navigation li.hover > a,.ast-header-sections-navigation li.focus > a' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-menu-a-color-responsive]', 		'color',				'.main-header-menu .current-menu-item > a, .main-header-menu .current-menu-ancestor > a, .main-header-menu .current_page_item > a,.ast-header-sections-navigation li.current-menu-item > a, .ast-above-header-menu-items li.current-menu-item > a,.ast-below-header-menu-items li.current-menu-item > a,.ast-header-sections-navigation li.current-menu-ancestor > a, .ast-above-header-menu-items li.current-menu-ancestor > a,.ast-below-header-menu-items li.current-menu-ancestor > a' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-menu-a-bg-color-responsive]', 	'background-color', 	'.main-header-menu .current-menu-item > a, .main-header-menu .current-menu-ancestor > a, .main-header-menu .current_page_item > a,.ast-header-sections-navigation li.current-menu-item > a, .ast-above-header-menu-items li.current-menu-item > a,.ast-below-header-menu-items li.current-menu-item > a,.ast-header-sections-navigation li.current-menu-ancestor > a, .ast-above-header-menu-items li.current-menu-ancestor > a,.ast-below-header-menu-items li.current-menu-ancestor > a, .ast-fullscreen-menu-overlay .main-header-menu li.current-menu-item > a, .ast-fullscreen-menu-overlay .main-header-menu li.current-menu-ancestor > a, .ast-fullscreen-menu-overlay .main-header-menu li.current_page_item > a' );
	
	/**
	 * Primary Submenu
	 */

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-submenu-bg-color-responsive]', 	 'background-color', 	'.main-navigation .sub-menu, .ast-header-break-point .main-header-menu ul' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-submenu-color-responsive]', 	 'color', 				'.main-header-menu .sub-menu, .main-header-menu .sub-menu a, .main-header-menu .children a, .ast-header-sections-navigation .sub-menu a, .ast-above-header-menu-items .sub-menu a, .ast-below-header-menu-items .sub-menu a' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-submenu-h-color-responsive]', 	 'color', 				'.main-header-menu .sub-menu a:hover, .main-header-menu .children a:hover, .main-header-menu .sub-menu li:hover > a, .main-header-menu .children li:hover > a,.main-header-menu .sub-menu li.focus > a, .main-header-menu .children li.focus > a, .main-header-menu .sub-menu li:hover > .ast-menu-toggle, .main-header-menu .sub-menu li.focus > .ast-menu-toggle, .ast-header-sections-navigation .sub-menu a:hover, .ast-above-header-menu-items .sub-menu a:hover, .ast-below-header-menu-items .sub-menu a:hover, .ast-desktop .main-header-menu .astra-megamenu-li .sub-menu li a:hover, .ast-desktop .main-header-menu .astra-megamenu-li .sub-menu .menu-item a:focus' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-submenu-h-bg-color-responsive]', 'background-color', 	'.main-header-menu .sub-menu a:hover, .main-header-menu .children a:hover, .main-header-menu .sub-menu li:hover > a, .main-header-menu .children li:hover > a,.main-header-menu .sub-menu li.focus > a, .main-header-menu .children li.focus > a, .ast-header-sections-navigation .sub-menu a:hover, .ast-above-header-menu-items .sub-menu a:hover, .ast-below-header-menu-items .sub-menu a:hover, .ast-desktop .ast-mega-menu-enabled.main-header-menu .sub-menu li a:hover, .ast-desktop .ast-mega-menu-enabled.main-header-menu .sub-menu .menu-item a:focus' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-submenu-a-color-responsive]', 	 'color', 				'.ast-header-break-point.ast-no-toggle-menu-enable .main-header-menu li.current-menu-item > .ast-menu-toggle:hover, .ast-header-break-point.ast-no-toggle-menu-enable .main-header-menu li.current-menu-item > .ast-menu-toggle, .main-header-menu .sub-menu li.current-menu-item > a, .main-header-menu .children li.current_page_item > a, .main-header-menu .sub-menu li.current-menu-ancestor > a, .main-header-menu .children li.current_page_ancestor > a, .main-header-menu .sub-menu li.current_page_item > a, .main-header-menu .children li.current_page_item > a, .ast-header-sections-navigation .sub-menu li.current-menu-item > a, .ast-above-header-menu-items .sub-menu li.current-menu-item > a, .ast-below-header-menu-items .sub-menu li.current-menu-item > a, .ast-header-break-point .main-header-menu .sub-menu li.current-menu-item > a, .ast-header-break-point .main-header-menu .sub-menu li.current_page_item > a' );

	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-submenu-a-bg-color-responsive]', 'background-color', 	'.main-header-menu .sub-menu li.current-menu-item > a, .main-header-menu .children li.current_page_item > a, .main-header-menu .sub-menu li.current-menu-ancestor > a, .main-header-menu .children li.current_page_ancestor > a, .main-header-menu .sub-menu li.current_page_item > a, .main-header-menu .children li.current_page_item > a, .ast-header-sections-navigation .sub-menu li.current-menu-item > a, .ast-above-header-menu-items .sub-menu li.current-menu-item > a, .ast-below-header-menu-items .sub-menu li.current-menu-item > a, .ast-header-break-point .main-header-menu .sub-menu li.current-menu-item > a, .ast-header-break-point .main-header-menu .sub-menu li.current_page_item > a' );


	/**
	 * Content background color
	 */
	if( jQuery( 'body' ).hasClass( 'ast-separate-container' ) && jQuery( 'body' ).hasClass( 'ast-two-container' )){
		var dynamicSelector   = '.ast-separate-container .ast-article-single, .ast-separate-container .comment-respond,.ast-separate-container .ast-comment-list li, .ast-separate-container .ast-woocommerce-container, .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container .ast-author-meta, .ast-separate-container .related-posts, .ast-separate-container .comments-area, .ast-separate-container .comments-count-wrapper, .ast-separate-container.ast-two-container #secondary .widget';
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'desktop' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'tablet' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'mobile' );
	}
	else if ( jQuery( 'body' ).hasClass( 'ast-separate-container' ) ) {
		var dynamicSelector   = '.ast-separate-container .ast-article-single, .ast-separate-container .comment-respond,.ast-separate-container .ast-comment-list li, .ast-separate-container .ast-woocommerce-container, .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container .ast-author-meta, .ast-separate-container .related-posts, .ast-separate-container .comments-area, .ast-separate-container .comments-count-wrapper';
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'desktop' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'tablet' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'mobile' );
	}
	else if ( jQuery( 'body' ).hasClass( 'ast-plain-container' ) && ( jQuery( 'body' ).hasClass( 'ast-box-layout' ) || jQuery( 'body' ).hasClass( 'ast-padded-layout' ) ) ) {
		var dynamicSelector   = '.ast-box-layout.ast-plain-container .site-content, .ast-padded-layout.ast-plain-container .site-content';
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'desktop' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'tablet' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'mobile' );
	}

	var blog_grid = (typeof ( wp.customize._value['astra-settings[blog-grid]'] ) != 'undefined') ? wp.customize._value['astra-settings[blog-grid]']._value : 1;
	var blog_layout = (typeof ( wp.customize._value['astra-settings[blog-layout]'] ) != 'undefined') ? wp.customize._value['astra-settings[blog-layout]']._value : 'blog-layout-1';

	if( 'blog-layout-1' == blog_layout && 1 != blog_grid ) {
		var dynamicSelector   = '.ast-separate-container .blog-layout-1, .ast-separate-container .blog-layout-2, .ast-separate-container .blog-layout-3';
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'desktop' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'tablet' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'mobile' );
	} else {
		var dynamicSelector   = '.ast-separate-container .ast-article-post';
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'desktop' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'tablet' );
		astra_apply_responsive_background_css( 'astra-settings[content-bg-obj-responsive]', dynamicSelector, 'mobile' );
	}
	/**
	 * Content background color
	 */
	wp.customize( 'astra-settings[content-bg-obj]', function( value ) {
		value.bind( function( bg_obj ) {
			if( '' != bg_obj ) {
				var blog_grid = (typeof ( wp.customize._value['astra-settings[blog-grid]'] ) != 'undefined') ? wp.customize._value['astra-settings[blog-grid]']._value : 1;
				var blog_layout = (typeof ( wp.customize._value['astra-settings[blog-layout]'] ) != 'undefined') ? wp.customize._value['astra-settings[blog-layout]']._value : 'blog-layout-1';

				if( 'blog-layout-1' !== blog_layout && 1 == blog_grid ) {
					var dynamicStyle  = '.ast-separate-container .blog-layout-1, .ast-separate-container .blog-layout-2, .ast-separate-container .blog-layout-3 {';
						dynamicStyle += '	background-color: transparent;';
						dynamicStyle += '	background-image: none;';
						dynamicStyle += '}';
					astra_add_dynamic_css( 'content-bg-obj-blog-layouts', dynamicStyle );
				}
			} else {
				wp.customize.preview.send( 'refresh' );
			}
		} );
	});

	/**
	 * Body
	 */
	astra_css( 'astra-settings[archive-summary-box-bg-color]', 'background-color', '.ast-separate-container .ast-archive-description');
	astra_css( 'astra-settings[archive-summary-box-title-color]', 'color', '.ast-archive-description .page-title');
	astra_css( 'astra-settings[archive-summary-box-text-color]', 'color', '.ast-archive-description');
	/**
	 * Content <h1> to <h6> headings
	 */
	astra_css( 'astra-settings[h1-color]', 'color', 'h1, .entry-content h1' );
	astra_css( 'astra-settings[h2-color]', 'color', 'h2, .entry-content h2' );
	astra_css( 'astra-settings[h3-color]', 'color', 'h3, .entry-content h3' );
	astra_css( 'astra-settings[h4-color]', 'color', 'h4, .entry-content h4' );
	astra_css( 'astra-settings[h5-color]', 'color', 'h5, .entry-content h5' );
	astra_css( 'astra-settings[h6-color]', 'color', 'h6, .entry-content h6' );

	/**
	 * Header
	 */
	astra_css( 'astra-settings[header-color-site-title]', 'color', '.site-title a, .site-title a:focus, .site-title a:hover, .site-title a:visited' );
	astra_css( 'astra-settings[header-color-h-site-title]', 'color', '.site-header .site-title a:hover' );
	astra_css( 'astra-settings[header-color-site-tagline]',	'color', '.site-header .site-description' );

	/**
	 * Primary Menu
	 */
	/**
	 * Primary Menu Bg colors & image 
	 */

	var headersectionSelector = '';
	
	var primaryMenuBgStyle = '.main-header-menu, .ast-header-break-point .main-header-menu, .ast-header-break-point .ast-header-custom-item, .ast-header-break-point .ast-header-sections-navigation';
	
	if ( jQuery('body').hasClass('ast-primary-menu-disabled') ) {
		headersectionSelector = ', .ast-above-header-menu-items, .ast-below-header-menu-items';
		primaryMenuBgStyle += headersectionSelector;
	}

	astra_apply_responsive_background_css( 'astra-settings[primary-menu-bg-obj-responsive]', primaryMenuBgStyle, 'desktop' );
	astra_apply_responsive_background_css( 'astra-settings[primary-menu-bg-obj-responsive]', primaryMenuBgStyle, 'tablet' );
	astra_apply_responsive_background_css( 'astra-settings[primary-menu-bg-obj-responsive]', primaryMenuBgStyle, 'mobile' );
	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-menu-h-bg-color-responsive]', 	'background-color', 	'.main-header-menu a:hover, .main-header-menu li:hover > a, .main-header-menu li.focus > a, .ast-header-sections-navigation li.hover > a,.ast-header-sections-navigation li.focus > a' );
	astra_color_responsive_css( 'colors-background', 'astra-settings[primary-menu-h-color-responsive]', 		'color', 				'.main-header-menu a:hover, .main-header-menu li:hover > a, .main-header-menu li.focus > a,  .main-header-menu li:hover > .ast-menu-toggle, .main-header-menu li.focus > .ast-menu-toggle, .main-header-menu .ast-masthead-custom-menu-items a:hover, .ast-header-sections-navigation li.current-menu-item > a' );

	
	/**
	 * Single Post / Page Title Color
	 */
	astra_css( 'astra-settings[entry-title-color]', 'color', '.ast-single-post .entry-title, .page-title' );

	/**
	 * Blog / Archive Title
	 */
	astra_css( 'astra-settings[page-title-color]', 'color', '.entry-title a');

	/**
	 * Blog / Archive Meta
	 */
	astra_css( 'astra-settings[post-meta-color]', 'color', '.entry-meta, .entry-meta *');
	astra_css( 'astra-settings[post-meta-link-color]', 'color', '.entry-meta a, .entry-meta a *, .read-more a');
	astra_css( 'astra-settings[post-meta-link-h-color]', 'color', '.read-more a:hover, .entry-meta a:hover, .entry-meta a:hover *');

	/**
	 * Sidebar
	 */
	astra_css( 'astra-settings[sidebar-widget-title-color]', 'color', '.secondary .widget-title, .secondary .widget-title *');
	astra_css( 'astra-settings[sidebar-text-color]', 'color', '.secondary .widget');
	astra_css( 'astra-settings[sidebar-link-color]', 'color', '.secondary a');
	astra_css( 'astra-settings[sidebar-link-h-color]', 'color', '.secondary a:hover');
	wp.customize( 'astra-settings[sidebar-bg-obj]', function( value ) {
		value.bind( function( bg_obj ) {
			astra_background_obj_css( wp.customize, bg_obj, 'sidebar-bg-obj', ' .sidebar-main { {{css}} } ' );
		} );
	} );

	/**
	 * Footer
	 */
	astra_css( 'astra-settings[footer-color]', 'color', '.ast-small-footer' );
	astra_css( 'astra-settings[footer-link-color]', 'color', '.ast-small-footer a' );
	astra_css( 'astra-settings[footer-link-h-color]', 'color', '.ast-small-footer a:hover' );

} )( jQuery );
