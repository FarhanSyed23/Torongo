<?php
/**
 * Astra Addon UAG Compatibility
 *
 * @package Astra Addon
 * @since 2.5.0
 */

if ( ! class_exists( 'Astra_Addon_Ultimate_Gutenberg_Compatibility' ) ) :

	/**
	 * Astra Addon Page Builder Compatibility base class
	 *
	 * @since 2.5.0
	 */
	class Astra_Addon_Ultimate_Gutenberg_Compatibility extends Astra_Addon_Page_Builder_Compatibility {

		/**
		 * Instance
		 *
		 * @since 2.5.0
		 *
		 * @access private
		 * @var object Class object.
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 2.5.0
		 *
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Load UAG styles and scripts.
		 *
		 * @param int $post_id Post id.
		 *
		 * @since 2.5.0
		 */
		public function enqueue_scripts( $post_id ) {

			if ( defined( 'UAGB_URL' ) && defined( 'UAGB_VER' ) ) {
				wp_enqueue_style(
					'uagb-block-css', // UAG-Handle.
					UAGB_URL . 'dist/blocks.style.css', // Block style CSS.
					array(),
					UAGB_VER
				);
			}

			add_action(
				'wp_head',
				function() use ( $post_id ) {

					$this_post               = get_post( $post_id );
					$uag_stylesheet_function = array( UAGB_Helper::get_instance(), 'get_generated_stylesheet' );
					$stylesheet              = is_callable( $uag_stylesheet_function ) ? UAGB_Helper::get_instance()->get_generated_stylesheet( $this_post ) : '';

					add_filter(
						'uagb_post_for_stylesheet',
						function() {
							return $this_post;
						}
					);
				}
			);
		}
	}

endif;
