<?php

require_once(GKS_CLASSES_DIR_PATH . "/GKSLicenseCore.php");

class GKSLicenseManager extends GKSLicenseCore {

    public function includeCustomCSS($gks_slider, $isSlider)
    {
        global $wpdb;
        $query = $wpdb->prepare("SELECT `css` FROM ".GKS_TABLE_SLIDERS." WHERE id = %d", $gks_slider->id);
        $res = $wpdb->get_row( $query , OBJECT );
        if (!empty($res)) {
            if (!empty($res->css)) {
                echo $res->css;
            } else {
                echo $this->generateCustomCSS($gks_slider, $isSlider);
            }
        }
    }

    public function generateCustomCSS($gks_slider, $isSlider)
    {
        $result = $this->sendRequest(array(
            'id' => $gks_slider->id,
            'options' => json_encode($gks_slider->options),
            'key' => $this->getKey(),
            'website' => $this->getWebsite(),
            'action' => 'get_css',
            'is_slider' => $isSlider ? 1 : 0,
        ));
        if (!empty($result) && $result['rc'] == 'OK') {
            $css = $result['css'];
        } else {
            $css = '';
        }
        global $wpdb;
        $wpdb->update(
            GKS_TABLE_SLIDERS,
            array( 'css' => $css ),
            array( 'id' => $gks_slider->id ),
            array( '%s' ),
            array( '%d' )
        );
        return $css;
    }
}
