<?php

if( class_exists( 'Xoo_Aff_fields' ) ){

	class Xoo_El_Aff_Fields{

		public $fields;

		public function __construct(){
			add_action( 'xoo_aff_easy-login-woocommerce_add_predefined_fields', array( $this, 'add_el_predefined_fields' ) );
			add_filter( 'xoo_aff_easy-login-woocommerce_before_fields_update', array( $this, 'manage_password_field' ) );
		}


		public function manage_password_field( $fields ){
			
			if( class_exists( 'woocommerce' ) ){

				if( $fields[ 'xoo_el_reg_pass' ]['settings']['active'] === "no" ){
					$fields['xoo_el_reg_pass_again']['settings']['active'] = "no";
				}
			}
			return $fields;

		}


		public function add_el_predefined_fields(){
			$this->fields = xoo_el()->aff->fields;
			$this->predefined_field_username();
			$this->predefined_field_useremail();
			$this->predefined_field_firstname();
			$this->predefined_field_lastname();
			$this->predefined_field_userpassword();
			$this->predefined_field_userpasswordagain();
			$this->predefined_mailchimp_subscribe();
			$this->predefined_field_terms();
		}


		public function predefined_field_username(){

			$field_type_id = $field_id = 'xoo_el_reg_username';

			$this->fields->add_type(
				$field_type_id,
				'text',
				'User Name',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-user',
				)
			);
				
			$setting_options = array(
				'active' => array(
					'value' => 'no'
				),
				'label',
				'cols',
				'icon' => array(
					'value' => 'fas fa-user-plus'
				),
				'placeholder' => array(
					'value' => 'Username',
				),
				'unique_id' => array(
					'disabled' => 'disabled',
				),
				'class'
			);

			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_id,
				$field_type_id,
				array(
					'unique_id' => $field_id,
					'required' 	=> 'yes',
				)
			);

		}
		
		public function predefined_field_useremail(){

			$field_type_id = $field_id = 'xoo_el_reg_email';

			$this->fields->add_type(
				$field_type_id,
				'email',
				'User Email',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-at',
				)
			);

			$setting_options = array(	
				'label',
				'cols',
				'icon' => array(
					'value' => 'fas fa-at'
				),
				'placeholder' => array(
					'value' => 'Email',
				),
				'unique_id' => array(
					'disabled' => 'disabled',
				),
				'class'
			);

			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_id,
				$field_type_id,
				array(
					'active' 	=> 'yes',
					'required' 	=> 'yes',
					'unique_id' 	=> $field_id,
				)			
			);

		}

		public function predefined_field_userpassword(){

			$field_type_id = $field_id = 'xoo_el_reg_pass';

			$this->fields->add_type(
				$field_type_id,
				'password',
				'Password',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-key'
				)
			);

			$setting_options = array(
				'label',
				'cols',
				'icon' => array(
					'value' => 'fas fa-key'
				),
				'placeholder' => array(
					'value' => 'Password',
				),
				'unique_id' => array(
					'disabled' => 'disabled',
				),
				'class'
			);


			$settings_value = array(
				'active' 	=> 'yes',
				'required' 	=> 'yes',
				'unique_id' 	=> $field_id,
			);

			if( class_exists( 'woocommerce' ) ){
				$active_setting = array(
					'active' => array(
						'info' => 'If disabled, a password will be sent to user email address.'
					)
				);
				$setting_options = array_merge( $active_setting, $setting_options );
				unset( $settings_value['active'] );
			}


			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_type_id,
				$field_id,
				$settings_value
			);

		}

		public function predefined_field_userpasswordagain(){

			$field_type_id = $field_id = 'xoo_el_reg_pass_again';

			$this->fields->add_type(
				$field_type_id,
				'password',
				'Confirm Password',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-key'
				)
			);

			$setting_options = array(
				'active',
				'label',
				'cols',
				'icon' => array(
					'value' => 'fas fa-key'
				),
				'placeholder' => array(
					'value' => 'Confirm Password',
				),
				'unique_id' => array(	
					'disabled' => 'disabled',
				),
				'class'
			);

			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_id,
				$field_type_id,
				array(
					'required' 	=> 'yes',
					'unique_id' 	=> $field_id,
				)	
			);

		}


		public function predefined_field_firstname(){

			$field_type_id = $field_id = 'xoo_el_reg_fname';

			$this->fields->add_type(
				$field_type_id,
				'text',
				'First Name',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-font',
				)
			);

			$setting_options = array(
				'active',
				'required' => array(				
					'value' => 'yes'
				),
				'label',
				'cols' => array(
					'value' => 'onehalf'
				),
				'icon' => array(
					'value' => 'far fa-user'
				),
				'placeholder' => array(
					'value' => 'First Name',
				),
				'minlength',
				'maxlength',
				'unique_id' => array(
					'disabled' => 'disabled',
				),
				'class'
			);

			$this->merge_with_wc_fields_setting_option( $field_type_id );

			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_id,
				$field_type_id,
				array(
					'unique_id' => $field_id,
				)
			);

		}


		public function predefined_field_lastname(){

			$field_type_id = $field_id = 'xoo_el_reg_lname';

			$this->fields->add_type(
				$field_type_id,
				'text',
				'Last Name',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-font',
				)
			);

			$setting_options = array(
				'active',
				'required' => array(
					'value' => 'yes'
				),
				'label',
				'cols' => array(
					'value' => 'onehalf'
				),
				'icon' => array(
					'value' => 'far fa-user'
				),
				'placeholder' => array(
					'value' => 'Last Name',
				),
				'minlength',
				'maxlength',
				'unique_id' => array(
					'disabled' => 'disabled',
				),
				'class'
			);

			$this->merge_with_wc_fields_setting_option( $field_type_id );

			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_id,
				$field_type_id,
				array(
					'unique_id' => 'xoo_el_reg_lname',
				)
			);

		}


		public function predefined_mailchimp_subscribe(){

			$mailchimp_id = false;

			if( function_exists( 'run_mailchimp_woocommerce' ) ){
				$mailchimp_id = 'mailchimp_woocommerce_newsletter';
			}

			if( function_exists('mc4wp') ){
				$mailchimp_id = class_exists( 'woocommerce' ) ? '_mc4wp_subscribe_wp-registration-form' : 'mc4wp-subscribe';
			}

			//If no mailchimp plugin, return
			if( !$mailchimp_id ) return;

			$field_type_id = $field_id = $mailchimp_id;

			$this->fields->add_type(
				$field_type_id,
				'checkbox_single',
				'Mailchimp Newsletter',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-envelope',
				)
			);

			$setting_options = array(				
				'active',
				'required' => array(
					'value' => 'no'
				),
				'label',
				'placeholder' => array(
					'value' => 'Subscribe to our newsletter',
				),
				'cols',
				'checkbox_single' => array(
					'value' 	=>array(
						'yes' => array(
							'value' 	=> 'yes',
							'label' 	=> 'Subscribe to our newsletter',
							'checked' 	=> false
						)
					)
				),
				'unique_id' => array(
					'disabled' => 'disabled',
				),
				'class'
			);

			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_id,
				$field_type_id,
				array(
					'unique_id' => $field_id,
				)
			);
		}


		public function predefined_field_terms(){

			$field_type_id = $field_id = 'xoo_el_reg_terms';

			$this->fields->add_type(
				$field_type_id,
				'checkbox_single',
				'Terms & Conditions',
				array(
					'is_selectable' => 'no',
					'can_delete'	=> 'no',
					'icon' 			=> 'fas fa-check-square',
				)
			);


			$privacyLink = class_exists( 'woocommerce' ) && function_exists( 'wc_privacy_policy_page_id' ) && wc_privacy_policy_page_id() ? get_page_link( wc_privacy_policy_page_id() ) : 'privacy-policy';

			$setting_options = array(				
				'active',
				'required' => array(
					'value' => 'yes'
				),
				'label',
				'placeholder' => array(
					'value' => 'The Terms & Conditions',
				),
				'cols',
				'checkbox_single' => array(
					'value' 	=>array(
						'yes' => array(
							'value' 	=> 'yes',
							'label' 	=> 'I accept the <a href="'.$privacyLink.'" target="_blank"> Terms of Service and Privacy Policy </a>',
							'checked' 	=> false
						)
					)
				),
				'unique_id' => array(
					'disabled' => 'disabled',
				),
				'class'
			);

			$this->fields->create_field_settings(
				$field_type_id,
				$setting_options
			);

			$this->fields->add_field(
				$field_id,
				$field_type_id,
				array(
					'unique_id' => $field_id,
				)
			);

		}


		public function merge_with_wc_fields_setting_option( $field_type_id ){
			if( !class_exists( 'woocommerce' ) ) return;
			$this->fields->add_setting(
				'xoo_el_merge_wc_field',
				'Auto fill woocommerce billing & shipping fields',
				'checkbox',
				$field_type_id,
				array(
					'priority' 	=> 100,
					'value' 	=> 'yes'
				)
			);
		}


	}

}

new Xoo_El_Aff_Fields();
?>