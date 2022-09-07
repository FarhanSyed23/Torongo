<style id="formCustomCSS"></style>
<div class="noptin-form-designer-loader">
	<div class="noptin-spinner"></div>
</div>
<div class="noptin-popup-designer">
	<div id="noptin-form-editor">
		<div v-if="!isPreviewShowing">
			<div class="noptin-popup-editor-header" tabindex="-1">
				<div class="noptin-popup-editor-title">
					<textarea class="noptin-popup-editor-main-preview-name-textarea" v-model="optinName"
						placeholder="Enter Form Name" rows="1" style="" spellcheck="false"></textarea>
					<button @click="saveAsTemplate()" title="Allows you to reuse this design on your other forms"
						type="button"
						class="button button-link noptin-popup-editor-header-button">{{saveAsTemplateText}}</button>
				</div>
				<div class="noptin-popup-editor-toolbar">
					<button v-if="optinType == 'popup'" @click="previewPopup()" type="button"
						class="button button-secondary noptin-popup-editor-header-button">{{previewText}}</button>
					<button v-if="optinStatus" @click.prevent="unpublish" type="button"
						class="button button-link noptin-popup-editor-header-button"><?php _e( 'Switch to Draft', 'newsletter-optin-box' );?></button>
					<button v-if="!optinStatus" @click.prevent="publish" type="button"
						class="button button-primary noptin-popup-editor-header-button"><?php _e( 'Publish Form', 'newsletter-optin-box' );?></button>
					<button @click="save()" type="button"
						:class="{'button-primary': optinStatus}"
						class="button noptin-popup-editor-header-button"><span v-if='optinStatus'>{{saveText}}</span><span v-if='!optinStatus'><?php _e( 'Save Draft', 'newsletter-optin-box' );?></span></button>
				</div>
			</div>
			<div class="noptin-divider"></div>
			<div class="noptin-popup-editor-body">
				<div class="noptin-popup-editor-main">
					<div class="noptin-popup-editor-main-preview">
						<div class="noptin-popup-notice noptin-is-error" v-show="hasError" v-html="Error"></div>
						<div class="noptin-popup-notice noptin-is-success" v-show="hasSuccess" v-html="Success"></div>
						<div class="noptin-popup-wrapper">
							<?php include 'optin-form.php'; ?>
						</div>
						<div class="noptin-form-usage-details">
							<p v-if="optinType=='inpost'"><?php _e( 'Shortcode', 'newsletter-optin-box' ); ?> <strong @click="copyShortcode">[noptin-form id={{id}}]</strong> <button
									class="noptin-copy-button"><?php _e( 'Copied', 'newsletter-optin-box' ); ?></button></p>
							<p v-if="optinType=='sidebar'">
								<?php
									printf(
										/* Translators: %s Widget name name. */
										__( 'Use the %s widget to add this form to a widget area', 'newsletter-optin-box' ),
										'<strong>Noptin Premade Form</strong>'
									);
								?>
							</p>
						</div>
					</div>
				</div>
				<div class="noptin-popup-editor-sidebar">
					<div class="noptin-popup-editor-sidebar-header">
						<ul>
							<?php
							foreach ( array_keys( $sidebar ) as $panel ) {
								$_panel = ucfirst( $panel );

								if ( $sidebar[ $panel ]['label'] ) {
									$_panel = $sidebar[ $panel ]['label'];
								}

								echo "
                                    <li>
                                        <button
                                            class='noptin-popup-editor-sidebar-section-header noptin-popup-editor-sidebar-{$panel}'
                                            :class=\"{ active: currentSidebarSection == '$panel' }\"
                                            @click.prevent=\"currentSidebarSection = '$panel'\">$_panel</button>
                                    </li>
                                ";
							}
							?>
						</ul>
					</div>
					<div class="noptin-popup-editor-sidebar-body noptin-fields">

						<?php
						foreach ( $sidebar as $panel => $fields ) {
							echo " <div class='noptin-popup-editor-{$panel}-fields'  v-show=\"'{$panel}'==currentSidebarSection\">";


							if ( isset( $fields['label'] ) ) {
								unset( $fields['label'] );
							}

							foreach ( $fields as $id => $field ) {
								Noptin_Vue::render_el( $id, $field, $panel );
							}
							echo '</div>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div id="noptin-popup-preview" class="noptin-popup-main-wrapper" :style="{backgroundColor: noptinOverlayBg,backgroundImage: 'url(' + noptinOverlayBgImg + ')'}"></div>
	</div>
</div>

<script type="text/x-template" id="noptinFieldEditorTemplate">
	<?php include 'fields-editor.php'; ?>
</script>
