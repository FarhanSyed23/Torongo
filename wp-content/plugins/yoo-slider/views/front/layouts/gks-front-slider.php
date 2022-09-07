<?php
    if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
      require_once(GKS_FRONT_VIEWS_DIR_PATH."/layouts/premium/gks-scroller.php");
      require_once(GKS_FRONT_VIEWS_DIR_PATH."/layouts/premium/gks-lg-functions.php");
    }

    $iconStyle = $gks_slider->options[GKSOption::kArrowIconStyle];
    $leftArrClass = substr($iconStyle, -1) == '-' ? $iconStyle.'left' : $iconStyle;
    $rightArrClass = substr($iconStyle, -1) == '-' ? $iconStyle.'right' : $iconStyle;

    $blank = ($gks_slider->options[GKSOption::kLoadUrlBlank]);

    $isCarousel = (!empty($gks_slider->options[GKSOption::kViewType]) && $gks_slider->options[GKSOption::kViewType] == GKSViewType::SliderCarousel);
    $heightIsProportional = (!empty($gks_slider->options[GKSOption::kHeightCalcAlgo]) && $gks_slider->options[GKSOption::kHeightCalcAlgo] == GKSHeightCalcAlgo::Proportional && !empty($gks_slider->options[GKSOption::kTileProportion]));
    $margin = $isCarousel ? $gks_slider->options[GKSOption::kSpaceBtwSlides]: 10;
    if ($isCarousel) {
        $infoDisplyStyle = !empty($gks_slider->options[GKSOption::kInfoDisplayStyle]) ? $gks_slider->options[GKSOption::kInfoDisplayStyle] : GKSInfoDisplayStyle::OnBottom;
        $showOverlay = $gks_slider->options[GKSOption::kShowOverlay];
        $faButtonIcon = isset($gks_slider->options[GKSOption::kButtonIcon]) ? $gks_slider->options[GKSOption::kButtonIcon] : "link";
        $dmxw = !empty($gks_slider->options[GKSOption::kDesktopMaxWidth]) ? $gks_slider->options[GKSOption::kDesktopMaxWidth] : GKSOption::kDesktopMaxWidthDefault;
        $dmnw = !empty($gks_slider->options[GKSOption::kDesktopMinWidth]) ? $gks_slider->options[GKSOption::kDesktopMinWidth] : GKSOption::kDesktopMinWidthDefault;
        $mmxw = !empty($gks_slider->options[GKSOption::kMobileMaxWidth]) ? $gks_slider->options[GKSOption::kMobileMaxWidth] : GKSOption::kMobileMaxWidthDefault;
    }

    $isScrollerAvailable = (!empty($gks_slider->options[GKSOption::kViewType]) && $gks_slider->options[GKSOption::kViewType] == GKSViewType::SliderScroller);
    $isStagingAvailable = (!empty($gks_slider->options[GKSOption::kViewType]) && $gks_slider->options[GKSOption::kViewType] == GKSViewType::SliderCoverflow);
    $isSlideAnimationsAvailable = GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM && isset($gks_slider->options[GKSOption::kSlideAnimation]) && $gks_slider->options[GKSOption::kSlideAnimation] != "" && !$isStagingAvailable && !$isCarousel ? true : false;
    $isShowPopup = $gks_slider->options[GKSOption::kShowPopupOnClick];
    $scrollerPosition = !empty($gks_slider->options[GKSOption::kScrollerPosition]) ? $gks_slider->options[GKSOption::kScrollerPosition] : GKSScrollerPosition::after;

    $isAutoplayVideo = false;

    $lgDTS = array();
    $lgVideosDTS = array();
?>

<?php
  if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
    if ($isScrollerAvailable && !$isCarousel && $scrollerPosition == GKSScrollerPosition::before) {
      echo gks_render_scroller_html($gks_slider);
    }
  }
?>

<?php $slideId = 0; ?>
<?php $slideIndex = 0; ?>
<div id="gks-slider-<?php echo $gks_slider->id; ?>"  data-gks-id="<?php echo $gks_slider->id; ?>" class="gks-slider-layout <?php echo ($isCarousel) ? 'gks-slider-carousel-layout' : ''; ?>">
    <?php if ($gks_slider->options[GKSOption::kShowArrows]) { ?>
    <a class="gks-slider-ctrl gks-slider-ctrl-prev"><i class="fa gks-fa <?php echo $leftArrClass; ?>"></i></a>
    <a class="gks-slider-ctrl gks-slider-ctrl-next"><i class="fa gks-fa <?php echo $rightArrClass; ?>"></i></a>
    <?php } ?>
    <div class="owl-carousel <?php echo $isCarousel ? "gks-carousel" : "" ?> <?php echo $isSlideAnimationsAvailable ? $gks_slider->options[GKSOption::kSlideAnimation] : ''?> <?php echo $isStagingAvailable ? 'stage-style' : ''?>">
        <?php
            foreach ($gks_slider->slides as $gks_slide) {
                $coverInfo = GKSHelper::decode2Obj(GKSHelper::decode2Str($gks_slide->cover));
                if (empty($coverInfo)) {
                    continue;
                }
                $url = isset($gks_slide->url) ? $gks_slide->url : "";
                $title = isset($gks_slide->title) ? GKSHelper::decode2Str($gks_slide->title) : "";
                $details = isset($gks_slide->description) ? GKSHelper::decode2Str($gks_slide->description) : "";

                // Analyize vars
                $details = str_replace(GKSVar::kVarTitle, $title, $details);

                $coverInfo = GKSHelper::decode2Obj(GKSHelper::decode2Str($gks_slide->cover));
                $coverType = !isset($coverInfo->type) ? GKSAttachmentType::PICTURE : $coverInfo->type;
                $playIconHtml = "";

                if ($coverType == GKSAttachmentType::PICTURE ) {
                  $meta = GKSHelper::getAttachementMeta($coverInfo->id, $gks_slider->options[GKSOption::kThumbnailQuality]);
                  $metaOriginal = GKSHelper::getAttachementMeta($coverInfo->id);
                } else if($coverType == GKSAttachmentType::YOUTUBE) {
                  $meta = GKSHelper::getYoutubeMeta($coverInfo, true, $gks_slider->options[GKSOption::kThumbnailQuality]);
                  $metaOriginal = GKSHelper::getYoutubeMeta($coverInfo);

                  $playIconHtml = '<span class="gks-video-play-icon gks-youtube-play-ic"></span>';
                } elseif ($coverType == GKSAttachmentType::VIDEO) {
              		$meta = GKSHelper::getVideoMeta($coverInfo, true, $gks_slider->options[GKSOption::kThumbnailQuality]);
              		$metaOriginal = GKSHelper::getVideoMeta($coverInfo);

                  $playIconHtml = '<span class="gks-video-play-icon gks-video-play-ic"></span>';
              	} elseif ($coverType == GKSAttachmentType::VIMEO) {
              		$meta = GKSHelper::getVimeoMeta($coverInfo, true, $gks_slider->options[GKSOption::kThumbnailQuality]);
              		$metaOriginal = GKSHelper::getVimeoMeta($coverInfo);

                  $playIconHtml = '<i class="gks-video-play-icon fa gks-fa fa-play gks-vimeo-play-ic"></i>';
              	} elseif($coverType == GKSAttachmentType::HTML) {
                  $meta = GKSHelper::getAttachementMeta($coverInfo->thumb->id, $gks_slider->options[GKSOption::kThumbnailQuality]);
                  $metaOriginal = GKSHelper::getAttachementMeta($coverInfo->thumb->id);

                  $coverHtml = base64_decode($coverInfo->html);
                  // Analyize vars
                  $coverHtml = str_replace(GKSVar::kVarTitle, $title, $coverHtml);
                }

                if ($coverType != GKSAttachmentType::HTML) {
                  // POPUP STUFF
                  if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
                    $shareText = $title;
                    $shareText = addslashes($shareText);
                    $subHtml = gks_lightGallerySubHtml($title, $details, isset($slider->options[GKSOption::kPopupShowTitle]) ? $slider->options[GKSOption::kPopupShowTitle] : true, isset($slider->options[GKSOption::kPopupShowDescription]) ? $slider->options[GKSOption::kPopupShowDescription] : true);

                    $lgJSData = "";
                    $lgVideoHTML = "";
                    $lgJSData .= "";
                    if ($coverType == GKSAttachmentType::VIDEO) {
                        $lgVideoHTML .= gks_InflateVideoSource($gks_slide, $coverInfo, $meta);
                        $lgJSData .= "
                          { facebookShareUrl: '{$metaOriginal['src']}',
                            twitterShareUrl: '{$metaOriginal['src']}',
                            pinterestShareUrl: '{$metaOriginal['src']}',
                            googleplusShareUrl: '{$metaOriginal['src']}',
                            tweetText: '{$shareText}',
                            pinterestText: '{$shareText}',
                            id: '{$gks_slide->id}',
                            html: '#gks-html5video-{$gks_slide->id}-{$coverInfo->video->id}',
                            thumb: '{$metaOriginal["src"]}',
                            subHtml: '{$subHtml}',
                            downloadUrl: " . ($url ? "'".$url."'" : "false") . "
                          }";
                    } else {
                        $lgJSData .= "
                          { facebookShareUrl: '{$metaOriginal['src']}',
                            twitterShareUrl: '{$metaOriginal['src']}',
                            pinterestShareUrl: '{$metaOriginal['src']}',
                            googleplusShareUrl: '{$metaOriginal['src']}',
                            tweetText: '{$shareText}',
                            pinterestText: '{$shareText}',
                            id: '{$gks_slide->id}',
                            src: '{$metaOriginal["src"]}',
                            thumb: '{$meta["src"]}',
                            subHtml: '{$subHtml}', 'downloadUrl': " . ($url ? "'".$url."'" : "false") . "
                          }";
                    }

                    $lgDTS[] = $lgJSData;
                    $lgVideosDTS[] = $lgVideoHTML;
                  }
                  // END POPUP STUFF
                }

                $pictureHoverEffect = isset($gks_slider->options[GKSOption::kPictureHoverEffect]) ? $gks_slider->options[GKSOption::kPictureHoverEffect] : GKSPictureHoverStyle::dflt;

                if (!$isCarousel) {
                    ?>
                    <div id="<?php echo $slideId++; ?>" class="gks-slider-cell <?php echo $pictureHoverEffect ?>" data-type="<?php echo $coverType; ?>" data-index="<?php echo $coverType != GKSAttachmentType::HTML ? $slideIndex++ : '' ?>" data-src="<?php echo @$metaOriginal['embed_src']; ?>">
                        <div class="gks-slider-image-wrapper gks-slider-cell-content gks-slider-cell-height">
                            <?php
                              if($coverType != GKSAttachmentType::HTML) {
                                if ($gks_slider->options[GKSOption::kSliderAutoHeight]) {
                                    $imgHtml = '<img class="gks-slider-auto-image gks-tile-img" src="' . $meta['src'] . '" alt="' . $title . '">';
                                } else {
                                    $imgHtml = '<div class="gks-slider-image gks-tile-img" style="background-image: url(' . $meta['src'] . '"></div>';
                                }
                                echo $coverType == GKSAttachmentType::PICTURE && !$isShowPopup ? '<a href="' . $url . '" ' . ($blank ? 'target="_blank"' : '') . '>' . $imgHtml . '</a>' : $imgHtml;

                                if (!empty($playIconHtml)) {
                                  echo $playIconHtml;
                                }
                              } else {
                                echo $coverHtml;
                              }
                            ?>
                        </div>
                        <?php if (!empty($title) || !empty($details)) {
                            echo '<div class="gks-slider-overlay-caption">';
                            if ($gks_slider->options[GKSOption::kShowTitle] && !empty($title)) {
                                echo '<div class="gks-slider-title">' . $title . '</div>';
                            }
                            if ($gks_slider->options[GKSOption::kShowDetails] && !empty($details)) {
                                echo '<div class="gks-slider-desc">' . $details . '</div>';
                            }
                            if ($gks_slider->options[GKSOption::kShowInfoMobile]) {
                                echo '<i class="fa gks-fa fa-angle-down gks-slider-info-toggle"></i>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>

                <?php
                } else {
                    $showButton = !empty($gks_slider->options[GKSOption::kShowButton]) && $gks_slider->options[GKSOption::kShowButton];
                    $isInfoOut = ($infoDisplyStyle == GKSInfoDisplayStyle::Before || $infoDisplyStyle == GKSInfoDisplayStyle::After);

                    $showTitle = ((!$isInfoOut && !empty($title) && $gks_slider->options[GKSOption::kShowTitle]) || ($isInfoOut && $gks_slider->options[GKSOption::kShowTitle]));
                    $showDetails = ((!$isInfoOut && !empty($details) && $gks_slider->options[GKSOption::kShowDetails]) || ($isInfoOut && $gks_slider->options[GKSOption::kShowDetails]));

                    if ($showTitle || $showDetails) {
                        $infoBox =  '<div class="gks-slider-onslide-details gks-slider-slide-caption">';
                        $infoBox .=  $showTitle ? '<div class="gks-slider-title">' . $title . '</div>' : "";
                        $infoBox .= $showDetails ? '<div class="gks-slider-details">' . $details . '</div>' : "";
                        $infoBox .= '</div>';
                    }

                    $infoOnHover = ($infoDisplyStyle == GKSInfoDisplayStyle::OnCenterHover || $infoDisplyStyle == GKSInfoDisplayStyle::OnTopHover || $infoDisplyStyle == GKSInfoDisplayStyle::OnBottomHover);

                    $showBorder = (!empty($gks_slider->options[GKSOption::kShowBorder]) && $gks_slider->options[GKSOption::kShowBorder]) ||
                                  (!empty($gks_slider->options[GKSOption::kShowBorderOnHover]) && $gks_slider->options[GKSOption::kShowBorderOnHover]);
                    ?>

                    <div id="<?php echo $slideId++; ?>" class="gks-slider-cell <?php echo $pictureHoverEffect ?>" data-type="<?php echo $coverType; ?>" data-index="<?php echo $coverType != GKSAttachmentType::HTML ? $slideIndex++ : '' ?>" data-src="<?php echo @$metaOriginal['embed_src']; ?>">
                        <div class="gks-slider-cell-content gks-slider-cell-height" <?php echo 'data-url="'.$url.'"'; ?>>
                          <?php if($coverType != GKSAttachmentType::HTML): ?>

                            <?php if (($showTitle || $showDetails) && $infoDisplyStyle == GKSInfoDisplayStyle::Before) { echo $infoBox; } ?>
                            <div class="gks-img-container">
                              <div class="gks-slider-cell-content-image gks-tile-img" style="background-image: url(<?php echo $meta['src']; ?>);">
                                <?php if ($showOverlay && ($infoDisplyStyle == GKSInfoDisplayStyle::Before || $infoDisplyStyle == GKSInfoDisplayStyle::After)): ?>
                                  <div class="gks-slider-overlay"></div>
                                <?php endif; ?>
                            </div>
                            <?php
                              if ($coverType == GKSAttachmentType::PICTURE) {
                                if ($showButton) {
                                  echo "<a href='{$url}' class='gks-slider-button' ".($blank ? 'target="_blank"' : '')."><div class='gks-slider-button-icon'><i class='fa gks-fa fa-{$faButtonIcon}'></i></div></a>";
                                }
                              } else {
                                if (!empty($playIconHtml)) {
                                  echo $playIconHtml;
                                }
                              }
                            ?>
                          </div>
                            <?php if (($showTitle || $showDetails) && $infoDisplyStyle == GKSInfoDisplayStyle::After) { echo $infoBox; } ?>

                            <?php
                                $onSlide = '<div class="gks-slider-onslide-content">';
                                if ($infoDisplyStyle != GKSInfoDisplayStyle::Before && $infoDisplyStyle != GKSInfoDisplayStyle::After) {
                                  if ($infoOnHover) {
                                      if ($showOverlay) { $onSlide .=  '<div class="gks-slider-overlay"></div>'; }
                                      if ($showTitle && !$isInfoOut) { $onSlide .= $infoBox; }
                                  } else {
                                      if ($showTitle && !$isInfoOut) { $onSlide .= $infoBox; }
                                      if ($showOverlay) { $onSlide .=  '<div class="gks-slider-overlay"></div>'; }
                                  }
                                }

                                if ($showBorder) {
                                    $onSlide .=  '<div class="gks-slide-border"></div>';
                                }

                                $onSlide .= '</div>';
                                echo $onSlide;
                            ?>
                          <?php else: ?>
                            <?php echo $coverHtml ?>
                          <?php endif; ?>

                        </div>
                    </div>
                <?php
                }
            }
        ?>
    </div>
</div>


<?php
  if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
    if ($isScrollerAvailable && !$isCarousel && $scrollerPosition == GKSScrollerPosition::after) {
      echo gks_render_scroller_html($gks_slider);
    }
  }
?>

<?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM): ?>

<script>
    var GKS_DATASOURCE_<?php echo $gks_slider->id; ?> = [
      <?php foreach($lgDTS as $source): ?>
        <?php echo $source; ?>,
      <?php endforeach; ?>
    ];

    var GKS_LG_OPTIONS_<?php echo $gks_slider->id; ?> = <?php echo gks_inflatePopupOptions($gks_slider->id, $gks_slider->options); ?>;

</script>

<?php foreach($lgVideosDTS as $sourceHTML): ?>
  <?php echo $sourceHTML; ?>
<?php endforeach; ?>

<?php endif; ?>

<?php
  $viewerType = ( !empty($gks_slider->options[GKSOption::kViewerType]) ) ? $gks_slider->options[GKSOption::kViewerType] : GKSPjViewerType::LightGalleryLight;
?>

<script>
    jQuery(document).ready(function(){
        var slideSpeed = 700;
        var settings = {
            responsiveBaseElement: '.gks-slider-layout',
            <?php if($isStagingAvailable): ?> stagePadding: 200, <?php endif; ?>
            lazyLoad: <?php echo $gks_slider->options[GKSOption::kEnableGridLazyLoad] ? 'true' : 'false' ?>,
            items: 1,
            margin: <?php echo $margin; ?>,
            <?php if($isStagingAvailable): ?>
            center: true,
            loop: true,
            <?php else:?>
            center: false,
            loop: <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM && $gks_slider->options[GKSOption::kSliderLoop] ? 'true' : 'false' ?>,
            <?php endif;?>
            autoplay: <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM && $gks_slider->options[GKSOption::kSliderAutoplay] ? 'true' : 'false' ?>,
            autoplayTimeout: <?php echo !empty($gks_slider->options[GKSOption::kSliderAutoplaySpeed]) ? $gks_slider->options[GKSOption::kSliderAutoplaySpeed]*1000 : 5000 ?>,
            autoplayHoverPause: <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM && $gks_slider->options[GKSOption::kSliderPauseOnHover] ? 'true' : 'false' ?>,
            mouseDrag: true,
            touchDrag: true,
            nav: false,
            dots: <?php echo $gks_slider->options[GKSOption::kShowPagination] ? 'true' : 'false' ?>,
            dotsEach: false,
            smartSpeed: slideSpeed,
            fluidSpeed: slideSpeed
        };

        <?php if ($isStagingAvailable): ?>
            settings.responsive = {
              0:{
                  items:1,
                  stagePadding: 60
              },
              600:{
                  items:1,
                  stagePadding: 100
              },
              1000:{
                  items:1,
                  stagePadding: 200
              },
              1200:{
                  items:1,
                  stagePadding: 250
              },
              1400:{
                  items:1,
                  stagePadding: 300
              },
              1600:{
                  items:1,
                  stagePadding: 350
              },
              1800:{
                  items:1,
                  stagePadding: 400
              }
            };

        <?php endif; ?>

        <?php if ($isCarousel) { ?>
            settings.responsive = {
                0 : {
                    items: <?php echo !empty($gks_slider->options[GKSOption::kMobileCols]) ? $gks_slider->options[GKSOption::kMobileCols] : 1; ?>
                },
                <?php echo $mmxw+1; ?> : {
                    items: <?php echo !empty($gks_slider->options[GKSOption::kTabletCols]) ? $gks_slider->options[GKSOption::kTabletCols] : 2; ?>
                },
                <?php echo $dmnw; ?> : {
                    items: <?php echo !empty($gks_slider->options[GKSOption::kDesktopCols]) ? $gks_slider->options[GKSOption::kDesktopCols] : 3; ?>
                },
                <?php echo $dmxw+1; ?> : {
                    items: <?php echo !empty($gks_slider->options[GKSOption::kLgDesktopCols]) ? $gks_slider->options[GKSOption::kLgDesktopCols] : 4; ?>
                }
            };
            settings.slideBy = <?php echo ($gks_slider->options[GKSOption::kSlideStep] == GKSSlideStep::Slide) ? 1 : "'page'"; ?>;
            settings.onInitialized = function(){
            <?php if ($gks_slider->options[GKSOption::kSliderPaginationPosition] == GKSSliderPaginationPosition::BeforeSlider) { ?>
                jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .owl-carousel').prepend(jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .owl-dots'));
                jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .owl-dots').css('padding-bottom', '10px');
            <?php } ?>
                <?php
                if ($heightIsProportional) {
                $parts = explode('x', $gks_slider->options[GKSOption::kTileProportion]);
                ?>
                gks_AdjustSliderProportions(<?php echo $gks_slider->id; ?>, <?php echo $parts[0]/$parts[1]; ?>);
                <?php } ?>
            };

        <?php } else { ?>
            settings.autoHeight = <?php echo $gks_slider->options[GKSOption::kSliderAutoHeight] ? 'true' : 'false' ?>;
            settings.animateOut = '<?php echo $isSlideAnimationsAvailable ? "fake" : ""?>';
            settings.animateIn = '<?php echo $isSlideAnimationsAvailable ? "fake" : ""?>';
        <?php } ?>

        <?php
        if (!$isCarousel && $heightIsProportional) {
        $parts = explode('x', $gks_slider->options[GKSOption::kTileProportion]);
        ?>
        settings.onInitialized = function(event) {
            gks_AdjustSliderProportions(<?php echo $gks_slider->id; ?>, <?php echo $parts[0]/$parts[1]; ?>);
        };
        <?php } ?>

        var gksSlider = jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .owl-carousel').owlCarousel(settings);
        gksSlider.on('changed.owl.carousel', function(property) {
          gks_destroyPlayer();

          if (<?php echo $isAutoplayVideo && !$isCarousel ? "true" : "false"; ?> ) {
            var current = property.item.index;
            var target = jQuery(property.target).find(".owl-item").eq(current).find(".gks-slider-cell");
            jQuery(target).trigger("click");
          }
        });

        //
        <?php if ($isSlideAnimationsAvailable && GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM): ?>
          var effect = gks_getAnimationName(gksSlider),
          outIndex,
          isDragged = false;

          gksSlider.on('change.owl.carousel', function(event) {
              outIndex = event.item.index;
          });

          gksSlider.on('changed.owl.carousel', function(event) {
              var inIndex = event.item.index,
              dir = outIndex <= inIndex ? 'Next' : 'Prev';

              var animation = {
                  moveIn: {
                    item: jQuery('.owl-item', gksSlider).eq(inIndex),
                    effect: effect + 'In' + dir
                  },
                  moveOut: {
                    item: jQuery('.owl-item', gksSlider).eq(outIndex),
                    effect: effect + 'Out' + dir
                  },
                  run: function (type) {
                    var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
                        animationObj = this[type],
                        inOut = type == 'moveIn' ? 'in' : 'out',
                        animationClass = 'animated owl-animated-' + inOut + ' ' + animationObj.effect;

                        animationObj.item.stop().addClass(animationClass).one(animationEndEvent, function () {
                          // remove class at the end of the animations
                          animationObj.item.removeClass(animationClass);
                        });
                   }
                };

                if (!isDragged){
                  animation.run('moveOut');
                  animation.run('moveIn');
                }
            });

            gksSlider.on('drag.owl.carousel', function(event) {
                isDragged = true;
            });

            gksSlider.on('dragged.owl.carousel', function(event) {
                isDragged = false;
            });

        <?php endif; ?>

        jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .gks-slider-ctrl-prev').click(function() {
            jQuery(this).closest('.gks-slider-layout').find('.owl-carousel').trigger('prev.owl.carousel', [1000]);
        });

        gksSlider.on('changed.owl.carousel', function(event) {
            jQuery("#gks-slider-<?php echo $gks_slider->id; ?> .gks-info-opened .gks-slider-info-toggle").click();
        });

        jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .gks-slider-ctrl-next').click(function() {
            jQuery(this).closest('.gks-slider-layout').find('.owl-carousel').trigger('next.owl.carousel', [1000]);
        });

        jQuery(window).resize(function(){
            gks_AdjustSlider(jQuery("#gks-slider-<?php echo $gks_slider->id; ?>"));
        });

        gks_AdjustSlider(jQuery("#gks-slider-<?php echo $gks_slider->id; ?>"));

        jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .gks-slider-info-toggle').click(function(){
            var caption = jQuery(this).closest('.gks-slider-overlay-caption');
            caption.toggleClass('gks-info-opened');
            if (caption.hasClass('gks-info-opened')) {
                jQuery('.gks-slider-info-toggle', caption).removeClass('fa-angle-down');
                jQuery('.gks-slider-info-toggle', caption).addClass('fa-angle-up');
                jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .gks-slider-ctrl').animate({opacity: 0}, 100);
            } else {
                jQuery('.gks-slider-info-toggle', caption).addClass('fa-angle-down');
                jQuery('.gks-slider-info-toggle', caption).removeClass('fa-angle-up');
                jQuery('#gks-slider-<?php echo $gks_slider->id; ?> .gks-slider-ctrl').animate({opacity: 1}, 100);
            }
            return false;
        });

        <?php

        if ($heightIsProportional) {
        $parts = explode('x', $gks_slider->options[GKSOption::kTileProportion]);
        ?>

        jQuery(window).resize(function(){
            gks_AdjustSliderProportions(<?php echo $gks_slider->id; ?>, <?php echo $parts[0]/$parts[1]; ?>);
        });
        gksSlider.on('resized.owl.carousel', function(event) {
            gks_AdjustSliderProportions(<?php echo $gks_slider->id; ?>, <?php echo $parts[0]/$parts[1]; ?>);
        });
        <?php
        }
        ?>

        jQuery("#gks-slider-<?php echo $gks_slider->id; ?> .gks-slider-cell-content").on("click", function(evt){
          if (jQuery("#gks-slider-<?php echo $gks_slider->id; ?> .gks-slider-onslide-details").has(evt.target).length) {
            return;
          }

          var parent = jQuery(this).closest(".gks-slider-cell");
          var type = jQuery(parent).data("type");
          if(type != "html") {
            if (<?php echo $isShowPopup ? "true" : "false" ?> || (type == "youtube" || type == "vimeo" || type == "video")) {
              evt.preventDefault();
            }
          }

          gks_handleClickAction(this, <?php echo $isShowPopup ? "true" : "false" ?>);
        });

        if (<?php echo $isAutoplayVideo && !$isCarousel ? "true" : "false"; ?>) {
          jQuery("#gks-slider-<?php echo $gks_slider->id; ?> #0.gks-slider-cell").trigger("click");
        }
    });

    function gks_handleClickAction(target, showPopup) {
      var parent = jQuery(target).closest(".gks-slider-cell");
      var index = jQuery(parent).data("index");

      var type = jQuery(parent).data("type");
      if (!showPopup && (type == "youtube" || type == "vimeo" || type == "video" || type == "yoo-media-player")) {
        gks_injectPlayer(parent);
      } else if(type != "html" && showPopup) {
        <?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM): ?>
          gks_openPopup(target);
        <?php endif; ?>
      }
    }

    jQuery(window).on('hashchange, popstate', function (event) {
        if(gksPopupIsOpen) {
            gksPopupIsOpen = false;
            gksBackCloses = true;
            jQuery('.lg-close').click();
        }
    });


    function gks_getAnimationName(slider){
      var re = /fx[a-zA-Z0-9\-_]+/i,
          matches = re.exec(slider.attr('class'));

      return matches !== null ? matches[0] : matches;
    }

    function gks_destroyPlayer() {
      var video = jQuery("#gksvideo");
      jQuery(video).closest(".gks-slider-cell").find(".gks-slider-onslide-content").css("visibility", "visible");
      jQuery(video).closest(".gks-slider-cell").find(".gks-video-play-icon").css("visibility", "visible");

      if (video) {
        video.attr("src","");
        video.remove();
      }
    }

    function gks_injectPlayer(parent) {
      var type = jQuery(parent).data("type");
      var src = jQuery(parent).data("src");

      if (type == "youtube" || type == "vimeo" || type == "video") {
        gks_destroyPlayer();

        var embbedIn = jQuery(parent).find(".gks-slider-cell-content-image").length > 0 ? jQuery(parent).find(".gks-slider-cell-content-image") : parent;
        jQuery('<iframe>', {
             src: src,
             id:  'gksvideo',
             frameborder: 0,
             scrolling: 'no',
             allow: 'autoplay',
             allowfullscreen: 'allowfullscreen',
             style: "position: absolute; width: 100%; height: 100%; left:0; top:0; z-index: 3; background-color: #000; z-index: 1000"
        }).appendTo(jQuery(embbedIn));

        jQuery(parent).find(".gks-slider-onslide-content").css("visibility", "hidden");
        jQuery(parent).find(".gks-video-play-icon").css("visibility", "hidden");
      }
    }

</script>

<?php
  if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
    if ($isScrollerAvailable && !$isCarousel) {
      echo gks_render_scroller_js($gks_slider);
    }
  }
?>
