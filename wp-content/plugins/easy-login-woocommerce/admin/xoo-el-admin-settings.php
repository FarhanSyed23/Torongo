<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Xoo_El_Admin_Settings{

	protected static $_instance = null;

	public static $callbacks;
	public $all_options_array = array();
	public $tabs = array();


	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){

		self::$callbacks = include XOO_EL_PATH.'admin/includes/class-xoo-el-callbacks.php';
		$this->set_tabs(); // Set tabs
		$this->hooks();	

	}

	public function hooks(){
		add_action( 'admin_init', array( $this, 'init' ) );
		add_filter( 'plugin_action_links_' . XOO_EL_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
		add_action( 'admin_menu',array($this,'add_menu_page') );
		add_action( 'admin_enqueue_scripts',array( $this,'enqueue_scripts') );
		add_action( 'xoo_el_recaptcha-section_section', array( $this, 'recaptcha_section' ) );
		add_filter( 'xoo_el_setting_args', array( $this, 'custom_setting_functions' ) );

		if( current_user_can( 'manage_options' ) ){
			add_action( 'init', array( $this, 'on_otp_login_activate_deactivate' ), 0 );
			add_action( 'wp_ajax_download_otp_plugin', array( $this, 'download_otp_plugin' ) );
			add_action( 'admin_init', array( $this, 'activate_deactivate_otp_plugin' ) );
		}

		add_action( 'admin_footer', array( $this, 'inline_css' ) );
	}

	public function init(){
		$this->set_default_options();
		$this->display_all_settings();
	}


	public function set_tabs(){

		if( !empty( $this->tabs ) ){
			return $this->tabs;
		}

		$this->tabs = array(
			'general'  => __('General','easy-login-woocommerce'),
			'advanced' => __('Advanced','easy-login-woocommerce'),
		);

	}

	public function set_default_options(){

		$default_options = $this->get_all_options_array();
		if( empty( $default_options ) ) return;

		foreach ($default_options as $option_name => $settings ) {

			//Return current option value from the database
			$option_value = (array) get_option($option_name) ;

			foreach ($settings as $setting) {	
				if( $setting['type'] === 'setting' && isset( $setting['default'] ) && isset( $setting['id'] ) && !isset( $option_value[$setting['id']]) ){
					$option_value[$setting['id']] = $setting['default'];
				}
			}

			update_option( $option_name, $option_value );
			
		}
	}


	public function get_all_options_array(){

		if( !empty( $this->all_options_array ) ){
			return $this->all_options_array;
		}

		foreach ($this->tabs as $key => $title) {

			$path = XOO_EL_PATH.'admin/includes/options/'.$key.'-options.php'; 

			if( file_exists( $path ) ){
				$this->all_options_array[ 'xoo-el-'.$key.'-options' ] = include $path;
			}
		}

		return $this->all_options_array;
	}


	public function enqueue_scripts($hook) {

		//Enqueue Styles only on plugin settings page
		if( $hook != 'toplevel_page_xoo-el' ){
			return;
		}
		
		wp_enqueue_media(); // media gallery
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style( 'xoo-el-admin-style', XOO_EL_URL . '/admin/assets/css/xoo-el-admin-style.css', array(), XOO_EL_VERSION, 'all' );
		wp_enqueue_script( 'xoo-el-admin-js', XOO_EL_URL . '/admin/assets/js/xoo-el-admin-js.js', array( 'jquery','wp-color-picker'), XOO_EL_VERSION, false );
		wp_localize_script('xoo-el-admin-js','xoo_el_admin_localize',array(
			'adminurl'  => admin_url().'admin-ajax.php',
		));

	}


	public function add_menu_page(){

		add_menu_page( 
			'Login/Signup Popup Settings', //Page Title
			'Login/Signup Popup', // Menu Titlle
			'manage_options',// capability
			'xoo-el', // Menu Slug
			null,
			null
		);


		add_submenu_page(
			'xoo-el',
			'Settings',
			'Settings',
    		'manage_options',
    		'xoo-el',
    		array( $this, 'menu_page_callback' )
    	);


    	add_submenu_page(
			'xoo-el',
			'Fields',
			'Fields',
    		'manage_options',
    		'xoo-el-fields',
    		array( $this, 'admin_fields_page' )
    	);

	}


	public function menu_page_callback(){

		$args = array(
			'tabs' 					=> $this->tabs,
			'outdated_section' 		=> xoo_el_helper()->get_outdated_section()
		);

		xoo_el_helper()->get_template( "xoo-el-admin-display.php", $args, XOO_EL_PATH.'/admin/templates/' );
	}

	public function admin_fields_page(){
		?>
		<div class="xoo-fields-pro-notice" style="display: none;">
			Adding custom fields is a PRO feature.<br>
			<a target="_blank" href="https://xootix.com/plugins/easy-login-for-woocommerce">Buy</a>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('button.xoo-aff-add-field').click(function(){
					$('.xoo-fields-pro-notice').show();
				})
			})
		</script>
		<?php
		xoo_el()->aff->admin->display_page();
	}


	public function display_all_settings(){

		$default_options = $this->get_all_options_array();

		foreach ( $default_options as $option_name => $settings ) {
			$this->generate_settings( $settings, $option_name, $option_name, $option_name);
		}
	}


	public function generate_settings( $setting_fields, $page, $group, $option_name ){

		if(empty($setting_fields)){
			return;
		}

		foreach ($setting_fields as $field) {

			//Arguments for add_settings_field
			$args = $field;

			if( !isset($field['id']) || !isset($field['type']) || !isset($field['callback']) ) {
				continue;
			}

			//Check for callback functions
			if( is_callable( array( self::$callbacks, $field['callback'] ) ) ){
				$callback = array( self::$callbacks, $field['callback'] );
			}
			elseif ( is_callable( $field['callback'] ) ) {
				$callback = $field['callback'];
			}
			else{
				continue;
			}

			$title = isset($field['title']) ? $field['title'] : null;

			
			//Add a section
			if( $field['type'] === 'section' ){

				$section_args = array(
					'id' 		=> $field['id'],
					'title' 	=> $title,
					'callback' 	=> $callback,
					'page' 		=>$page
				);

				$section_args = apply_filters( 'xoo_el_section_args', $section_args );
				call_user_func_array( 'add_settings_section', array_values( $section_args ) );

			}

			//Add a setting field
			elseif( $field['type'] === 'setting' ){

				$setting_args = array(
					'id' 		=> $field['id'],
					'title' 	=> $title,
					'callback' 	=> $callback,
					'page' 		=> $page,
					'section' 	=> $field['section'],
					'args' 		=> $args
				);

				$setting_args = apply_filters( 'xoo_el_setting_args', $setting_args );
				
				call_user_func_array( 'add_settings_field', array_values( $setting_args ) );

			}

		}

		register_setting( $group, $option_name);

	}


	/**
	 * Show action links on the plugin screen.
	 *
	 * @param	mixed $links Plugin Action links
	 * @return	array
	 */
	public function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=xoo-el' ) . '">' . __('Settings', 'easy-login-woocommerce' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}



	public function custom_setting_functions( $args ){
		if( $args['id'] === 'm-en-otp-login' ){
			$args['callback'] = array( $this, 'otp_login_download_setting' );
		}
		return $args;
	}

	//Modify  output for phone operator setting
	public function otp_login_download_setting( $args ){

		$html = call_user_func( array( self::$callbacks, $args['callback'] ), $args );
		ob_start();
		?>
		<div class="xoo-el-links">
		<?php if( !is_dir( WP_PLUGIN_DIR.'/mobile-login-woocommerce' ) && !is_dir( WP_PLUGIN_DIR.'/mobile-login-woocommerce-premium' )  ): ?>
			<a class="xoo-el-otp-dwnld">Download Plugin</a>
		<?php else: ?>

			<?php if( !class_exists( 'Xoo_Ml' ) ): ?>
				<a href="<?php echo esc_url( add_query_arg( 'xoo_otp_login', 'activate' ) ); ?>" class="button button-alert">Activate</a>
			<?php else: ?>
				<a href="<?php echo admin_url( 'admin.php?page=xoo-ml' ); ?>">Settings</a>
				<a href="http://docs.xootix.com/mobile-login-for-woocommerce/" target="_blank">Documentation</a>
				<a href="<?php echo esc_url( add_query_arg( 'xoo_otp_login', 'deactivate' ) ); ?>" class="button button-alert">Deactivate</a>
			<?php endif; ?>

		<?php endif; ?>
		<div class="xoo-el-notice"></div>
		</div>
		<?php
		$html .= ob_get_clean();
		echo $html;
	}


	public function download_otp_plugin(){

		try {

			// If the function it's not available, require it.
			if ( ! function_exists( 'download_url' ) ) {
			    require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			//Download
			$permfile 		= WP_PLUGIN_DIR.'/mobile-login-woocommerce.zip';
			$tmpfile 		= download_url( 'https://downloads.wordpress.org/plugin/mobile-login-woocommerce.zip', $timeout = 300 );

			//Check if download was succesfull
			if( is_wp_error( $tmpfile ) ){
				return $tmpfile;
			}
			copy( $tmpfile, $permfile );
			unlink( $tmpfile ); // must unlink afterwards

			//Unzip
			WP_Filesystem();
			$unzipfile = unzip_file( $permfile, WP_PLUGIN_DIR );

			if( is_wp_error( $unzipfile ) ){
				throw new Xoo_Exception( $unzipfile );	
			}

			//All good
			wp_send_json( array(
				'error' 	=> 0,
				'notice' 	=> $this->get_otp_plugin_activate_link()
			) );

		} catch ( Xoo_Exception $e) {
			wp_send_json( array(
				'error' 	=> 1,
				'notice' 	=> $e->getMessage()
			) );
		}
		

	}

	public function on_otp_login_activate_deactivate(){
		if( get_option( 'xoo_ml_el_refresh_fields' ) === false ) return;
		xoo_el()->aff->fields->set_defaults();
		delete_option( 'xoo_ml_el_refresh_fields' );
	}


	public function activate_deactivate_otp_plugin(){

		if( !isset( $_GET['xoo_otp_login'] ) ) return;

		$action = $_GET['xoo_otp_login'] === 'activate' ? 'activate_plugin' : 'deactivate_plugins';

		if( is_dir( WP_PLUGIN_DIR.'/mobile-login-woocommerce-premium' ) && ( $action === 'activate_plugin' || defined( 'XOO_ML_PRO' ) ) ){
			call_user_func( $action, 'mobile-login-woocommerce-premium/xoo-ml-main.php' );
		}
		else{
			call_user_func( $action, 'mobile-login-woocommerce/xoo-ml-main.php' );
		}

		wp_safe_redirect( remove_query_arg( 'xoo_otp_login' ) );

	}

	//Inline CSS
	public function inline_css(){
		?>
		<style type="text/css">

			<?php if( isset( $_GET['xoo_el_nav'] ) ): ?>
				li#xoo_el_actions_link .accordion-section-title {
				    background-color: #007cba;
				    color: #fff;
				}
			<?php endif; ?>

			<?php if( isset( $_GET['page'] ) && $_GET['page'] === 'xoo-el-fields' ): ?>
				form.xoo-aff-general-form-settings table tr:not(:first-child) {
				    opacity: 0.6!important;
				    pointer-events: none!important;
				}
				form.xoo-aff-general-form-settings table tr:nth-child(2) td:before{
				    content: "Pro settings";
				    color: #2196F3;
				    font-size: 17px;
				    text-transform: uppercase;
				    display: block;
				    clear: both;
				    margin-bottom: 10px;
				    font-weight: bold;
				}

				.xoo-fields-pro-notice {
				    display: block;
				    font-size: 18px;
				    padding: 20px 10px 0 0;
				    color: #6495ed;
				    font-weight: 600;
				    text-align: center;
				}

				.xoo-fields-pro-notice a {
				    text-transform: uppercase;
				    margin: 10px;
				    display: inline-block;
				}
			<?php endif; ?>

		</style>
		<?php
	}

}

function xoo_el_admin_settings(){
	return Xoo_El_Admin_Settings::get_instance();
}
xoo_el_admin_settings();

?>