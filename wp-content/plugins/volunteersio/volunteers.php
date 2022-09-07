<?php
/*
Plugin Name: Volunteers.io
Plugin URI: https://www.volunteers.io
Description: Your volunteers register themselves for your tasks on your WordPress site. Click Settings in the dashboard bar and select 'Volunteers.io'
Version: 1.0
Author: Errel
Author URI: https://www.volunteers.io
License:  This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or (at your option) any later version. This software is freemium ware. A version is
available free of charge and a pro version with advanced extras is available for a small charge per year.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

$var_vioheader = "not_yet_set";
$volunteersio_server = 'https://www.easyapps.io';
// $volunteersio_server = 'http://192.168.0.90:8081';
$volunteersio_appserver = 'https://app50.volunteers.io';
// $volunteersio_appserver = 'http://192.168.0.90:3000';

$characters = "abcdefghijklmnopqrstuvwxyz0123456789"; $randstring = '';
for ($i = 0; $i < 20; $i++) { $randstring .= $characters[rand(0, strlen($characters)-1)]; }
$wpsessionsecuritycode = "wpses_" . $randstring;

function volunteersio_saveoption() {

    $tmp_allfields =  json_decode(json_encode($_GET));
    header('Content-Type: application/json');

    if($tmp_allfields->volunteersiowpses == $wpsessionsecuritycode) {

        if( !isset( $tmp_allfields->boPw ) || $tmp_allfields->boPw == '' || !isset( $tmp_allfields->volunteersioid ) || $tmp_allfields->volunteersioid == '' || !isset( $tmp_allfields->volunteersiomail ) || $tmp_allfields->volunteersiomail == '' ) {

            $res = array( 'success' => true, 'error' => "Security check failed (1)" );
            wp_send_json($res);
            exit;

        } else {

            update_option( "volunteersioid", $tmp_allfields->volunteersioid);
            update_option( "volunteersiomail", $tmp_allfields->volunteersiomail);
            update_option( "volunteersiopw", $tmp_allfields->boPw);                 //received via https encrypted connection - is encodeuricompo
            update_option( "volunteersiosession", $tmp_allfields->boSession);       //received via https encrypted connection
            update_option( "volunteersioaccountcode", $tmp_allfields->boAccountcode);       //received via https encrypted connection
            //update_option( "volunteersiodomain", $tmp_allfields->boDomain);       //received via https encrypted connection

            $res = array( 'success' => true, 'message' => "all ok " . $tmp_allfields->volunteersiowpses );
            wp_send_json($res);
            exit;
        }
    } else {
            $res = array( 'success' => true, 'error' => "Security check failed (2)" . $tmp_allfields->volunteersiowpses);
            wp_send_json($res);
            exit;
    }

}

if(!class_exists('WP_volunteers_io')) {
    class WP_volunteers_io {

        /**
		 * Tag identifier used by file includes and selector attributes.
		 * @var string
		 */
		protected $tag = 'volunteers';

		/**
		 * User friendly name used to identify the plugin.
		 * @var string
		 */
		protected $name = 'Volunteers.io';

		/**
		 * Current version of the plugin.
		 * @var string
		 */
		protected $version = '1.0';


        protected $repeat = 0;

        /**
		 * List of options to determine plugin behaviour.
		 * @var array
		 */
		protected $options = array();

        /**
         * Construct the plugin object
         */
        public function __construct() {

            //add_shortcode( $this->tag, array( &$this, 'shortcode' ) );
            add_shortcode( $this->tag, array( &$this, 'shortcode' ) );

            // register actions
            if ( is_admin() ) {
                add_action('admin_init', array(&$this, 'admin_init'));
                add_action('admin_menu', array(&$this, 'add_menu'));
            }

        } // END public function __construct

        /**
		 * Allow the shortcode to be used.
		 *
		 * @access public
		 * @param array $atts
		 * @param string $content
		 * @return string
		 */
		public function shortcode( $atts, $content) {

            extract( shortcode_atts( array(
				'nocss',
				'layout' => '1',
                'tag',
                'nodescriptions',
                'nolocations',
			), $atts ) );

	        // Enqueue the required styles and scripts...
			$this->_enqueue();

            $par_layout = "-layout=1";
            if (is_array($atts)) {

                if (array_key_exists('layout', $atts) ) {
                    if ( $atts['layout'] !== null && is_numeric( $atts['layout'] ) ) {
                         $par_layout = "-layout=" . esc_attr($atts['layout']);
                    }
                };
                if (array_key_exists('tag', $atts) ) {
                    if ( $atts['tag'] !== null) {
                         $par_tag = "-tag=" . esc_attr($atts['tag']);
                    }
                };

                if (array_key_exists('nocss', $atts) ) {
                    $par_css = "-nocss";
                }
                if (array_key_exists('fullvolunteers', $atts) ) {
                    $par_fullvolunteers = "-fullvolunteers";
                }
                if (array_key_exists('nodescriptions', $atts) ) {
                    $par_descriptions = "-nodescriptions";
                }
                if (array_key_exists('nolocations', $atts) ) {
                    $par_locations = "-nolocations";
                }

            };

              // Output the terminal...
			ob_start();
    ?>
    [volunteers
    <?php echo $par_layout . $par_css . $par_fullvolunteers . $par_descriptions . $par_locations . $par_tag; ?>]
        <script>
            var benaccount = "<?php echo get_option("volunteersioaccountcode"); ?>";
            var benclient = "000";
            var benregion = "us";
            var benmid = "vol";
            var agecdnbase = "s3.amazonaws.com/us-age-ee-data";
        </script>
        <?php
			return ob_get_clean();
		}

        /**
		 * Enqueue the required scripts and styles, only if they have not
		 * previously been queued.
		 *
		 * @access public
		 */
		protected function _enqueue() {
	           // Define the URL path to the plugin...
			$plugin_path = plugin_dir_url( __FILE__ );
            global $volunteersio_server;

	           // Enqueue the scripts if not already...
			if ( !wp_script_is( $this->tag, 'enqueued' ) ) {
				wp_enqueue_script('jquery' );

				wp_enqueue_script(
					'easyappsloader',
					$volunteersio_server . '/s1.4/ldr.js',
					array( 'jquery' ),
					'0.1.40',  //version number string as query
                    true
				);

				wp_enqueue_script( $this->tag );
			} else {

            }
		}


        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init() {
            wp_enqueue_script('jquery');
            $var_volunteersio_id = get_option("volunteersioid");
            add_action( 'wp_ajax_volunteersio', 'volunteersio_saveoption' );
            add_action( 'wp_ajax_nopriv_volunteersio', 'volunteersio_saveoption' );

            // Possibly do additional admin_init tasks
        } // END public static function activate

        /**
         * add a menu
         */
        public function add_menu() {
            // Add a page to manage this plugin's settings
            add_options_page(
                'Volunteers.io',
                'Volunteers.io',   //title in Settings sub-menu
                'manage_options',
                'wp_volunteersio-page',
                array(&$this, 'plugin_settings_page')
            );
        } // END public function add_menu()

        /**
         * Menu Callback
         */
        public function plugin_settings_page() {
            global $volunteersio_server;
            global $volunteersio_appserver;

            if(!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }


?>
            <!-- HTML +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
            <script src="<?php echo $volunteersio_appserver; ?>/wp-admin.js?v=1.45"></script>
            <script src="<?php echo plugins_url('simpleStorage.min.js', __FILE__ ); ?>"></script>

            <div class="wrap">
                <style>
                    .marleft {
                        margin-left: 50px;
                    }

                    .volio_greenbar {
                        background-color: #B3CFEC;
                        padding-top: 10px;
                        padding-bottom: 10px;
                        padding-left: 5px;
                        cursor: pointer;
                    }

                    .managementcontent {
                        height: 0;
                        overflow: hidden;
                    }

                    .volio_status,
                    .volio_bostatus {
                        /*                    float: right;*/
                        padding-right: 2px;
                        padding-left: 2px;
                    }

                    .volio_green {
                        color: green;
                    }

                    .volio_chevron,
                    .volio_bochevron,
                    .floatr {
                        float: right;
                        padding-right: 5px;
                        height: 100%;
                    }

                    .notvisible {
                        display: none;
                        visibility: hidden;
                    }

                    .volio_importopt {
                        visibility: hidden;
                    }

                    .volio_importopt_active {
                        visibility: visible;
                        font-weight: bold;
                    }

                    .volio_importopt_nonactive {
                        visibility: hidden;
                    }

                    .volio_exportopt {
                        visibility: hidden;
                    }

                    .volio_exportopt_active {
                        visibility: visible;
                        font-weight: bold;
                    }

                    .volio_exportopt_nonactive {
                        visibility: hidden;
                    }

                    #openboframeExt {
                        padding: 5px;
                    }

    .volio_imgonbtn{
        vertical-align: middle;
        max-width: 40px;
        max-height: 25px;
                    }
    .volio_txtonbtn{
        vertical-align: middle;
        padding: 3px;
        font-weight: bold;
    }
                </style>

                <a href="https://www.volunteers.io" target="_blank">

                    <img src="<?php echo plugins_url('volunteers_io_logo_gray_200x24.png', __FILE__ ); ?>" alt="Manage volunteers with volunteers.io">

                </a>

                <p style="font-size:105%">
                    <table>
                        <tr>
                            <td>
                                Volunteers.io is a managed cloud based application. It will not charge your WP server. Maintenance, monitoring and upgrades are taken care of by the makers.
                            </td>
                            <td>
                                <?php if ( get_option("volunteersioaccountcode") ) { ?>
                                <a href="https://sales.volunteers.io/showproducts?userid=<?php echo get_option("volunteersioaccountcode"); ?>&mid=vol&lang=0&region=ad&beta=betaall" target="_blank" class="button button-primary volio_upgr notvisible floatr"> Upgrade to Pro version </a>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>

                </p>

                <div id="accordion">
                    <?php if (get_option("volunteersiopw") && get_option("volunteersioaccountcode")) { ?>

                        <h3 id="setupbar" class="volio_greenbar">Setup <span class="volio_status"><span class="dashicons dashicons-yes volio_green"></span></span><span class="volio_chevron"><span class="dashicons dashicons-minus"></span></span></h3>
                        <div class="setupcontent">
                            <button class="btn btn-default volio_export floatr"> Export account </button>
                            <table>
                                <tr>
                                    <td><b>ID</b>:</td>
                                    <td>
                                        <?php echo get_option('volunteersioid'); ?>
                                    </td>
                                    <td><span class="volio_exportopt"><b>Password</b>:</span></td>
                                    <td>
                                        <span class="volio_exportopt">
                                            <span id="volio_exporttmppw"></span>
                                        <button onclick="jQuery('#volio_exporttmppw').html(makeEpw(decodeURIComponent(volunteersiopw) ) );">Show password</button>
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>E-mail</b>:</td>
                                    <td>
                                        <?php echo get_option('volunteersiomail'); ?>
                                    </td>
                                    <td><span class="volio_exportopt"><b>Account code</b>:</span></td>
                                    <td>
                                        <span class="volio_exportopt"><?php echo get_option("volunteersioaccountcode"); ?></span>
                                    </td>

                                </tr>
                                <tr>
                                    <td><!-- <b>Domain name</b>: --></td>
                                    <td>
                                        <?php //echo get_option('volunteersiodomain'); ?>
                                    </td>
                                    <td></td>
                                    <td>
                                        <span class="volio_exportopt">
                                            </b><i>Install the plugin in the destination WordPress, click the Import button and copy and paste the id, password and accountcode.</i><b>
                                        </span>
                                    </td>

                                </tr>

                            </table>

                            <br>
                            <div class="instructionscontent">

                            </div>

                            <span id="InfoPanel"></span>

                        </div>

                        <?php } else { ?>
                            <h3 class="volio_greenbar">Setup <span class="volio_status"><span class="dashicons dashicons-warning"></span> Setup required</span> <span class="volio_chevron"><span class="dashicons dashicons-minus"></span></span></h3>
                            <div class="setupcontent">
                                <br> The e-mail address is required and used for identification and security messages only.
                                <button class="btn btn-default volio_import floatr"> Import account </button>
                                <div class="marleft">
                                    <div id="newaccount1512">

                                        <form id='volunteersioform'>
                                            <table>

                                                <tr class="volio_importopt">
                                                    <td>Account code:</td>
                                                    <td>
                                                        <input type='text' id='volunteersioform_accountcode' value="">
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>ID: <span class="volio_importopt"> (enter ID to import) </span></td>
                                                    <td>
                                                        <input type='text' id='volunteersioform_id' value='<?php echo get_option('volunteersioid'); ?>' readonly>
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>
                                                <tr class="volio_importopt">
                                                    <td>Password:</td>
                                                    <td>
                                                        <input type='text' id='volunteersioform_pw' value="">
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>E-mail:</td>
                                                    <td>
                                                        <input type='text' id='volunteersioform_mail' value='<?php echo get_option('volunteersiomail'); ?>'>
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>
                                                <!--
                                                // <tr>
                                                //     <td>Domain name:</td>
                                                //     <td>
                                                //         <input type='text' id='volunteersioform_domain' value='<?php //echo get_option('volunteersiodomain'); ?>'>
                                                //     </td>
                                                //     <td>
                                                //     </td>
                                                // </tr>
                                                // -->
                                                <tr>
                                                    <td>&nbsp; </td>
                                                    <td>
                                                        <input type="hidden" id='volunteersioform_wpses' value="<?php echo $wpsessionsecuritycode; ?>">

                                                        <input type="submit" name="submit" id="volunteersiosubmit1" class="button button-primary" value="Create account">
                                                        <input type="submit" name="submit" id="volunteersiosubmit2" class="button button-primary volio_importopt" value="Import account">

                                                    </td>
                                                    <td>


                                                    </td>
                                                </tr>

                                            </table>

                                        </form>
                                    </div>

                                    <br>
                                    <div class="instructionscontent">
                                    </div>

                                    <span id="InfoPanel"></span>

                                </div>
                            </div>
                            <?php } ?>

                                <h3 class="volio_greenbar">Volunteers management  <span class="volio_bostatus"></span><span class="volio_bochevron"></span></h3>

                                <button data-src="" id="openboframeExt"><img src="https://www.volunteers.io/nocompressedimg/volunteers_io_hands_49x19.png" alt="volunteers.io" class="volio_imgonbtn"> Manage volunteers</button>
                                <div class="managementcontent">
                                </div>

                </div>
                <!-- /accordion -->
                <hr>
                <a href="https://www.volunteers.io" target="_blank">Volunteers.io</a>
                <hr>

            </div>
            <!-- /wrap-->

            <script type="text/javascript">
                var appserver = "<?php echo $volunteersio_appserver; ?>";
                var modeimport = false;
                var modeexport = false;
                var volio_defstatus = "<?php
                if ($var_volunteersio_id == FALSE) {
                    echo "0";
                } else {
                    echo "1";
                } ?>";

                var volio_acceptfrms = false;
                var k = 123456789;
                var volunteersioid = "<?php
                $var_volunteersio_id = get_option("volunteersioid");
                if ($var_volunteersio_id == FALSE) {
                    $k = "0123456789";
                    $randstring = '';
                    for ($i = 0; $i < 20; $i++) {
                        $randstring .= $k[rand(0, strlen($k)-1)];
                    }
                    $var_volunteersio_id = "user_".$randstring;
                }
                echo $var_volunteersio_id; ?> ";
                var volunteersiomail = "<?php echo get_option("volunteersiomail"); ?>";
                var volunteersiopw = "<?php echo get_option("volunteersiopw"); ?>";
                var volunteersiosession = "<?php echo get_option("volunteersiosession"); ?>";
                var volunteersioaccountcode = "<?php echo get_option("volunteersioaccountcode"); ?>";
            </script>

<?php
        } // END public function plugin_settings_page()

        /**
         * Settings intro
         */
        public function wp_volunteersioclass_cb() {
            // Think of this as help text for the section.
            //reserved

        }

        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args) {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" cols=50 name="%s" id="%s" value="%s"></input>', $field, $field, $value);
        } // END public function settings_field_input_text($args)

        public function settings_field_input_textarea($args) {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<textarea cols=50 rows=5 name="%s" id="%s">%s</textarea>', $field, $field, $value);
        } // END public function settings_field_input_text($args)


        /**
         * Activate the plugin
         */
        public static function activate() {
            // Do nothing
            //reserved
        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate() {
            delete_option("volunteersioid");
            delete_option("volunteersiomail");
            delete_option("volunteersiopw");
            delete_option("volunteersiosession");
            delete_option("volunteersioaccountcode");
            delete_option("volunteersiodomain");
        } // END public static function deactivate

    } // END class WP_volunteers_io

} // END if(!class_exists('WP_volunteers_io'))

if( !class_exists( 'WP_Http' ) ) {
    include_once( ABSPATH . WPINC. '/class-http.php' );
}

if(class_exists('WP_volunteers_io')) {

    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('WP_volunteers_io', 'activate'));
    register_deactivation_hook(__FILE__, array('WP_volunteers_io', 'deactivate'));

    // instantiate the plugin class
    $plugininstance = new WP_volunteers_io();

    $var_vioheader = get_option("plugin_header");
    if(strlen($var_vioheader)<1) { $var_vioheader = "alert('Please setup first!')"; }
    // Add a link to the settings page onto the plugin page

    if(isset($plugininstance)) {
        // reserved
    }

}

?>
