<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


//Menu items filter
if( !function_exists( 'xoo_el_nav_menu_items' ) ):
	function xoo_el_nav_menu_items( $items ) {

		if( empty( $items ) || !is_array( $items ) ) return;


		$actions_classes = array(
			'xoo-el-login-tgr',
			'xoo-el-reg-tgr',
			'xoo-el-lostpw-tgr',
			'xoo-el-logout-menu',
			'xoo-el-myaccount-menu',
			'xoo-el-username-menu',
			'xoo-el-firstname-menu'
		);

		$user = wp_get_current_user();

		foreach ( $items as $key => $item ) {

			$classes = $item->classes;

			if( !empty( $action_class = array_values( array_intersect( $actions_classes, $classes ) ) ) ){

				$action_class = $action_class[0];

				if( is_user_logged_in() ){

					if( $action_class === "xoo-el-myaccount-menu" ){
						//do nothing
						continue;
					}
					elseif( $action_class === "xoo-el-logout-menu" ){
						if( $item->url ) continue;
						$gl_options = get_option('xoo-el-general-options');
						$logout_redirect = !empty( $gl_options['m-logout-url'] ) ? $gl_options['m-logout-url'] : $_SERVER['REQUEST_URI'];
						$item->url = wp_logout_url($logout_redirect);
					}
					elseif( $action_class === "xoo-el-firstname-menu"){
						
						$name = !$user->user_firstname ? $user->user_login : $user->user_firstname;
						$item->title = get_avatar($user->ID).str_replace( 'firstname' , $name , $item->title );
						if( class_exists('woocommerce') ){
							$item->url 	 = wc_get_page_permalink( 'myaccount' );
						}
					}
					elseif( $action_class === "xoo-el-username-menu"){
						$item->title = get_avatar($user->ID).str_replace( 'username' , $user->user_login , $item->title );
						if( class_exists('woocommerce') ){
							$item->url 	 = wc_get_page_permalink( 'myaccount' );
						}
					}
					else{
						unset($items[$key]);
					}

				}
				else{
					if( $action_class === "xoo-el-logout-menu" || $action_class === "xoo-el-myaccount-menu" ||  $action_class === "xoo-el-username-menu"  || $action_class === "xoo-el-firstname-menu"){
						unset($items[$key]);
					}

				}

			}
		}

		return $items;
	}
	add_filter('wp_nav_menu_objects','xoo_el_nav_menu_items',11);
endif;


//Inline Form Shortcode
if( !function_exists( 'xoo_el_inline_form' ) ){
	function xoo_el_inline_form_shortcode($user_atts){

		$atts = shortcode_atts( array(
			'active'	=> 'login',
		), $user_atts, 'xoo_el_inline_form');

		if( is_user_logged_in() ) return;

		$args = array(
			'form_active' 	=> $atts['active'],
			'return' 		=> true
		); 
		
		return xoo_el_get_form( $args );

	}
	add_shortcode( 'xoo_el_inline_form', 'xoo_el_inline_form_shortcode' );
}

//Add notice
function xoo_el_add_notice( $notice_type = 'error', $message, $notice_class = null ){

	$classes = $notice_type === 'error' ? 'xoo-el-notice-error' : 'xoo-el-notice-success';
	
	$classes .= ' '.$notice_class;

	$html = '<div class="'.$classes.'">'.$message.'</div>';
	
	return apply_filters('xoo_el_notice_html',$html,$message,$classes);
}

//Print notices
function xoo_el_notice_container( $form, $form_args, $all_args ){

	$notices = '';

	$notices .= '<div class="xoo-el-notice"></div>';

	echo apply_filters( 'xoo_el_notice_container', $notices, $form );

}

add_action( 'xoo_el_before_form', 'xoo_el_notice_container',10, 3 );



function xoo_el_get_form( $args = array() ){

	$gl_options 	= get_option('xoo-el-general-options');

	$defaults = array(
		'display' 		=> 'inline',
		'form_active' 	=> 'login',
		'return' 		=> false,
		'forms' => array(
			'login' 		=> array(
				'enable' 	=> 'yes'
			),
			'register' 		=> array(
				'enable' => $gl_options['m-en-reg']
			),
			'lostpw' 		=> array(
				'enable' 	=> 'yes'
			)
		)

	);

	$args = wp_parse_args( $args, $defaults );

	return xoo_el_helper()->get_template( 'xoo-el-form.php', array( 'args' => $args ), '', $args['return'] );
}



//Override woocommerce form login template
function xoo_el_override_wc_login_form( $located, $template_name, $args, $template_path, $default_path ){

	$gl_options 	  	= get_option('xoo-el-general-options');
	$enable_myaccount 	= $gl_options['m-en-myaccount-page'];
	$enable_checkout 	= $gl_options['m-en-chk-page'];

	if( ( $template_name === 'myaccount/form-login.php' && $enable_myaccount === "yes" ) || ( $template_name === 'global/form-login.php' && $enable_checkout === "yes" ) ){
		$located = xoo_el_helper()->locate_template( 'xoo-el-wc-form-login.php', XOO_EL_PATH.'/templates/' );
	}
	return $located;
}
add_filter( 'wc_get_template', 'xoo_el_override_wc_login_form', 99999, 5 );


function xoo_el_register_generate_password(){
	if( !class_exists( 'woocommerce' ) ) return;
	$aff = xoo_el()->aff->fields;
	$fields = $aff->get_fields_data();
	if( isset( $fields['xoo_el_reg_pass'] ) && $fields['xoo_el_reg_pass']['settings']['active'] === "no" ){
		add_filter( 'pre_option_woocommerce_registration_generate_password', function(){ return 'yes'; } );
	}
}
add_action( 'init', 'xoo_el_register_generate_password' );



//Auto fil woocommerce fields
function xoo_el_autofill_wc_fields( $customer_id, $customer_data ){
	if( !class_exists( 'woocommerce' ) ) return;
	$customer = new Wc_Customer( $customer_id );
	if( !$customer ) return;

	$aff = xoo_el()->aff->fields;
	$fields = $aff->get_fields_data();
	$firstname = isset( $fields['xoo_el_reg_fname'] ) ? $fields['xoo_el_reg_fname'] : false;
	$lastname = isset( $fields['xoo_el_reg_lname'] ) ? $fields['xoo_el_reg_lname'] : false;

	if( $firstname ){
		if( isset( $firstname['settings']['xoo_el_merge_wc_field'] ) && $firstname['settings']['xoo_el_merge_wc_field'] === "yes" ){
			update_user_meta( $customer_id, 'billing_first_name', $customer->get_first_name() );
			update_user_meta( $customer_id, 'shipping_first_name', $customer->get_first_name() );
		}
	}

	if( $lastname ){
		if( isset( $lastname['settings']['xoo_el_merge_wc_field'] ) && $lastname['settings']['xoo_el_merge_wc_field'] === "yes" ){
			update_user_meta( $customer_id, 'billing_last_name', $customer->get_last_name() );
			update_user_meta( $customer_id, 'shipping_last_name', $customer->get_last_name() );
		}
	}
}
add_action( 'xoo_el_created_customer', 'xoo_el_autofill_wc_fields', 10, 2 );


?>