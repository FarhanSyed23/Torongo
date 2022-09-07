<?php

namespace mp_timetable\plugin_core\classes;

use mp_timetable\classes\libs\GUMP;
use \Mp_Time_Table;

class Preprocessor extends GUMP {

	protected static $instance;

	public static function get_instance() {
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Install Preprocessors
	 */
	static function install() {
		Core::include_all( Mp_Time_Table::get_plugin_part_path('classes/preprocessors') );
	}

	/**
	 * Call controller
	 *
	 * @param string $action
	 * @param bool|false $controller
	 *
	 * @return mixed
	 */
	public function call_controller($action = 'content', $controller = false) {
		if (empty($controller)) {
			trigger_error("Wrong controller ");
		}
		$path = Mp_Time_Table::get_plugin_part_path('classes/controllers/');
		// if controller exists
		if ('controller' != $controller && !file_exists("{$path}class-controller-{$controller}.php")) {
			$ControllerName = 'Controller_' . ucfirst($controller);
			if (class_exists($ControllerName)) {
				trigger_error("Wrong controller {$path}class-controller-{$controller}.php");
			}
		}
		$action = "action_$action";
		$controller = Core::get_instance()->get_state()->get_controller($controller);
		// if method exists
		if (method_exists($controller, $action)) {
			return $controller->$action();
		} else {
			trigger_error("Wrong {$action} in {$path}class-controller-{$controller}.php");
		}
	}

	/**
	 * Progress
	 *
	 * @param array $params
	 * @param $name
	 * @param $type
	 *
	 * @return array
	 */
	protected function progress(array $params, $name, $type) {
		$success = $this->run($params);
		if ($success !== false) {
			return Core::get_instance()->get_model($type)->$name($params);
		} else {
			$name = "on_error_{$name}";
			if (!method_exists($this, $name)) {
				$name = 'get_errors_array';
			}
			return array('success' => $success, 'data' => $this->$name());
		}
	}

	/**
	 * Process the validation errors and return an array of errors with field names as keys.
	 *
	 * @param $convert_to_string
	 *
	 * @return array | null (if empty)
	 */
	public function get_errors_array($convert_to_string = null) {
		if (empty($this->errors)) {
			return ($convert_to_string) ? null : array();
		}

		$resp = array();

		foreach ($this->errors as $e) {
			$field = ucwords(str_replace(array('_', '-'), chr(32), $e['field']));
			$param = $e['param'];

			// Let's fetch explicit field names if they exist
			if (array_key_exists($e['field'], self::$fields)) {
				$field = self::$fields[$e['field']];
			}

			switch ($e['rule']) {
				case 'mismatch' :
					$resp[$e['field']] = "There is no validation rule for $field";
					break;
				case 'validate_required':
					$resp[$e['field']] = "Enter $field field";
					break;
				case 'validate_valid_email':
					$resp[$e['field']] = "Enter a valid email address";
					break;
				case 'validate_max_len':
					$resp[$e['field']] = "The $field field needs to be $param or shorter in length";
					break;
				case 'validate_min_len':
					$resp[$e['field']] = "The $field field needs to be $param or longer in length";
					break;
				case 'validate_exact_len':
					$resp[$e['field']] = "The $field field needs to be exactly $param characters in length";
					break;
				case 'validate_alpha':
					$resp[$e['field']] = "The $field field may only contain alpha characters(a-z)";
					break;
				case 'validate_alpha_numeric':
					$resp[$e['field']] = "The $field field may only contain alpha-numeric characters";
					break;
				case 'validate_alpha_dash':
					$resp[$e['field']] = "The $field field may only contain alpha characters &amp; dashes";
					break;
				case 'validate_numeric':
					$resp[$e['field']] = "The $field field may only contain numeric characters";
					break;
				case 'validate_integer':
					$resp[$e['field']] = "The $field field may only contain a numeric value";
					break;
				case 'validate_boolean':
					$resp[$e['field']] = "The $field field may only contain a true or false value";
					break;
				case 'validate_float':
					$resp[$e['field']] = "The $field field may only contain a float value";
					break;
				case 'validate_valid_url':
					$resp[$e['field']] = "The $field field is required to be a valid URL";
					break;
				case 'validate_url_exists':
					$resp[$e['field']] = "The $field URL does not exist";
					break;
				case 'validate_valid_ip':
					$resp[$e['field']] = "The $field field needs to contain a valid IP address";
					break;
				case 'validate_valid_cc':
					$resp[$e['field']] = "The $field field needs to contain a valid credit card number";
					break;
				case 'validate_valid_name':
					$resp[$e['field']] = "The $field field needs to contain a valid human name";
					break;
				case 'validate_contains':
					$resp[$e['field']] = "The $field field needs to contain one of these values: " . implode(', ', $param);
					break;
				case 'validate_street_address':
					$resp[$e['field']] = "The $field field needs to be a valid street address";
					break;
				case 'validate_date':
					$resp[$e['field']] = "The $field field needs to be a valid date";
					break;
				case 'validate_min_numeric':
					$resp[$e['field']] = "The $field field needs to be a numeric value, equal to, or higher than $param";
					break;
				case 'validate_max_numeric':
					$resp[$e['field']] = "The $field field needs to be a numeric value, equal to, or lower than $param";
					break;
				case 'validate_min_age':
					$resp[$e['field']] = "The $field field needs to have an age greater than or equal to $param";
					break;
				default:
					$resp[$e['field']] = "The $field field is invalid";
			}
		}

		return $resp;
	}

}
