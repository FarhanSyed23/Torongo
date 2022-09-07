<?php

class GKSNotificationManager
{
    const GKS_NOTIFICATIONS_OPTION_KEY = 'gks_notifications_option_key';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';
    const TYPE_INFO = 'info';

    const KEY_OVERUSED = 'overused';
    const KEY_INVALID = 'invalid';
    const KEY_EXPIRED = 'expired';
    const KEY_EXPIRING = 'expiring';
    const KEY_NOT_FOUND = 'not_found';
    const KEY_MISMATCH = 'mismatch';

    public function register($key, $data)
    {
        $notifications = get_option(GKSNotificationManager::GKS_NOTIFICATIONS_OPTION_KEY);
        $notifications = empty($notifications) ? array() : json_decode($notifications, true);
        $notifications[$key] = json_encode($data);
        update_option(GKSNotificationManager::GKS_NOTIFICATIONS_OPTION_KEY, json_encode($notifications));
    }

    public function registerForStatus($status)
    {
        if (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_LIFETIME && ($status == GKSLicenseManager::STATUS_EXPIRING || $status == GKSLicenseManager::STATUS_EXPIRED || $status == GKSLicenseManager::STATUS_INVALID)) {
            return;
        }
        $data = array();
        $key = null;
        if ($status == GKSLicenseManager::RS_OVERUSED) {
            $key = GKSNotificationManager::KEY_OVERUSED;
            $data['type'] = GKSNotificationManager::TYPE_WARNING;
            $data['title'] = '';//'<h3>Overused</h3>';
            $data['content'] = '<p>| <b>Yoo Slider</b> | <i>You have reached to the limit of your license supported websites! Manage your license from <a href="'.admin_url('admin.php?page=' . GKS_SUBMENU_LICENSE_SLUG).'">Yoo Slider License</a> page.</i></p>';
            $data['buttons'] = '';
        } elseif ($status == GKSLicenseManager::RS_INVALID) {
            $key = GKSNotificationManager::KEY_INVALID;
            $data['type'] = GKSNotificationManager::TYPE_ERROR;
            $data['title'] = '';//'<h3>Invalid</h3>';
            $data['content'] = '<p>| <b>Yoo Slider</b> | <i>Your license is invalid!</i></p>';
            $data['buttons'] = '';
        } elseif ($status == GKSLicenseManager::RS_MISMATCH) {
            $key = GKSNotificationManager::KEY_MISMATCH;
            $data['type'] = GKSNotificationManager::TYPE_ERROR;
            $data['title'] = '';//'<h4>Package - Key mismatch</h4>';
            $data['content'] = '<p>| <b>Yoo Slider</b> | <i>The entered license key was not registered for this package!</i></p>';
            $data['buttons'] = '';
        } elseif ($status == GKSLicenseManager::RS_EXPIRED) {
            $key = GKSNotificationManager::KEY_EXPIRED;
            $data['type'] = GKSNotificationManager::TYPE_ERROR;
            $data['title'] = '';//'<h3>Expired</h3>';
            $data['content'] = '<p>| <b>Yoo Slider</b> | <i>Your license has expired! Renew your license from <a href="'.admin_url('admin.php?page=' . GKS_SUBMENU_LICENSE_SLUG).'">Yoo Slider License</a> page.</i></p>';
            $data['buttons'] = '';
        } elseif ($status == GKSLicenseManager::RS_EXPIRING) {
            $key = GKSNotificationManager::KEY_EXPIRING;
            $data['type'] = GKSNotificationManager::TYPE_WARNING;
            $data['title'] = '';//'<h3>Expiring</h3>';
            $data['content'] = '<p>| <b>Yoo Slider</b> | <i>Your license is about to expire! Manage your license from <a href="'.admin_url('admin.php?page=' . GKS_SUBMENU_LICENSE_SLUG).'">Yoo Slider License</a> page.</i></p>';
            $data['buttons'] = '';
        } elseif ($status == GKSLicenseManager::RS_NOT_FOUND) {
            $key = GKSNotificationManager::KEY_NOT_FOUND;
            $data['type'] = GKSNotificationManager::TYPE_ERROR;
            $data['title'] = '';//'<h3>Not found</h3>';
            $data['content'] = '<p>| <b>Yoo Slider</b> | <i>License was not found!</i></p>';
            $data['buttons'] = '';
        }
        if (!empty($key)) {
            GKSNotificationManager::register($key, $data);
        }
    }

    public function dismissAll()
    {
       delete_option(GKSNotificationManager::GKS_NOTIFICATIONS_OPTION_KEY);
    }

    public function showAll()
    {
        $notifications = get_option(GKSNotificationManager::GKS_NOTIFICATIONS_OPTION_KEY);
        if (!empty($notifications)) {
            $notifications = json_decode($notifications, true);
            foreach ($notifications as $key => $notification) {
                $notification = json_decode($notification, true);
?>
                <div class="notice notice-<?php echo $notification['type']; ?> is-dismissible">
                    <?php echo $notification['title']; ?>
                    <?php echo $notification['content']; ?>
                    <?php echo $notification['buttons']; ?>
                </div>
<?php

            }
        }
    }

}
