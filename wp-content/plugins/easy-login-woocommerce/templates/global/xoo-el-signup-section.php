<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$gl_options = get_option('xoo-el-general-options');
$redirect 	= !empty( $gl_options['m-register-url'] ) ? esc_attr( $gl_options['m-register-url'] ) : $_SERVER['REQUEST_URI'];
$terms_url 	= !empty( $gl_options['m-terms-url'] ) ? esc_attr( $gl_options['m-terms-url'] ) : null;
?>

<div class="xoo-el-fields">
	
	<?php xoo_el_print_notices(); ?>

	<form class="xoo-el-action-form xoo-el-form-register">

		<?php do_action('xoo_el_register_form_start'); ?>

		<?php xoo_el()->aff->fields->get_fields_layout(); ?>

		<input type="hidden" name="_xoo_el_form" value="register">

		<input type="hidden" name="_xoo_el_form_register" value="register">


		<?php do_action('xoo_el_register_add_fields'); ?>


		<button type="submit" class="button btn xoo-el-action-btn xoo-el-register-btn"><?php _e('Sign Up','easy-login-woocommerce'); ?></button>

		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

		<?php do_action('xoo_el_register_form_end'); ?>

	</form>
</div>