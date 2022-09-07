<?php
/**
 * Above Header Layout 2
 *
 * This template generates markup required for the Above Header style 2
 *
 * @todo Update this template for Default Above Header Style
 *
 * @package Astra Addon
 */

$section = Astra_Ext_Header_Sections_Markup::get_above_header_section( 'above-header-section-1' );
$value1  = astra_get_option( 'above-header-section-1' );
/**
 * Hide above header markup if:
 *
 * - User is not logged in. [AND]
 * - Sections 1 is set to none
 */
if ( empty( $section ) ) {
	return;
}
?>

<div class="ast-above-header-wrap above-header-2" >
	<div class="ast-above-header">
		<?php do_action( 'astra_above_header_top' ); ?>
		<div class="ast-container">
			<div class="ast-flex ast-above-header-section-wrap">
		<?php if ( $section ) { ?>
					<div class="ast-above-header-section ast-above-header-section-1 ast-flex ast-justify-content-center <?php echo esc_attr( $value1 ); ?>-above-header" >
						<?php echo $section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php } ?>
			</div>
		</div><!-- .ast-container -->
		<?php do_action( 'astra_above_header_bottom' ); ?>
	</div><!-- .ast-above-header -->
</div><!-- .ast-above-header-wrap -->
