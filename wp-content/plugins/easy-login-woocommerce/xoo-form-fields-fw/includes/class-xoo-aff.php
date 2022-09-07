<?php

class Xoo_Aff{

	public $plugin_slug, $admin_page_slug, $fields, $admin;

	public function __construct( $plugin_slug, $admin_page_slug ){

		$this->plugin_slug = $plugin_slug;
		$this->admin_page_slug = $admin_page_slug;

		$this->includes();
		$this->hooks();
		$this->init();
		
	}

	public function hooks(){
		add_action( 'init', array( $this, 'on_install' ), 1 );
	}

	public function includes(){

		include_once XOO_AFF_DIR.'/includes/xoo-aff-functions.php';
		include_once XOO_AFF_DIR.'/admin/class-xoo-aff-fields.php';
		include_once XOO_AFF_DIR.'/admin/class-xoo-aff-admin.php';

	}

	public function init(){

		$this->fields 		= new Xoo_Aff_Fields( $this );
		$this->admin 		= new Xoo_Aff_Admin( $this );
		
	}


	public function is_fields_page(){
		return is_admin() && isset( $_GET['page'] ) && $_GET['page'] === $this->admin_page_slug;
	}


	public function is_fields_page_ajax_request(){
		return isset( $_POST['plugin_info'] ) && $_POST['plugin_info']['admin_page_slug'] === $this->admin_page_slug;
	}


	//Enqueue scripts from the main plugin
	public function enqueue_scripts(){

		$sy_options 	= get_option( $this->admin->settings->get_option_key( 'general' ) );

		wp_enqueue_style( 'xoo-aff-style', XOO_AFF_URL.'/assets/css/xoo-aff-style.css', array(), XOO_AFF_VERSION) ;

		if( $sy_options['s-show-icons'] === "yes" ){
			wp_enqueue_style( 'xoo-aff-font-awesome5', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css' );
		}


		$fields = $this->fields->get_fields_data();

		$has_date = false;
		if( !empty( $fields ) ){
			foreach ( $fields as $field_id => $field_data) {
				if( !isset( $field_data['input_type'] ) ) continue;
				if( $field_data['input_type'] === "date" ){
					$has_date = true;
					break;
				}
			}
		}

		if( $has_date ){
			wp_enqueue_style( 'jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css' );
			wp_enqueue_script('jquery-ui-datepicker');
		}

		if( !wp_style_is( 'select2' ) ){
			wp_enqueue_style( 'select2', "https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" );
		}

		if( !wp_script_is( 'select2' ) ){
			wp_enqueue_script( 'select2', "https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js", array('jquery'), XOO_AFF_VERSION, true ); // Main JS
		}

		wp_enqueue_script( 'xoo-aff-js', XOO_AFF_URL.'/assets/js/xoo-aff-js.js', array( 'jquery' ), XOO_AFF_VERSION, true );
		wp_localize_script('xoo-aff-js','xoo_aff_localize',array(
			'adminurl'  			=> admin_url().'admin-ajax.php',
			'countries' 			=> json_encode( include XOO_AFF_DIR.'/countries/countries.php' ),
			'states' 				=> json_encode( include XOO_AFF_DIR.'/countries/states.php' ),
			'password_strength' 	=> array(
				'min_password_strength' => apply_filters( 'xoo_aff_'.$this->plugin_slug.'_min_password_strength', 3 ),
				'i18n_password_error'   => esc_attr__( 'Please enter a stronger password.', $this->plugin_slug ),
				'i18n_password_hint'    => esc_attr( wp_get_password_hint() ),
			)
		));

		$iconbgcolor 	= esc_attr( $sy_options['s-icon-bgcolor'] );
		$iconcolor 		= esc_attr( $sy_options['s-icon-color'] );
		$iconsize 		= esc_attr( $sy_options['s-icon-size'] );
		$iconwidth 		= esc_attr( $sy_options['s-icon-width'] );
		$iconborcolor	= esc_attr( $sy_options['s-icon-borcolor'] );
		$fieldmargin 	= esc_attr( $sy_options['s-field-bmargin'] );
		$inputbgcolor 	= esc_attr( $sy_options['s-input-bgcolor'] );
		$inputtxtcolor 	= esc_attr( $sy_options['s-input-txtcolor'] );
		$focusbgcolor 	= esc_attr( $sy_options['s-input-focusbgcolor'] );
		$focustxtcolor 	= esc_attr( $sy_options['s-input-focustxtcolor'] );

		$inline_style 	=  '
			.xoo-aff-input-group .xoo-aff-input-icon{
				background-color: '.$iconbgcolor.';
				color: '.$iconcolor.';
				max-width: '.$iconwidth.'px;
				min-width: '.$iconwidth.'px;
				border: 1px solid '.$iconborcolor.';
				border-right: 0;
				font-size: '.$iconsize.'px;
			}
			.xoo-aff-group{
				margin-bottom: '.$fieldmargin.'px;
			}
			.xoo-aff-group input[type="text"], .xoo-aff-group input[type="password"], .xoo-aff-group input[type="email"], .xoo-aff-group input[type="number"], .xoo-aff-group select, , .xoo-aff-group select + .select2{
				background-color: '.$inputbgcolor.';
				color: '.$inputtxtcolor.';
			}

			.xoo-aff-group input[type="text"]::placeholder, .xoo-aff-group input[type="password"]::placeholder, .xoo-aff-group input[type="email"]::placeholder, .xoo-aff-group input[type="number"]::placeholder, .xoo-aff-group select::placeholder{
				color: '.$inputtxtcolor.';
				opacity: 0.7;
			}

			.xoo-aff-group input[type="text"]:focus, .xoo-aff-group input[type="password"]:focus, .xoo-aff-group input[type="email"]:focus, .xoo-aff-group input[type="number"]:focus, .xoo-aff-group select:focus, , .xoo-aff-group select + .select2:focus{
				background-color: '.$focusbgcolor.';
				color: '.$focustxtcolor.';
			}

		';

		if( $sy_options['s-show-icons'] !== "yes" ){
			$inline_style .= '
				.xoo-aff-input-group .xoo-aff-input-icon{
					display: none!important;
				}
			';
		}else{
			$inline_style .= '
				.xoo-aff-group input[type="text"], .xoo-aff-group input[type="password"], .xoo-aff-group input[type="email"], .xoo-aff-group input[type="number"], .xoo-aff-group select{
					border-bottom-left-radius: 0;
    				border-top-left-radius: 0;
				}
			';
		}
		wp_add_inline_style( 'xoo-aff-style', $inline_style );

	}


	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}


	public function on_install(){

		$db_version = get_option( 'xoo_aff_'.$this->plugin_slug.'_version' );
		
		if( version_compare( $db_version, XOO_AFF_VERSION , '<' ) ){
			$this->fields->set_defaults();
			update_option( 'xoo_aff_'.$this->plugin_slug.'_version', XOO_AFF_VERSION );
		}
	}

}


?>