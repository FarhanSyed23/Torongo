<?php
/**
 * Contains Header HTML for switching tabs.
 *
 * This template can be overridden by copying it to yourtheme/templates/easy-login-woocommerce/global/xoo-el-header.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/easy-login-woocommerce/
 * @version 2.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$register_args 	= $args['forms']['register'];
$form_active 	= $args['form_active'];

?>

<div class="xoo-el-header">
	<ul class="xoo-el-tabs">

		<li class="xoo-el-login-tgr <?php echo $form_active === 'login' ? 'xoo-el-active' : ''; ?> xoo-el-login-ph"><?php _e( 'Login', 'easy-login-woocommerce' ); ?></li>

		<?php if( isset( $register_args['enable'] ) && $register_args['enable'] === "yes" ): ?> 
			<li class="xoo-el-reg-tgr <?php echo $form_active === 'register' ? 'xoo-el-active' : ''; ?> xoo-el-register-ph"><?php _e( 'Sign Up', 'easy-login-woocommerce' ); ?></li>
		<?php endif; ?>

	</ul>
</div>