<div class="gks-admin-header-banner">
<?php
    $gksBanner = "";

    if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
      $licenseManager = new GKSLicenseManager();
      $gksBanner = $licenseManager->getBanner('header');
    }

    if (!empty($gksBanner)) {
        echo $gksBanner['content'];
    } else {
?>
        <style>
            .gks-default-banner-box {
                width: 100%;
                background-color: #34495e;
                height: 100px;
                margin-bottom: 20px;
                color: white;
            }
            .gks-default-banner-box--bg-image {
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
            }
            .gks-default-banner-box--logo-block {
                padding: 0px 0px 0 20px;
                float: left;
            }
            .gks-default-banner-box--logo {
                background-image: url('<?php echo GKS_IMAGES_URL.'/admin/banner/logo.png'; ?>');
                width: 200px;
                height: 70px;
                margin-left: -12px;
            }
            .gks-default-banner-box--logo-title {
                text-align: center;
                margin-top: -5px;
                padding-top: 4px;
                margin-right: 10px;
                border-top: 1px solid white;
            }
            .gks-default-banner-box--title-block {
                padding-top: 20px;
            }
            .gks-default-banner-box--title-block-icon {
                /* background-image: url('<?php echo GKS_IMAGES_URL.'/admin/banner/yooslider.png'; ?>'); */
                width: 320px;
                height: 70px;
                margin: 0 auto;
                visibility: visible;
                text-align: center;
            }
            .gks-default-banner-box--menu-block {
                float: right;
            }
            .gks-default-banner-box--menu-block-help {
                background-image: url('<?php echo GKS_IMAGES_URL.'/admin/banner/support.png'; ?>');
                margin-top: -60px;
                width: 45px;
                height: 45px;
                margin-right: 20px;
                display: block;
            }
            .gks-default-banner-box--menu-block-help:hover {
                opacity: 0.8;
            }
            .gks-default-banner-box--menu-block-help:active,
            .gks-default-banner-box--menu-block-help:focus {
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
            }

            .gks-buy-button {
              display: inline-block;
              margin-top: 7px;
              border: 1px solid white;
              padding: 10px;
              color: white;
              text-decoration: none;
              font-size: 14px;
            }

        </style>
        <div class="gks-default-banner-box">
            <div class="gks-default-banner-box--logo-block">
                <div class="gks-default-banner-box--logo gks-default-banner-box--bg-image"></div>
                <div class="gks-default-banner-box--logo-title"><?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM ? "PREMIUM" : "FREE"; ?></div>
            </div>
            <div class="gks-default-banner-box--title-block">
                <div class="gks-default-banner-box--title-block-icon gks-default-banner-box--bg-image">
                  <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?>
                    <a href="https://yooslider.com" class="gks-buy-button" target="_blank">
                        BUY YOO SLIDER PREMIUM NOW!
                    </a>
                  <?php endif; ?>
                </div>
            </div>
            <div class="gks-default-banner-box--menu-block">
                <a href="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM ? GKS_PREMIUM_SUPPORT_URL : GKS_FREE_SUPPORT_URL; ?>" target="_blank" class="gks-default-banner-box--menu-block-help gks-default-banner-box--bg-image"></a>
            </div>
        </div>
<?php
    }
?>
</div>
