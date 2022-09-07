<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_El_Frontend{

	protected static $_instance = null;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	public function __construct(){
		$this->hooks();
	}

	public function hooks(){
		add_action( 'wp_enqueue_scripts', array($this,'enqueue_styles') );
		add_action( 'wp_enqueue_scripts', array($this,'enqueue_scripts') );
		add_action( 'wp_footer', array($this,'popup_markup') );
		add_shortcode( 'xoo_el_action', array($this,'markup_shortcode') );
		add_filter( 'xoo_easy-login-woocommerce_get_template', array( $this, 'force_plugin_templates_over_outdated' ), 10, 4 );
	}

	//Enqueue stylesheets
	public function enqueue_styles(){

		wp_enqueue_style( 'xoo-el-style', XOO_EL_URL.'/assets/css/xoo-el-style.css', array(), XOO_EL_VERSION ) ;
		wp_enqueue_style( 'xoo-el-fonts', XOO_EL_URL.'/assets/css/xoo-el-fonts.css', array(), XOO_EL_VERSION );

		$gl_options = get_option('xoo-el-general-options');

		$btn_bg_color 		= esc_attr( $gl_options['m-btn-bgcolor'] );
		$btn_txt_color 		= esc_attr( $gl_options['m-btn-txtcolor'] );
		$popup_width 		= esc_attr( $gl_options['m-popup-width'] );
		$popup_height 		= esc_attr( $gl_options['m-popup-height'] );
		$sidebar_img  		= esc_attr( $gl_options['s-sidebar-img']) ;
		$sidebar_width 		= esc_attr( $gl_options['s-sidebar-width'] );
		$sidebar_pos 		= esc_attr( $gl_options['s-sidebar-pos'] );
		$popup_pos 			= esc_attr( $gl_options['s-popup-pos'] );
		$tab_bg_color 		= esc_attr( $gl_options['s-tab-bgcolor'] );
		$tab_actbg_color 	= esc_attr( $gl_options['s-tab-active-bgcolor'] );
		$tab_txt_color 		= esc_attr( $gl_options['s-tab-txtcolor'] );

		$inline_style = "
			button.button.btn.xoo-el-action-btn{
				background-color: {$btn_bg_color};
				color: {$btn_txt_color};
			}
			.xoo-el-inmodal{
				max-width: {$popup_width}px;
				max-height: {$popup_height}px;
			}
			.xoo-el-sidebar{
    			background-image: url({$sidebar_img});
    			min-width: {$sidebar_width}%;
    		}
    		ul.xoo-el-tabs li.xoo-el-active {
    			background-color: {$tab_actbg_color};
    			color: {$tab_txt_color};
    		}
    		ul.xoo-el-tabs {
    			background-color: {$tab_bg_color};
    		}
		";

		if($sidebar_pos == 'right'){
			$inline_style .= "
				.xoo-el-wrap{
					direction: rtl;
				}
				.xoo-el-wrap > div{
					direction: ltr;
				}

			";
		}

		//Hide popup trigger links , if user is logged in
		if( is_user_logged_in() ){
			$inline_style .= "
				.xoo-el-login-tgr, .xoo-el-reg-tgr, .xoo-el-lostpw-tgr{
					display: none!important;
				}
			";
		}


		if($popup_pos  === 'middle'){
			$inline_style .= "
				.xoo-el-modal:before {
				    content: '';
				    display: inline-block;
				    height: 100%;
				    vertical-align: middle;
				    margin-right: -0.25em;
				}
			";
		}
		else{
			$inline_style .= "
				.xoo-el-inmodal{
					margin-top: 40px;
				}

			";
		}

		wp_add_inline_style('xoo-el-style',$inline_style);
	}

	//Enqueue javascript
	public function enqueue_scripts(){

		//Enqueue Form field framework scripts
		xoo_el()->aff->enqueue_scripts();

		//Scrollbar
		if( apply_filters( 'xoo_el_custom_scrollbar', true ) ){
			wp_enqueue_script( 'smooth-scrollbar', XOO_EL_URL.'/library/smooth-scrollbar/smooth-scrollbar.js', array( 'jquery' ), XOO_EL_VERSION, true ); // Main JS
		}

		wp_enqueue_script( 'xoo-el-js', XOO_EL_URL.'/assets/js/xoo-el-js.js', array( 'jquery' ), XOO_EL_VERSION, true );

		wp_localize_script( 'xoo-el-js', 'xoo_el_localize', array(
			'adminurl'  			=> admin_url().'admin-ajax.php',
			'strings'				=> $this->get_js_strings(),
		) );
	}


	//Get Javascript strings
	public function get_js_strings(){
		return array(
			'errors' => array(
				'login' => array(
					'empty' => __('Please fill both the fields','easy-login-woocommerce'), 
				),

				'register' => array(
					'valid_email' 		=> __('Enter valid email address','easy-login-woocommerce'),
					'min_password' 		=> __('Password must be minimum 6 characters.','easy-login-woocommerce'),
					'match_password' 	=> __('Passwords don\'t match.','easy-login-woocommerce'),
					'min_fname' 		=> __('First name must be minimum 3 characters.','easy-login-woocommerce'),
					'min_lname' 		=> __('Last name must be minimum 3 characters.','easy-login-woocommerce'),
					'check_terms' 		=> __('Please accept the terms & conditions.','easy-login-woocommerce'),
				)
			)
		);
	}


	//Add popup to footer
	public function popup_markup(){
		  xoo_el_helper()->get_template( 'xoo-el-popup.php' );
	}

	//Shortcode
	public function markup_shortcode( $user_atts ){

		$atts = shortcode_atts( array(
			'action' 			=> 'login', // For version < 1.3
			'type'				=> 'login',
			'change_to' 		=> 'logout',
			'change_to_text' 	=> '',
			'display' 			=> 'link'
		), $user_atts, 'xoo_el_action');


		$class = 'xoo-el-action-sc ';

		if( $atts['display'] === 'button' ){
			$class .= 'button btn ';
		}

		if( is_user_logged_in() ){

			$change_to_text = esc_attr( $atts['change_to_text'] );

			if( $atts['change_to'] === 'myaccount' ) {
				$change_to_link = wc_get_page_permalink( 'myaccount' );
				$change_to_text =  !empty( $change_to_text ) ? $change_to_text : __('My account','easy-login-woocommerce');
			}
			else if( $atts['change_to'] === 'logout' ){
				$gl_options  	= get_option('xoo-el-general-options');
				$logout_link 	= !empty( $gl_options['m-logout-url'] ) ? $gl_options['m-logout-url'] : $_SERVER['REQUEST_URI'];
				$change_to_link = wp_logout_url( $logout_link );
				$change_to_text =  !empty( $change_to_text ) ? $change_to_text : __('Logout','easy-login-woocommerce');
			}
			else{
				$change_to_link = esc_attr( $atts['change_to'] );
				$change_to_text =  !empty( $change_to_text ) ? $change_to_text : __('Logout','easy-login-woocommerce');
			}

			$html =  '<a href="'.$change_to_link.'" class="'.$class.'">'.$change_to_text.'</a>';
		}
		else{
			$action_type = isset( $user_atts['action'] ) ? $user_atts['action'] : $atts['type'];
			switch ( $action_type ) {
				case 'login':
					$class .= 'xoo-el-login-tgr';
					$text  	= __('Login','easy-login-woocommerce');
					break;

				case 'register':
					$class .= 'xoo-el-reg-tgr';
					$text  	= __('Signup','easy-login-woocommerce');
					break;

				case 'lost-password':
					$class .= 'xoo-el-lostpw-tgr';
					$text 	= __('Lost Password','easy-login-woocommerce');
					break;
				
				default:
					$class .= 'xoo-el-login-tgr';
					$text 	= __('Login','easy-login-woocommerce');
					break;
			}

			$html = '<a class="'.$class.'">'.$text.'</a>';
		}
		return $html;
	}


	public function force_plugin_templates_over_outdated( $template, $template_name, $args, $template_path ){

		$templates_data = xoo_el_helper()->get_theme_templates_data();

		if( empty( $templates_data ) || $templates_data['has_outdated'] !== 'yes' ) return $template;

		$templates = $templates_data['templates'];		

		foreach ( $templates as $template_data ) {
			if( $template_data['is_outdated'] === "yes" && version_compare( $template_data['theme_version'] , '2.0', '<' )  && basename( $template_name ) === $template_data['basename'] && @md5_file( $template ) === @md5_file( $template_data['file'] ) ){
				return XOO_EL_PATH.'/templates/'.$template_name;
			}
		}

		return $template;
	}
}

function xoo_el_frontend(){
	return Xoo_El_Frontend::get_instance();
}

xoo_el_frontend();

?>