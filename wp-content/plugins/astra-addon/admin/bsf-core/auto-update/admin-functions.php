<?php
/**
 * Admin functions.
 *
 * @package BSF core
 */

if ( ! function_exists( 'bsf_generate_rand_token' ) ) {
	/**
	 * Generate 32 characters random token.
	 *
	 * @return string
	 */
	function bsf_generate_rand_token() {
		$valid_characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$token            = '';
		$length           = 32;
		for ( $n = 1; $n < $length; $n++ ) {
			$which_character = wp_rand( 0, strlen( $valid_characters ) - 1 );
			$token          .= $valid_characters[ $which_character ];
		}
		return $token;
	}
}

/**
 * Update version numbers of all the brainstorm products in options `brainstorm_products` and `brainstrom_bundled_products`
 *
 * @todo Current version numbers can be fetched from WordPress at runtime whenever ruquired,
 *          Remote version can only be required when transient for update data is deleted (i hope)
 */
if ( ! function_exists( 'bsf_update_all_product_version' ) ) {

	/**
	 * Updates all product versions.
	 *
	 * @return void
	 */
	function bsf_update_all_product_version() {

		$brainstrom_products         = ( get_option( 'brainstrom_products' ) ) ? get_option( 'brainstrom_products' ) : array();
		$brainstrom_bundled_products = ( get_option( 'brainstrom_bundled_products' ) ) ? get_option( 'brainstrom_bundled_products' ) : array();

		$mix_products       = array();
		$update_ready       = array();
		$bsf_product_themes = array();
		$bsf_product_themes = array();

		if ( ! empty( $brainstrom_products ) ) :
			$bsf_product_plugins = ( isset( $brainstrom_products['plugins'] ) ) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes  = ( isset( $brainstrom_products['themes'] ) ) ? $brainstrom_products['themes'] : array();
		endif;

		$product_updated         = false;
		$bundled_product_updated = false;

		if ( ! empty( $bsf_product_plugins ) ) {

			foreach ( $bsf_product_plugins as $key => $plugin ) {
				if ( ! isset( $plugin['id'] ) || empty( $plugin['id'] ) ) {
					continue;
				}
				if ( ! isset( $plugin['template'] ) || empty( $plugin['template'] ) ) {
					continue;
				}
				if ( ! isset( $plugin['type'] ) || empty( $plugin['type'] ) ) {
					continue;
				}
				$version         = ( isset( $plugin['version'] ) ) ? $plugin['version'] : '';
				$current_version = bsf_get_current_version( $plugin['template'], $plugin['type'] );
				$name            = bsf_get_current_name( $plugin['template'], $plugin['type'] );
				if ( '' !== $name ) {
					$brainstrom_products['plugins'][ $key ]['product_name'] = $name;
				}
				if ( '' !== $current_version ) {
					if ( version_compare( $version, $current_version ) === - 1 || 1 === version_compare( $version, $current_version ) ) {
						$brainstrom_products['plugins'][ $key ]['version'] = $current_version;
						$product_updated                                   = true;
					}
				}
			}
		}

		if ( ! empty( $bsf_product_themes ) ) {

			foreach ( $bsf_product_themes as $key => $theme ) {
				if ( ! isset( $theme['id'] ) || empty( $theme['id'] ) ) {
					continue;
				}
				if ( ! isset( $theme['template'] ) || empty( $theme['template'] ) ) {
					continue;
				}
				if ( ! isset( $theme['type'] ) || empty( $theme['type'] ) ) {
					continue;
				}
				$version         = ( isset( $theme['version'] ) ) ? $theme['version'] : '';
				$current_version = bsf_get_current_version( $theme['template'], $theme['type'] );
				$name            = bsf_get_current_name( $theme['template'], $theme['type'] );
				if ( '' !== $name ) {
					$brainstrom_products['themes'][ $key ]['product_name'] = $name;
				}
				if ( '' !== $current_version || false !== $current_version ) {
					if ( version_compare( $version, $current_version ) === - 1 || 1 === version_compare( $version, $current_version ) ) {
						$brainstrom_products['themes'][ $key ]['version'] = $current_version;
						$product_updated                                  = true;
					}
				}
			}
		}

		if ( ! empty( $brainstrom_bundled_products ) ) {

			foreach ( $brainstrom_bundled_products as $keys => $bps ) {
				$version = '';
				if ( strlen( $keys ) > 1 ) {
					foreach ( $bps as $key => $bp ) {
						if ( ! isset( $bp->id ) || '' === $bp->id ) {
							continue;
						}
						$version         = $bp->version;
						$current_version = bsf_get_current_version( $bp->init, $bp->type );

						if ( '' !== $current_version && false !== $current_version ) {
							if ( 1 === - version_compare( $version, $current_version ) || 1 === version_compare( $version, $current_version ) ) {
								if ( is_object( $brainstrom_bundled_products ) ) {
									$brainstrom_bundled_products = array( $brainstrom_bundled_products );
								}
								$single_bp                            = $brainstrom_bundled_products[ $keys ];
								$single_bp[ $key ]->version           = $current_version;
								$bundled_product_updated              = true;
								$brainstrom_bundled_products[ $keys ] = $single_bp;
							}
						}
					}
				} else {
					if ( ! isset( $bps->id ) || '' === $bps->id ) {
						continue;
					}
					$version         = $bps->version;
					$current_version = bsf_get_current_version( $bps->init, $bps->type );
					if ( '' !== $current_version || false !== $current_version ) {
						if ( - 1 === version_compare( $version, $current_version ) || 1 === version_compare( $version, $current_version ) ) {
							$brainstrom_bundled_products[ $keys ]->version = $current_version;
							$bundled_product_updated                       = true;
						}
					}
				}
			}
		}

		update_option( 'brainstrom_products', $brainstrom_products );

		if ( $bundled_product_updated ) {
			update_option( 'brainstrom_bundled_products', $brainstrom_bundled_products );
		}
	}
}

add_action( 'admin_init', 'bsf_update_all_product_version', 1000 );

if ( ! function_exists( 'bsf_get_current_version' ) ) {
	/**
	 * Get current version of plugin / theme.
	 *
	 * @param string $template plugin template/slug.
	 * @param string $type type of product.
	 *
	 * @return float
	 */
	function bsf_get_current_version( $template, $type ) {
		if ( '' === $template ) {
			return false;
		}
		if ( 'theme' === $type || 'themes' === $type ) {
			$theme   = wp_get_theme( $template );
			$version = $theme->get( 'Version' );
		} elseif ( 'plugin' === $type || 'plugins' === $type ) {
			$plugin_file = rtrim( WP_PLUGIN_DIR, '/' ) . '/' . $template;
			if ( ! is_file( $plugin_file ) ) {
				return false;
			}
			$plugin  = get_plugin_data( $plugin_file );
			$version = $plugin['Version'];
		}
		return $version;
	}
}
if ( ! function_exists( 'bsf_get_current_name' ) ) {
	/**
	 * Get name of plugin / theme.
	 *
	 * @param string $template plugin template/slug.
	 * @param string $type type of product.
	 * @return string
	 */
	function bsf_get_current_name( $template, $type ) {
		if ( '' === $template ) {
			return false;
		}
		if ( 'theme' === $type || 'themes' === $type ) {
			$theme = wp_get_theme( $template );
			$name  = $theme->get( 'Name' );
		} elseif ( 'plugin' === $type || 'plugins' === $type ) {
			$plugin_file = rtrim( WP_PLUGIN_DIR, '/' ) . '/' . $template;
			if ( ! is_file( $plugin_file ) ) {
				return false;
			}
			$plugin = get_plugin_data( $plugin_file );
			$name   = $plugin['Name'];
		}
		return $name;
	}
}
add_action( 'admin_notices', 'bsf_notices', 1000 );
add_action( 'network_admin_notices', 'bsf_notices', 1000 );
if ( ! function_exists( 'bsf_notices' ) ) {
	/**
	 * Display admin notices.
	 *
	 * @return bool
	 */
	function bsf_notices() {
		global $pagenow;

		if ( 'update-core.php' === $pagenow || 'plugins.php' === $pagenow || 'post-new.php' === $pagenow || 'edit.php' === $pagenow || 'post.php' === $pagenow ) {
			$brainstrom_products         = get_option( 'brainstrom_products' );
			$brainstrom_bundled_products = ( get_option( 'brainstrom_bundled_products' ) ) ? get_option( 'brainstrom_bundled_products' ) : array();

			if ( empty( $brainstrom_products ) ) {
				return false;
			}

			$brainstrom_bundled_products_keys = array();

			if ( ! empty( $brainstrom_bundled_products ) ) :
				foreach ( $brainstrom_bundled_products as $bps ) {
					foreach ( $bps as $key => $bp ) {
						array_push( $brainstrom_bundled_products_keys, $bp->id );
					}
				}
			endif;

			$mix = array();

			$plugins = ( isset( $brainstrom_products['plugins'] ) ) ? $brainstrom_products['plugins'] : array();
			$themes  = ( isset( $brainstrom_products['themes'] ) ) ? $brainstrom_products['themes'] : array();

			$mix = array_merge( $plugins, $themes );

			if ( empty( $mix ) ) {
				return false;
			}

			if ( ( defined( 'BSF_PRODUCTS_NOTICES' ) && ( 'false' === BSF_PRODUCTS_NOTICES || false === BSF_PRODUCTS_NOTICES ) ) ) {
				return false;
			}

			$is_multisite     = is_multisite();
			$is_network_admin = is_network_admin();

			foreach ( $mix as $product ) :
				if ( ! isset( $product['id'] ) ) {
					continue;
				}

				if ( false === apply_filters( "bsf_display_product_activation_notice_{$product['id']}", true ) ) {
					continue;
				}

				if ( isset( $product['is_product_free'] ) && ( 'true' === $product['is_product_free'] || true === $product['is_product_free'] ) ) {
					continue;
				}

				$constant        = strtoupper( str_replace( '-', '_', $product['id'] ) );
				$constant_nag    = 'BSF_' . $constant . '_NAG';
				$constant_notice = 'BSF_' . $constant . '_NOTICES';

				if ( defined( $constant_nag ) && ( 'false' === constant( $constant_nag ) || false === constant( $constant_nag ) ) ) {
					continue;
				}
				if ( defined( $constant_notice ) && ( 'false' === constant( $constant_notice ) || false === constant( $constant_notice ) ) ) {
					continue;
				}

				$status = ( isset( $product['status'] ) ) ? $product['status'] : false;
				$type   = ( isset( $product['type'] ) ) ? $product['type'] : false;

				if ( ! $type ) {
					continue;
				}

				if ( 'plugin' === $type ) {
					if ( ! is_plugin_active( $product['template'] ) ) {
						continue;
					}
				} elseif ( 'theme' === $type ) {
					$theme = wp_get_theme();
					if ( $product['template'] !== $theme->template ) {
						continue;
					}
				} else {
					continue;
				}

				if ( BSF_Update_Manager::bsf_is_product_bundled( $product['id'] ) ) {
					continue;
				}

				if ( 'registered' !== $status ) :

					$url = bsf_registration_page_url( '', $product['id'] );

					$message = __( 'Please', 'bsf' ) . ' <a href="' . esc_url( $url ) . '" class="bsf-core-license-form-btn" plugin-slug="' . esc_html( $product['id'] ) . '">' . __( 'activate', 'bsf' ) . '</a> ' . __( 'your copy of the', 'bsf' ) . ' <i>' . esc_html( $product['product_name'] ) . '</i> ' . __( 'to get update notifications, access to support features & other resources!', 'bsf' );
					$message = apply_filters( "bsf_product_activation_notice_{$product['id']}", $message, $url, $product['product_name'] );

					$allowed_html = array(
						'a'      => array(
							'href'        => array(),
							'class'       => array(),
							'title'       => array(),
							'plugin-slug' => array(),
						),
						'br'     => array(),
						'em'     => array(),
						'strong' => array(),
						'i'      => array(),
					);

					if ( ( $is_multisite && $is_network_admin ) || ! $is_multisite ) {
						echo '<div class="update-nag bsf-update-nag">' . wp_kses( $message, $allowed_html ) . '</div>';
					}
				endif;
			endforeach;
		}
	}
}

if ( ! function_exists( 'bsf_get_free_products' ) ) {
	/**
	 * Get free products data.
	 *
	 * @return array
	 */
	function bsf_get_free_products() {
		$plugins = get_plugins();
		$themes  = wp_get_themes();

		$brainstrom_products = ( get_option( 'brainstrom_products' ) ) ? get_option( 'brainstrom_products' ) : array();

		$bsf_free_products = array();

		if ( ! empty( $brainstrom_products ) ) :
			$bsf_product_plugins = ( isset( $brainstrom_products['plugins'] ) ) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes  = ( isset( $brainstrom_products['themes'] ) ) ? $brainstrom_products['themes'] : array();
		endif;

		foreach ( $plugins as $plugin => $plugin_data ) {
			if ( 'Brainstorm Force' === trim( $plugin_data['Author'] ) ) {
				if ( ! empty( $bsf_product_plugins ) ) :
					foreach ( $bsf_product_plugins as $key => $bsf_product_plugin ) {
						$bsf_template = ( isset( $bsf_product_plugin['template'] ) ) ? $bsf_product_plugin['template'] : '';
						if ( $plugin === $bsf_template ) {
							if ( isset( $bsf_product_plugin['is_product_free'] ) && ( true === $bsf_product_plugin['is_product_free'] || 'true' === $bsf_product_plugin['is_product_free'] ) ) {
								$bsf_free_products[] = $bsf_product_plugin;
							}
						}
					}
				endif;
			}
		}

		foreach ( $themes as $theme => $theme_data ) {
			$data         = wp_get_theme( $theme );
			$theme_author = trim( $data->display( 'Author', false ) );
			if ( 'Brainstorm Force' === $theme_author ) {
				if ( ! empty( $bsf_product_themes ) ) :
					foreach ( $bsf_product_themes as $key => $bsf_product_theme ) {
						$bsf_template = $bsf_product_theme['template'];
						if ( $theme === $bsf_template ) {
							if ( isset( $bsf_product_theme['is_product_free'] ) && ( true === $bsf_product_theme['is_product_free'] || 'true' === $bsf_product_theme['is_product_free'] ) ) {
								$bsf_free_products[] = $bsf_product_theme;
							}
						}
					}
				endif;
			}
		}

		return $bsf_free_products;
	}
}

// delete bundled products after switch theme.
if ( ! function_exists( 'bsf_theme_deactivation' ) ) {
	/**
	 * Delete transients while switching theme.
	 *
	 * @return void
	 */
	function bsf_theme_deactivation() {

		delete_site_transient( 'bsf_get_bundled_products' );
		delete_site_option( 'bsf_installer_menu' );
		update_option( 'bsf_force_check_extensions', false );
	}
}

add_action( 'switch_theme', 'bsf_theme_deactivation' );
add_action( 'deactivated_plugin', 'bsf_theme_deactivation' );

if ( ! function_exists( 'bsf_get_free_menu_position' ) ) {
	/**
	 * Get free theme position.
	 *
	 * @param int   $start menu position priority index.
	 * @param float $increment increment number for menu position.
	 * @return int
	 */
	function bsf_get_free_menu_position( $start, $increment = 0.3 ) {
		foreach ( $GLOBALS['menu'] as $key => $menu ) {
			$menus_positions[] = $key;
		}

		if ( ! in_array( $start, $menus_positions, true ) ) {
			return $start;
		}

		/* the position is already reserved find the closet one */
		while ( in_array( $start, $menus_positions, true ) ) {
			$start += $increment;
		}
		return $start;
	}
}
if ( ! function_exists( 'bsf_get_option' ) ) {
	/**
	 * Get free theme position.
	 *
	 * @param bool $request return complete option data OR a single variable.
	 * @return array
	 */
	function bsf_get_option( $request = false ) {
		$bsf_options = get_option( 'bsf_options' );
		if ( ! $request ) {
			return $bsf_options;
		} else {
			return ( isset( $bsf_options[ $request ] ) ) ? $bsf_options[ $request ] : false;
		}
	}
}
if ( ! function_exists( 'bsf_update_option' ) ) {
	/**
	 * Update bsf option with key and value.
	 *
	 * @param string $request variable key.
	 * @param string $value variable value.
	 * @return bool
	 */
	function bsf_update_option( $request, $value ) {
		$bsf_options             = get_option( 'bsf_options' );
		$bsf_options[ $request ] = $value;
		return update_option( 'bsf_options', $bsf_options );
	}
}

if ( ! function_exists( 'bsf_sort' ) ) {
	/**
	 * Sort array of objects.
	 *
	 * @param string $a The first string.
	 * @param string $b The second string.
	 * @return int
	 */
	function bsf_sort( $a, $b ) {
		return strcmp( strtolower( $a->short_name ), strtolower( $b->short_name ) );
	}
}

if ( ! function_exists( 'brainstorm_switch' ) ) {
	/**
	 * Brainstorm Switch
	 *
	 * Outputs markup for the switch
	 *
	 * @param string $name - name for the switch, this will be the reference for saving the value.
	 * @param bool   $default - Default valuw of switch, true|false.
	 * @return string
	 */
	function brainstorm_switch( $name = '', $default = false ) {

		$checked             = '0';
		$bsf_updater_options = get_option( 'bsf_updater_options', array() );

		if ( isset( $bsf_updater_options[ $name ] ) ) {
			$checked = $bsf_updater_options[ $name ];
		}
		$uid    = uniqid();
		$switch = '';

		$switch .= "\t\t" . '<div class="switch-wrapper">
							<input type="text"  id="brainstorm_switch_' . $uid . '" class="' . $name . ' form-control smile-input bsf-switch-input" value="' . esc_attr( $checked ) . '"/>
							<input type="checkbox" ' . checked( true, $checked, false ) . ' id="brainstorm_core_switch_' . $uid . '" name="' . $name . '" class="ios-toggle smile-input bsf-switch-input switch-checkbox smile-switch " value="0" >
							<label class="bsf-switch-btn checkbox-label" data-on="ON"  data-off="OFF" data-id="brainstorm_switch_' . $uid . '" for="brainstorm_core_switch_' . $uid . '">
							</label>
						</div>';

		return $switch;
	}
}


if ( ! function_exists( 'update_bsf_core_options_callback' ) ) {

	/**
	 * Save option brainstorm updater advanced/debug settings.
	 */
	function update_bsf_core_options_callback() {

		if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'bsf-update-menu-settings' ) ) {
			wp_send_json_error( __( 'Invalid Request', 'bsf' ) );
		}

		$option = isset( $_POST['option'] ) ? esc_attr( $_POST['option'] ) : '';
		$value  = isset( $_POST['value'] ) ? esc_attr( $_POST['value'] ) : '';

		$bsf_updater_options            = get_option( 'bsf_updater_options', array() );
		$bsf_updater_options[ $option ] = $value;

		update_option( 'bsf_updater_options', $bsf_updater_options );
		$bsf_updater_options = get_option( 'bsf_updater_options', array() );

		$location = bsf_registration_page_url( '&author' );

		$response = array(
			'redirect' => $location,
		);

		wp_send_json( $response );
	}
}

add_action( 'wp_ajax_update_bsf_core_options', 'update_bsf_core_options_callback' );
