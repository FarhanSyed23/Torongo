<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Optin Class.
 *
 * All properties are run through the noptin_form_{$property} filter hook
 *
 * @see noptin_get_optin_form
 *
 * @class    Noptin_Form
 * @version  1.0.5
 */
class Noptin_Form {

	/**
	 * Form id
	 *
	 * @since 1.0.5
	 * @var int
	 */
	protected $id = null;

	/**
	 * Form information
	 *
	 * @since 1.0.5
	 * @var array
	 */
	protected $data = array();

	/**
	 * Class constructor. Loads form data.
	 *
	 * @param mixed $form Form ID, array, or Noptin_Form instance.
	 */
	public function __construct( $form = false ) {

		// If this is an instance of the class...
		if ( $form instanceof Noptin_Form ) {
			$this->init( $form->get_all_data() );
			return;
		}

		// ... or an array of form properties.
		if ( is_array( $form ) ) {
			$this->init( $form );
			return;
		}

		// Try fetching the form by its post id.
		if ( ! empty( $form ) && is_numeric( $form ) ) {
			$form = absint( $form );

			$data = $this->get_data_by( 'id', $form );
			if ( $data ) {
				$this->init( $data );
				return;
			}
		}

		// If we are here then the form does not.
		$this->init( $this->get_defaults() );
	}

	/**
	 * Sets up object properties
	 *
	 * @param array $data contains form details.
	 */
	public function init( $data ) {

		$data       = $this->sanitize_form_data( $data );
		$this->data = apply_filters( 'noptin_get_form_data', $data, $this );
		$this->id   = $data['id'];

	}

	/**
	 * Fetch a form from the db/cache
	 *
	 * @param string     $field The field to query against: At the moment only ID is allowed.
	 * @param string|int $value The field value.
	 * @return array|false array of form details on success. False otherwise.
	 */
	public function get_data_by( $field, $value ) {

		// 'ID' is an alias of 'id'...
		if ( 'id' === strtolower( $field ) ) {

			// Make sure the value is numeric to avoid casting objects, for example, to int 1.
			if ( ! is_numeric( $value ) ) {
				return false;
			}

			// Ensure this is a valid form id.
			$value = intval( $value );
			if ( $value < 1 ) {
				return false;
			}
		} else {
			return false;
		}

		// Maybe fetch from cache.
		$form = wp_cache_get( $value, 'noptin_forms' );
		if ( $form ) {
			return $form;
		}

		// Fetch the post object from the db.
		$post = get_post( $value );
		if ( ! $post || 'noptin-form' !== $post->post_type ) {
			return false;
		}

		// Init the form.
		$form = array(
			'optinName'   => $post->post_title,
			'optinStatus' => ( 'publish' === $post->post_status ),
			'id'          => $post->ID,
			'optinHTML'   => $post->post_content,
			'optinType'   => get_post_meta( $post->ID, '_noptin_optin_type', true ),
		);

		$state = get_post_meta( $post->ID, '_noptin_state', true );
		if ( ! is_array( $state ) ) {
			$state = array();
		}

		$form = array_replace( $state, $form );

		// Update the cache with out data.
		wp_cache_add( $post->ID, $form, 'noptin_forms' );

		return $this->sanitize_form_data( $form );
	}

	/**
	 * Return default object properties
	 *
	 * @return array
	 */
	public function get_defaults() {

		$noptin   = noptin();
		$defaults = array(
			'optinName'             => '',
			'optinStatus'           => false,
			'id'                    => null,
			'optinHTML'             => __( 'This form is incorrectly configured', 'newsletter-optin-box' ),
			'optinType'             => 'inpost',

			// Opt in options.
			'formRadius'            => '0px',

			'singleLine'            => false,
			'gdprCheckbox'          => false,
			'gdprConsentText'       => __( 'I consent to receive promotional emails about your products and services.', 'newsletter-optin-box' ),
			'fields'                => array(
				array(
					'type'    => array(
						'label' => __( 'Email Address', 'newsletter-optin-box' ),
						'name'  => 'email',
						'type'  => 'email',
					),
					'require' => 'true',
					'key'     => 'noptin_email_key',
				),
			),
			'hideFields'            => false,
			'inject'                => '0',
			'buttonPosition'        => 'block',
			'subscribeAction'       => 'message', // redirect.
			'successMessage'        => get_noptin_option( 'success_message' ),
			'redirectUrl'           => '',

			// Form Design.
			'noptinFormBgImg'       => '',
			'noptinFormBgVideo'     => '',
			'noptinFormBg'          => '#eeeeee',
			'noptinFormBorderColor' => '#eeeeee',
			'borderSize'            => '4px',
			'formWidth'             => '620px',
			'formHeight'            => '280px',

			// Overlay.
			'noptinOverlayBgImg'    => '',
			'noptinOverlayBgVideo'  => '',
			'noptinOverlayBg'       => 'rgba(96, 125, 139, 0.6)',

			// image Design.
			'image'                 => '',
			'imagePos'              => 'right',
			'imageMain'             => '',
			'imageMainPos'          => '',

			// Button designs.
			'noptinButtonBg'        => '#313131',
			'noptinButtonColor'     => '#fefefe',
			'noptinButtonLabel'     => __( 'Subscribe Now', 'newsletter-optin-box' ),

			// Title design.
			'hideTitle'             => false,
			'title'                 => __( 'JOIN OUR NEWSLETTER', 'newsletter-optin-box' ),
			'titleColor'            => '#313131',

			// Description design.
			'hideDescription'       => false,
			'description'           => __( 'And get notified everytime we publish a new blog post.', 'newsletter-optin-box' ),
			'descriptionColor'      => '#32373c',

			// Note design.
			'hideNote'              => false,
			'note'                  => __( 'By subscribing, you agree with our <a href="">privacy policy</a> and our terms of service.', 'newsletter-optin-box' ),
			'noteColor'             => '#607D8B',
			'hideOnNoteClick'       => false,

			// Trigger Options.
			'timeDelayDuration'     => 4,
			'scrollDepthPercentage' => 25,
			'DisplayOncePerSession' => true,
			'cssClassOfClick'       => '#id .class',
			'triggerPopup'          => 'immeadiate',
			'slideDirection'        => 'bottom_right',

			// Restriction Options.
			'showEverywhere'        => true,
			'showHome'              => true,
			'showBlog'              => true,
			'showSearch'            => false,
			'showArchives'          => false,
			'neverShowOn'           => '',
			'onlyShowOn'            => '',
			'whoCanSee'             => 'all',
			'userRoles'             => array(),
			'hideSmallScreens'      => false,
			'hideLargeScreens'      => false,
			'showPostTypes'         => array( 'post' ),

			// custom css.
			'CSS'                   => '.noptin-optin-form-wrapper *{}',

		);

		if ( empty( $defaults['successMessage'] ) ) {
			$defaults['successMessage'] = esc_html__( 'Thanks for subscribing to the newsletter', 'newsletter-optin-box' );
		}

		return apply_filters( 'noptin_optin_form_default_form_state', $defaults, $this );

	}

	/**
	 * Sanitizes form data
	 *
	 * @since 1.0.5
	 * @access public
	 * @param  array $data the unsanitized data.
	 * @return array the sanitized data
	 */
	public function sanitize_form_data( $data ) {

		$defaults = $this->get_defaults();

		// Arrays only please.
		if ( ! is_array( $data ) ) {
			return $defaults;
		}

		$data   = array_replace( $defaults, $data );
		$return = array();

		foreach ( $data as $key => $value ) {

			// convert 'true' to a boolean true.
			if ( 'false' === $value ) {
				$return[ $key ] = false;
				continue;
			}

			// convert 'false' to a boolean false.
			if ( 'true' === $value ) {
				$return[ $key ] = true;
				continue;
			}

			if ( ! isset( $defaults[ $key ] ) || ! is_array( $defaults[ $key ] ) ) {
				$return[ $key ] = $value;
				continue;
			}

			// Ensure props that expect array always receive arrays.
			if( is_scalar( $data[ $key ] ) ) {
				$return[ $key ] = noptin_parse_list( $data[ $key ] );
				continue;
			}

			if ( ! is_array( $data[ $key ] ) ) {
				$return[ $key ] = $defaults[ $key ];
				continue;
			}

			$return[ $key ] = $value;
		}

		if ( empty( $return['optinType'] ) ) {
			$return['optinType'] = 'inpost';
		}

		return $return;
	}

	/**
	 * Magic method for checking the existence of a certain custom field.
	 *
	 * @since 1.0.5
	 * @access public
	 * @param string $key The key to check for.
	 * @return bool Whether the given form field is set.
	 */
	public function __isset( $key ) {

		if ( 'id' === strtolower( $key ) ) {
			return null !== $this->id;
		}
		return isset( $this->data[ $key ] ) && null !== $this->data[ $key ];

	}

	/**
	 * Magic method for accessing custom fields.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @param string $key form property to retrieve.
	 * @return mixed Value of the given form property
	 */
	public function __get( $key ) {

		if ( 'id' === strtolower( $key ) ) {
			return apply_filters( 'noptin_form_id', $this->id, $this );
		}

		if ( isset( $this->data[ $key ] ) ) {
			$value = $this->data[ $key ];
		} else {
			$value = null;
		}

		return apply_filters( "noptin_form_{$key}", $value, $this );
	}

	/**
	 * Magic method for setting custom form fields.
	 *
	 * This method does not update custom fields in the database. It only stores
	 * the value on the Noptin_Form instance.
	 *
	 * @param string $key   The key to set.
	 * @param mixed  $value The new value for the key.
	 * @since 1.0.5
	 * @access public
	 */
	public function __set( $key, $value ) {

		if ( 'id' === strtolower( $key ) ) {

			$this->id         = $value;
			$this->data['id'] = $value;
			return;

		}

		$this->data[ $key ] = $value;

	}

	/**
	 * Saves the current form to the database
	 *
	 * @since 1.0.5
	 * @access public
	 */
	public function save( $status = false ) {

		if ( isset( $this->id ) ) {
			$id = $this->update( $status );
		} else {
			$id = $this->create( $status );
		}

		if ( is_wp_error( $id ) ) {
			return $id;
		}

		// Update the cache with our new data.
		wp_cache_delete( $id, 'noptin_forms' );
		wp_cache_add( $id, $this->data, 'noptin_forms' );
		return true;
	}

	/**
	 * Creates a new form
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed True on success. WP_Error on failure
	 */
	public function create( $status = false ) {

		// Prepare the args...
		$args = $this->get_post_array();
		unset( $args['ID'] );

		if ( ! empty( $status ) ) {
			$args['post_status'] = $status;
		}

		// ... then create the form.
		$id = wp_insert_post( $args, true );

		// If an error occured, return it.
		if ( is_wp_error( $id ) ) {
			return $id;
		}

		// Set the new id.
		$this->id         = $id;
		$this->data['id'] = $id;

		$state = $this->data;
		unset( $state['optinHTML'] );
		unset( $state['optinType'] );
		unset( $state['id'] );
		update_post_meta( $id, '_noptin_state', $this->data );
		update_post_meta( $id, '_noptin_optin_type', $this->optinType );
		return true;
	}

	/**
	 * Updates the form in the db
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed True on success. WP_Error on failure
	 */
	private function update( $status = false ) {

		// Prepare the args...
		$args = $this->get_post_array();

		if ( ! empty( $status ) ) {
			$args['post_status'] = $status;
		}

		// ... then update the form.
		$id = wp_update_post( $args, true );

		// If an error occured, return it.
		if ( is_wp_error( $id ) ) {
			return $id;
		}

		$state = $this->data;
		unset( $state['optinHTML'] );
		unset( $state['optinType'] );
		unset( $state['id'] );
		update_post_meta( $id, '_noptin_state', $this->data );
		update_post_meta( $id, '_noptin_optin_type', $this->optinType );
		return true;
	}

	/**
	 * Returns post creation/update args
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed
	 */
	private function get_post_array() {
		$data = array(
			'post_title'   => empty( $this->optinName ) ? '' : $this->optinName,
			'ID'           => $this->id,
			'post_content' => empty( $this->optinHTML ) ? __( 'This form is incorrectly configured', 'newsletter-optin-box' ) : $this->optinHTML,
			'post_status'  => empty( $this->optinStatus ) ? 'draft' : 'publish',
			'post_type'    => 'noptin-form',
		);

		foreach ( $data as $key => $val ) {
			if ( empty( $val ) ) {
				unset( $data[ $key ] );
			}
		}

		return $data;
	}

	/**
	 * Duplicates the form
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed
	 */
	public function duplicate() {
		$this->optinName = $this->optinName . ' (duplicate)';
		$this->id        = null;
		return $this->save( 'draft' );
	}

	/**
	 * Determine whether the form exists in the database.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return bool True if form exists in the database, false if not.
	 */
	public function exists() {
		return null !== $this->id;
	}

	/**
	 * Determines whether this form has been published
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return bool True if form is published, false if not.
	 */
	public function is_published() {
		return $this->optinStatus;
	}

	/**
	 * Checks whether this is a real form and is saved to the database
	 *
	 * @return bool
	 */
	public function is_form() {
		$is_form = ( $this->exists() && get_post_type( $this->id ) === 'noptin-form' );
		return apply_filters( 'noptin_is_form', $is_form, $this );
	}

	/**
	 * Checks whether this form can be displayed on the current page
	 *
	 * @return bool
	 */
	public function can_show() {
		return apply_filters( 'noptin_can_show_form', $this->_can_show(), $this );
	}

	/**
	 * Contains the logic for Noptin_Form::can_show()
	 *
	 * @internal
	 * @return bool
	 */
	protected function _can_show() {

		// Abort early if the form is not published...
		if ( ! $this->exists() || ! $this->is_published() ) {
			return false;
		}

		// Always display click triggered popups.
		if ( 'popup' === $this->optinType && 'after_click' === $this->triggerPopup ) {
			return true;
		}

		// ... or the user wants to hide all forms.
		if ( ! noptin_should_show_optins() ) {
			return false;
		}

		// Maybe hide on mobile.
		if ( $this->hideSmallScreens && wp_is_mobile() ) {
			return false;
		}

		// Maybe hide on desktops.
		if ( $this->hideLargeScreens && ! wp_is_mobile() ) {
			return false;
		}

		// Has the user restricted this to a few posts?
		if ( ! empty( $this->onlyShowOn ) ) {
			return noptin_is_singular( $this->onlyShowOn );
		}

		// or maybe forbidden it on this post?
		if ( ! empty( $this->neverShowOn ) && noptin_is_singular( $this->neverShowOn ) ) {
			return false;
		}

		// Is this form set to be shown everywhere?
		if ( $this->showEverywhere ) {
			return true;
		}

		// frontpage.
		if ( is_front_page() ) {
			return $this->showHome;
		}

		// blog page.
		if ( is_home() ) {
			return $this->showBlog;
		}

		// search.
		if ( is_search() ) {
			return $this->showSearch;
		}

		// other archive pages.
		if ( is_archive() ) {
			return $this->showArchives;
		}

		// Single posts.
		$post_types = $this->showPostTypes;

		if ( empty( $post_types ) ) {
			return false;
		}

		return is_singular( $post_types );

	}

	/**
	 * Returns the html required to display the form
	 *
	 * @return string html
	 */
	public function get_html() {
		$type       = esc_attr( $this->optinType );
		$id         = $this->id;
		$id_class   = "noptin-form-id-$id";
		$type_class = "noptin-$type-main-wrapper";

		if ( 'popup' !== $type ) {

			$count = (int) get_post_meta( $id, '_noptin_form_views', true );
			update_post_meta( $id, '_noptin_form_views', $count + 1 );

		}

		$html = "<div class='$type_class $id_class noptin-optin-main-wrapper'>";

		if ( 'popup' === $type ) {
			$html .= "<div class='noptin-popup-optin-inner-wrapper'>";
		}

		// Maybe print custom css.
		if ( ! empty( $this->CSS ) ) {

			// Our best attempt at scoping styles.
			$wrapper = '.noptin-optin-form-wrapper';
			$css     = str_ireplace( ".$type_class", ".$type_class.$id_class", $this->CSS );
			$css     = str_ireplace( $wrapper, ".$id_class $wrapper", $css );
			$html   .= "<style>$css</style>";
		}

		$html .= $this->_get_html();

		if ( 'popup' === $type ) {
			$html .= '</div>';
		}

		// print main form html.
		$html = do_shortcode( $html . '</div>' );

		// Remove comments.
		$html = preg_replace( '/<!--(.*)-->/Uis', '', $html );

		return apply_filters( 'noptin_optin_form_html', $html, $this );
	}

	/**
	 * Generates HTML
	 *
	 * @return string
	 */
	protected function _get_html() {
		ob_start();
		$data = $this->data;
		$data['data'] = $data;
		get_noptin_template( 'frontend-optin-form.php', $data );
		return ob_get_clean();
	}

	/**
	 * Returns all form data
	 *
	 * @return array an array of form data
	 */
	public function get_all_data() {
		return $this->data;
	}

}
