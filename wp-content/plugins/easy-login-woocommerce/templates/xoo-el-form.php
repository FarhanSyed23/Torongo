<?php
/**
 * The template is a form container
 *
 * This template can be overridden by copying it to yourtheme/templates/easy-login-woocommerce/xoo-el-form.php.
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

$form_active = $args['form_active'];

?>

<div class="xoo-el-form-container xoo-el-form-<?php echo $args['display']; ?>" data-active="xoo-el-<?php echo $form_active; ?>-ph">

	<?php do_action( 'xoo_el_before_header', $args ); ?>

	<?php xoo_el_helper()->get_template( 'global/xoo-el-header.php', array( 'args' => $args ) ); ?>

	<?php do_action( 'xoo_el_after_header', $args ); ?>

	<?php foreach ( $args['forms'] as $form => $form_args ): ?>

		<?php if( $form_args['enable'] !== 'yes' ) continue; ?>
	
		<div class="xoo-el-section xoo-el-section-<?php echo $form; ?> <?php echo $form_active === $form ? 'xoo-el-active' : ''; ?> xoo-el-<?php echo $form; ?>-ph">

			<div class="xoo-el-fields">

				<?php do_action( 'xoo_el_before_form', $form, $form_args, $args ); ?>

				<form class="xoo-el-action-form xoo-el-form-<?php echo $form; ?>">

					<?php do_action( 'xoo_el_form_start', $form, $form_args, $args ); ?>
					<?php do_action( 'xoo_el_'.$form.'_form_start' ); //old action ?>

					<?php xoo_el_helper()->get_template( 'global/xoo-el-'.$form.'-section.php', array( 'args' => $args ) ); ?>

					<?php do_action( 'xoo_el_form_end', $form ); ?>
					<?php do_action( 'xoo_el_'.$form.'_form_end', $form, $form_args, $args ); //old action ?>

				</form>

				<?php do_action( 'xoo_el_after_form', $form, $form_args ); ?>

			</div>

		</div>

	<?php endforeach; ?>

	<?php do_action( 'xoo_el_container_end', $args ); ?>

</div>