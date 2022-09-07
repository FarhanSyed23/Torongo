<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_El_Core{

	protected static $_instance = null;

	public $aff;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	public function __construct(){
		
		if( defined( 'XOO_ML_VERSION' ) && version_compare( XOO_ML_VERSION , '1.3', '<=' ) ){
			add_action( 'admin_notices', array( $this, 'otp_login_update_notice' ) );
			return;
		}

		$this->includes();
		$this->hooks();
	}


	public function includes(){

		//xootix framework
		require_once XOO_EL_PATH.'/includes/xoo-framework/xoo-framework.php';
		require_once XOO_EL_PATH.'/includes/class-xoo-el-helper.php';

		//Field framework
		require_once XOO_EL_PATH.'/xoo-form-fields-fw/xoo-aff.php';
		
		$this->aff = xoo_aff_fire( 'easy-login-woocommerce', 'xoo-el-fields' ); // start framework
		
		require_once XOO_EL_PATH.'includes/xoo-el-functions.php';

		if( $this->is_request('frontend') ){
			require_once XOO_EL_PATH.'includes/class-xoo-el-frontend.php';
			require_once XOO_EL_PATH.'includes/class-xoo-el-form-handler.php';
		}

		if( $this->is_request('admin') ) {

			require_once XOO_EL_PATH.'admin/xoo-el-admin-settings.php';
			require_once XOO_EL_PATH.'admin/class-xoo-el-aff-fields.php';
			require_once XOO_EL_PATH.'admin/includes/class-xoo-el-menu-settings.php';
			
		}

	}


	public function hooks(){
		add_action( 'init', array( $this, 'on_install' ), 0 );
		add_action( 'in_plugin_update_message-easy-login-woocommerce/xoo-el-main.php', array( $this, 'update_notice' ), 10, 2 );
		add_action( 'admin_notices', array( $this, 'show_outdated_template_notice' ) );
		add_action( 'admin_head', array( $this, 'inline_styling' ) );
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


	/**
	* On install
	*/
	public function on_install(){

		$version_option = 'xoo-el-version';
		$db_version 	= get_option( $version_option );

		//If first time install
		if( $db_version === false ){
			add_action( 'admin_notices', array( $this, 'admin_notice_on_install' ) );
		}

		//Check if installed version is lower than the installed version
		if( version_compare( $db_version, '1.3', '<' ) ){
			//Map old values to new option
			$current_gl_value = get_option( 'xoo-el-gl-options' );
			if( $current_gl_value ){
				//changing 1 to yes
				if( isset( $current_gl_value['m-en-reg'] ) && $current_gl_value['m-en-reg'] == '1' ){
					$current_gl_value['m-en-reg'] = 'yes';
				}
				update_option( 'xoo-el-general-options', $current_gl_value );
			}
		}

		if( version_compare( $db_version, XOO_EL_VERSION, '<') ){
			xoo_el()->aff->fields->set_defaults();
			//Update to current version
			update_option( $version_option, XOO_EL_VERSION);
		}
	}



	public function otp_login_update_notice(){
		?>
		<div class="notice is-dismissible notice-warning" style="padding: 10px; font-weight: 600; font-size: 16px; line-height: 2">
			<?php _e( 'This version of login/signup popup is not compatible with the current version of OTP Login plugin. <br>Please update the OTP login plugin.' ); ?>
		</div>
		<?php
	}


	public function admin_notice_on_install(){
		?>
		<div class="notice notice-success is-dismissible xoo-el-admin-notice">
			<p>Start by adding Login/Registration links to your <a href="<?php echo admin_url( 'nav-menus.php?xoo_el_nav=true' ); ?>">menu</a>.</p>
			<p>Check <a href="<?php echo admin_url( 'admin.php?page=xoo-el' ); ?>">Settings & Shortcodes</a></p>
		</div>
		<?php
	}


	public function show_outdated_template_notice(){

		$themeTemplatesData = xoo_el_helper()->get_theme_templates_data();
		if( empty( $themeTemplatesData ) || $themeTemplatesData['has_outdated'] !== 'yes' ) return;
		?>
		<div class="notice notice-success is-dismissible xoo-el-admin-notice">
		<p><?php printf( __( 'You have <a href="%1$s">outdated templates</a> in your theme which are no longer supported. Please fetch a new copy from the plugin folder.<br>Afterwards go to <a href="%1$s">Settings</a> & click on check again. Until then plugin will use the default templates', 'easy-login-woocommerce'  ), admin_url( 'admin.php?page=xoo-el' ) ); ?></p>
		</div>
		<?php
	}



	public function update_notice( $args, $response ){

		//If major update
		$version_parts 		= explode( '.' , XOO_EL_VERSION );
		$version_base 		= (int) $version_parts[0];
		$new_version 		= $args['new_version'];
		$new_version_base 	= (int) $new_version[0];

		if ( version_compare( $version_base, $new_version_base, '>=' ) ) return;

		?>
		<style type="text/css">
			.xoo-el-upc-info {
			    padding: 10px 0;
			    font-size: 14px;
			    line-height: 21px;
			    font-family: monospace;
			}
		</style>
		<div class="xoo-el-up-container">
			<div class="xoo-el-upc-info">
				<?php echo $new_version; ?> is a major update.<br>
				If you see any issues with the plugin or is not working for you, please leave an offline message <a target="_blank" href="http://xootix.com/support/">here</a><br>
			</div>
		</div>
		<?php

	}

	public function inline_styling(){
		?>
		<style type="text/css">
			.notice.xoo-el-admin-notice p {
			    font-size: 16px;
			}
			.notice.xoo-el-admin-notice{
			    border: 2px solid #007cba;
			}
		</style>
		<?php
	}

}


?>