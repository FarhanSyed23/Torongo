<?php

namespace Essential_Addons_Elementor\Pro\Classes\WPML\Widgets;

use WPML_Elementor_Module_With_Items;
use Essential_Addons_Elementor\Classes\WPML\Eael_WPML;

if ( ! defined('ABSPATH') ) exit; // No access of directly access

/**
 * Carousel
 *
 * Registers translatable widget with items.
 *
 * @since 3.2.4
 */
class Testimonial_Slider extends WPML_Elementor_Module_With_Items {

	/**
	 * Get widget field name.
	 * 
	 * @return string
	 */
	public function get_items_field() {
		return 'eael_testimonial_slider_item';
	}

	/**
	 * Get the fields inside the repeater.
	 *
	 * @return array
	 */
	public function get_fields() {
		return array(
			'eael_testimonial_name',
            'eael_testimonial_company_title',
            'eael_testimonial_description'
		);
	}

  	/**
     * @param string $field
	 * 
	 * Get the field title string
     *
     * @return string
     */
	protected function get_title( $field ) {
		switch($field) {
			case 'eael_testimonial_name':
				return __( 'Testimonial Slider: User Name', 'essential-addons-elementor' );

			case 'eael_testimonial_company_title':
				return __( 'Testimonial Slider: Company Name', 'essential-addons-elementor' );

			case 'eael_testimonial_description':
				return __( 'Testimonial Slider: Description', 'essential-addons-elementor' );

			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 * 
	 * Get perspective field types.
	 *
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		switch($field) {
			case 'eael_testimonial_name':
				return 'LINE';

			case 'eael_testimonial_company_title':
				return 'LINE';

			case 'eael_testimonial_description':
				return 'VISUAL';

			default:
				return '';
		}
	}

}
