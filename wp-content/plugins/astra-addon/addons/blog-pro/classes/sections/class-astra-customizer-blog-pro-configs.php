<?php
/**
 * Blog Pro General Options for our theme.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       1.4.3
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

/**
 * Customizer Sanitizes
 *
 * @since 1.4.3
 */
if ( ! class_exists( 'Astra_Customizer_Blog_Pro_Configs' ) ) {

	/**
	 * Register General Customizer Configurations.
	 */
	class Astra_Customizer_Blog_Pro_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register General Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Display Post Meta
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-meta]',
					'type'     => 'control',
					'control'  => 'ast-sortable',
					'section'  => 'section-blog',
					'default'  => astra_get_option( 'blog-meta' ),
					'priority' => 50,
					'required' => array( ASTRA_THEME_SETTINGS . '[blog-post-structure]', 'contains', 'title-meta' ),
					'title'    => __( 'Meta', 'astra-addon' ),
					'choices'  => array(
						'comments'  => __( 'Comments', 'astra-addon' ),
						'category'  => __( 'Category', 'astra-addon' ),
						'author'    => __( 'Author', 'astra-addon' ),
						'date'      => __( 'Publish Date', 'astra-addon' ),
						'tag'       => __( 'Tag', 'astra-addon' ),
						'read-time' => __( 'Read Time', 'astra-addon' ),
					),
				),

				/**
				 * Option: Blog Layout
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-layout]',
					'type'     => 'control',
					'control'  => 'ast-radio-image',
					'section'  => 'section-blog',
					'default'  => astra_get_option( 'blog-layout' ),
					'priority' => 5,
					'title'    => __( 'Layout', 'astra-addon' ),
					'choices'  => array(
						'blog-layout-1' => array(
							'label' => __( 'Layout 1', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g><g><g><path fill="#0586BB" d="M93.548,38.73c0,0.977-0.823,1.77-1.84,1.77H28.79c-1.016,0-1.838-0.793-1.838-1.77V20.037 c0-0.977,0.822-1.77,1.838-1.77h62.918c1.017,0,1.84,0.793,1.84,1.77V38.73z"/></g><g><path fill="#0586BB" d="M91.846,53.198H28.655c-0.807,0-1.456-0.692-1.456-1.541s0.649-1.541,1.456-1.541h63.191 c0.805,0,1.454,0.692,1.454,1.541C93.301,52.506,92.65,53.198,91.846,53.198z"/></g><g><path fill="#0586BB" d="M87.941,62.732H32.766c-0.808,0-1.456-0.691-1.456-1.541s0.648-1.541,1.456-1.541h55.177 c0.808,0,1.457,0.691,1.457,1.541S88.75,62.732,87.941,62.732z"/></g></g></g></svg>',
						),
						'blog-layout-2' => array(
							'label' => __( 'Layout 2', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g><g><g><g><path fill="#0085BA" d="M21.129,42.385h31.36c0.874,0,1.583-0.708,1.583-1.582c0-0.873-0.709-1.582-1.583-1.582h-31.36 c-0.873,0-1.58,0.709-1.58,1.582C19.549,41.677,20.257,42.385,21.129,42.385z"/></g><g><path fill="#0085BA" d="M21.129,31.667h31.36c0.874,0,1.583-0.708,1.583-1.582c0-0.873-0.709-1.582-1.583-1.582h-31.36 c-0.873,0-1.58,0.709-1.58,1.582S20.257,31.667,21.129,31.667z"/></g><g><path fill="#0085BA" d="M21.129,53.104h24.36c0.874,0,1.583-0.709,1.583-1.582s-0.709-1.582-1.583-1.582h-24.36 c-0.873,0-1.58,0.709-1.58,1.582S20.257,53.104,21.129,53.104z"/></g></g><g><path fill="#0085BA" d="M66.889,59.336c0,1.217,0.987,2.203,2.204,2.203h29.654c1.217,0,2.204-0.986,2.204-2.203v-37.67 c0-1.217-0.987-2.205-2.204-2.205H69.093c-1.217,0-2.204,0.987-2.204,2.205V59.336z"/></g></g></g></svg>',
						),
						'blog-layout-3' => array(
							'label' => __( 'Layout 3', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M0.25,77.247V3.753c0-1.957,1.593-3.549,3.549-3.549h112.902c1.957,0,3.549,1.592,3.549,3.549v73.494 c0,1.957-1.592,3.549-3.549,3.549H3.799C1.843,80.796,0.25,79.204,0.25,77.247z M3.799,1.979c-0.979,0-1.773,0.795-1.773,1.774 v73.494c0,0.976,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.793,1.773-1.772V3.753c0-0.977-0.795-1.774-1.773-1.774H3.799 z"/></g></g></g><g><g><g><path fill="#0085BA" d="M99.371,42.385h-31.36c-0.874,0-1.583-0.708-1.583-1.582c0-0.873,0.709-1.582,1.583-1.582h31.36 c0.873,0,1.58,0.709,1.58,1.582C100.951,41.677,100.243,42.385,99.371,42.385z"/></g><g><path fill="#0085BA" d="M99.371,31.667h-31.36c-0.874,0-1.583-0.708-1.583-1.582c0-0.873,0.709-1.582,1.583-1.582h31.36 c0.873,0,1.58,0.709,1.58,1.582S100.243,31.667,99.371,31.667z"/></g><g><path fill="#0085BA" d="M99.371,53.104H75.012c-0.875,0-1.584-0.709-1.584-1.582s0.709-1.582,1.584-1.582h24.359 c0.873,0,1.58,0.709,1.58,1.582S100.243,53.104,99.371,53.104z"/></g></g><g><path fill="#0085BA" d="M53.611,59.336c0,1.217-0.987,2.203-2.204,2.203H21.753c-1.217,0-2.204-0.986-2.204-2.203v-37.67 c0-1.217,0.987-2.205,2.204-2.205h29.654c1.217,0,2.204,0.987,2.204,2.205V59.336z"/></g></g></g></svg>',
						),
					),
				),

				/**
				 * Option: Grid Layout
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-grid]',
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-blog',
					'default'  => astra_get_option( 'blog-grid' ),
					'priority' => 10,
					'required' => array( ASTRA_THEME_SETTINGS . '[blog-layout]', '===', 'blog-layout-1' ),
					'title'    => __( 'Grid Layout', 'astra-addon' ),
					'choices'  => array(
						'1' => __( '1 Column', 'astra-addon' ),
						'2' => __( '2 Columns', 'astra-addon' ),
						'3' => __( '3 Columns', 'astra-addon' ),
						'4' => __( '4 Columns', 'astra-addon' ),
					),
				),

				/**
				 * Option: Space Between Post
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-space-bet-posts]',
					'default'  => astra_get_option( 'blog-space-bet-posts' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'section-blog',
					'title'    => __( 'Add Space Between Posts', 'astra-addon' ),
					'priority' => 15,
				),

				/**
				 * Option: Masonry Effect
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-masonry]',
					'default'  => astra_get_option( 'blog-masonry' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'section-blog',
					'title'    => __( 'Masonry Layout', 'astra-addon' ),
					'priority' => 20,
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[blog-layout]', '===', 'blog-layout-1' ),
							array( ASTRA_THEME_SETTINGS . '[blog-grid]', '!=', 1 ),
						),
					),

				),

				/**
				 * Option: First Post full width
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[first-post-full-width]',
					'default'     => astra_get_option( 'first-post-full-width' ),
					'type'        => 'control',
					'control'     => 'checkbox',
					'section'     => 'section-blog',
					'title'       => __( 'Highlight First Post', 'astra-addon' ),
					'description' => __( 'This will not work if Masonry Layout is enabled.', 'astra-addon' ),
					'priority'    => 25,
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[blog-layout]', '===', 'blog-layout-1' ),
							array( ASTRA_THEME_SETTINGS . '[blog-grid]', '!=', 1 ),
						),
					),
				),

				/**
				 * Option: Disable Date Box
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-date-box]',
					'default'  => astra_get_option( 'blog-date-box' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'section-blog',
					'title'    => __( 'Enable Date Box', 'astra-addon' ),
					'priority' => 30,
				),

				/**
				 * Option: Date Box Style
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-date-box-style]',
					'default'  => astra_get_option( 'blog-date-box-style' ),
					'type'     => 'control',
					'section'  => 'section-blog',
					'title'    => __( 'Date Box Style', 'astra-addon' ),
					'control'  => 'select',
					'priority' => 35,
					'choices'  => array(
						'square' => __( 'Square', 'astra-addon' ),
						'circle' => __( 'Circle', 'astra-addon' ),
					),
					'required' => array( ASTRA_THEME_SETTINGS . '[blog-date-box]', '===', true ),
				),

				/**
				 * Option: Remove feature image padding
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[blog-featured-image-padding]',
					'default'     => astra_get_option( 'blog-featured-image-padding' ),
					'type'        => 'control',
					'control'     => 'checkbox',
					'section'     => 'section-blog',
					'title'       => __( 'Remove Featured Image Padding', 'astra-addon' ),
					'description' => __( 'This option will not work on full width layouts.', 'astra-addon' ),
					'priority'    => 40,
					'required'    => array( ASTRA_THEME_SETTINGS . '[blog-layout]', '===', 'blog-layout-1' ),
				),
				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[ast-styling-section-blog-grid]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'section'  => 'section-blog',
					'priority' => 40,
					'settings' => array(),
				),

				/**
				 * Option: Excerpt Count
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[blog-excerpt-count]',
					'default'     => astra_get_option( 'blog-excerpt-count' ),
					'type'        => 'control',
					'control'     => 'number',
					'section'     => 'section-blog',
					'priority'    => 80,
					'title'       => __( 'Excerpt Count', 'astra-addon' ),
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 3000,
					),
					'required'    => array( ASTRA_THEME_SETTINGS . '[blog-post-content]', '===', 'excerpt' ),
				),

				/**
				 * Option: Read more text
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-read-more-text]',
					'default'  => astra_get_option( 'blog-read-more-text' ),
					'type'     => 'control',
					'section'  => 'section-blog',
					'priority' => 85,
					'title'    => __( 'Read More Text', 'astra-addon' ),
					'control'  => 'text',
					'required' => array( ASTRA_THEME_SETTINGS . '[blog-post-content]', '===', 'excerpt' ),
				),

				/**
				 * Option: Display read more as button
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-read-more-as-button]',
					'default'  => astra_get_option( 'blog-read-more-as-button' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'section-blog',
					'title'    => __( 'Display Read More as Button', 'astra-addon' ),
					'priority' => 90,
					'required' => array( ASTRA_THEME_SETTINGS . '[blog-post-content]', '===', 'excerpt' ),
				),

				/**
				 * Option: Post Pagination
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-pagination]',
					'default'  => astra_get_option( 'blog-pagination' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-blog',
					'priority' => 110,
					'title'    => __( 'Post Pagination', 'astra-addon' ),
					'choices'  => array(
						'number'   => __( 'Number', 'astra-addon' ),
						'infinite' => __( 'Infinite Scroll', 'astra-addon' ),
					),
				),

				/**
				 * Option: Post Pagination Style
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-pagination-style]',
					'default'  => astra_get_option( 'blog-pagination-style' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-blog',
					'priority' => 115,
					'title'    => __( 'Post Pagination Style', 'astra-addon' ),
					'choices'  => array(
						'default' => __( 'Default', 'astra-addon' ),
						'square'  => __( 'Square', 'astra-addon' ),
						'circle'  => __( 'Circle', 'astra-addon' ),
					),
					'required' => array( ASTRA_THEME_SETTINGS . '[blog-pagination]', '===', 'number' ),
				),
				/**
				 * Option: Event to Trigger Infinite Loading
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[blog-infinite-scroll-event]',
					'default'     => astra_get_option( 'blog-infinite-scroll-event' ),
					'type'        => 'control',
					'control'     => 'select',
					'section'     => 'section-blog',
					'description' => __( 'Infinite Scroll cannot be previewed in the Customizer.', 'astra-addon' ),
					'priority'    => 85,
					'title'       => __( 'Event to Trigger Infinite Loading', 'astra-addon' ),
					'choices'     => array(
						'scroll' => __( 'Scroll', 'astra-addon' ),
						'click'  => __( 'Click', 'astra-addon' ),
					),
					'required'    => array( ASTRA_THEME_SETTINGS . '[blog-pagination]', '===', 'infinite' ),
				),

				/**
				 * Option: Read more text
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-load-more-text]',
					'default'  => astra_get_option( 'blog-load-more-text' ),
					'type'     => 'control',
					'section'  => 'section-blog',
					'priority' => 90,
					'title'    => __( 'Load More Text', 'astra-addon' ),
					'control'  => 'text',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[blog-pagination]', '===', 'infinite' ),
							array( ASTRA_THEME_SETTINGS . '[blog-infinite-scroll-event]', '===', 'click' ),
						),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[ast-styling-section-blog-pagination]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'section'  => 'section-blog',
					'priority' => 108,
					'settings' => array(),
				),

			);

			return array_merge( $configurations, $_configs );
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
new Astra_Customizer_Blog_Pro_Configs();
