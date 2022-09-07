<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$option_name = 'xoo-el-general-options';

$editable_roles = array_reverse( get_editable_roles() );
foreach ( $editable_roles as $role_id => $role_data) {
	$user_roles[$role_id] = translate_user_role( $role_data['name'] );
}
$user_roles = apply_filters( 'xoo_el_user_roles', $user_roles );

$settings = array(
	
	array(
		'type' 			=> 'section',
		'callback' 		=> 'section',
		'id' 			=> 'main-section',
		'title' 		=> 'Main',
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'checkbox',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-en-reg',
		'title' 		=> 'Enable Registration',
		'default' 		=> 'yes'
	),


	array(
		'type' 			=> 'setting',
		'callback' 		=> 'checkbox',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-en-otp-login',
		'title' 		=> 'OTP Login',
		'default' 		=> 'yes'
	),

	array(
		'type' 			=> class_exists( 'woocommerce' ) ? 'setting' : 'trash',
		'callback' 		=> 'checkbox',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-en-myaccount-page',
		'title' 		=> 'Replace with WC myaccount form',
		'default' 		=> 'yes',
		'desc'			=> 'If checked , this will replace woocommerce myaccount page form.'
	),


	array(
		'type' 			=> class_exists( 'woocommerce' ) ? 'setting' : 'trash',
		'callback' 		=> 'checkbox',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-en-chk-page',
		'title' 		=> 'Replace with checkout login form',
		'default' 		=> 'no',
		'desc'			=> 'If checked & login on checkout is enabled, this will replace login form.'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'checkbox',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-en-auto-login',
		'title' 		=> 'Auto login user on signup',
		'default' 		=> 'yes',
		'desc'			=> ''
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'select',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-user-role',
		'title' 		=> 'User Role',
		'default' 		=> class_exists( 'woocommerce' ) ? 'customer' : 'subscriber',
		'extra'			=> array(
			'options' => $user_roles	
		)
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'text',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-login-url',
		'title' 		=> 'Login Redirect',
		'desc' 			=> 'Leave empty to redirect on the same page'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'text',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-register-url',
		'title' 		=> 'Register Redirect',
		'desc' 			=> 'Leave empty to redirect on the same page'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'text',
		'section' 		=> 'main-section',
		'option_name' 	=> $option_name,
		'id' 			=> 'm-logout-url',
		'title' 		=> 'Logout Redirect',
		'desc' 			=> 'Leave empty to redirect on the same page'
	),


	array(
		'type' 			=> 'section',
		'callback' 		=> 'section',
		'id' 			=> 'style-section',
		'title' 		=> 'Style',
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'select',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 's-popup-pos',
		'title' 		=> 'Popup Position',
		'default' 		=> 'middle',
		'extra'			=> array(
			'options' => array(
				'top'  => 'Top',
				'middle' => 'Middle',
			)	
		)
	),

	array(
		'type' 			=> 'setting',	
		'callback' 		=> 'color',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 's-tab-bgcolor',
		'title' 		=> 'Tabs BG Color',
		'default' 		=> ' #eee'
	),


	array(
		'type' 			=> 'setting',	
		'callback' 		=> 'color',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 's-tab-active-bgcolor',
		'title' 		=> 'Active Tab BG Color',
		'default' 		=> '#528FF0'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'color',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 's-tab-txtcolor',
		'title' 		=> 'Tabs Text Color',
		'default' 		=> '#fff'
	),


	array(
		'type' 			=> 'setting',	
		'callback' 		=> 'color',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 'm-btn-bgcolor',
		'title' 		=> 'Button Background Color',
		'default' 		=> '#333'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'color',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 'm-btn-txtcolor',
		'title' 		=> 'Button Text Color',
		'default' 		=> '#fff'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'number',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 'm-popup-width',
		'title' 		=> 'Pop Up Width',
		'default' 		=> '800',
		'desc'			=> 'Size in px'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'number',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 'm-popup-height',
		'title' 		=> 'Pop Up Height',
		'default' 		=> '600',
		'desc'			=> 'Size in px'
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'upload',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 's-sidebar-img',
		'title' 		=> 'Sidebar Image',
		'default' 		=> XOO_EL_URL.'/assets/images/popup-sidebar.png',
		'desc'			=> 'Supported format: JPEG,PNG',
		'extra'			=> array(
			'upload_type' => 'image'
		)
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'select',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 's-sidebar-pos',
		'title' 		=> 'Sidebar Position',
		'default' 		=> 'left',
		'extra'			=> array(
			'options' => array('left','right')	
		)
	),

	array(
		'type' 			=> 'setting',
		'callback' 		=> 'number',
		'section' 		=> 'style-section',
		'option_name' 	=> $option_name,
		'id'			=> 's-sidebar-width',
		'title' 		=> 'Sidebar Width',
		'default' 		=> '40',
		'desc'			=> 'Width in percentage'
	),

);

return $settings;

?>