<?php

class GKSLicenseCore {

    const PKG_STR = 'starter';
    const PKG_STD = 'standard';
    const PKG_DVP = 'developer';

    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';
    const STATUS_EXPIRING = 'expiring';
    const STATUS_INVALID = 'invalid';

    const WEBSITE_STATUS_ACTIVE = 'active';
    const WEBSITE_STATUS_INACTIVE = 'inactive';

    const RS_OVERUSED = 'overused';
    const RS_INVALID = 'invalid';
    const RS_MISMATCH = 'mismatch';
    const RS_EXPIRED = 'expired';
    const RS_ACTIVE = 'active';
    const RS_EXPIRING = 'expiring';
    const RS_NOT_FOUND = 'not_found';

    const RC_ERROR = 'ERROR';
    const RC_OK = 'OK';

    private $updateMessageInfo = null;
    private static $banners = null;

    public function getKey()
    {
        $result = get_option(GKS_LICENSE_OPTION_KEY);
        if ($result !== false) {
            return $result;
        }
        return '';
    }

    public function validateKey($key)
    {
        if ($key == '') {
            return false;
        }
        $result = $this->sendRequest(array(
            'key' => $key,
            'website' => $this->getWebsite(),
            'action' => 'validate_license_key',
            'license' => GKS_LICENSE_TYPE,
        ));

        if (!empty($result)) {
            $nm = new GKSNotificationManager();
            $nm->registerForStatus($result['data']['status']);
            if ($result['rc'] == GKSLicenseManager::RC_OK) {
                if (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_RECURRING) {
                    update_option(GKS_VALIDATOR_FLAG, 1);
                    update_option(GKS_LAST_VALIDATED_AT, time());
                }
                return true;
            } elseif (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_LIFETIME) {
                return $result['data']['status'];
            }
        }

        global $wpdb;
        if (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_RECURRING) {
            $wpdb->query("UPDATE ".GKS_TABLE_SLIDERS." SET `css` = ''");
            update_option(GKS_VALIDATOR_FLAG, 0);
            update_option(GKS_LAST_VALIDATED_AT, time());
        }

        return false;
    }

    public function canUse()
    {
        $licenseKey = $this->getKey();
        if (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_LIFETIME) {
            $result = $this->validateKey($licenseKey);
            if ($result !== false && $result === GKSLicenseManager::STATUS_INVALID) {
                return false;
            }
            if ($result === true || $licenseKey != '') {
                return true;
            }
            return false;
        } else {
            if ($licenseKey == '' || !$this->validateKey($licenseKey)) {
                return false;
            }
            return true;
        }
    }

    public function getInfo($key)
    {
        $result = $this->sendRequest(array(
            'key' => $key,
            'action' => 'get_info',
        ));
        if (!empty($result) && $result['rc'] == GKSLicenseManager::RC_OK) {
            return $result['data'];
        }
        return false;
    }

    public function getPluginUpdateMessageInfo($key)
    {
        if (is_null($this->updateMessageInfo)) {
            $result = $this->sendRequest(array(
                'key' => $key,
                'action' => 'get_update_message_info',
            ));
            if (!empty($result) && $result['rc'] == GKSLicenseManager::RC_OK) {
                $this->updateMessageInfo = $result['data'];
            }
        }
        if (!empty($this->updateMessageInfo)) {
            return $this->updateMessageInfo;
        }
        return false;
    }

    public function disableWebsite($key, $website)
    {
        $result = $this->sendRequest(array(
            'key' => $key,
            'website' => $website,
            'action' => 'disable_website',
        ));
        if (!empty($result) && $result['rc'] == GKSLicenseManager::RC_OK) {
           return true;
        }
        return false;
    }

    public function enableWebsite($key, $website)
    {
        $result = $this->sendRequest(array(
            'key' => $key,
            'website' => $website,
            'action' => 'enable_website',
        ));
        if (!empty($result)) {
            if ($result['rc'] == GKSLicenseManager::RC_ERROR) {
                $nm = new GKSNotificationManager();
                $nm->registerForStatus($result['data']['status']);
            }
        }
    }

    public function getWebsite()
    {
        $url = site_url();
        if (!empty($url)) {
            $parts = parse_url($url);
            return isset($parts['host']) ? $parts['host'] : '';
        }
        return '';
    }

    public function getTemplates($type = '')
    {
        $pluginData = get_plugin_data(GKS_PLUGIN_ROOT_FILE_PATH, array('Version'));
        $result = $this->sendRequest(array(
            'v' => $pluginData['Version'],
            'type' => $type,
            'action' => 'get_templates'
        ), 'GET');
        if (!empty($result) && $result['rc'] == GKSLicenseManager::RC_OK) {
            return $result['templates'];
        }
        return array();
    }

    public function getTemplate($id)
    {
        $pluginData = get_plugin_data(GKS_PLUGIN_ROOT_FILE_PATH, array('Version'));
        $key = $this->getKey();
        $result = $this->sendRequest(array(
            'id' => $id,
            'key' => $key,
            'v' => $pluginData['Version'],
            'action' => 'get_template'
        ), 'GET');
        if (!empty($result) && $result['rc'] == GKSLicenseManager::RC_OK) {
            return $result['template'];
        }
        return array();
    }

    public function getBanner($zone)
    {
        if (is_null(GKSLicenseCore::$banners)) {
            $lastLoadedAt = get_option(GKS_BANNERS_LAST_LOADED_AT);
            $lastLoadedAt = !empty($lastLoadedAt) ? $lastLoadedAt : 0;
            if ($lastLoadedAt == 0 || time() - $lastLoadedAt > 1 * 24 * 60 * 60) {
                $key = $this->getKey();
                $result = $this->sendRequest(array(
                    'pkg' => GKS_LICENSE_TYPE,
                    'key' => $key,
                    'action' => 'get_banners'
                ), 'GET');
                $cache = array();
                if (!empty($result) && $result['rc'] == GKSLicenseManager::RC_OK) {
                    $cache = !empty($result['banners']) ? $result['banners'] : array();
                    update_option(GKS_BANNERS_CONTENT, $cache);
                    update_option(GKS_BANNERS_LAST_LOADED_AT, time());
                }
            } else {
                $cache = get_option(GKS_BANNERS_CONTENT);
            }
            GKSLicenseCore::$banners = $cache;
        }
        if (!empty(GKSLicenseCore::$banners[$zone])) {
            return GKSLicenseCore::$banners[$zone];
        }
        return array();
    }

    public function sendRequest($params, $method = 'POST')
    {
        $result = wp_remote_post( GKS_API_URL,
            array(
                'method' => $method,
                'timeout' => 45,
                'blocking' => true,
                'headers' => array(),
                'body' => $params,
                'cookies' => array()
            )
        );
        if (!$result instanceof WP_Error && isset($result['response']['code']) && $result['response']['code'] == 200) {
            $result = json_decode($result['body'], true);
            if (json_last_error() != JSON_ERROR_NONE) {
                return false;
            }
            return $result;
        }
        return false;
    }
}
