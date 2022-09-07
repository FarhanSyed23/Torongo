<?php
/**
 * Astra Addon Customizer
 *
 * @package Astra Addon
 * @since 1.6.0
 */

if ( ! class_exists( 'Astra_Addon_Page_Builder_Compatibility' ) ) :

	/**
	 * Astra Addon Page Builder Compatibility base class
	 *
	 * @since 1.6.0
	 */
	class Astra_Addon_Page_Builder_Compatibility {

		/**
		 * Instance
		 *
		 * @since 1.6.0
		 *
		 * @access private
		 * @var object Class object.
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.6.0
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
		 * Returns instance for active page builder.
		 *
		 * @param int $post_id Post id.
		 *
		 * @since 1.6.0
		 */
		public function get_active_page_builder( $post_id ) {

			$post = get_post( $post_id );

			if ( class_exists( '\Elementor\Plugin' ) ) {
				if ( ( version_compare( ELEMENTOR_VERSION, '1.5.0', '<' ) &&
					'builder' === Elementor\Plugin::$instance->db->get_edit_mode( $post_id ) ) || Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id ) ) {

					return Astra_Addon_Elementor_Compatibility::get_instance();
				}
			}

			if ( defined( 'TVE_VERSION' ) && get_post_meta( $post_id, 'tcb_editor_enabled', true ) ) {
				return Astra_Addon_Thrive_Compatibility::get_instance();
			}

			if ( class_exists( 'FLBuilderModel' ) && apply_filters( 'fl_builder_do_render_content', true, FLBuilderModel::get_post_id() ) && get_post_meta( $post_id, '_fl_builder_enabled', true ) ) {
				return Astra_Addon_Beaver_Builder_Compatibility::get_instance();
			}

			$vc_active = get_post_meta( $post_id, '_wpb_vc_js_status', true );

			if ( class_exists( 'Vc_Manager' ) && ( 'true' == $vc_active || has_shortcode( $post->post_content, 'vc_row' ) ) ) {
				return Astra_Addon_Visual_Composer_Compatibility::get_instance();
			}

			if ( function_exists( 'et_pb_is_pagebuilder_used' ) && et_pb_is_pagebuilder_used( $post_id ) ) {
				return Astra_Addon_Divi_Compatibility::get_instance();
			}

			if ( class_exists( 'Brizy_Editor_Post' ) ) {
				try {
					$post = Brizy_Editor_Post::get( $post_id );

					if ( $post ) {
						return Astra_Addon_Brizy_Compatibility::get_instance();
					}
				} catch ( Exception $exception ) { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
					// The post type is not supported by Brizy hence Brizy should not be used render the post.
				}
			}

			$uag_active = get_post_meta( $post_id, 'uagb_style_timestamp-css', true );

			if ( class_exists( 'UAGB_Helper' ) && $uag_active ) {
				return Astra_Addon_Ultimate_Gutenberg_Compatibility::get_instance();
			}

			return self::get_instance();
		}

		/**
		 * Render content for post.
		 *
		 * @param int $post_id Post id.
		 *
		 * @since 1.6.0
		 */
		public function render_content( $post_id ) {

			$current_post = get_post( $post_id, OBJECT );
			ob_start();
			echo do_shortcode( $current_post->post_content );
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Check is a post is built using WPBakery Page Builder.
		 *
		 * @since 1.6.0
		 * @param int $post_id Post ID of a Post to be checked for.
		 * @return boolean
		 */
		public static function is_vc_activated( $post_id ) {
			$post      = get_post( $post_id );
			$vc_active = get_post_meta( $post_id, '_wpb_vc_js_status', true );

			if ( class_exists( 'Vc_Manager' ) && ( 'true' == $vc_active || has_shortcode( $post->post_content, 'vc_row' ) ) ) {
				return true;
			}

			return false;
		}
	}

	/**
	 * Initialize class object with 'get_instance()' method
	 */
	Astra_Addon_Page_Builder_Compatibility::get_instance();

endif;
