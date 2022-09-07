<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_El_Actions{

	public function __construct(){
		add_action('wp_ajax_xoo_el_form_action',array($this,'form_action'));
		add_action('wp_ajax_nopriv_xoo_el_form_action',array($this,'form_action'));
	}

	//Process form
	public function form_action(){

		if(!isset($_POST['_xoo_el_form'])) return;

		$form_action = sanitize_text_field($_POST['_xoo_el_form']);

		switch ($form_action) {
			case 'login':
				$action = Xoo_El_Form_Handler::process_login();
				break;

			case 'register':
				$action = Xoo_El_Form_Handler::process_registration();
				break;

			case 'lostPassword':
				$action = Xoo_El_Form_Handler::process_lost_password();
				break;
		}

		wp_send_json($action);
		
		die();

	}

}

new Xoo_El_Actions();

?>