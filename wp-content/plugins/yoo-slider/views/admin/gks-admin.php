<div class="gks-background">
</div>
<div id="gks-wrap" class="gks-wrap gks-glazzed-wrap">

<?php include_once( GKS_ADMIN_VIEWS_DIR_PATH.'/gks-header-banner.php'); ?>

<div class="gks-wrap-main">
    <script>
        GKS_AJAX_URL = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
        GKS_IMAGES_URL = '<?php echo GKS_IMAGES_URL ?>';
    </script>

    <?php

    abstract class GKSTabType{
        const Dashboard = 'dashboard';
        const Settings = 'settings';
        const Help = 'help';
        const Terms = 'terms';
    }

    $gks_tabs = array(
        GKSTabType::Dashboard => 'All Sliders',
        GKSTabType::Settings => 'General Settings',
        GKSTabType::Help => 'User Manual',
    );

    $gks_adminPage = @$_REQUEST['page'];
    $gks_currentTab = isset ( $_GET['tab'] ) ? sanitize_text_field($_GET['tab']) : GKSTabType::Dashboard;
    $gks_action = isset ( $_GET['action'] ) ? sanitize_text_field($_GET['action']) : null;
    $gks_layoutType = isset ( $_GET['type'] ) ? sanitize_text_field($_GET['type']) : null;

    include_once(GKS_ADMIN_VIEWS_DIR_PATH."/gks-admin-modal-spinner.php");

    if ($gks_action == 'create' || $gks_action == 'edit'){
        if($gks_layoutType == GKSLayoutType::SLIDER) {
            include_once(GKS_ADMIN_VIEWS_DIR_PATH."/gks-admin-slider.php");
        }
    } else if ($gks_action == 'options'){
        if($gks_layoutType == GKSLayoutType::SLIDER) {
            include_once(GKS_ADMIN_VIEWS_DIR_PATH."/gks-admin-slider-options.php");
        }
    } else{
        if ($gks_action == 'duplicate' && isset($_GET['id'])) {
            $gks_sid = (int)$_GET['id'];
            $gks_page = sanitize_text_field($_GET['page']);

            GKSHelper::duplicateSlider($gks_sid);
            header('Location: ?page='.$gks_page);
        }

        if($gks_currentTab == GKSTabType::Dashboard){
            include_once(GKS_ADMIN_VIEWS_DIR_PATH."/gks-admin-dashboard.php");
        }else if($gks_currentTab == GKSTabType::Settings){
            include_once(GKS_ADMIN_VIEWS_DIR_PATH."/gks-admin-settings.php");
        }else if($gks_currentTab == GKSTabType::Help){
            include_once(GKS_ADMIN_VIEWS_DIR_PATH."/gks-admin-help.php");
        }
    }
    
    ?>
        <div style="clear:both;"></div>
    </div>
</div>
