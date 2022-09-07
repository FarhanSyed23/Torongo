<?php

/**
 * The Calendar Activation page.
 *
 * @author     Time.ly Network Inc.
 * @since      2.6
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_View_Activate extends Ai1ec_View_Admin_Abstract {
    /**
     * Adds page to the menu.
     *
     * @wp_hook admin_menu
     *
     * @return void
     */
    public function add_page() {
        global $submenu;

        add_submenu_page(
            AI1EC_ADMIN_BASE_URL,
            __( 'Activate', AI1EC_PLUGIN_NAME ),
            __( 'Activate', AI1EC_PLUGIN_NAME ),
            'manage_options',
            AI1EC_PLUGIN_NAME . '-activate',
            array( $this, 'display_page' )
        );

        if ( $this->isLoggedIn() ) {
            remove_submenu_page( AI1EC_ADMIN_BASE_URL, AI1EC_PLUGIN_NAME . '-activate' );
        } else {
            if ( isset( $submenu[AI1EC_ADMIN_BASE_URL] ) ) {
                foreach ( $submenu[AI1EC_ADMIN_BASE_URL] as $submenuItem ) {
                    if ( count( $submenuItem ) > 2 ) {
                        $submenuSlug = $submenuItem[2];
                        if ( $submenuSlug != AI1EC_PLUGIN_NAME . '-activate' ) {
                            remove_submenu_page( AI1EC_ADMIN_BASE_URL, $submenuSlug );
                        }
                    }
                }
            }
        }
    }
    /**
     * Display activation page
     *
     * @return void
     */
    public function display_page() {
        if ( isset( $_POST['ai1ec_save_login'] ) ) {
            $email     = isset( $_POST['ai1ec_email'] )      ? $_POST['ai1ec_email']      : null;
            $authToken = isset( $_POST['ai1ec_auth_token'] ) ? $_POST['ai1ec_auth_token'] : null;

            $result    = false;

            if ( $email && $authToken ) {
                $result = $this->login( $authToken, $email );
            }

            if ( $result ) {
                wp_redirect( ai1ec_admin_url( AI1EC_ADMIN_BASE_URL . '&page=' . AI1EC_PLUGIN_NAME . '-add-ons' ) );
            }
        }

        wp_enqueue_style(
            'ai1ec_activate.css',
            AI1EC_ADMIN_THEME_CSS_URL . 'activate.css',
            array(),
            AI1EC_VERSION
        );

        $this->_registry->get( 'theme.loader' )->get_file(
            'activate.twig',
            array(),
            true
        )->render();
    }

    public function add_meta_box() {
    }

    public function display_meta_box( $object, $box ) {
    }

    public function handle_post() {
    }

    public function login( $authToken, $email ) {
        $api = $this->_registry->get( 'model.api.api-registration' );
        $result = $api->saveLoginInfo( '', $authToken, $email );

        return $result;
    }
}