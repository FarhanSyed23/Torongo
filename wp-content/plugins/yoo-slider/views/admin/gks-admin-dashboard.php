<?php

require_once( GKS_CLASSES_DIR_PATH.'/GKSDashboardListTable.php');

//Create an instance of our package class...
$listTable = new GKSDashboardListTable();
$listTable->prepare_items();

global $gks_theme;

$textMap = array(
    GKSLayoutType::SLIDER => array(
        'label' => '+ Slider',
        'hover' => 'Add new slider',
    )
);
?>

<div id="gks-dashboard-wrapper">
    <div id="gks-dashboard-actionbar">
        <a href="<?php echo GKSHelper::getPageUrl(GKSLayoutType::SLIDER, 'create'); ?>">
          <div class="gks-btn gks-add-slider-btn">
            <div class="gks-btn-content">
              <div class="gks-btn-icon gks-add-slider-icon"></div>
              <h3 class="gks-btn-title">NEW SLIDER</h3>
              <div class="gks-btn-overlay"></div>
            </div>
          </div>
        </a>

        <?php require_once ('gks-admin-templates-btn.php'); ?>
    </div>

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $gks_adminPage ?>" />
        <!-- Now we can render the completed list table -->
        <?php $listTable->display() ?>
    </form>

</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".tablenav.top", jQuery(".wp-list-table .no-items").closest("#gks-dashboard-wrapper")).hide();
    });
</script>
