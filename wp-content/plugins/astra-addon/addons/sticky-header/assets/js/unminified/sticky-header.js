/**
 * Stick elements
 *
 * => How to use?
 *
 * jQuery( {SELECTOR} ).astExtSticky( {
 *		dependent: [{selectors}], 	// Not required. Default: []. Stick element dependent selectors.
 *		stick_upto_scroll: {value}, 	// Not required. Default: 0. Stick element after scroll upto the {value} in px.
 *		gutter: {value}, 			// Not required. Default: 0. Stick element from top of the window in px\.
 * });
 *
 * @package Astra Addon
 * @since  1.0.0
 */

;(function ( $, window, undefined ) {

	var pluginName    = 'astExtSticky',
		document      = window.document,
		windowWidth   = jQuery( window ).outerWidth(),
		viewPortWidth = jQuery( window ).width(),
		defaults      = {
			dependent            : [],
			max_width            : '',
			site_layout          : '',
			break_point          : 920,
			admin_bar_height_lg  : 32,
			admin_bar_height_sm  : 46,
			admin_bar_height_xs  : 0,
			stick_upto_scroll    : 0,
			gutter               : 0,
			wrap                 : '<div></div>',

			// Padding support of <body> tag.
			body_padding_support : true,

			// Padding support of <html> tag.
			html_padding_support : true,

			// Added shrink option.
			shrink               : {
									padding_top    : '',
									padding_bottom : '',
						    	},

			// Enable sticky on mobile
			sticky_on_device 	 : 'desktop',

			header_style 		 : 'none',

			hide_on_scroll 		 : 'no',
		},
		/* Manage hide on scroll down */
		lastScrollTop 		= 0,
		delta 				= 5,
		navbarHeight 		= 0,
		should_stick		= true,
		hideScrollInterval;

	/**
	 * Init
	 *
	 * @since  1.0.0
	 */
	function astExtSticky( element, options ) {
		this.element   = element;
		this.options   = $.extend( {}, defaults, options );
		this._defaults = defaults;
		this._name     = pluginName;

		/* Manage hide on scroll down */
		if ( '1' == this.options.hide_on_scroll ) {
			this.navbarHeight = $(element).outerHeight();
		}

		this.lastScrollTop 		= 0;
		this.delta 				= 5;
		this.should_stick		= true;
		this.hideScrollInterval = '';

		this.init();
	}

	/**
	 * Stick element
	 *
	 * @since  1.0.0
	 */
	astExtSticky.prototype.stick_me = function( self, type ) {

		var selector      	  = jQuery( self.element ),
			windowWidth       = jQuery( window ).outerWidth();
			stick_upto_scroll = parseInt( self.options.stick_upto_scroll ),
			max_width         = parseInt( selector.parent().attr( 'data-stick-maxwidth' ) ), // parseInt( self.options.max_width ),
			gutter            = parseInt( selector.parent().attr( 'data-stick-gutter' ) ); // parseInt( self.options.gutter ).

		/**
		 * Check window width
		 */
		if ( 'desktop' == self.options.sticky_on_device && jQuery( 'body' ).hasClass( 'ast-header-break-point' ) ) {
			self.stickRelease( self );
		} else if ( 'mobile' == self.options.sticky_on_device && ! jQuery( 'body' ).hasClass( 'ast-header-break-point' ) ) {
			self.stickRelease( self );
		} else {

			if ( jQuery( window ).scrollTop() > stick_upto_scroll ) {

				var fixed_header = selector;
				
				if ( '1' === self.options.hide_on_scroll ) {

					self.hasScrolled( self, 'stick' );
				}else if ( 'none' == self.options.header_style ) {					
					selector.parent().css( 'min-height', selector.outerHeight() );

					selector.addClass( 'ast-sticky-active' ).stop().css({
						'max-width'      : max_width,
						'top'            : gutter,
						'padding-top'    : self.options.shrink.padding_top,
						'padding-bottom' : self.options.shrink.padding_bottom,
					});
					selector.addClass( 'ast-sticky-shrunk' ).stop();
					$( document ).trigger( "addStickyClass" );
					fixed_header.addClass('ast-header-sticked');


				}else if ( 'slide' == self.options.header_style ) {
					fixed_header.css({
						'top' : gutter,
					});
					fixed_header.addClass('ast-header-slide');
					fixed_header.css( 'visibility', 'visible' );
					fixed_header.addClass( 'ast-sticky-active' ).stop().css({
						'transform':'translateY(0)',
					});
					$('html').addClass('ast-header-stick-slide-active');
					$( document ).trigger( "addStickyClass" );
					fixed_header.addClass('ast-header-sticked');


				}else if( 'fade' == self.options.header_style ) {
					fixed_header.css({
						'top' : gutter,
					});
					fixed_header.addClass('ast-header-fade');
					fixed_header.css( 'visibility', 'visible' );
					fixed_header.addClass( 'ast-sticky-active' ).stop().css({
						'opacity' : '1',
					});
					$('html').addClass('ast-header-stick-fade-active');
					$( document ).trigger( "addStickyClass" );
					fixed_header.addClass('ast-header-sticked');

				}
			} else {
				self.stickRelease( self );
			}
		}
	}

	astExtSticky.prototype.update_attrs = function () {

		var self  	          = this,
			selector          = jQuery( self.element ),
			gutter            = parseInt( self.options.gutter ),
			max_width         = self.options.max_width;

		if ( 'none' == self.options.header_style && ! jQuery( 'body' ).hasClass( 'ast-sticky-toggled-off' ) ) {
			var stick_upto_scroll = selector.offset().top || 0;
		}else{
			if ( $('#masthead').length ) {
				var masthead 			= $('#masthead');
				var masthead_bottom 	= masthead.offset().top + masthead.outerHeight() + 100;
				var stick_upto_scroll 	= masthead_bottom || 0;
			}
		}

		/**
		 * Update Max-Width
		 */
		if ( 'ast-box-layout' != self.options.site_layout ) {
			max_width = jQuery( 'body' ).width();
		}

		/**
		 * Check dependent element
		 * - Is exist?
		 * - Has attr 'data-stick-support' with status 'on'
		 */
		if ( self.options.dependent ) {
			jQuery.each( self.options.dependent, function(index, val) {
				if (
					( jQuery( val ).length ) &&
					( jQuery( val ).parent().attr( 'data-stick-support' ) == 'on' )
				) {

					dependent_height   = jQuery( val ).outerHeight();
					gutter            += parseInt( dependent_height );
					stick_upto_scroll -= parseInt( dependent_height );
				}
			});
		}

		/**
		 * Add support for Admin bar height
		 */
		if ( self.options.admin_bar_height_lg && jQuery( '#wpadminbar' ).length && viewPortWidth > 782 ) {
			gutter            += parseInt( self.options.admin_bar_height_lg );
			stick_upto_scroll -= parseInt( self.options.admin_bar_height_lg );
		}

		if ( self.options.admin_bar_height_sm && jQuery( '#wpadminbar' ).length && ( viewPortWidth >= 600 && viewPortWidth <= 782 ) ) {
			gutter            += parseInt( self.options.admin_bar_height_sm );
			stick_upto_scroll -= parseInt( self.options.admin_bar_height_sm );
		}

		if( self.options.admin_bar_height_xs && jQuery( '#wpadminbar' ).length ){
			gutter            += parseInt( self.options.admin_bar_height_xs );
			stick_upto_scroll -= parseInt( self.options.admin_bar_height_xs );
		}

		/**
		 * Add support for <body> tag
		 */
		if ( self.options.body_padding_support ) {
			gutter            += parseInt( jQuery( 'body' ).css( 'padding-top' ), 10 );
			stick_upto_scroll -= parseInt( jQuery( 'body' ).css( 'padding-top' ), 10 );
		}

		/**
		 * Add support for <html> tag
		 */
		if ( self.options.html_padding_support ) {
			gutter            += parseInt( jQuery( 'html' ).css( 'padding-top' ), 10 );
			stick_upto_scroll -= parseInt( jQuery( 'html' ).css( 'padding-top' ), 10 );
		}

		/**
		 * Reduce the stick_upto_scrll by one if filter `astra_addon_sticky_header_stick_origin_position` is set true.
		 * This will make the sticky header appear sticky on initial load.
		 */
		if ( stick_origin_position ) {
			stick_upto_scroll--;
		}

		/**
		 * Updated vars
		 */
		self.options.stick_upto_scroll = stick_upto_scroll;

		/**
		 * Update Attributes
		 */
		if ( 'none' == self.options.header_style ) {
			selector.parent()
				.css( 'min-height', selector.outerHeight() )
				.attr( 'data-stick-gutter', parseInt( gutter ) )
				.attr( 'data-stick-maxwidth', parseInt( max_width ) );
		}else{
			selector.parent()
				.attr( 'data-stick-gutter', parseInt( gutter ) )
				.attr( 'data-stick-maxwidth', parseInt( max_width ) );

			if ( 'ast-padded-layout' === self.options.site_layout ) {
				selector.css( 'max-width', parseInt( max_width ) );
			}
		}
	}

	astExtSticky.prototype.hasScrolled = function( self, method ) {
		
		var st = $( window ).scrollTop();
    
	    // Make sure they scroll more than delta
	    if(Math.abs(lastScrollTop - st) <= delta)
	        return;
	    
	    // If they scrolled down and are past the navbar, add class .nav-up.
	    // This is necessary so you never see what is "behind" the navbar.
		var fixed_header = jQuery(self.element);
	    if (st > lastScrollTop && st > navbarHeight){

	        // Scroll Down
	        jQuery(self.element).removeClass('ast-nav-down').addClass('ast-nav-up');
	    } else {
	        // Scroll Up
	        if(st + $(window).height() < $(document).height()) {
	            jQuery(self.element).removeClass('ast-nav-up').addClass('ast-nav-down');
	        }
	    }
	    
	    lastScrollTop = st;

	    if ( !$(self.element).hasClass('ast-nav-up') && 'stick' == method ) {
			fixed_header.css({
				'top' : gutter,
			});
			fixed_header.addClass('ast-header-sticked');
			fixed_header.addClass('ast-header-slide');
			fixed_header.css( 'visibility', 'visible' );
			fixed_header.addClass( 'ast-sticky-active' ).stop().css({
				'transform':'translateY(0)',
			});
			$( document ).trigger( "addStickyClass" );
			$('html').addClass('ast-header-stick-scroll-active');
		}else{
			fixed_header.css({
				'transform':'translateY(-100%)',
			}).stop();

			setTimeout(function() {
				fixed_header.removeClass( 'ast-sticky-active' );
			}, 300);
			fixed_header.css({ 
				'visibility' : 'hidden',
				'top' : '',
			});
			$( document ).trigger( "removeStickyClass" );
			$('html').removeClass('ast-header-stick-scroll-active');
			fixed_header.removeClass('ast-header-sticked');
		}
	}

	astExtSticky.prototype.stickRelease = function( self ) {
		var selector = jQuery( self.element );
		var fixed_header = selector;
		if ( '1' === self.options.hide_on_scroll ) {
			self.hasScrolled( self, 'release' );
		}else{
			if ( 'none' == self.options.header_style ) {
				selector.removeClass( 'ast-sticky-active' ).stop().css({
					'max-width' : '',
					'top'		: '',
					'padding'	: '',
				});
				selector.parent().css( 'min-height', '' );
				$( document ).trigger( "removeStickyClass" );
				fixed_header.removeClass('ast-header-sticked');
				selector.removeClass( 'ast-sticky-shrunk' ).stop();


			}else if ( 'slide' == self.options.header_style ) {
				fixed_header.removeClass( 'ast-sticky-active' ).stop().css({
					'transform':'translateY(-100%)',
				});
				fixed_header.css({ 
					'visibility' : 'hidden',
					'top' : '',
				});

				$('html').removeClass('ast-header-stick-slide-active');
				$( document ).trigger( "removeStickyClass" );
				fixed_header.removeClass('ast-header-sticked');


			}else if( 'fade' == self.options.header_style ) {
				fixed_header.removeClass( 'ast-sticky-active' ).stop().css({
					'opacity' : '0',
				});
				fixed_header.css({ 
					'visibility' : 'hidden',
				});
				fixed_header.removeClass('ast-header-sticked');
				$( document ).trigger( "removeStickyClass" );
				$('html').removeClass('ast-header-stick-fade-active');


			}
		}
	}
	/**
	 * Init Prototype
	 *
	 * @since  1.0.0
	 */
	astExtSticky.prototype.init = function () {

		/**
		 * If custom stick options are set
		 */
		if ( jQuery( this.element ) ) {

			var self                       	   = this,
				selector                       = jQuery( self.element ),
				gutter                         = parseInt( self.options.gutter ),
				stick_upto_scroll              = selector.position().top || 0,
				dependent_height               = 0;

			/**
			 *	Add parent <div> wrapper with height element for smooth scroll
			 *
			 *	Added 'data-stick-support' to all sticky elements
			 *	To know the {dependent} element has support of 'stick'
			 */
			 if ( 'none' == self.options.header_style ) {
				selector.wrap( self.options.wrap )
					.parent().css( 'min-height', selector.outerHeight() )
					.attr( 'data-stick-support', 'on' )
					.attr( 'data-stick-maxwidth', parseInt( self.options.max_width ) );
			}else{
				selector.wrap( self.options.wrap )
					.attr( 'data-stick-support', 'on' )
					.attr( 'data-stick-maxwidth', parseInt( self.options.max_width ) );
			}

			self.update_attrs();

			// Stick me!.
			jQuery( window ).on('resize', function() {

				self.stickRelease( self );
				self.update_attrs();
				self.stick_me( self );
			} );

			jQuery( window ).on('scroll', function() {
				// update the stick_upto_scroll if normal main header navigation is opend.
				self.stick_me( self, 'scroll' );
				 
				if( jQuery( 'body' ).hasClass( 'ast-sticky-toggled-off' ) ){
					self.update_attrs();
					self.stick_me( self, 'scroll' );
				}
			} );

			jQuery( document ).ready(function($) {
				self.stick_me( self );
			} );

		}

	};

	$.fn[pluginName] = function ( options ) {
		return this.each(function () {
			if ( ! $.data( this, 'plugin_' + pluginName )) {
				$.data( this, 'plugin_' + pluginName, new astExtSticky( this, options ) );
			}
		});
	}



	var $body = jQuery( 'body' ),
		layout_width             = $body.width(),
		stick_header_meta        = astraAddon.stick_header_meta || 'default',
		stick_main               = astraAddon.header_main_stick || '',
		main_shrink              = astraAddon.header_main_shrink || '',
		stick_above              = astraAddon.header_above_stick || '',
		stick_below              = astraAddon.header_below_stick || '',
		header_main_stick_meta   = astraAddon.header_main_stick_meta || '',
		header_above_stick_meta  = astraAddon.header_above_stick_meta || '',
		header_below_stick_meta  = astraAddon.header_below_stick_meta || '',
		site_layout              = astraAddon.site_layout || '',
		site_layout_padded_width = astraAddon.site_layout_padded_width || 1200,
		site_layout_box_width    = astraAddon.site_layout_box_width || 1200,
		site_content_width       = astraAddon.site_content_width || 1200,
		sticky_header_on_devices = astraAddon.sticky_header_on_devices || 'desktop',
		sticky_header_style		 = astraAddon.sticky_header_style || 'none',
		sticky_hide_on_scroll 	 = astraAddon.sticky_hide_on_scroll || '',
		header_logo_width    	 = astraAddon.header_logo_width || '',
		responsive_header_logo_width = astraAddon.responsive_header_logo_width || '';
		stick_origin_position    = astraAddon.stick_origin_position || '';
		

	/**
	 * Check meta options
	 */
	if ( 'disabled' == stick_header_meta ) {
		return;
	}

	if ( 'enabled' === stick_header_meta ) {
		stick_main = header_main_stick_meta;
		stick_above  = header_above_stick_meta;
		stick_below = header_below_stick_meta;
	}

	if ( $('header .site-logo-img img').length > 0 ) {
		var id_img 		= $('header .site-logo-img img');
		var id_height 	= id_img.attr('height');

		if ( typeof id_height === 'undefined' ) {
			id_height 	= id_img.height();
		}
		
		if ( id_height == 0 ) {
			id_height = '';
		}
		
		if ( -1 === id_height.toString().indexOf('%') ) {
			id_height += 'px';
		}

		if ( '' != responsive_header_logo_width.desktop || '' != responsive_header_logo_width.tablet ||  '' != responsive_header_logo_width.mobile  ) {
		var output = "<style type='text/css' id='ast-site-identity-img' class='ast-site-identity-img' > #masthead .site-logo-img .astra-logo-svg { width: " + responsive_header_logo_width.desktop + "px; } @media (max-width: 768px) { #masthead .site-logo-img .astra-logo-svg { width: " + responsive_header_logo_width.tablet + "px; } } @media (max-width: 544px) { #masthead .site-logo-img .astra-logo-svg{ width: " + responsive_header_logo_width.mobile + "px; } }  #masthead .site-logo-img img { max-height: " + id_height + "; width: auto; } </style>";
		}else if( '' != header_logo_width ){
			var output = "<style type='text/css' id='ast-site-identity-img' class='ast-site-identity-img' > #masthead .site-logo-img .astra-logo-svg { width: " + header_logo_width + "px; } #masthead .site-logo-img img { max-height: " + id_height + "; width: auto; } </style>";
		}

		$("head").append( output );
	}

	// Any stick header is enabled?
	if ( stick_main || stick_above || stick_below ) {

		// Add Respective class to the body dependent on which sticky header is activated.
		$( document ).on( "addStickyClass", function() {
			var bodyClass = '';
			
			if ( '1' == stick_main || 'on' == stick_main ) {
				bodyClass += " ast-primary-sticky-header-active";
			}
			if ( '1' == stick_above || 'on' == stick_above ) {
				bodyClass += " ast-above-sticky-header-active";
			}
			if ( '1' == stick_below || 'on' == stick_below ) {
				bodyClass += " ast-below-sticky-header-active";
			}
			$('body').addClass(bodyClass);
		});

		// Remove Respective class from the body dependent on which sticky header is not activated.
		$( document ).on( "removeStickyClass", function() {
			var bodyClass = '';

			if ( '1' == stick_main || 'on' == stick_main ) {
				bodyClass += " ast-primary-sticky-header-active";
			}
			if ( '1' == stick_above || 'on' == stick_above ) {
				bodyClass += " ast-above-sticky-header-active";
			}
			if ( '1' == stick_below || 'on' == stick_below ) {
				bodyClass += " ast-below-sticky-header-active";
			}
			$('body').removeClass(bodyClass);
		});

		switch ( site_layout ) {
			case 'ast-box-layout':
				layout_width = parseInt( site_layout_box_width );
			break;
		}

		jQuery( document ).ready(function($) {


			if ( '1' == sticky_hide_on_scroll ) {
	    		if ( '1' == main_shrink ) {
	    			jQuery( '#ast-fixed-header' ).addClass( 'ast-sticky-shrunk' ).stop();
	    		}

	    		if( !( '1' == stick_above || 'on' == stick_above ) ) {
					jQuery( '#ast-fixed-header .ast-above-header' ).hide();
				}
				if( !( '1' == stick_main || 'on' == stick_main ) ) {
					jQuery( '#ast-fixed-header .main-header-bar' ).hide();
				}
				if( !( '1' == stick_below || 'on' == stick_below ) ) {
					jQuery( '#ast-fixed-header .ast-below-header' ).hide();
				}

	    		jQuery( '#ast-fixed-header' ).astExtSticky({
					//dependent: ['#masthead .ast-above-header'],
					max_width: layout_width,
					site_layout: site_layout,
					sticky_on_device: sticky_header_on_devices,
					header_style: 'slide',
					hide_on_scroll: sticky_hide_on_scroll,
				});
			}else{
		    	if ( 'none' == sticky_header_style ) {
			    	/**
			    	 * Stick Above Header
			    	 */
			    	if ( '1' == stick_above || 'on' == stick_above ) {
			    		jQuery( '#masthead .ast-above-header' ).astExtSticky({
					    	max_width: layout_width,
					    	site_layout: site_layout,
					    	sticky_on_device: sticky_header_on_devices,
					    	header_style: sticky_header_style,
					    	hide_on_scroll: sticky_hide_on_scroll,
					    });
			    	}
			    	// Add wrapper class to primary header & below header if stick primary header , stick below header and shrink primary header is enabled.
			    	// stick wrapper class of primary header and below header
			    	if ( ( '1' == stick_main || 'on' == stick_main ) &&
			    		( '1' == stick_below || 'on' == stick_below ) 
			    	) {

			    		jQuery( '#masthead .main-header-bar-wrap' ).wrap('<div class="ast-stick-primary-below-wrapper"></div>')
				    	jQuery( '#masthead .ast-below-header-wrap' ).prependTo('.ast-stick-primary-below-wrapper');
				    	jQuery( '#masthead .main-header-bar-wrap' ).prependTo('.ast-stick-primary-below-wrapper');

				    	jQuery( '#masthead .ast-stick-primary-below-wrapper' ).astExtSticky({
					    	dependent: ['#masthead .ast-above-header'],
					    	max_width: layout_width,
					    	site_layout: site_layout,
					    	shrink: shrink_options,
					    	sticky_on_device: sticky_header_on_devices,
					    	header_style: sticky_header_style,
					    	hide_on_scroll: sticky_hide_on_scroll,
					    });

			    	} else {

				    	/**
				    	 * Stick Main Header
				    	 */
				    	if ( '1' == stick_main || 'on' == stick_main ) {

				    		// If shrink is enabled
				    		// then add shrink top and bottom paddings.
			    			var shrink_options = '';
				    		if( main_shrink ) {
				    			shrink_options = {
						    		padding_top: '',
						    		padding_bottom: '',
						    	}
				    		}

						    jQuery( '#masthead .main-header-bar' ).astExtSticky({
						    	dependent: ['#masthead .ast-above-header'],
						    	max_width: layout_width,
						    	site_layout: site_layout,
						    	shrink: shrink_options,
						    	sticky_on_device: sticky_header_on_devices,
						    	header_style: sticky_header_style,
						    	hide_on_scroll: sticky_hide_on_scroll,
						    });

						    jQuery( '#masthead .ast-custom-header' ).astExtSticky({
								max_width: layout_width,
								site_layout: site_layout,
								shrink: shrink_options,
								sticky_on_device: sticky_header_on_devices,
								header_style: sticky_header_style,
								hide_on_scroll: sticky_hide_on_scroll,
							});
				    	}

				    	/**
				    	 * Stick Below Header
				    	 */
				    	if ( ('1' == stick_below || 'on' == stick_below ) ) {
						    jQuery( '#masthead .ast-below-header' ).astExtSticky( {
						    	dependent: [ '#masthead .main-header-bar', '#masthead .ast-above-header'],
						    	max_width: layout_width,
						    	site_layout: site_layout,
						    	sticky_on_device: sticky_header_on_devices,
						    	header_style: sticky_header_style,
						    	hide_on_scroll: sticky_hide_on_scroll,
						    } );

						}
			    	}


				}else{

					jQuery( '#ast-fixed-header' ).addClass( 'ast-sticky-shrunk' ).stop();

					if( !( '1' == stick_above || 'on' == stick_above ) ) {
						jQuery( '#ast-fixed-header .ast-above-header' ).hide();
					}
					if( !( '1' == stick_main || 'on' == stick_main ) ) {
						jQuery( '#ast-fixed-header .main-header-bar' ).hide();
					}
					if( !( '1' == stick_below || 'on' == stick_below ) ) {
						jQuery( '#ast-fixed-header .ast-below-header' ).hide();
					}
					/**
			    	 * Stick Main Header
			    	 */
			    	if ( '1' == stick_above || 'on' == stick_above
						 || '1' == stick_main || 'on' == stick_main
						 || '1' == stick_below || 'on' == stick_below
						) {

			    		// If shrink is enabled
			    		// then add shrink top and bottom paddings.
		    			var shrink_options = '';
			    		if( main_shrink ) {
			    			shrink_options = {
					    		padding_top: '',
					    		padding_bottom: '',
					    	}
			    		}

					    jQuery( '#ast-fixed-header' ).astExtSticky({
					    	//dependent: ['#masthead .ast-above-header'],
					    	max_width: layout_width,
					    	site_layout: site_layout,
					    	shrink: shrink_options,
					    	sticky_on_device: sticky_header_on_devices,
					    	header_style: sticky_header_style,
					    	hide_on_scroll: sticky_hide_on_scroll,
					    });
			    	}
				}
			}

			// If Sticky Header for both mobile , desktops.
			if ( 'mobile' == sticky_header_on_devices || 'both' == sticky_header_on_devices ) {
				// Normal Header Mobile Menu Toggled
				jQuery( '#masthead .main-header-menu-toggle' ).click(function(event) {

					/* If menu navigation is opened and has sticky active */
					if( jQuery( '#masthead .main-header-menu-toggle' ).hasClass( 'toggled' ) ){
						// Add body class to update the stick_upto_scroll.
						$body.addClass('ast-sticky-toggled-off');

						if ( 
							'none' == defaults['header_style'] && 
							( jQuery( '#masthead .main-header-bar' ).hasClass('ast-sticky-active') || 
								jQuery( '#masthead .ast-stick-primary-below-wrapper' ).hasClass('ast-sticky-active') ) 
							){

							// Only If none style is selected
							var windowHeight = jQuery( window ).height(),
							headerSectionHeight = 0;

							if ( jQuery( '#masthead .ast-above-header' ) && jQuery( '#masthead .ast-above-header' ).length ) {
								headerSectionHeight = jQuery( '#masthead .ast-above-header' ).height();
							}

							// overflow hide for html.
							if ( '1' == sticky_hide_on_scroll ) {
								jQuery( 'html' ).css({
									'overflow'      : 'hidden',
								});
							}
					    	// add min height to wrapper class of primary header and below header
					    	if (  '1' == main_shrink && 
					    		( '1' == stick_main || 'on' == stick_main ) &&
					    		( '1' == stick_below || 'on' == stick_below ) 
					    	) {
								jQuery( '#masthead .ast-stick-primary-below-wrapper' ).css({
									'max-height'      : ( windowHeight - headerSectionHeight ) +'px',
									'overflow-y'      : 'auto',
								});
					    	} else {
								// ass max height to sticky header.
								jQuery( '#masthead .main-header-bar.ast-sticky-active' ).css({
									'max-height'      : ( windowHeight - headerSectionHeight ) +'px',
									'overflow-y'      : 'auto',
								});
							}
						}
					}
					else{
						$body.addClass('ast-sticky-toggled-off');
						jQuery( 'html' ).css({
							'overflow'      : '',
						});
						if (  '1' == main_shrink && 
					    		( '1' == stick_main || 'on' == stick_main ) &&
					    		( '1' == stick_below || 'on' == stick_below ) 
					    	) {
								jQuery( '#masthead .ast-stick-primary-below-wrapper' ).css({
									'max-height'      : '',
									'overflow-y'      : '',
								});
					    	} else {
								// ass max height to sticky header.
								jQuery( '#masthead .main-header-bar.ast-sticky-active' ).css({
									'max-height'      : '',
									'overflow-y'      : '',
								});
							}
					}
				});
				// Fixed Header Mobile Menu Toggled
				jQuery( '#ast-fixed-header .main-header-menu-toggle' ).click(function(event) {
					/* If menu navigation is opened and has sticky active */

					if( jQuery( '#ast-fixed-header .main-header-menu-toggle' ).hasClass( 'toggled' ) ){

						var windowHeight = jQuery( window ).height();

						// overflow hide for html.
						if ( '1' == sticky_hide_on_scroll ) {
							jQuery( 'html' ).css({
								'overflow'      : 'auto',
							});
						}
						// ass max height to sticky header.
						jQuery( '#ast-fixed-header' ).css({
							'max-height'      : ( windowHeight ) +'px',
							'overflow-y'      : 'auto',
						});
					}
					// remove css if menu toggle is closed.
					else{
						jQuery( 'html' ).css({
							'overflow'      : '',
						});
						jQuery( '#ast-fixed-header' ).css({
							'max-height'      : '',
							'overflow-y'      : '',
						});
					}
				});
			}

	    });
	}

}(jQuery, window));
