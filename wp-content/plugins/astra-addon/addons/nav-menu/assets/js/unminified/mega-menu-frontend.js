document.addEventListener("DOMContentLoaded", display_mega_menu_on_load);

/**
 * Remove "hidden" class after the page is fully loaded to fix the visibility issue of MegaMenu width.
 */
function display_mega_menu_on_load() {
    // For Content width.
    var menu_content = document.querySelectorAll(".content-width-mega");
    if ( menu_content.length > 0 ) {
        for (var i = 0; i < menu_content.length; i++) {
            menu_content[i].addEventListener( "mouseenter", function( event ) {
                var mega_menu_container = event.target.querySelector(".astra-mega-menu-width-content");
                mega_menu_container.classList.remove("ast-hidden"); 
            });
        }
    }
    
    // For Menu width.
    var menu_container = document.querySelectorAll(".menu-container-width-mega");
    if ( menu_container.length > 0 ) {
        for (var i = 0; i < menu_container.length; i++) {
            menu_container[i].addEventListener( "mouseenter", function( event ) {
                var mega_menu_container = event.target.querySelector(".astra-mega-menu-width-menu-container");
                mega_menu_container.classList.remove("ast-hidden"); 
            });
        }
    }
    
    // For Full width.
    var menu_full_width = document.querySelectorAll(".full-width-mega");
    if ( menu_full_width.length > 0 ) {
		for (var i = 0; i < menu_full_width.length; i++) {
			menu_full_width[i].addEventListener( "mouseenter", function( event ) {
                var mega_menu_container = event.target.querySelector(".astra-full-megamenu-wrapper");
                var mega_menu_submenu = event.target.querySelector(".astra-mega-menu-width-full");
                mega_menu_container.classList.remove("ast-hidden");
                mega_menu_submenu.classList.remove("ast-hidden");
            });
        }
    }
}

var items = document.getElementsByClassName('astra-megamenu-li');

[].slice.call(items).forEach(function(container) {
    jQuery( container ).hover( function() {

        var ast_container = jQuery(container).parents( '.ast-container' ),
            $main_container = ast_container.children(),
            $full_width_main_container = ast_container.parent(),
            $this            = jQuery( this );

        // Full width mega menu
        if( $this.hasClass( 'full-width-mega' ) ) {
            $main_container = jQuery( $main_container ).closest('.ast-container' );
        }

        if ( parseInt( jQuery(window).width() ) > parseInt( astra.break_point ) ) { 

            var $menuWidth           = $main_container.width(),     
                $menuPosition        = $main_container.offset(), 
                $menuItemPosition    = $this.offset(),
                $positionLeft        = $menuItemPosition.left - ( $menuPosition.left + parseFloat($main_container.css('paddingLeft') ) );

            var $fullMenuWidth           = $full_width_main_container.width(),
                $fullMenuPosition        = $full_width_main_container.offset(),
                $fullPositionLeft        = $menuItemPosition.left - ( $fullMenuPosition.left + parseFloat( $full_width_main_container.css( 'paddingLeft' ) ) );

            if( $this.hasClass( 'menu-container-width-mega' ) ) {
                $target_container = jQuery(".main-navigation");
                $menuWidth           = $target_container.width() + 'px';
                var $offset_right    = jQuery(window).width() - ( $target_container.offset().left + $target_container.outerWidth() );
                var $current_offset  = $this.offset();
                var $width           = ( jQuery(window).width() - $offset_right ) - $current_offset.left;
                $positionLeft        = parseInt( $target_container.width() - $width );
            }
            if( $this.hasClass( 'full-width-mega' ) ) {
                $this.find( '.astra-full-megamenu-wrapper' ).css( { 'left': '-'+$fullPositionLeft+'px', 'width': $fullMenuWidth } );
                $this.find( '.astra-megamenu' ).css( { 'width': $menuWidth } );
            } else{
                $this.find( '.astra-megamenu' ).css( { 'left': '-'+$positionLeft+'px', 'width': $menuWidth } );
            }
        } else {
            $this.find( '.astra-megamenu' ).css( { 'left': '', 'width': '', 'background-image': '' } );
            $this.find( '.astra-full-megamenu-wrapper' ).css( { 'left': '', 'width': '', 'background-image': '' } );
        }
    } );
});

// Achieve accessibility for megamenus using focusin on <a>.
[].slice.call(items).forEach(function(container) {

    var ast_container = jQuery(container).parents( '.ast-container' ),
        $main_container = ast_container.children(),
        $full_width_main_container = ast_container.parent(),
        $this            = jQuery( container );

    // Full width mega menu
    if( $this.hasClass( 'full-width-mega' ) ) {
        $main_container = jQuery( $main_container ).closest('.ast-container' );
    }

    $this.find( '.menu-link' ).focusin(function( e ) {
        $this.find( '.sub-menu' ).addClass( 'astra-megamenu-focus' );
        $this.find( '.astra-full-megamenu-wrapper' ).addClass( 'astra-megamenu-wrapper-focus' );
        if ( parseInt( jQuery(window).width() ) > parseInt( astra.break_point ) ) { 

            var $menuWidth           = $main_container.width(),     
                $menuPosition        = $main_container.offset(), 
                $menuItemPosition    = $this.offset(),
                $positionLeft        = $menuItemPosition.left - ( $menuPosition.left + parseFloat($main_container.css('paddingLeft') ) );

            var $fullMenuWidth           = $full_width_main_container.width(),
                $fullMenuPosition        = $full_width_main_container.offset(),
                $fullPositionLeft        = $menuItemPosition.left - ( $fullMenuPosition.left + parseFloat( $full_width_main_container.css( 'paddingLeft' ) ) );

            if( $this.hasClass( 'menu-container-width-mega' ) ) {
                $target_container = jQuery(".main-navigation");
                $menuWidth           = $target_container.width() + 'px';
                var $offset_right    = jQuery(window).width() - ( $target_container.offset().left + $target_container.outerWidth() );
                var $current_offset  = $this.offset();
                var $width           = ( jQuery(window).width() - $offset_right ) - $current_offset.left;
                $positionLeft        = parseInt( $target_container.width() - $width );
            }
            if( $this.hasClass( 'full-width-mega' ) ) {
                $this.find( '.astra-full-megamenu-wrapper' ).css( { 'left': '-'+$fullPositionLeft+'px', 'width': $fullMenuWidth } );
                $this.find( '.astra-megamenu' ).css( { 'width': $menuWidth } );
            } else{
                $this.find( '.astra-megamenu' ).css( { 'left': '-'+$positionLeft+'px', 'width': $menuWidth } );
            }
        } else {
            $this.find( '.astra-megamenu' ).css( { 'left': '', 'width': '', 'background-image': '' } );
            $this.find( '.astra-full-megamenu-wrapper' ).css( { 'left': '', 'width': '', 'background-image': '' } );
        }
    });

    $this.find( '.menu-link' ).keydown(function (e) {    
    if (e.which  == 9 && e.shiftKey) {
        $this.find( '.sub-menu' ).removeClass( 'astra-megamenu-focus' );
        $this.find( '.astra-full-megamenu-wrapper' ).removeClass( 'astra-megamenu-wrapper-focus' );
    }
    });

    jQuery( container ).find( '.sub-menu .menu-item' ).last().focusout(function() {
        $this.find( '.sub-menu' ).removeClass( 'astra-megamenu-focus' );
        $this.find( '.astra-full-megamenu-wrapper' ).removeClass( 'astra-megamenu-wrapper-focus' );
    });

    jQuery(window).click(function() {
        $this.find( '.sub-menu' ).removeClass( 'astra-megamenu-focus' );
        $this.find( '.astra-full-megamenu-wrapper' ).removeClass( 'astra-megamenu-wrapper-focus' );
    });

    $this.click(function(event){
        event.stopPropagation();
    });
});
