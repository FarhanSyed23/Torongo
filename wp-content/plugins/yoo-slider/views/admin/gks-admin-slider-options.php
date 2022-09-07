<?php

$gks_sid = isset($_GET['id']) ? (int)$_GET['id'] : 0;

function gks_tooltipForOption($option){
    $tooltip = "";
    $tooltip .= "<div class=\"gks-tooltip-content\">";
    $tooltip .=      "<img src=\"". GKS_IMAGES_URL ."/general/glazzed-image-placeholder.png\" />";
    $tooltip .= "</div>";

    $tooltip = htmlentities($tooltip);
    return $tooltip;
}


function gks_layoutWithName($name, $active = ''){
    $layoutType = layoutTypeWithName($name);
    $html = "";

    $html .= "<li id='{$layoutType}' class='gks-layout-type-option {$active} " .  (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE && $layoutType != GKSViewType::SliderStandard && $layoutType != GKSViewType::SliderCarousel ? "gks-free" : "gks-premium") . "' onClick=' " . (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE && $layoutType != GKSViewType::SliderStandard && $layoutType != GKSViewType::SliderCarousel ? "" : "onChooseLayout(event,this)" ) . "'>";
    $html .=    "<a>";
    $html .=        "<div class='gks-layout-thumb gks-layout-{$name}'>";
    $html .=            "<div class='gks-thumb-overlay " . (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE && $layoutType != GKSViewType::SliderStandard && $layoutType != GKSViewType::SliderCarousel ? "gks-free" : "gks-premium") . "'>";
    if (GKS_PKG_TYPE != GKS_PKG_TYPE_FREE || ( GKS_PKG_TYPE == GKS_PKG_TYPE_FREE && ($layoutType == GKSViewType::SliderStandard || $layoutType == GKSViewType::SliderCarousel))) {
      $html .=                "<i class='gks-layout-tick fa gks-fa fa-check'></i>";
    }
    $html .=            "</div>";

    if (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE && $layoutType != GKSViewType::SliderStandard && $layoutType != GKSViewType::SliderCarousel) {
      $html .=          "<div class='gks-layout-premium-badge'>PREMIUM</div>";
    }
    $html .=            "<h3 class='gks-layout-title'>" . layoutDisplayName($layoutType) . "</h3>";
    $html .=        "</div>";
    $html .=    "</a>";
    $html .= "</li>";

    return $html;
}

function layoutTypeWithName($name){

    if($name == "slider-general"){
        return GKSViewType::SliderStandard;
    }else if($name == "slider-carousel"){
        return GKSViewType::SliderCarousel;
    }else if($name == "slider-scroller"){
        return GKSViewType::SliderScroller;
    }else if($name == "slider-coverflow"){
        return GKSViewType::SliderCoverflow;
    }else{
        return GKSViewType::Unknown;
    }
}

function layoutDisplayName($type){

    if($type == GKSViewType::SliderStandard){
        return "SLIDER";
    }else if($type == GKSViewType::SliderCarousel){
        return "CAROUSEL";
    }else if($type == GKSViewType::SliderScroller){
        return "SCROLLER";
    }else if($type == GKSViewType::SliderCoverflow){
        return "COVERFLOW";
    }

    return "";
}

function gks_inflateFontawosomeIconOptions(){
    $html ='<option value="fa-angle-">Angles</option>
            <option value="fa-angle-double-"">Double anges</option>
            <option value="fa-caret-">Carets</option>
            <option value="fa-arrow-">Arrows</option>
            <option value="fa-arrow-circle-o-">Arrow circle</option>
            <option value="fa-arrow-circle-">Arrow circle filled</option>
            <option value="fa-long-arrow-">Long arrows</option>';
    return $html;
}

function gks_inflateButtonFontawosomeIconOptions(){
    $html ='<option value="diamond">Diamond</option>
            <option value="leanpub">Leanpub</option>
            <option value="neuter">Neuter</option>
            <option value="bolt">Bolt</option>
            <option value="bookmark">Bookmark</option>
            <option value="bookmark-o">Bookmark Outline</option>
            <option value="bug">Bug</option>
            <option value="bullseye">Bullseye</option>
            <option value="camera">Camera</option>
            <option value="camera-retro">Camera Retro</option>
            <option value="check">Check</option>
            <option value="check-circle">Check Circle</option>
            <option value="check-circle-o">Check Circle Outline</option>
            <option value="cloud">Cloud</option>
            <option value="coffee">Coffee</option>
            <option value="comment">Comment</option>
            <option value="comment-o">Comment Outline</option>
            <option value="crosshairs">Crosshairs</option>
            <option value="dot-circle-o">Dot Circle Outline</option>
            <option value="external-link">External Link</option>
            <option value="eye">Eye</option>
            <option value="file-image-o">File Image</option>
            <option value="fire">Fire</option>
            <option value="folder-open">Folder Open</option>
            <option value="folder-open-o">Folder Open Outline</option>
            <option value="heart">Heart</option>
            <option value="heart-o">Heart Outline</option>
            <option value="heartbeat">Heartbeat</option>
            <option value="info">Info</option>
            <option value="info-circle">Info Circle</option>
            <option value="lightbulb-o">LIghtbulb</option>
            <option value="magic">Magic</option>
            <option value="paper-plane">Paper Plane</option>
            <option value="paper-plane-o">Paper Plane Outline</option>
            <option value="paw">Paw</option>
            <option value="photo">Photo</option>
            <option value="plug">Plug</option>
            <option value="search">Search</option>
            <option value="search-plus">Search Plus</option>
            <option value="star">Star</option>
            <option value="star">Star Outline</option>
            <option value="tag">Label</option>
            <option value="thumbs-up">Thumbs Up</option>
            <option value="chain">Chain</option>
            <option value="chain-broken">Chain Broken</option>
            <option value="link">Link</option>
            <option value="hand-o-right">Hand Right</option>
            <option value="hand-o-up">Hand Up</option>
            <option value="arrows">Arrows</option>
            <option value="expand">Expand</option>';
    return $html;
}

function gks_inflateSlideAnimationOptions(){
    $html = ' <option value="">None</option>
              <option value="fxSoftScale">Soft scale</option>
              <option value="fxPressAway">Press away</option>
              <option value="fxSideSwing">Side Swing</option>
              <option value="fxFortuneWheel">Fortune wheel</option>
              <option value="fxArchiveMe">Archive me</option>
              <option value="fxVGrowth">Vertical growth</option>
              <option value="fxSoftPulse">Soft Pulse</option>
              <option value="fxCliffDiving">Cliff diving</option>';
    return $html;
}

function gks_inflateGoogleFontsOptions(){
    $html = '';

    $fonts = GKSPremiumFuncs::getGoogleFontsList();
    foreach($fonts as $font) {
      $html .= ' <option value="' . $font["family"] . '">' . $font["family"] . '</option>';
    }

    return $html;
}

function gks_inflateOpacityOptions(){
    $html = '<option value="FF">100%</option>
             <option value="F2">95%</option>
             <option value="E6">90%</option>
             <option value="D9">85%</option>
             <option value="CC">80%</option>
             <option value="BF">75%</option>
             <option value="B3">70%</option>
             <option value="A6">65%</option>
             <option value="99">60%</option>
             <option value="8C">55%</option>
             <option value="80">50%</option>
             <option value="73">45%</option>
             <option value="66">40%</option>
             <option value="59">35%</option>
             <option value="4D">30%</option>
             <option value="40">25%</option>
             <option value="33">20%</option>
             <option value="26">15%</option>
             <option value="1A">10%</option>
             <option value="0D">5%</option>
             <option value="00">0%</option>';

    return $html;
}

?>

<div class="gks-options-header">
    <div class="gks-three-parts gks-fl">
        <a class='gks-back-btn button-secondary slider-button gks-glazzed-btn gks-glazzed-btn-dark' href="<?php echo "?page={$gks_adminPage}"; ?>">
            <div class='gks-icon gks-slider-button-icon'><i class="fa gks-fa fa-long-arrow-left"></i></div>
        </a>
    </div>

    <div class="gks-three-parts gks-fl gks-title-part gks-settings-title"><span></span></div>

    <div class="gks-three-parts gks-fr">
        <a id="gks-save-options-button" class='button-secondary options-button gks-glazzed-btn gks-glazzed-btn-green' href="#">
            <div class='gks-icon gks-slider-button-icon'><i class="fa gks-fa fa-save fa-fw"></i></div>
        </a>
    </div>
</div>

<hr />

<div id="gks-options-accordion" class="gks-options-wrapper gks-slider-options-wrapper">
    <h3 class="gks-section-title">SLIDER SETTINGS</h3>

    <div class="collapse-card active">
        <div class="title">
            Layout type
        </div>
        <div class="body" style="display: block">
            <div class="gks-options-section">
                <ul class="gks-layouts">
                    <?php echo gks_layoutWithName('slider-general'); ?>
                    <?php echo gks_layoutWithName('slider-carousel'); ?>
                    <?php echo gks_layoutWithName('slider-scroller'); ?>
                    <?php echo gks_layoutWithName('slider-coverflow'); ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Slider elements
        </div>
        <div class="body">
            <div class="gks-options-section">
              <br/>

                <div class="" style="">
                    <div class="gks-options-row">
                        <label>Show slide title:</label>
                        <input id="<?php echo GKSOption::kShowTitle ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slide details:</label>
                        <input id="<?php echo GKSOption::kShowDetails ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slide info on mobile:</label>
                        <input id="<?php echo GKSOption::kShowInfoMobile ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row gks-binding" data-binding="">
                      <hr/>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slider arrows:</label>
                        <input id="<?php echo GKSOption::kShowArrows ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row gks-binding" data-binding="">
                      <hr/>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slider pagination:</label>
                        <input id="<?php echo GKSOption::kShowPagination ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row">
                        <label>Show pagination on mobile:</label>
                        <input id="<?php echo GKSOption::kShowPaginationMobile ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row gks-binding" data-binding="">
                      <hr/>
                    </div>

                    <div class="gks-options-row">
                        <label>Open popup on click:</label>
                        <input id="<?php echo GKSOption::kShowPopupOnClick ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>
                </div>

              <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kShowBorder ?>">
                <hr/>
              </div>

                <div class="">
                    <div class="gks-options-row">
                        <label>Show slide border:</label>
                        <input id="<?php echo GKSOption::kShowBorder ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slide border on hover:</label>
                        <input id="<?php echo GKSOption::kShowBorderOnHover ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kShowShadow ?>">
                      <hr/>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slide shadow:</label>
                        <input id="<?php echo GKSOption::kShowShadow ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slide shadow on hover:</label>
                        <input id="<?php echo GKSOption::kShowShadowOnHover ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kShowOverlay ?>">
                      <hr/>
                    </div>

                    <div class="gks-options-row">
                        <label>Show slide overlay on hover:</label>
                        <input id="<?php echo GKSOption::kShowOverlay ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kShowButton ?>">
                      <hr/>
                    </div>

                    <div class="gks-options-row">
                        <label>Show button on slide:</label>
                        <input id="<?php echo GKSOption::kShowButton ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="gks-options-row">
                        <label>Appear slide button on hover:</label>
                        <input id="<?php echo GKSOption::kAppearButtonOnHover ?>" type="checkbox">
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Styles & effects
        </div>
        <div class="body">
            <div class="gks-options-section">

                <br/>
                <div class="gks-options-row">
                    <label>Slider arrow icon style:</label>
                    <select id="<?php echo GKSOption::kArrowIconStyle ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <?php echo gks_inflateFontawosomeIconOptions(); ?>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Slider arrow bg style:</label>
                    <select id="<?php echo GKSOption::kArrowBgStyle ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <option value="<?php echo GKSSliderArrowBgStyle::None ?>" selected="selected">None</option>
                        <option value="<?php echo GKSSliderArrowBgStyle::Dot ?>">Circle</option>
                        <option value="<?php echo GKSSliderArrowBgStyle::Square ?>">Square</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Slider arrow position:</label>
                    <select id="<?php echo GKSOption::kArrowPosition ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <option value="<?php echo GKSSliderArrowPosition::Center ?>" selected="selected">Center</option>
                        <option value="<?php echo GKSSliderArrowPosition::Top ?>">Top</option>
                        <option value="<?php echo GKSSliderArrowPosition::Bottom ?>">Bottom</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Appear slider arrows on hover:</label>
                    <input id="<?php echo GKSOption::kAppearArrowsOnHover ?>" type="checkbox">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="">
                  <hr/>
                </div>

                <div class="gks-options-row">
                    <label>Slider pagination style:</label>

                    <select id="<?php echo GKSOption::kSliderPaginationStyle ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <option value="<?php echo GKSSliderPaginationStyle::Dots ?>" selected="selected">Dots</option>
                        <option value="<?php echo GKSSliderPaginationStyle::Squares ?>">Squares</option>
                        <option value="<?php echo GKSSliderPaginationStyle::Rectangles ?>">Rectangles</option>
                        <option value="<?php echo GKSSliderPaginationStyle::Ovals ?>">Ovals</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Slider pagination position:</label>

                    <select id="<?php echo GKSOption::kSliderPaginationPosition ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <option class="no-carousel carousel" value="<?php echo GKSSliderPaginationPosition::AfterSlider ?>" selected="selected">After slider</option>
                        <option class="carousel" value="<?php echo GKSSliderPaginationPosition::BeforeSlider ?>" selected="selected">Before slider</option>
                        <option class="no-carousel" value="<?php echo GKSSliderPaginationPosition::OnSliderBottom ?>">On slider bottom</option>
                        <option class="no-carousel" value="<?php echo GKSSliderPaginationPosition::OnSliderTop ?>">On slider top</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kSlideAnimation ?>">
                  <hr/>
                </div>

                <div class="gks-options-row">
                    <label>Slide animation:</label>

                    <select id="<?php echo GKSOption::kSlideAnimation ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <?php echo gks_inflateSlideAnimationOptions(); ?>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kSliderTextWidthStyle ?>">
                  <hr/>
                </div>

                <div class="gks-options-row">
                    <label>Slide info box width:</label>

                    <select id="<?php echo GKSOption::kSliderTextWidthStyle ?>">
                        <option value="<?php echo GKSSliderTextWidthStyle::Auto ?>" selected="selected">Auto</option>
                        <option value="<?php echo GKSSliderTextWidthStyle::Fill ?>">Fill</option>
                    </select>

                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Info box position on slide:</label>

                    <select id="<?php echo GKSOption::kSliderTextPosition ?>">
                        <option value="<?php echo GKSSliderTextPosition::TopLeft ?>" selected="selected">Top Left</option>
                        <option value="<?php echo GKSSliderTextPosition::TopRight ?>">Top Right</option>
                        <option value="<?php echo GKSSliderTextPosition::LeftBottom ?>">Left Bottom</option>
                        <option value="<?php echo GKSSliderTextPosition::RightBottom ?>">Right Bottom</option>
                        <option value="<?php echo GKSSliderTextPosition::TopCenter ?>">Top Center</option>
                        <option value="<?php echo GKSSliderTextPosition::BottomCenter ?>">Bottom Center</option>
                    </select>

                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kInfoDisplayStyle ?>">
                  <hr/>
                </div>

                <div class="gks-options-row">
                    <label>Info display style:</label>

                    <select id="<?php echo GKSOption::kInfoDisplayStyle ?>">
                        <option value="<?php echo GKSInfoDisplayStyle::After ?>">After slide picture</option>
                        <option value="<?php echo GKSInfoDisplayStyle::Before ?>">Before slide picture</option>
                        <option value="<?php echo GKSInfoDisplayStyle::OnTop ?>" selected="selected">On slide picture top</option>
                        <option value="<?php echo GKSInfoDisplayStyle::OnTopHover ?>">On slide picture top on hover</option>
                        <option value="<?php echo GKSInfoDisplayStyle::OnBottom ?>">On slide picture bottom</option>
                        <option value="<?php echo GKSInfoDisplayStyle::OnBottomHover ?>">On slide picture bottom on hover</option>
                        <option value="<?php echo GKSInfoDisplayStyle::OnCenter ?>">On slide picture center</option>
                        <option value="<?php echo GKSInfoDisplayStyle::OnCenterHover ?>">On slide picture center on hover</option>
                    </select>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kButtonStyle ?>">
                  <hr/>
                </div>

                <div class="gks-options-row">
                    <label>Slide button style:</label>

                    <select id="<?php echo GKSOption::kButtonStyle ?>">
                        <option value="<?php echo GKSButtonStyle::Rect ?>" selected="selected">Rectangular</option>
                        <option value="<?php echo GKSButtonStyle::Circle ?>">Circle</option>
                    </select>
                </div>

                <div class="gks-options-row">
                    <label>Slide button icon:</label>

                    <select id="<?php echo GKSOption::kButtonIcon ?>">
                        <?php echo gks_inflateButtonFontawosomeIconOptions(); ?>
                    </select>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kPictureHoverEffect ?>">
                  <hr/>
                </div>

                <div class="gks-options-row">
                      <label>Slide picture hover effect:</label>

                      <select id="<?php echo GKSOption::kPictureHoverEffect ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                          <option value="<?php echo GKSPictureHoverStyle::none ?>" selected="true">None</option>
                          <option value="<?php echo GKSPictureHoverStyle::style01 ?>"> Zoom in</option>
                          <option value="<?php echo GKSPictureHoverStyle::style02 ?>"> Zoom out</option>
                          <option value="<?php echo GKSPictureHoverStyle::style05 ?>"> RGB to Grayscale</option>
                          <option value="<?php echo GKSPictureHoverStyle::style06 ?>"> Grayscale to RGB</option>
                          <option value="<?php echo GKSPictureHoverStyle::style07 ?>"> Zoom in & rotate</option>
                      </select>
                      <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                  </div>
            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Colorizations
        </div>
        <div class="body">
            <div class="gks-options-section">

                <br/>

                <div class="gks-options-row fh">
                    <label>Slide title color:</label>
                    <input id="<?php echo GKSOption::kTileTitleColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide details color:</label>
                    <input id="<?php echo GKSOption::kTileDescColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label class="gks-label">Slide info box color:</label>
                    <input id="<?php echo GKSOption::kTileOverlayColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label class="gks-label">Slide info box opacity:</label>
                    <select id="<?php echo GKSOption::kTileOverlayOpacity ?>" class="w2">
                        <?php echo gks_inflateOpacityOptions(); ?>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kSlideBgColor ?>">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide bg color:</label>
                    <input id="<?php echo GKSOption::kSlideBgColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide bg opacity:</label>
                    <select id="<?php echo GKSOption::kSlideBgOpacity ?>" class="w2">
                        <?php echo gks_inflateOpacityOptions(); ?>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide bg color on hover:</label>
                    <input id="<?php echo GKSOption::kSlideBgHoverColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide bg opacity on hover:</label>
                    <select id="<?php echo GKSOption::kSlideBgHoverOpacity ?>" class="w2">
                        <?php echo gks_inflateOpacityOptions(); ?>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kBorderColor ?>">
                  <hr/>
                </div>

                <div class="gks-options-row fh <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-disabled-color-picker' : '' ?> ">
                    <label>Slide border color:</label>
                    <input id="<?php echo GKSOption::kBorderColor ?>" type="text" class="gks-color-picker">
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge gks-premium-color-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-disabled-color-picker' : '' ?> fh">
                    <label>Slide shadow color:</label>
                    <input id="<?php echo GKSOption::kShadowColor ?>" type="text" class="gks-color-picker">
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge gks-premium-color-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kButtonIconColor ?>">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide button icon color:</label>
                    <input id="<?php echo GKSOption::kButtonIconColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide button bg color:</label>
                    <input id="<?php echo GKSOption::kButtonBgColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide button bg opacity:</label>
                    <select id="<?php echo GKSOption::kButtonBgOpacity ?>" class="w2">
                        <?php echo gks_inflateOpacityOptions(); ?>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide button bg color on hover:</label>
                    <input id="<?php echo GKSOption::kButtonBgHoverColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide button bg opacity on hover:</label>
                    <select id="<?php echo GKSOption::kButtonBgHoverOpacity ?>" class="w2">
                        <?php echo gks_inflateOpacityOptions(); ?>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kPaginationColor ?>">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label>Slider pagination color:</label>
                    <input id="<?php echo GKSOption::kPaginationColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slider active page color:</label>
                    <input id="<?php echo GKSOption::kPaginationHoverColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kArrowColor ?>">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label>Slider arrow icon color:</label>
                    <input id="<?php echo GKSOption::kArrowColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Arrow icon color on hover:</label>
                    <input id="<?php echo GKSOption::kArrowHoverColor ?>" type="text" class="gks-color-picker">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-disabled-color-picker' : '' ?>  fh">
                    <label>Arrow bg color:</label>
                    <input id="<?php echo GKSOption::kArrowBgColor ?>" type="text" class="gks-color-picker">
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge gks-premium-color-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Arrow bg opacity:</label>
                    <select id="<?php echo GKSOption::kArrowBgOpacity ?>" class="w2 <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> >
                        <?php echo gks_inflateOpacityOptions(); ?>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-disabled-color-picker' : '' ?>  fh">
                    <label>Arrow bg color on hover:</label>
                    <input id="<?php echo GKSOption::kArrowBgHoverColor ?>" type="text" class="gks-color-picker">
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge gks-premium-color-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>


                <div class="gks-options-row fh">
                    <label>Arrow bg opacity on hover:</label>
                    <select id="<?php echo GKSOption::kArrowBgHoverOpacity ?>" class="w2 <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?>>
                        <?php echo gks_inflateOpacityOptions(); ?>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Dimensions
        </div>
        <div class="body">
            <div class="gks-options-section">
              <br/>

                <div class="gks-options-row fh">
                    <label>Slide image height calculation:</label>
                    <select id="<?php echo GKSOption::kHeightCalcAlgo ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <option value="<?php echo GKSHeightCalcAlgo::Fixed ?>">Fixed</option>
                        <option value="<?php echo GKSHeightCalcAlgo::Proportional ?>">Proportional</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Height to width proportion:</label>
                    <select class="gks-proportion" id="<?php echo GKSOption::kTileProportion ?>">
                        <?php
                        foreach(GKSOption::getTileProportions() as $k => $v) {
                            echo '<option value="'.$k.'">'.$v.'</option>';
                        }
                        ?>
                    </select>
                    <select class="unit" disabled="disabled">
                        <option value="" selected="true">x width</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide image height:</label>
                    <input id="<?php echo GKSOption::kSliderHeight ?>" class="only-digits" type="text">
                    <select id="<?php echo GKSOption::kSliderHeight ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide info box margins:</label>
                    <input id="<?php echo GKSOption::kSliderInfoPadding ?>" class="only-digits" type="text">
                    <select id="<?php echo GKSOption::kSliderInfoPadding ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>


                <div class="gks-options-row fh">
                    <label>Slide paddings:</label>
                    <input id="<?php echo GKSOption::kSlidePadding?>" class="only-digits" type="text">
                    <select disabled="disabled" class="unit">
                        <option value="sec" selected="true">px</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Space between slides:</label>
                    <input id="<?php echo GKSOption::kSpaceBtwSlides ?>" class="only-digits" type="text">
                    <select id="<?php echo GKSOption::kSpaceBtwSlides ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kBorderRadius ?>">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide border radius:</label>
                    <input id="<?php echo GKSOption::kBorderRadius?>" class="only-digits <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>" type="text" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?>>
                    <select disabled="disabled" class="unit">
                        <option value="sec" selected="true">px</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slide border width:</label>
                    <input id="<?php echo GKSOption::kBorderWidth?>" class="only-digits <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>" type="text">
                    <select disabled="disabled" class="unit">
                        <option value="sec" selected="true">px</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>


                <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kArrowFontSize ?>">
                  <hr/>
                </div>

                <div class="gks-options-row fh">
                    <label>Arrow icon size:</label>
                    <input id="<?php echo GKSOption::kArrowFontSize?>" class="only-digits" type="text">
                    <select class="unit" disabled="disabled">
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Arrow horizontal margins:</label>
                    <input id="<?php echo GKSOption::kTilePaddings ?>" class="only-digits" type="text">
                    <select id="<?php echo GKSOption::kTilePaddings ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Arrow inner paddings:</label>
                    <input id="<?php echo GKSOption::kSliderArrowsPadding ?>" class="only-digits" type="text">
                    <select id="<?php echo GKSOption::kSliderArrowsPadding ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div id="gks-screen-sizes-box" class="gks-screen-sizes-box">

                  <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kLgDesktopCols ?>">
                    <hr/>
                  </div>


                    <div id="gks-col-numbers" class="gks-col-numbers">
                        <div class="gks-options-row fh">
                            <label>Columns for large container:</label>
                            <input id="<?php echo GKSOption::kLgDesktopCols ?>" class="only-digits" type="text">
                            <select class="unit" disabled="disabled">
                                <option value="cols" selected="true">cols</option>
                            </select>
                            <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                        </div>
                        <div class="gks-options-row fh">
                            <label>Columns for normal container:</label>
                            <input id="<?php echo GKSOption::kDesktopCols ?>" class="only-digits" type="text">
                            <select class="unit" disabled="disabled">
                                <option value="cols" selected="true">cols</option>
                            </select>
                            <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                        </div>
                        <div class="gks-options-row fh">
                            <label>Columns for medium container:</label>
                            <input id="<?php echo GKSOption::kTabletCols ?>" class="only-digits" type="text">
                            <select class="unit" disabled="disabled">
                                <option value="cols" selected="true">cols</option>
                            </select>
                            <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                        </div>
                        <div class="gks-options-row fh">
                            <label>Columns for small container:</label>
                            <input id="<?php echo GKSOption::kMobileCols ?>" class="only-digits" type="text">
                            <select class="unit" disabled="disabled">
                                <option value="cols" selected="true">cols</option>
                            </select>
                            <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                        </div>
                    </div>

                    <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kScreenSize ?>">
                      <hr/>
                    </div>

                    <div class="gks-options-row">
                        <label>Container width breakpoints:</label>

                        <select id="<?php echo GKSOption::kScreenSize ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                            <option value="<?php echo GKSScreenSize::Std ?>" selected="selected">Default</option>
                            <option value="<?php echo GKSScreenSize::Custom ?>">Custom</option>
                        </select>
                        <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                        <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div id="gks-screen-sizes" class="gks-screen-sizes">
                        <br>
                        <div id="gks-screen-size-slider" class="gks-screen-size-slider"></div>
                        <div id="gks-screen-size-values" class="gks-screen-size-values">
                            <span class="gks-fl">Small</span>
                            <span class="gks-fr">Large</span>

                            <input id="<?php echo GKSOption::kDesktopMaxWidth ?>" type="hidden">
                            <input id="<?php echo GKSOption::kDesktopMinWidth ?>" type="hidden">
                            <input id="<?php echo GKSOption::kMobileMaxWidth ?>" type="hidden">
                        </div>
                        <br>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Fonts
        </div>
        <div class="body">
            <div class="gks-options-section">

              <br/>
              <div class="gks-options-row">
                  <label>Slider general font:</label>
                  <select id="<?php echo GKSOption::kFont ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                      <option value="" selected="true">Theme default font</option>
                      <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM ? gks_inflateGoogleFontsOptions() : ""; ?>
                  </select>
                  <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>

              <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kTileTitleFontSize ?>">
                <hr/>
              </div>

              <div class="gks-options-row">
                  <label>Slide title font:</label>
                  <select id="<?php echo GKSOption::kTileTitleFont ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                      <option value="" selected="true">Theme default font</option>
                      <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM ? gks_inflateGoogleFontsOptions() : ""; ?>
                  </select>
                  <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>

              <div class="gks-options-row">
                  <label>Slide title font style:</label>
                  <select id="<?php echo GKSOption::kTileTitleFontStyle ?>">
                      <option value="normal" selected="true">Normal</option>
                      <option value="bold">Bold</option>
                      <option value="italic">Italic</option>
                  </select>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>

              <div class="gks-options-row fh">
                  <label>Slide title font size:</label>
                  <input id="<?php echo GKSOption::kTileTitleFontSize?>" class="only-digits" type="text">
                  <select class="unit" disabled="disabled">
                      <option value="px" selected="true">px</option>
                  </select>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>

              <div class="gks-options-row">
                  <label>Slide title alignment:</label>
                  <select id="<?php echo GKSOption::kTileTitleAlignment ?>">
                      <option value="left" selected="true">Left</option>
                      <option value="right">Right</option>
                      <option value="center">Center</option>
                      <option value="justify">Justify</option>
                  </select>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>

              <div class="gks-options-row gks-binding" data-binding="<?php echo GKSOption::kFontStyle ?>">
                <hr/>
              </div>

              <div class="gks-options-row">
                  <label>Slide details font style:</label>
                  <select id="<?php echo GKSOption::kFontStyle ?>">
                      <option value="normal" selected="true">Normal</option>
                      <option value="bold">Bold</option>
                      <option value="italic">Italic</option>
                  </select>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>


              <div class="gks-options-row fh">
                  <label>Slide details font size:</label>
                  <input id="<?php echo GKSOption::kFontSize?>" class="only-digits" type="text">
                  <select class="unit" disabled="disabled">
                      <option value="px" selected="true">px</option>
                  </select>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>


              <div class="gks-options-row">
                  <label>Slide details alignment:</label>
                  <select id="<?php echo GKSOption::kTileDescAlignment ?>">
                      <option value="left" selected="true">Left</option>
                      <option value="right">Right</option>
                      <option value="center">Center</option>
                      <option value="justify">Justify</option>
                  </select>
                  <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
              </div>

            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Advanced
        </div>
        <div class="body">
            <div class="gks-options-section gks-social-networks">

              <br/>

                <div class="gks-options-row">
                    <label>Slider autoplay:</label>
                    <input id="<?php echo GKSOption::kSliderAutoplay ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row fh">
                    <label>Slider autoplay speed:</label>
                    <input id="<?php echo GKSOption::kSliderAutoplaySpeed?>" class="only-digits <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>" type="text" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> >
                    <select disabled="disabled" style="width: 100px;">
                        <option value="sec" selected="true">sec</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Pause autoslide on hover:</label>
                    <input id="<?php echo GKSOption::kSliderPauseOnHover ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Loop slides:</label>
                    <input id="<?php echo GKSOption::kSliderLoop ?>" type="checkbox" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Slider slide step:</label>

                    <select id="<?php echo GKSOption::kSlideStep ?>" <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'disabled' : '' ?> class="<?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? 'gks-free' : '' ?>">
                        <option value="<?php echo GKSSlideStep::Slide ?>">One slide</option>
                        <option value="<?php echo GKSSlideStep::Page ?>">One page</option>
                    </select>
                    <?php if(GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?><div class='gks-premium-option-badge'>PREMIUM</div><?php endif; ?>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="">
                  <hr/>
                </div>

                <div class="gks-options-row">
                    <label>Slide image quality:</label>

                    <select id="<?php echo GKSOption::kThumbnailQuality ?>">
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                        <option value="original">Original</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Enable image lazy loading:</label>
                    <input id="<?php echo GKSOption::kEnableGridLazyLoad ?>" type="checkbox">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Use slide image original height:</label>
                    <input id="<?php echo GKSOption::kSliderAutoHeight ?>" type="checkbox">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Slide image fill mode:</label>

                    <select id="<?php echo GKSOption::kImageBackgroundSize ?>">
                        <option value="cover">Fill container</option>
                        <option value="contain">Fit container</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row">
                    <label>Slide image crop position:</label>

                    <select id="<?php echo GKSOption::kImageBackgroundPosition ?>">
                        <option value="center">Center</option>
                        <option value="top">Top</option>
                        <option value="bottom">Bottom</option>
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="gks-options-row gks-binding" data-binding="">
                  <hr/>
                </div>

                <div class="gks-options-row">
                    <label>Load url in a new tab:</label>
                    <input id="<?php echo GKSOption::kLoadUrlBlank ?>" type="checkbox">
                    <i class="fa gks-fa fa-info-circle tooltip" title="<?php echo gks_tooltipForOption('opname'); ?>"></i>
                </div>

            </div>
        </div>
    </div>
</div>

<?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) { ?>
  <div id="gks-scroller-options-accordion" class="gks-options-wrapper gks-slider-options-wrapper">
    <h3 class="gks-section-title">THUMBNAILS SCROLLER SETTINGS</h3>
    <?php require_once ('premium/gks-admin-scroller-options.php'); ?>
  </div>
<?php } ?>

<?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) { ?>
  <div id="gks-popup-options-accordion" class="gks-options-wrapper gks-slider-options-wrapper">
    <h3 class="gks-section-title">POPUP SETTINGS</h3>
    <?php require_once ('premium/gks-admin-popup-options.php'); ?>
  </div>
<?php } ?>


<div id="gks-custom-css-options-accordion" class="gks-options-wrapper gks-slider-options-wrapper">
  <h3 class="gks-section-title">DEVELOPER</h3>
  <?php require_once ('gks-admin-custom-css.php'); ?>
</div>

<div class="gks-options-footer">
<p class="gks-pwered-by">Powered by <a href="https://yooslider.com" target="_blank">Yoo Slider</a></p>
</div>

<!--Here Goes JS-->
<script>
    //Show loading while the page is being complete loaded
    gks_showSpinner();

    //Configure javascript vars passed PHP
    var gks_adminPage = "<?php echo $gks_adminPage ?>";
    var gks_sid = "<?php echo $gks_sid ?>";

    gks_options = {};

    jQuery(document).ready(function() {
        //Setup colorpicker
        jQuery(function() {
            jQuery( '.gks-color-picker' ).wpColorPicker();
            jQuery(".gks-disabled-color-picker .button").attr("disabled", true);
            jQuery(".gks-disabled-color-picker .button").addClass("gks-free");
        });

        //Setup tooltipster
        jQuery('.tooltip').tooltipster({
            contentAsHTML: true,
            position: 'left',
            animation: 'fade', //fade, grow, swing, slide, fall
            theme: 'tooltipster-shadow'
        });

        var options = gksAjaxGetOptionsWithPid(gks_sid);
        options = GksBase64.decode(options);
        gks_options = JSON.parse(options);

        if(gks_options.kViewerType > 3) {
            gks_options.kViewerType = '<?php echo GKSPjViewerType::LightGalleryLight; ?>'; // colorboxes to fixed size lightgallery
        }

        jQuery("#<?php echo GKSOption::kViewerType; ?>").change(function(){
            if (jQuery(this).val() == <?php echo GKSPjViewerType::LightGalleryLight; ?>) {
                jQuery(".popup-options .gks-options-row").hide();
                jQuery(".popup-options .gks-popup-commons").show();
                jQuery("#<?php echo GKSOption::kPopupShowCounter; ?>").closest('.gks-options-row').show();
                jQuery("#<?php echo GKSOption::kPopupTitlePosition; ?>").closest('.gks-options-row').show();
            } else if (jQuery(this).val() == <?php echo GKSPjViewerType::LightGalleryFixed; ?>) {
                jQuery(".popup-options .gks-options-row").hide();
                jQuery(".popup-options .gks-popup-commons").show();
                jQuery("#<?php echo GKSOption::kPopupTitlePosition; ?>").closest('.gks-options-row').show();
            } else {
                jQuery(".popup-options .gks-options-row").show();
                jQuery("#<?php echo GKSOption::kPopupTitlePosition; ?>").closest('.gks-options-row').hide();
            }
        });

        jQuery("#<?php echo GKSOption::kShowPopupOnClick; ?>").change(function(){
          if (jQuery(this).is(':checked')) {
            jQuery("#gks-popup-options-accordion").show();
          } else {
            jQuery("#gks-popup-options-accordion").hide();
          }
        });

        //Update UI based on the retrieved model
        gks_updateUI();

        //When the page is ready, hide loading spinner
        gks_hideSpinner();

    });

    function onChooseLayout(event,target){
        event.preventDefault();

        jQuery(".gks-layouts li.active").removeClass("active");
        jQuery(target).addClass("active");
        gks_configureSliderLayout();
    }

    jQuery("#gks-save-options-button").on( 'click', function( evt ){
        evt.preventDefault();

        //Show spinner
        gks_showSpinner();

        //Apply last changes to the model
        gks_updateModel();

        //Perform Ajax calls
        var options = GksBase64.encode(JSON.stringify(gks_options));
        var response = gksAjaxSaveOptionsWithPid(options, gks_sid);

        //Hide spinner
        gks_hideSpinner();
    });

    jQuery("#gks-back-button").on( 'click', function( evt ){
        evt.preventDefault();
        window.history.back();
    });

    jQuery(document).keypress(function(event) {
        //cmd+s or control+s
        if (event.which == 115 && (event.ctrlKey||event.metaKey)|| (event.which == 19)) {
            event.preventDefault();

            jQuery( "#gks-save-options-button" ).trigger( "click" );
            return false;
        }
        return true;
    });

    jQuery( "#<?php echo GKSOption::kTileTitleFont ?>" ).change(function() {
        var str = jQuery( this ).val();
        gks_updateTileFontPreview(this, str);
    });

    jQuery( "#<?php echo GKSOption::kFont ?>" ).change(function() {
        var str = jQuery( this ).val();
        gks_updateTileFontPreview(this, str);
    });


    jQuery( "input[type='text'].only-digits" ).change(function() {
        var str = jQuery( this ).val();
        str = str.replace(/[^0-9]/g, '');
        if(!str){
            str = "0";
        }
        jQuery(this).attr("value",str);
    });

    function gks_updateUICheckbox(options){
        for(var i in options) {
            jQuery('#'+options[i]).attr('checked', gks_options[options[i]] );
        }
    }
    function gks_updateUISelectbox(options){
        for(var i in options) {
            setOptionSelectedFor('#'+options[i], gks_options[options[i]]);
        }
    }
    function gks_updateUITextbox(options){
        for(var i in options) {
            jQuery('#'+options[i]).attr('value', gks_options[options[i]]);
        }
    }

    function gks_fixDefaults() {
      if(jQuery('#kScrollerHeight').attr("value") == "") {

        jQuery('#kScrollerShowCover').attr('checked', 1 );
        setOptionSelectedFor('#kScrollerPosition', 'before');
        jQuery('#kScrollerHeight').attr('value', 70);
        jQuery('#kScrollerLgDesktopCols').attr('value', 6);
        jQuery('#kScrollerDesktopCols').attr('value', 5);
        jQuery('#kScrollerTabletCols').attr('value', 4);
        jQuery('#kScrollerMobileCols').attr('value', 3);
      }
    }

    function gks_getCheckboxOptions()
    {
        return [
            '<?php echo GKSOption::kShowTitle; ?>',
            '<?php echo GKSOption::kShowDetails; ?>',
            '<?php echo GKSOption::kShowInfoMobile; ?>',
            '<?php echo GKSOption::kShowArrows; ?>',
            '<?php echo GKSOption::kShowPagination; ?>',
            '<?php echo GKSOption::kShowPaginationMobile; ?>',
            '<?php echo GKSOption::kAppearArrowsOnHover; ?>',
            '<?php echo GKSOption::kShowPopupOnClick; ?>',
            '<?php echo GKSOption::kSliderAutoplay; ?>',
            '<?php echo GKSOption::kSliderAutoHeight; ?>',
            '<?php echo GKSOption::kSliderLoop; ?>',
            '<?php echo GKSOption::kSliderPauseOnHover; ?>',
            '<?php echo GKSOption::kEnableGridLazyLoad; ?>',
            '<?php echo GKSOption::kLoadUrlBlank; ?>',

            '<?php echo GKSOption::kShowBorder; ?>',
            '<?php echo GKSOption::kShowShadow; ?>',
            '<?php echo GKSOption::kShowOverlay; ?>',
            '<?php echo GKSOption::kShowBorderOnHover; ?>',
            '<?php echo GKSOption::kShowShadowOnHover; ?>',
            '<?php echo GKSOption::kShowButton; ?>',
            '<?php echo GKSOption::kAppearButtonOnHover; ?>',
            // Popup options
            '<?php echo GKSOption::kPopupShowTitle ?>',
            '<?php echo GKSOption::kPopupShowTextToggle ?>',
            '<?php echo GKSOption::kPopupShowCounter ?>',
            '<?php echo GKSOption::kPopupShowZoomButtons ?>',
            '<?php echo GKSOption::kPopupShowSlideshowButton ?>',
            '<?php echo GKSOption::kPopupShowFullscreenButton ?>',
            '<?php echo GKSOption::kPopupShowLinkButton ?>',
            '<?php echo GKSOption::kPopupShowThumbnails ?>',
            '<?php echo GKSOption::kPopupShowPaging ?>',
            '<?php echo GKSOption::kPopupAutoplaySlideshow ?>',
            '<?php echo GKSOption::kPopupAutoopenThumbnails ?>',

            // Scroller
            '<?php echo GKSOption::kScrollerShowTitle; ?>',
            '<?php echo GKSOption::kScrollerShowCover; ?>',
            '<?php echo GKSOption::kScrollerShowBorder; ?>'
        ];
    }

    function gks_getSelectboxOptions()
    {
        return [
            '<?php echo GKSOption::kArrowIconStyle; ?>',
            '<?php echo GKSOption::kSliderPaginationStyle; ?>',
            '<?php echo GKSOption::kSliderPaginationPosition; ?>',
            '<?php echo GKSOption::kArrowBgStyle; ?>',
            '<?php echo GKSOption::kArrowPosition; ?>',
            '<?php echo GKSOption::kSlideAnimation; ?>',
            '<?php echo GKSOption::kSliderTextPosition; ?>',
            '<?php echo GKSOption::kSliderTextWidthStyle; ?>',
            '<?php echo GKSOption::kTileOverlayOpacity; ?>',
            '<?php echo GKSOption::kArrowBgOpacity; ?>',
            '<?php echo GKSOption::kArrowBgHoverOpacity; ?>',
            '<?php echo GKSOption::kFont; ?>',
            '<?php echo GKSOption::kTileTitleFont; ?>',
            '<?php echo GKSOption::kTileTitleFontStyle; ?>',
            '<?php echo GKSOption::kFontStyle; ?>',
            '<?php echo GKSOption::kThumbnailQuality; ?>',
            '<?php echo GKSOption::kImageBackgroundSize; ?>',
            '<?php echo GKSOption::kImageBackgroundPosition; ?>',
            '<?php echo GKSOption::kTileTitleAlignment ?>',
            '<?php echo GKSOption::kTileDescAlignment ?>',
            '<?php echo GKSOption::kInfoDisplayStyle ?>',
            '<?php echo GKSOption::kButtonStyle ?>',
            '<?php echo GKSOption::kPictureHoverEffect ?>',
            '<?php echo GKSOption::kButtonIcon ?>',
            '<?php echo GKSOption::kSlideBgOpacity; ?>',
            '<?php echo GKSOption::kSlideBgHoverOpacity; ?>',
            '<?php echo GKSOption::kSlideStep; ?>',
            '<?php echo GKSOption::kHeightCalcAlgo; ?>',
            '<?php echo GKSOption::kTileProportion; ?>',
            //Popup options
            '<?php echo GKSOption::kViewerType ?>',
            '<?php echo GKSOption::kPopupTitlePosition ?>',
            '<?php echo GKSOption::kPopupTheme ?>',
            '<?php echo GKSOption::kPopupSlideAnimationEffect ?>',
            '<?php echo GKSOption::kPopupThumbnailsTheme ?>',

            // Scroller
            '<?php echo GKSOption::kScrollerPosition; ?>'
        ];
    }
    function getTextboxOptions()
    {
        return [
            '<?php echo GKSOption::kPaginationColor; ?>',
            '<?php echo GKSOption::kPaginationHoverColor; ?>',
            '<?php echo GKSOption::kTileTitleColor; ?>',
            '<?php echo GKSOption::kTileDescColor; ?>',
            '<?php echo GKSOption::kTileOverlayColor; ?>',
            '<?php echo GKSOption::kArrowBgColor; ?>',
            '<?php echo GKSOption::kArrowBgHoverColor; ?>',
            '<?php echo GKSOption::kArrowHoverColor; ?>',
            '<?php echo GKSOption::kArrowColor; ?>',
            '<?php echo GKSOption::kSliderHeight; ?>',
            '<?php echo GKSOption::kSliderArrowsPadding; ?>',
            '<?php echo GKSOption::kSliderInfoPadding; ?>',
            '<?php echo GKSOption::kTilePaddings; ?>',
            '<?php echo GKSOption::kTileTitleFontSize; ?>',
            '<?php echo GKSOption::kFontSize; ?>',
            '<?php echo GKSOption::kArrowFontSize; ?>',
            '<?php echo GKSOption::kSliderAutoplaySpeed; ?>',
            '<?php echo GKSOption::kCustomJS; ?>',
            '<?php echo GKSOption::kCustomCSS; ?>',

            '<?php echo GKSOption::kSlidePadding; ?>',
            '<?php echo GKSOption::kBorderRadius; ?>',
            '<?php echo GKSOption::kBorderWidth; ?>',
            '<?php echo GKSOption::kSlideBgColor; ?>',
            '<?php echo GKSOption::kSlideBgHoverColor; ?>',
            '<?php echo GKSOption::kBorderColor; ?>',
            '<?php echo GKSOption::kShadowColor; ?>',
            '<?php echo GKSOption::kLgDesktopCols; ?>',
            '<?php echo GKSOption::kDesktopCols; ?>',
            '<?php echo GKSOption::kTabletCols; ?>',
            '<?php echo GKSOption::kMobileCols; ?>',
            '<?php echo GKSOption::kDesktopMaxWidth; ?>',
            '<?php echo GKSOption::kDesktopMinWidth; ?>',
            '<?php echo GKSOption::kMobileMaxWidth; ?>',
            '<?php echo GKSOption::kScreenSize; ?>',
            '<?php echo GKSOption::kSpaceBtwSlides; ?>',

            '<?php echo GKSOption::kScrollerLgDesktopCols; ?>',
            '<?php echo GKSOption::kScrollerDesktopCols; ?>',
            '<?php echo GKSOption::kScrollerTabletCols; ?>',
            '<?php echo GKSOption::kScrollerMobileCols; ?>',
            '<?php echo GKSOption::kScrollerDesktopMaxWidth; ?>',
            '<?php echo GKSOption::kScrollerDesktopMinWidth; ?>',
            '<?php echo GKSOption::kScrollerMobileMaxWidth; ?>',
            '<?php echo GKSOption::kScrollerScreenSize; ?>',
            '<?php echo GKSOption::kScrollerThumbBgColor; ?>',
            '<?php echo GKSOption::kScrollerActiveThumbBgColor; ?>',
            '<?php echo GKSOption::kScrollerThumbBorderColor; ?>',
            '<?php echo GKSOption::kScrollerActiveThumbBorderColor; ?>',
            '<?php echo GKSOption::kScrollerThumbTitleColor; ?>',
            '<?php echo GKSOption::kScrollerHeight; ?>',

            '<?php echo GKSOption::kButtonBgColor; ?>',
            '<?php echo GKSOption::kButtonBgOpacity; ?>',
            '<?php echo GKSOption::kButtonBgHoverColor; ?>',
            '<?php echo GKSOption::kButtonBgHoverOpacity; ?>',
            '<?php echo GKSOption::kButtonIconColor; ?>',
        ];
    }

    function gks_updateUI(){

        if (typeof gks_options.<?php echo GKSOption::kViewType ?> == 'undefined') {
            gks_options.<?php echo GKSOption::kViewType ?> = '<?php echo GKSViewType::SliderStandard ?>';
        }
        jQuery('.gks-layouts #' + gks_options.<?php echo GKSOption::kViewType ?>).addClass('active');

        gks_configureSliderLayout();
        gks_updateUICheckbox(gks_getCheckboxOptions());
        gks_updateUISelectbox(gks_getSelectboxOptions());
        gks_updateUITextbox(getTextboxOptions());

        gks_fixDefaults();

        jQuery('#<?php echo GKSOption::kViewerType ?>').change();
        jQuery('#<?php echo GKSOption::kShowPopupOnClick ?>').change();

        var sizeSlider = document.getElementById('gks-screen-size-slider');
        if (sizeSlider != null) {
            var x1 = (typeof gks_options.<?php echo GKSOption::kMobileMaxWidth ?> != 'undefined') ? gks_options.<?php echo GKSOption::kMobileMaxWidth ?> : <?php echo GKSOption::kMobileMaxWidthDefault ?>;
            var x2 = (typeof gks_options.<?php echo GKSOption::kDesktopMinWidth ?> != 'undefined') ? gks_options.<?php echo GKSOption::kDesktopMinWidth ?> : <?php echo GKSOption::kDesktopMinWidthDefault ?>;
            var x3 = (typeof gks_options.<?php echo GKSOption::kDesktopMaxWidth ?> != 'undefined') ? gks_options.<?php echo GKSOption::kDesktopMaxWidth ?> : <?php echo GKSOption::kDesktopMaxWidthDefault ?>;
            noUiSlider.create(sizeSlider, {
                start: [x1, x2, x3],
                connect: [false, false, false, false],
                padding: [320, 499],
                step: 1,
                tooltips: [
                    {
                        to: function (value) {
                            return '< ' + parseInt(value) + 'px (Small)';
                        },
                        from: function (value) {
                            return value.replace('< ', '').replace('px (Small)', '') + '.00';
                        }
                    }, {
                        to: function (value) {
                            return '< ' + parseInt(value) + 'px (Medium)';
                        },
                        from: function (value) {
                            return value.replace('< ', '').replace('px (Medium)', '') + '.00';
                        }
                    }, {
                        to: function (value) {
                            return '< ' + parseInt(value) + 'px (Normal)';
                        },
                        from: function (value) {
                            return value.replace('< ', '').replace('px (Normal)', '') + '.00';
                        }
                    }
                ],
                range: {
                    'min': [1],
                    'max': [2000]
                }
            });

            sizeSlider.noUiSlider.on('update', function (values, handle) {
                jQuery('#<?php echo GKSOption::kMobileMaxWidth ?>').val(parseInt(values[0]));
                jQuery('#<?php echo GKSOption::kDesktopMinWidth ?>').val(parseInt(values[1]));
                jQuery('#<?php echo GKSOption::kDesktopMaxWidth ?>').val(parseInt(values[2]));
            });
        }

        var scrollerSizeSlider = document.getElementById('gks-scroller-screen-size-slider');
        if (scrollerSizeSlider != null) {
            var x1 = (typeof gks_options.<?php echo GKSOption::kScrollerMobileMaxWidth ?> != 'undefined') ? gks_options.<?php echo GKSOption::kScrollerMobileMaxWidth ?> : <?php echo GKSOption::kMobileMaxWidthDefault ?>;
            var x2 = (typeof gks_options.<?php echo GKSOption::kScrollerDesktopMinWidth ?> != 'undefined') ? gks_options.<?php echo GKSOption::kScrollerDesktopMinWidth ?> : <?php echo GKSOption::kDesktopMinWidthDefault ?>;
            var x3 = (typeof gks_options.<?php echo GKSOption::kScrollerDesktopMaxWidth ?> != 'undefined') ? gks_options.<?php echo GKSOption::kScrollerDesktopMaxWidth ?> : <?php echo GKSOption::kDesktopMaxWidthDefault ?>;
            noUiSlider.create(scrollerSizeSlider, {
                start: [x1, x2, x3],
                connect: [false, false, false, false],
                padding: [320, 499],
                step: 1,
                tooltips: [
                    {
                        to: function (value) {
                            return '< ' + parseInt(value) + 'px (Small)';
                        },
                        from: function (value) {
                            return value.replace('< ', '').replace('px (Small)', '') + '.00';
                        }
                    }, {
                        to: function (value) {
                            return '< ' + parseInt(value) + 'px (Medium)';
                        },
                        from: function (value) {
                            return value.replace('< ', '').replace('px (Medium)', '') + '.00';
                        }
                    }, {
                        to: function (value) {
                            return '< ' + parseInt(value) + 'px (Normal)';
                        },
                        from: function (value) {
                            return value.replace('< ', '').replace('px (Normal)', '') + '.00';
                        }
                    }
                ],
                range: {
                    'min': [1],
                    'max': [2000]
                }
            });

            scrollerSizeSlider.noUiSlider.on('update', function (values, handle) {
                jQuery('#<?php echo GKSOption::kScrollerMobileMaxWidth ?>').val(parseInt(values[0]));
                jQuery('#<?php echo GKSOption::kScrollerDesktopMinWidth ?>').val(parseInt(values[1]));
                jQuery('#<?php echo GKSOption::kScrollerDesktopMaxWidth ?>').val(parseInt(values[2]));
            });
        }

        jQuery("#<?php echo GKSOption::kScreenSize; ?>").change(function(){
            if (jQuery(this).val() == '<?php echo GKSScreenSize::Custom; ?>') {
                jQuery("#gks-screen-sizes").show();
            } else {
                jQuery("#gks-screen-sizes").hide();
            }
        });
        jQuery("#<?php echo GKSOption::kScreenSize; ?>").change();

        jQuery("#<?php echo GKSOption::kScrollerScreenSize; ?>").change(function(){
            if (jQuery(this).val() == '<?php echo GKSScreenSize::Custom; ?>') {
                jQuery("#gks-scroller-screen-sizes").show();
            } else {
                jQuery("#gks-scroller-screen-sizes").hide();
            }
        });
        jQuery("#<?php echo GKSOption::kScrollerScreenSize; ?>").change();

        jQuery("#<?php echo GKSOption::kHeightCalcAlgo; ?>").off().on('change', function(){
            if (jQuery(this).val() == '<?php echo GKSHeightCalcAlgo::Proportional ?>') {
                jQuery("#<?php echo GKSOption::kSliderHeight; ?>").closest('.gks-options-row').hide();
                jQuery("#<?php echo GKSOption::kTileProportion; ?>").closest('.gks-options-row').show();
            } else {
                jQuery("#<?php echo GKSOption::kSliderHeight; ?>").closest('.gks-options-row').show();
                jQuery("#<?php echo GKSOption::kTileProportion; ?>").closest('.gks-options-row').hide();
            }
        });
        jQuery("#<?php echo GKSOption::kHeightCalcAlgo; ?>").change();

        var fontTarget = jQuery("#<?php echo GKSOption::kFont ?>");
        gks_updateTileFontPreview(fontTarget, jQuery(fontTarget).val());

        var titleFontTarget = jQuery("#<?php echo GKSOption::kTileTitleFont ?>");
        gks_updateTileFontPreview(titleFontTarget, jQuery(titleFontTarget).val());
    }

    function gks_updateTileFontPreview(target, font)
    {
        if (font) {
          gks_addGoogleFont(font);
        }
        jQuery(target).css("font-family", font);
    }


    function gks_updateModelCheckbox(options)
    {
        for(var i in options) {
            gks_options[options[i]] = jQuery('#'+options[i]).is(":checked");
        }
    }
    function gks_updateModelSelectbox(options)
    {
        for(var i in options) {
            gks_options[options[i]] = selectedOptionsFor('#'+options[i]);
        }
    }
    function gks_updateModelTextbox(options)
    {
        for(var i in options) {
            gks_options[options[i]] = selectedOptionsFor('#'+[options[i]]);
            gks_options[options[i]] = jQuery('#'+options[i]).attr('value');
        }
    }

    function gks_updateModel(){
        gks_options.<?php echo GKSOption::kViewType ?> = jQuery('.gks-layout-type-option.active').attr('id');
        if (gks_options.<?php echo GKSOption::kViewType ?> == "<?php echo GKSViewType::SliderCarousel ?>") {
            gks_options.carouselUsed = 1;
        }
        gks_updateModelCheckbox(gks_getCheckboxOptions());
        gks_updateModelSelectbox(gks_getSelectboxOptions());
        gks_updateModelTextbox(getTextboxOptions());
    }

    function selectedOptionsFor(selector){
        var selections = "";
        if(!selector) return selections;

        jQuery(selector + " option:selected").each(function( name, val ){
            selections += jQuery(this).val() + " ";
        });

        selections = jQuery.trim(selections);
        return selections;
    }

    function setOptionSelectedFor(selector,opVal){
        if(!selector || !opVal) return;

        //Reset all
        jQuery(selector + " option:selected").each(function( name, val ){
            jQuery(this).attr("selected", false);
        });

        //Iterate
        jQuery(selector + " option").each(function( name, val ){
            if( jQuery(this).val() === opVal){
                jQuery(this).attr("selected", true);
            }
        });
    }

    function gks_configureSliderLayout()
    {
        var hideForCarousel = [
            "<?php echo GKSOption::kShowInfoMobile ?>",
            "<?php echo GKSOption::kSlideAnimation ?>",
            "<?php echo GKSOption::kSliderTextWidthStyle ?>",
            "<?php echo GKSOption::kSliderTextPosition ?>",
            "<?php echo GKSOption::kSliderAutoHeight ?>",
        ];
        var showForCarousel = [
            "<?php echo GKSOption::kShowBorder ?>",
            "<?php echo GKSOption::kShowShadow ?>",
            "<?php echo GKSOption::kShowOverlay ?>",
            "<?php echo GKSOption::kShowBorderOnHover ?>",
            "<?php echo GKSOption::kShowShadowOnHover ?>",
            "<?php echo GKSOption::kShowButton ?>",
            "<?php echo GKSOption::kAppearButtonOnHover ?>",
            "<?php echo GKSOption::kInfoDisplayStyle ?>",
            "<?php echo GKSOption::kAppearButtonOnHover ?>",
            "<?php echo GKSOption::kButtonStyle ?>",
            "<?php echo GKSOption::kButtonIcon ?>",
            "<?php echo GKSOption::kBorderRadius ?>",
            "<?php echo GKSOption::kBorderWidth ?>",
            "<?php echo GKSOption::kSlideBgColor ?>",
            "<?php echo GKSOption::kSlideBgOpacity ?>",
            "<?php echo GKSOption::kSlideBgHoverColor ?>",
            "<?php echo GKSOption::kSlideBgHoverOpacity ?>",
            "<?php echo GKSOption::kBorderColor ?>",
            "<?php echo GKSOption::kShadowColor ?>",
            "<?php echo GKSOption::kSpaceBtwSlides ?>",
            "<?php echo GKSOption::kSlideStep ?>",

            "<?php echo GKSOption::kButtonBgColor ?>",
            "<?php echo GKSOption::kButtonBgOpacity ?>",
            "<?php echo GKSOption::kButtonBgHoverColor ?>",
            "<?php echo GKSOption::kButtonBgHoverOpacity ?>",
            "<?php echo GKSOption::kButtonIconColor ?>",
            "<?php echo GKSOption::kSlidePadding ?>",
        ];

        var hideForCoverflow = [
            "<?php echo GKSOption::kSlideAnimation ?>",
            "<?php echo GKSOption::kSliderAutoHeight ?>",
        ];

        var showForScroller = [
          "<?php echo GKSOption::kScrollerThumbBgColor ?>",
          "<?php echo GKSOption::kScrollerActiveThumbBgColor ?>",
          "<?php echo GKSOption::kScrollerThumbBorderColor ?>",
          "<?php echo GKSOption::kScrollerActiveThumbBorderColor ?>",
          "<?php echo GKSOption::kScrollerThumbTitleColor ?>",
        ];


        if (jQuery('.gks-layout-type-option.active').attr('id') == "<?php echo GKSViewType::SliderCarousel ?>") {
            for (var i in hideForCarousel) {
                jQuery("#"+hideForCarousel[i]).closest('.gks-options-row').hide();
            }
            for (var i in showForCarousel) {
                jQuery("#"+showForCarousel[i]).closest('.gks-options-row').show();
            }

            jQuery("#<?php echo GKSOption::kHeightCalcAlgo; ?> option[value=<?php echo GKSHeightCalcAlgo::Proportional; ?>]").prop('disabled', false);

            jQuery("#<?php echo GKSOption::kTileOverlayColor ?>").closest('.gks-options-row').find('label.gks-label').text('Slide overlay color:');
            jQuery("#<?php echo GKSOption::kTileOverlayOpacity ?>").closest('.gks-options-row').find('label.gks-label').text('Slide overlay opacity:');
            jQuery("#gks-screen-sizes-box").show();
            jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option.no-carousel").hide();
            jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option.carousel").show();
            if (!jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option:selected").hasClass('carousel')) {
                jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?>").val(jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option.carousel").first().attr('value'));
            }

            //set default values
            if (typeof gks_options.carouselUsed == 'undefined') {
                gks_setDefaultForInput("<?php echo GKSOption::kBorderRadius ?>", 0, false);
                gks_setDefaultForInput("<?php echo GKSOption::kBorderWidth ?>", 1, false);
                gks_setDefaultForInput("<?php echo GKSOption::kSpaceBtwSlides ?>", 10, false);
                gks_setDefaultForInput("<?php echo GKSOption::kSlidePadding ?>", 0, false);
                gks_setDefaultForInput("<?php echo GKSOption::kSlideBgColor ?>", '#eeeeee', true);
                gks_setDefaultForInput("<?php echo GKSOption::kSlideBgHoverColor ?>", '#e0e0e0', true);
                gks_setDefaultForInput("<?php echo GKSOption::kShadowColor ?>", '#4c4c4c', true);
                gks_setDefaultForInput("<?php echo GKSOption::kButtonBgColor ?>", '#ffffff', true);
                gks_setDefaultForInput("<?php echo GKSOption::kButtonBgHoverColor ?>", '#ffffff', true);
                gks_setDefaultForInput("<?php echo GKSOption::kButtonIconColor ?>", '#000000', true);
                gks_setDefaultForInput("<?php echo GKSOption::kButtonIcon ?>", 'search');
                jQuery("#<?php echo GKSOption::kSlideBgOpacity ?>").val('A6');
                jQuery("#<?php echo GKSOption::kSlideBgHoverOpacity ?>").val('BF');
                jQuery("#<?php echo GKSOption::kButtonBgOpacity ?>").val('A6');
                jQuery("#<?php echo GKSOption::kButtonBgHoverOpacity ?>").val('BF');
            }

        } else {
            for (var i in hideForCarousel) {
                jQuery("#"+hideForCarousel[i]).closest('.gks-options-row').show();
            }

            for (var i in showForCarousel) {
                jQuery("#"+showForCarousel[i]).closest('.gks-options-row').hide();
            }

            if (jQuery('.gks-layout-type-option.active').attr('id') == "<?php echo GKSViewType::SliderCoverflow ?>") {
              for (var i in hideForCoverflow) {
                  jQuery("#"+hideForCoverflow[i]).closest('.gks-options-row').hide();
              }


              jQuery("#<?php echo GKSOption::kSliderAutoHeight ?>").attr('checked', false );
            } else {
              for (var i in hideForCoverflow) {
                  jQuery("#"+hideForCoverflow[i]).closest('.gks-options-row').show();
              }
            }

            if (jQuery('.gks-layout-type-option.active').attr('id') == "<?php echo GKSViewType::SliderScroller ?>") {
              for (var i in showForScroller) {
                  jQuery("#"+showForScroller[i]).closest('.gks-options-row').show();
              }
            } else {
              for (var i in showForScroller) {
                  jQuery("#"+showForScroller[i]).closest('.gks-options-row').hide();
              }
            }

            jQuery("#<?php echo GKSOption::kHeightCalcAlgo; ?> option[value=<?php echo GKSHeightCalcAlgo::Fixed; ?>]").attr('selected', 'selected');
            jQuery("#<?php echo GKSOption::kHeightCalcAlgo; ?> option[value=<?php echo GKSHeightCalcAlgo::Proportional; ?>]").attr('disabled', 'disabled');
            jQuery("#<?php echo GKSOption::kHeightCalcAlgo; ?> ").change();

            jQuery("#<?php echo GKSOption::kTileOverlayColor ?>").closest('.gks-options-row').find('label.gks-label').text('Slide info box color:');
            jQuery("#<?php echo GKSOption::kTileOverlayOpacity ?>").closest('.gks-options-row').find('label.gks-label').text('Slide info box opacity:');
            jQuery("#gks-screen-sizes-box").hide();
            jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option.carousel").hide();
            jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option.no-carousel").show();
            if (!jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option:selected").hasClass('no-carousel')) {
                jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?>").val(jQuery("#<?php echo GKSOption::kSliderPaginationPosition ?> option.no-carousel").first().attr('value'));
            }
        }

        if (jQuery('.gks-layout-type-option.active').attr('id') == "<?php echo GKSViewType::SliderScroller ?>") {
          jQuery("#gks-scroller-options-accordion").show();

        } else {
          jQuery("#gks-scroller-options-accordion").hide();

        }

        jQuery(".gks-binding").each(function( index ) {
            var boundTo = jQuery(this).data('binding');
            if (boundTo && jQuery("#" + boundTo).closest(".gks-options-row").css("display") == "none") {
              jQuery(this).hide();
            } else {
              jQuery(this).show();
            }
        });
    }

    function gks_setDefaultForInput(option, value, triggerChange) {
        if (jQuery("#"+option).val() == '') {
            if (triggerChange) {
                jQuery("#"+option).val(value).change();
            } else {
                jQuery("#"+option).val(value);
            }
        }
    }

</script>
