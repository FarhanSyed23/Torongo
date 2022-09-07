<div class="xoo-tabs">
	<?php

	$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $tabs as $tab_key => $tab_caption ) {
		$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
		echo '<a class="nav-tab ' . $active . '" href="?page=xoo-el&tab=' . $tab_key . '">' . $tab_caption . '</a>';	
	}
	echo '</h2>';

	if( $current_tab === 'advanced' ){
		$option_name = 'premium';
	}
	else{
		$option_name = 'xoo-el-'.$current_tab.'-options';
	}

	?>
</div>

<div class="xoo-container">
	<div class="xoo-main">

		<?php if( $option_name === 'premium' ): ?>

			<?php include(plugin_dir_path(__FILE__).'xoo-el-premium-info.php'); ?>

		<?php else: ?>

			<a style="margin: 15px 10px; display: inline-block;" target="_blank" href="http://docs.xootix.com/easy-login-for-woocommerce/">Documentation</a>

			<a style="color: #9C27B0" href="<?php echo admin_url( 'admin.php?page=xoo-el-fields' ); ?>">Manage Registration Fields</a>

			<?php echo $outdated_section; ?>
			
			<form method="post" action="options.php">
				<?php
					settings_fields( $option_name ); // Display Settings

					do_settings_sections( $option_name ); // Display Sections

					submit_button( 'Save Settings' );	// Display Save Button
				?>			
			</form>

		<?php endif; ?>

		<div class="xoo-el-faqs">
			<ul>

				<li>
					<h4>How to add login/signup links to your menu?</h4>
					<div>Go to apperance->menus & select the desired option from "Login/Signup Popup" tab.</div>
				</li>

				<li>
					<h4>Inline form (Shortcode) </h4>
					<div>
						<span>[xoo_el_inline_form] will generate an inline login/signup form</span>
						<ul class="xoo-el-faq-sc">
							<li>Eg: [xoo_el_inline_form active="register"]</li>
							<li>
								<span>active - Which form to open on front</span>
								<span>values - login, register</span>
							</li>
						</ul>
					</div>
				</li>
				<li>
					<h4>Open Popup (Shortcode)</h4>
					<div>
						<span>[xoo_el_action] will generate a link/button for opening popup</span>
						<ul class="xoo-el-faq-sc">
							<li>Eg: [xoo_el_action type="login" display="button" change_to="logout" change_to_text="Logout"]</li>
							<li>
								<span>display - Display type</span>
								<span>values - link, button</span>
							</li>
							<li>
								<span>type - Which form to open on front</span>
								<span>values - login, register, lost-password</span>
							</li>
							<li>
								<span>change_to - Once logged in, button link should change into</span>
								<span>values - logout, myaccount</span>
								<span>You can also place your custom url, for eg: [xoo_el_action change_to="http://somewherelese.com"]</span>
							</li>
							<li>
								<span>change_to_text  - Once logged in, button text should change into</span>
								<span>Your custom text, for eg: [xoo_el_action change_to_text="my custom page"]</span>
							</li>
						</ul>
					</div>
				</li>

			</ul>
		</div>

	</div>

	<div class="xoo-sidebar">
		<?php include XOO_EL_PATH.'/admin/templates/xoo-el-sidebar.php'; ?>
	</div>
</div>

