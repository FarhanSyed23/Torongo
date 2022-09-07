<?php

namespace mp_timetable\plugin_core\classes;

use Mp_Time_Table;

/**
 * View class
 */
class View {

	protected static $instance;
	protected $template_path;
	protected $templates_path;
	protected $prefix = 'mptt';
	private $data;

	/**
	 * View constructor.
	 */
	public function __construct() {
		$this->template_path = Mp_Time_Table::get_template_path();
		$this->templates_path = Mp_Time_Table::get_templates_path();
		$this->taxonomy_names = Core::get_instance()->get_taxonomy_names();
		$this->post_types = Core::get_instance()->get_post_types();
	}

	/**
	 * @return View
	 */
	public static function get_instance() {
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Render template
	 *
	 * @param null $template
	 * @param null $data
	 */
	function render_template($template = null, $data = null) {
		$this->template = $template;
		if (is_array($data)) {
			extract($data);
		}
		$this->data = $data;
		include_once $this->templates_path . 'index.php';
	}

	/**
	 * Render html
	 *
	 * @param $template
	 * @param null $data
	 * @param bool $output
	 *
	 * @return string
	 */
	public function render_html($template, $data = null, $output = true) {

		$this->data = $data;
		if ( is_array($data) ) {
			extract($data, EXTR_SKIP);
		}

		$includeFile = $this->templates_path . $template . '.php';

		ob_start();
		include($includeFile);
		$out = ob_get_clean();

		if ($output) {
			echo $out;
		} else {
			return $out;
		}
	}

	/**
	 * Get template part theme/plugin
	 *
	 * @param string $name
	 * @param string $slug
	 *
	 * @return void
	 */
	public function get_template_part($slug, $name = '') {
		$template = '';

		if ($name) {
			$template = locate_template(array("{$slug}-{$name}.php", $this->template_path . "{$slug}-{$name}.php"));
		}

		// Get default slug-name.php
		if (!$template && $name && file_exists($this->templates_path . "{$slug}-{$name}.php")) {
			$template = $this->templates_path . "{$slug}-{$name}.php";
		}

		if (!$template) {
			$template = locate_template(array("{$slug}.php", $this->template_path . "{$slug}.php"));
		}

		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters($this->prefix . '_get_template_part', $template, $slug, $name);

		if ($template) {
			load_template($template, false);
		}
	}

	/**
	 * @param $template_name
	 * @param array $args
	 * @param string $template_path
	 * @param string $default_path
	 *
	 * @return mixed/void
	 */
	public function get_template_html($template_name, $args = array(), $template_path = '', $default_path = '') {
		ob_start();
		$this->get_template($template_name, $args, $template_path, $default_path);
		return ob_get_clean();
	}

	/**
	 * Get template
	 *
	 * @param $template_name
	 * @param array $args
	 * @param string $template_path
	 * @param string $default_path
	 */
	public function get_template($template_name, $args = array(), $template_path = '', $default_path = '') {
		$template_name = $template_name . '.php';

		if (!empty($args) && is_array($args)) {
			extract($args);
		}

		$located = $this->locate_template($template_name, $template_path, $default_path);

		if (!file_exists($located)) {
			_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $located), '2.1');
			return;
		}

		// Allow 3rd party plugin filter template file from their plugin.
		$located = apply_filters($this->prefix . '_get_template', $located, $template_name, $args, $template_path, $default_path);

		do_action($this->prefix . '_before_template_part', $template_name, $template_path, $located, $args);

		include($located);

		do_action($this->prefix . '_after_template_part', $template_name, $template_path, $located, $args);
	}

	/**
	 * Locate template
	 *
	 * @param $template_name
	 * @param string $template_path
	 * @param string $default_path
	 *
	 * @return mixed|void
	 */
	function locate_template($template_name, $template_path = '', $default_path = '') {
		if (!$template_path) {
			$template_path = $this->template_path;
		}

		if (!$default_path) {
			$default_path = $this->templates_path;
		}

		// Look within passed path within the theme - this is priority.
		$template_args = array(trailingslashit($template_path) . $template_name, $template_name);

		$template = locate_template($template_args);

		// Get default template/
		if (!$template) {
			$template = $default_path . $template_name;
		}

		// Return what we found.
		return apply_filters($this->prefix . '_locate_template', $template, $template_name, $template_path);
	}


	/**
	 * Include template
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function template_loader($template) {
		global $post, $taxonomy;
		$file = '';
		$find = array();
		if (is_embed()) {
			return $template;
		}
		if (is_single() && in_array($post->post_type, $this->post_types)) {
			$file = "single-{$post->post_type}.php";
			$find[] = $file;
			$find[] = $this->template_path . $file;
		} elseif (in_array($taxonomy, $this->taxonomy_names)) {
			$term = get_queried_object();
			$file = "taxonomy-{$term->taxonomy}.php";
			$find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = $this->template_path . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = 'taxonomy-' . $term->taxonomy . '.php';
			$find[] = $this->template_path . 'taxonomy-' . $term->taxonomy . '.php';
			$find[] = $file;
			$find[] = $this->template_path . $file;
		}
//		elseif (is_post_type_archive($this->post_types)) {
//			$file = 'archive.php';
//			$find[] = $file;
//			$find[] = $this->template_path . $file;
//		}
		if ($file) {
			$find_template = locate_template(array_unique($find));
			if (!empty($find_template)) {
				$template = $find_template;
			}
		}

		return $template;
	}
}
