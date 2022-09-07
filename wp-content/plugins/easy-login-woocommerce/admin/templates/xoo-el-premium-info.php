<div class="xoo-wsc-prem">
	<div class="xoo-hero-btns">
		<a class="buy-prem button button-primary button-hero" href="http://demo.xootix.com/easy-login-for-woocommerce/">LIVE DEMO</a>
		<a class="live-demo button button-primary button-hero" href="http://xootix.com/plugins/easy-login-for-woocommerce/">BUY PREMIUM - 18$</a>
	</div>

	<!-- Free V/s Premium -->
	<div class="xoo-fvsp">
		<span class="xoo-fvsp-head">Free V/s Premium</span>

		<?php

		$table_content = array(
			array('Fully Ajaxed','yes','yes'),
			array('Add custom registration fields.','no','yes','alert'),
			array('Login via social accounts.','no','yes','alert'),
			array('Google Recaptcha - Protect spam from bots.','no','yes','alert'),
			array('Password Strength Indicator','no','yes','alert'),
			array('Auto Open Popup on checkout & other custom pages.','no','yes','alert'),
			array('Reset Password within form','no','yes','alert'),
			array('Limit Login Attempts - Reduce server load from unnecessary login attempts','no','yes','alert'),
			array('Other Customization options.','no','yes','alert'),
		);

		?>

		<table class="xoo-fvsp-table">
			<thead>
				<tr>
					<th></th>
					<th>Free</th>
					<th>Premium</th>
				</tr>
			</thead>

			<tbody>
				<?php 
					$html = '';
					foreach ($table_content as $table_row) {
						$html .= '<tr>';
						$alert = isset($table_row[3]) ? 'class=xfp-alert' : '';
						$html .= '<td '.$alert.'>'.$table_row[0].'</td>';
						$html .= '<td class="xfp-'.$table_row[1].'"><span class="dashicons dashicons-'.$table_row[1].'"></span></td>';
						$html .= '<td class="xfp-'.$table_row[2].'"><span class="dashicons dashicons-'.$table_row[2].'"></span></td>';
						$html .= '</tr>';
					}

					echo $html;
				?>
			</tbody>

		</table>

	</div>

</div>