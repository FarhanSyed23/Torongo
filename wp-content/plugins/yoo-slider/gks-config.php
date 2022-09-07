<?php

define( 'GKS_DEBUG', 0 );
if (GKS_DEBUG) {
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);
}

//If it's disabled, the all 3rd partes should call gks_do_shortcode('[yooslider]) instead of WordPress native do_shortcode('[yooslider]) function
define( 'GKS_NATIVE_DO_SHORTCODE', 1 );

//***************** Immutable configurations ********************//
define( 'GKS_ROOT_DIR_NAME', 'yoo-slider');
define( 'GKS_ROOT_FILE_NAME', 'yoo-slider.php');

define( 'GKS_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GKS_PLUGIN_ROOT_FILE_PATH', GKS_ROOT_DIR_PATH.'/'.GKS_ROOT_FILE_NAME );
define( 'GKS_CLASSES_DIR_PATH' , GKS_ROOT_DIR_PATH.'classes' );
define( 'GKS_IMAGES_DIR_PATH', GKS_ROOT_DIR_PATH.'images' );
define( 'GKS_VIEWS_DIR_PATH', GKS_ROOT_DIR_PATH.'views' );
define( 'GKS_ADMIN_VIEWS_DIR_PATH', GKS_VIEWS_DIR_PATH.'/admin' );
define( 'GKS_FRONT_VIEWS_DIR_PATH', GKS_VIEWS_DIR_PATH.'/front' );

define( 'GKS_PLUGIN_URL'   , plugins_url( GKS_ROOT_DIR_NAME ) );
define( 'GKS_CSS_URL'      , GKS_PLUGIN_URL.'/css' );
define( 'GKS_JS_URL'       , GKS_PLUGIN_URL.'/js' );
define( 'GKS_IMAGES_URL', GKS_PLUGIN_URL.'/images' );
define( 'GKS_API_URL', 'https://yooslider.com/deliver/api/v1/api.php' );

define( 'GKS_FREE_SUPPORT_URL', 'https://wordpress.org/support/plugin/yoo-slider/' );
define( 'GKS_PREMIUM_SUPPORT_URL', 'https://yooslider.com/' );

define( 'GKS_VALIDATOR_FLAG', 'gks_validator_flag' );
define( 'GKS_LAST_VALIDATED_AT', 'gks_last_validated_at' );
define( 'GKS_LICENSE_OPTION_KEY', 'gks_license_key' );
define( 'GKS_BANNERS_LAST_LOADED_AT', 'gks_banners_last_loaded_at' );
define( 'GKS_BANNERS_CONTENT', 'gks_banners_content' );

define( 'GKS_SAMPLE_IMG_ID', 'gks_sample_img_id' );
define( 'GKS_SAMPLE_IMG_NAME', 'gks_sample_img.jpg' );
define( 'GKS_SAMPLE_IMG_PATH', GKS_IMAGES_DIR_PATH.'/general/'.GKS_SAMPLE_IMG_NAME );

global $wpdb;

define( 'GKS_PLUGIN_PREFIX', 'gks');
define( 'GKS_DB_PREFIX'     , $wpdb->prefix.GKS_PLUGIN_PREFIX.'_' );

define("GKS_PLUGIN_NAME","Yoo Slider");
define("GKS_PLUGIN_SLAG","yooslider");

define("GKS_SUBMENU_SLIDER_TITLE","Sliders");

define("GKS_SUBMENU_LICENSE_TITLE","License");
define("GKS_SUBMENU_LICENSE_SLUG","yooslider-license");

define("GKS_SUBMENU_TEMPLATES_TITLE","Templates");
define("GKS_SUBMENU_TEMPLATES_SLUG","yooslider-templates");

define("GKS_LICENSE_TYPE_LIFETIME", 'lifetime');
define("GKS_LICENSE_TYPE_RECURRING", 'recurring');

define("GKS_LICENSE_TYPE", GKS_LICENSE_TYPE_LIFETIME);

define("GKS_PKG_TYPE_FREE", 'free');
define("GKS_PKG_TYPE_PREMIUM", 'premium');
define("GKS_PKG_TYPE", GKS_PKG_TYPE_FREE);


//**************** Configurable configurations *******************//
define( 'GKS_PRO_URL' , 'http://yooslider.com' );


//Define table names
define( 'GKS_TABLE_SLIDERS' , GKS_DB_PREFIX.'sliders' );
define( 'GKS_TABLE_SLIDES' , GKS_DB_PREFIX.'slides' );
define( 'GKS_TABLE_OPTIONS' , GKS_DB_PREFIX.'options' );

//Enum simulated classese
abstract class GKSLayoutType{
    const SLIDER = 'slider';
}

abstract class GKSAttachmentType{
    const PICTURE = 'pic';
    const VIDEO = 'video';
    const YOUTUBE = 'youtube';
    const VIMEO = 'vimeo';
    const IFRAME = 'iframe';
    const MAP = 'map';
    const HTML = 'html';
}

abstract class GKSViewType{
    const Unknown = 0;
    const SliderStandard = 1;
    const SliderCarousel = 2;
    const SliderScroller = 3;
    const SliderCoverflow = 4;
}

abstract class GKSPjViewerType{
    const Unknown = 0;
    const LightGallery = 1;
    const LightGalleryLight = 2;
    const LightGalleryFixed = 3;
}

abstract class GKSCurrencyPosition{
    const BeforeAmount = 0;
    const AfterAmount = 1;
}

abstract class GKSPopupTitlePosition{
    const OnTop = 0;
    const OnBottom = 1;
}

abstract class GKSPopupTheme{
    const Light = 0;
    const Dark = 1;
}

abstract class GKSPopupThumbnailTheme{
    const Grid = 0;
    const Scroll = 1;
}

abstract class GKSAlbumViewerType{
    const Popup = 0;
    const Grid = 1;
}

abstract class GKSPopupSlideAnimationEffect{
    const lgslide = 'lg-slide';
    const lgfade = 'lg-fade';
    const lgzoomin = 'lg-zoom-in';
    const lgzoominbig = 'lg-zoom-in-big';
    const lgzoomout = 'lg-zoom-out';
    const lgzoomoutbig = 'lg-zoom-out-big';
    const lgzoomoutin = 'lg-zoom-out-in';
    const lgzoominout = 'lg-zoom-in-out';
    const lgsoftzoom = 'lg-soft-zoom';
    const lgscaleup = 'lg-scale-up';
    const lgslidecircular = 'lg-slide-circular';
    const lgslidecircularvertical = 'lg-slide-circular-vertical';
    const lgslidevertical = 'lg-slide-vertical';
    const lgslideverticalgrowth = 'lg-slide-vertical-growth';
    const lgslideskewonly = 'lg-slide-skew-only';
    const lgslideskewonlyrev = 'lg-slide-skew-only-rev';
    const lgslideskewonlyy = 'lg-slide-skew-only-y';
    const lgslideskewonlyyrev = 'lg-slide-skew-only-y-rev';
    const lgslideskew = 'lg-slide-skew';
    const lgslideskewrev = 'lg-slide-skew-rev';
    const lgslideskewcross = 'lg-slide-skew-cross';
    const lgslideskewcrossrev = 'lg-slide-skew-cross-rev';
    const lgslideskewver = 'lg-slide-skew-ver';
    const lgslideskewverrev = 'lg-slide-skew-ver-rev';
    const lgslideskewvercross = 'lg-slide-skew-ver-cross';
    const lgslideskewvercrossrev = 'lg-slide-skew-ver-cross-rev';
    const lglollipop = 'lg-lollipop';
    const lglollipoprev = 'lg-lollipop-rev';
    const lgrotate = 'lg-rotate';
    const lgrotaterev = 'lg-rotate-rev';
    const lgtube = 'lg-tube';
}

abstract class GKSDetailsDisplayStyle{
    const none = 'details-none';
    const style01 = 'details01';
    const style02 = 'details02';
    const style03 = 'details03';
    const style04 = 'details04';
    const style05 = 'details05';
    const style06 = 'details06';
    const style07 = 'details07';
    const style08 = 'details08';
    const style09 = 'details09';
    const style10 = 'details10';
    const style11 = 'details11';
    const style12 = 'details12';
    const style13 = 'details13';
    const style14 = 'details14';
    const style15 = 'details15';
    const style16 = 'details16';
    const style17 = 'details17';
    const style18 = 'details18';
    const style19 = 'details19';
    const style20 = 'details20';
    const style21 = 'details21';
    const style22 = 'details22';
    const style23 = 'details23';
    const style24 = 'details24';
    const style25 = 'details25';
    const style26 = 'details26';
    const style27 = 'details27';
    const style28 = 'details28';
    const style29 = 'details29';
    const style30 = 'details30';
    const style31 = 'details31 gks-details-bg';
    const style32 = 'details32 gks-details-bg';
    const style33 = 'details33 gks-details-bg';
    const style34 = 'details34 gks-details-bg';
    const style35 = 'details35 gks-details-bg';
    const style36 = 'details36 gks-details-bg';
    const style37 = 'details37 gks-details-bg';
    const style38 = 'details38 gks-details-bg';
    const style39 = 'details39 gks-details-bg';
    const style40 = 'details40 gks-details-bg';
    const style41 = 'details41 gks-details-bg';
    const style42 = 'details42 gks-details-bg';
    const style43 = 'details43 gks-details-bg';
    const style44 = 'details44 gks-details-bg';
    const style45 = 'details45';
    const style46 = 'details46';
    const style47 = 'details47';

    const dflt = 'details-none';
}

abstract class GKSPictureHoverStyle{
    const none = 'image-none';
    const style01 = 'image01';
    const style02 = 'image02';
    const style03 = 'image03';
    const style04 = 'image04';
    const style05 = 'image05';
    const style06 = 'image06';
    const style07 = 'image07';

    const dflt = 'image-none';
}

abstract class GKSScrollerPosition {
    const after = 'after';
    const before = 'before';
}

abstract class GKSOverlayDisplayStyle{
    const none = 'overlay-none';
    const style00 = 'overlay00';
    const style01 = 'overlay01';
    const style02 = 'overlay02';
    const style03 = 'overlay03';
    const style04 = 'overlay04';
    const style05 = 'overlay05';
    const style06 = 'overlay06';
    const style07 = 'overlay07';
    const style08 = 'overlay08';
    const style09 = 'overlay09';
    const style10 = 'overlay10';
    const style11 = 'overlay11';
    const style12 = 'overlay12';
    const style13 = 'overlay13';
    const style14 = 'overlay14';
    const style15 = 'overlay15';
    const style16 = 'overlay16';
    const style17 = 'overlay17';
    const style18 = 'overlay18';
    const style19 = 'overlay19';
    const style20 = 'overlay20';
    const style21 = 'overlay21';
    const style22 = 'overlay22';
    const style23 = 'overlay23';
    const style24 = 'overlay24';
    const style25 = 'overlay25';
    const style26 = 'overlay26';
    const style27 = 'overlay27';

    const dflt = 'overlay-none';
}

abstract class GKSOverlayButtonsDisplayStyle{
    const none =    'button-none';
    const style01 = 'button01';
    const style02 = 'button02';
    const style03 = 'button03';
    const style04 = 'button04';
    const style05 = 'button05';
    const style06 = 'button06';
    const style07 = 'button07';
    const style08 = 'button08';
    const style09 = 'button09';
    const style10 = 'button10';
    const style11 = 'button11';
    const style12 = 'button12';
    const style13 = 'button13';
    const style14 = 'button14';
    const style15 = 'button15';
    const style16 = 'button16';
    const style17 = 'button17';
    const style18 = 'button18';
    const style19 = 'button19';
    const style20 = 'button20';
    const style21 = 'button21';
    const style22 = 'button22';

    const dflt = 'button-none';
}

abstract class GKSShareButtonsDisplayStyle{
    const none =    'share-none';
    const style01 = 'share01';
    const style02 = 'share02';
    const style03 = 'share03';
    const style04 = 'share04';
    const style05 = 'share05';
    const style06 = 'share06';
    const style07 = 'share07';
    const style08 = 'share08';
    const style09 = 'share09';
    const style10 = 'share10';
    const style11 = 'share11';
    const style12 = 'share12';
    const style13 = 'share13';
    const style14 = 'share14';
    const style15 = 'share15';
    const style16 = 'share16';
    const style17 = 'share17';
    const style18 = 'share18';
    const style19 = 'share19';
    const style20 = 'share20';
    const style21 = 'share21';
    const style22 = 'share22';
    const style23 = 'share23';
    const style24 = 'share24';

    const dflt = 'share-none';
}

abstract class GKSOverlayButtonsHoverEffect{
    const none =    '';

    //2D Transitions
    const style01 = 'gks-hvr-grow';
    const style02 = 'gks-hvr-shrink';
    const style03 = 'gks-hvr-pulse';
    const style04 = 'gks-hvr-pulse-grow';
    const style05 = 'gks-hvr-pulse-shrink';
    const style06 = 'gks-hvr-push';
    const style07 = 'gks-hvr-pop';
    const style08 = 'gks-hvr-bounce-in';
    const style09 = 'gks-hvr-bounce-out';
    const style10 = 'gks-hvr-rotate';
    const style11 = 'gks-hvr-grow-rotate';
    const style12 = 'gks-hvr-float';
    const style13 = 'gks-hvr-sink';
    const style14 = 'gks-hvr-bob';
    const style15 = 'gks-hvr-hang';
    const style16 = 'gks-hvr-skew';
    const style17 = 'gks-hvr-skew-forward';
    const style18 = 'gks-hvr-skew-backward';
    const style19 = 'gks-hvr-wobble-horizontal';
    const style20 = 'gks-hvr-wobble-vertical';
    const style21 = 'gks-hvr-wobble-to-bottom-right';
    const style22 = 'gks-hvr-wobble-to-top-right';
    const style23 = 'gks-hvr-wobble-top';
    const style24 = 'gks-hvr-wobble-bottom';
    const style25 = 'gks-hvr-wobble-skew';
    const style26 = 'gks-hvr-wobble-skew';
    const style27 = 'gks-hvr-buzz';
    const style28 = 'gks-hvr-buzz-out';

    //Background Transitions
    const style29 = 'gks-hvr-fade';
    const style30 = 'gks-hvr-sweep-to-right';
    const style31 = 'gks-hvr-sweep-to-left';
    const style32 = 'gks-hvr-sweep-to-bottom';
    const style33 = 'gks-hvr-sweep-to-top';
    const style34 = 'gks-hvr-bounce-to-right';
    const style35 = 'gks-hvr-bounce-to-left';
    const style36 = 'gks-hvr-bounce-to-bottom';
    const style37 = 'gks-hvr-bounce-to-top';
    const style38 = 'gks-hvr-radial-out';
    const style39 = 'gks-hvr-radial-in';
    const style40 = 'gks-hvr-rectangle-in';
    const style41 = 'gks-hvr-rectangle-out';
    const style42 = 'gks-hvr-shutter-in-horizontal';
    const style43 = 'gks-hvr-shutter-out-horizontal';
    const style44 = 'gks-hvr-shutter-in-vertical';
    const style45 = 'gks-hvr-shutter-out-vertical';

    //Underline & Overline Transitions
    const style46 = 'gks-hvr-underline-from-left';
    const style47 = 'gks-hvr-underline-from-center';
    const style48 = 'gks-hvr-underline-from-right';
    const style49 = 'gks-hvr-underline-reveal';
    const style50 = 'gks-hvr-overline-reveal';
    const style51 = 'gks-hvr-overline-from-left';
    const style52 = 'gks-hvr-overline-from-center';
    const style53 = 'gks-hvr-overline-from-right';

    const dflt = '';
}

abstract class GKSPaginationStyle{
    const style1 = 'gks-pagination-style-1';
    const style2 = 'gks-pagination-style-2';
    const style3 = 'gks-pagination-style-3';
    const style4 = 'gks-pagination-style-4';
    const style5 = 'gks-pagination-style-5';
    const style6 = 'gks-pagination-style-6';
    const style7 = 'gks-pagination-style-7';
}

abstract class GKSVideoPresentationStyle {
    const MediaPlayer = 'MediaPlayer';
    const Standard = 'Standard';
}

abstract class GKSSlideStatus {
    const Visible = 'Visible';
    const Invisible = 'Invisible';
}

//Enum simulated classes
abstract class GKSOption{

    // Popup options
    const kViewerType = "kViewerType";
    const kPopupShowCounter = "kPopupShowCounter";
    const kPopupShowZoomButtons = "kPopupShowZoomButtons";
    const kPopupShowSlideshowButton = "kPopupShowSlideshowButton";
    const kPopupShowFullscreenButton = "kPopupShowFullscreenButton";
    const kPopupShowLinkButton = "kPopupShowLinkButton";
    const kPopupShowThumbnails = "kPopupShowThumbnails";
    const kPopupShowPaging = "kPopupShowPaging";
    const kPopupShowShareButton = "kPopupShowShareButton";
    const kPopupShowTitle = "kPopupShowTitle";
    const kPopupShowDescription = "kPopupShowDescription";
    const kPopupAutoplaySlideshow = "kPopupAutoplaySlideshow";
    const kPopupAutoopenThumbnails = "kPopupAutoopenThumbnails";
    const kPopupTheme = "kPopupTheme";
    const kPopupThumbnailsTheme = "kPopupThumbnailsTheme";
    const kPopupSlideAnimationEffect = "kPopupSlideAnimationEffect";
    const kPopupTitlePosition = "kPopupTitlePosition";
    const kPopupShowTextToggle = "kPopupShowTextToggle";

    //Styles & Effects
    const kViewType = "kViewType";
    const kDetailsDisplayStyle = "kDetailsDisplayStyle";
    const kPictureHoverEffect = "kPictureHoverEffect";
    const kOverlayDisplayStyle = "kOverlayDisplayStyle";
    const kOverlayButtonsDisplayStyle = "kOverlayButtonsDisplayStyle";
    const kOverlayButtonsHoverEffect = "kOverlayButtonsHoverEffect";
    const kShareButtonsDisplayStyle = "kShareButtonsDisplayStyle";
    const kVideoPresentationStyle = "kVideoPresentationStyle";
    const kPlayVideosInline = "kPlayVideosInline";

    //Quality
    const kThumbnailQuality = "kThumbnailQuality";

    //Category filtration
    const kShowCategoryFilters = "kShowCategoryFilters";
    const kFilterStyle = "kFilterStyle";

    //Overlay items
    const kShowTitle = "kShowTitle";
    const kShowDetails = "kShowDetails";
    const kShowOverlay = "kShowOverlay";
    const kShowLinkButton = "kShowLinkButton";
    const kShowExploreButton = "kShowExploreButton";
    const kShowFacebookButton = "kShowFacebookButton";
    const kShowTwitterButton = "kShowTwitterButton";
    const kShowGooglePlusButton = "kShowGooglePlusButton";
    const kShowPinterestButton = "kShowPinterestButton";

    const kShowFacebookLink = "kShowFacebookLink";
    const kShowLinkedinLink = "kShowLinkedinLink";

    const kLinkIcon = "kLinkIcon";
    const kZoomIcon = "kZoomIcon";
    const kGoIcon = "kGoIcon";

    //Scroller
    const kScrollerShowTitle = "kScrollerShowTitle";
    const kScrollerShowCover = "kScrollerShowCover";
    const kScrollerShowBorder = "kScrollerShowBorder";
    const kScrollerLgDesktopCols = "kScrollerLgDesktopCols";
    const kScrollerDesktopCols = "kScrollerDesktopCols";
    const kScrollerTabletCols = "kScrollerTabletCols";
    const kScrollerMobileCols = "kScrollerMobileCols";
    const kScrollerScreenSize = "kScrollerScreenSize";
    const kScrollerDesktopMaxWidth = "kScrollerDesktopMaxWidth";
    const kScrollerDesktopMinWidth = "kScrollerDesktopMinWidth";
    const kScrollerMobileMaxWidth = "kScrollerMobileMaxWidth";
    const kScrollerHeight = "kScrollerHeight";
    const kScrollerPosition = "kScrollerPosition";

    const kScrollerThumbBgColor = "kScrollerThumbBgColor";
    const kScrollerActiveThumbBgColor = "kScrollerActiveThumbBgColor";
    const kScrollerThumbBorderColor = "kScrollerThumbBorderColor";
    const kScrollerActiveThumbBorderColor = "kScrollerActiveThumbBorderColor";
    const kScrollerThumbTitleColor = "kScrollerThumbTitleColor";

    //Dimensions
    const kLayoutWidth = "kLayoutWidth";
    const kLayoutWidthUnit = "kLayoutWidthUnit";
    const kTileApproxWidth = "kTileApproxWidth";
    const kSliderHeight = "kSliderHeight";
    const kTileMinWidth = "kTileMinWidth";
    const kTileMargins = "kTileMargins";

    //Alignments
    const kLayoutAlignment = "kLayoutAlignment";
    const kTileAlignment = "kTileAlignment";
    //Colorization
    const kProgressColor = "kProgressColor";
    const kFiltersColor = "kFiltersColor";
    const kFiltersHoverColor = "kFiltersHoverColor";
    const kTileTitleColor = "kTileTitleColor";
    const kTileDescColor = "kTileDescColor";
    const kTileOverlayColor = "kTileOverlayColor";
    const kTileOverlayOpacity = "kTileOverlayOpacity";
    const kTileIconsColor = "kTileIconsColor";
    const kTileIconsBgColor = "kTileIconsBgColor";

    //Fonts
    const kFont = "kFont";
    const kTileTitleFont = "kTileTitleFont";
    const kTileTitleFontSize = "kTileTitleFontSize";
    const kFontSize = "kFontSize";
    const kTileTitleAlignment = "kTileTitleAlignment";
    const kTileDescAlignment = "kTileDescAlignment";
    const kTileTitleFontStyle = "kTileTitleFontStyle";
    const kFontStyle = "kFontStyle";

    //Other
    const kDirectLinking = "kDirectLinking";
    const kMouseType = "kMouseType";
    const kDescMaxLength = "kDescMaxLength";
    const kLinkTarget = "kLinkTarget";
    const kDisableAlbumStylePresentation = "kDisableAlbumStylePresentation";
    const kEnablePictureCaptions = "kEnablePictureCaptions";
    const kExcludeCoverPicture = "kExcludeCoverPicture";
    const kEnableGridLazyLoad = "kEnableGridLazyLoad";
    const kEnableCategoryAjaxLoad = "kEnableCategoryAjaxLoad";
    const kHideAllCategoryFilter = "kHideAllCategoryFilter";
    const kAllCategoryAlias = "kAllCategoryAlias";
    const kLoadUrlBlank = "kLoadUrlBlank";
    const kGoogleMapApiKey = "kGoogleMapApiKey";
    const kDontCropImage = "kDontCropImage";
    const kRandomizeTileOrder = "kRandomizeTileOrder";

    //Pagination
    const kItemsPerPage = "kItemsPerPage";
    const kMaxVisiblePageNumbers = "kMaxVisiblePageNumbers";
    const kEnablePagination = "kEnablePagination";
    const kPaginationAlignment = "kPaginationAlignment";
    const kPaginationStyle = "kPaginationStyle";
    const kPaginationColor = "kPaginationColor";
    const kPaginationHoverColor = "kPaginationHoverColor";
    const kItemsPerPageDefault = 10;
    const kMaxVisiblePageNumbersDefault = 10;

    //Custom fields
    const kCustomFields = "kCustomFields";

    //Customize CSS & JS
    const kCustomCSS = "kCustomCSS";
    const kCustomJS = "kCustomJS";

    const kAlbumViewerType = "kAlbumViewerType";

    const kCurrency = "kCurrency";
    const kCurrencyPosition = "kCurrencyPosition";
    const kBuyButtonTitle = "kBuyButtonTitle";
    const kBuyButtonAction = "kBuyButtonAction";
    const kProductBuyButtonTitle = "kProductBuyButtonTitle";
    const kProductBuyButtonAction = "kProductBuyButtonAction";
    const kProductOnClickAction = "kProductOnClickAction";
    const kCatalogBadgePosition = "kCatalogBadgePosition";
    const kCatalogBadgeContent = "kCatalogBadgeContent";
    const kCatalogBadgeText = "kCatalogBadgeText";
    const kCatalogBadgeBackgroundColor = "kCatalogBadgeBackgroundColor";
    const kCatalogBadgeTextColor = "kCatalogBadgeTextColor";
    const kCatalogPopupBackgroundColor = "kCatalogPopupBackgroundColor";
    const kCatalogPopupTextColor = "kCatalogPopupTextColor";
    const kCatalogBuyButtonBackgroundColor = "kCatalogBuyButtonBackgroundColor";
    const kCatalogBuyButtonTextColor = "kCatalogBuyButtonTextColor";

    const kCatalogNotifyEnquiry = "kCatalogNotifyEnquiry";
    const kCatalogNotifyEnquiryEmail = "kCatalogNotifyEnquiryEmail";

    const kCatalogShowPrice= "kCatalogShowPrice";
    const kCatalogShowSalePrice= "kCatalogShowSalePrice";
    const kCatalogShowRating= "kCatalogShowRating";
    const kCatalogShowBadge= "kCatalogShowBadge";
    const kCatalogShowBuyButton= "kCatalogShowBuyButton";
    const kCatalogShowCustomFields= "kCatalogShowCustomFields";
    const kCatalogShowSortBy= "kCatalogShowSortBy";
    const kCatalogShowSearchBox= "kCatalogShowSearchBox";
    const kCatalogWidgetStyle = "kCatalogWidgetStyle";
    const kCatalogProductShowCustomFields= "kCatalogProductShowCustomFields";
    const kCatalogProductShowReviews= "kCatalogProductShowReviews";
    const kCatalogProductShowReviewForm= "kCatalogProductShowReviewForm";
    const kCatalogProductShowSimilar= "kCatalogProductShowSimilar";
    const kCatalogProductShowFacebookButton = "kCatalogProductShowFacebookButton";
    const kCatalogProductShowTwitterButton = "kCatalogProductShowTwitterButton";
    const kCatalogProductShowGooglePlusButton = "kCatalogProductShowGooglePlusButton";
    const kCatalogProductShowPinterestButton = "kCatalogProductShowPinterestButton";
    const kCatalogProductDisableImageZoom = "kCatalogProductDisableImageZoom";
    const kCatalogProductDontCropImage = "kCatalogProductDontCropImage";

    const kLocalization = 'kLocalization';
    const kLocalizationEnquiryTitle = 'kLocalizationEnquiryTitle';
    const kLocalizationEnquiryName = 'kLocalizationEnquiryName';
    const kLocalizationEnquiryEmail = 'kLocalizationEnquiryEmail';
    const kLocalizationEnquiryPhone = 'kLocalizationEnquiryPhone';
    const kLocalizationEnquiryMessage = 'kLocalizationEnquiryMessage';
    const kLocalizationEnquiryButton = 'kLocalizationEnquiryButton';
    const kLocalizationEnquiryErrorMessage = 'kLocalizationEnquiryErrorMessage';

    const kLocalizationSuccessDialogText = 'kLocalizationSuccessDialogText';
    const kLocalizationSuccessDialogButton = 'kLocalizationSuccessDialogButton';

    const kLocalizationReviewTitle = 'kLocalizationReviewTitle';
    const kLocalizationReviewRating = 'kLocalizationReviewRating';
    const kLocalizationReviewName = 'kLocalizationReviewName';
    const kLocalizationReviewEmail = 'kLocalizationReviewEmail';
    const kLocalizationReviewMessage = 'kLocalizationReviewMessage';
    const kLocalizationReviewButton = 'kLocalizationReviewButton';
    const kLocalizationReviewErrorMessage = 'kLocalizationReviewErrorMessage';
    const kLocalizationReviewEmailReviewedErrorMessage = 'kLocalizationReviewEmailReviewedErrorMessage';


    const kLocalizationReviewListTitle = 'kLocalizationReviewListTitle';
    const kLocalizationReviewListMore = 'kLocalizationReviewListMore';
    const kLocalizationReviewListLess = 'kLocalizationReviewListLess';
    const kLocalizationProductMore = 'kLocalizationProductMore';
    const kLocalizationProductLess = 'kLocalizationProductLess';
    const kLocalizationProductCategories = 'kLocalizationProductCategories';
    const kLocalizationProductSimilars = 'kLocalizationProductSimilars';
    const kLocalizationProductBack = 'kLocalizationProductBack';


    const kLocalizationWidgetSearch = 'kLocalizationWidgetSearch';
    const kLocalizationWidgetSortBy = 'kLocalizationWidgetSortBy';
    const kLocalizationWidgetSortByAsc = 'kLocalizationWidgetSortByAsc';
    const kLocalizationWidgetSortByDesc = 'kLocalizationWidgetSortByDesc';
    const kLocalizationWidgetOrderBy = 'kLocalizationWidgetOrderBy';
    const kLocalizationWidgetOrderByDate = 'kLocalizationWidgetOrderByDate';
    const kLocalizationWidgetOrderByRating = 'kLocalizationWidgetOrderByRating';
    const kLocalizationWidgetOrderByPrice = 'kLocalizationWidgetOrderByPrice';

    //Slider options
    const kShowArrows = "kShowArrows";
    const kShowPagination = "kShowPagination";
    const kShowPaginationMobile = "kShowPaginationMobile";
    const kAppearArrowsOnHover = "kAppearArrowsOnHover";
    const kShowPopupOnClick = "kShowPopupOnClick";
    const kArrowIconStyle = "kArrowIconStyle";
    const kArrowBgStyle = "kArrowBgStyle";
    const kArrowPosition = "kArrowPosition";
    const kArrowFontSize = "kArrowFontSize";
    const kSliderPaginationStyle = "kSliderPaginationStyle";
    const kSliderPaginationPosition = "kSliderPaginationPosition";
    const kSliderTextPosition = "kSliderTextPosition";
    const kArrowBgColor = "kArrowBgColor";
    const kArrowColor = "kArrowColor";
    const kArrowBgHoverColor = "kArrowBgHoverColor";
    const kArrowBgOpacity = "kArrowBgOpacity";
    const kArrowBgHoverOpacity = "kArrowBgHoverOpacity";
    const kArrowHoverColor = "kArrowHoverColor";
    const kSliderAutoplay = "kSliderAutoplay";
    const kSliderAutoplaySpeed = "kSliderAutoplaySpeed";
    const kSliderLoop = "kSliderLoop";
    const kSliderPauseOnHover = "kSliderPauseOnHover";
    const kTilePaddings = "kTilePaddings";
    const kSlideAnimation = "kSlideAnimation";
    const kSliderAutoHeight = "kSliderAutoHeight";
    const kImageBackgroundSize = "kImageBackgroundSize";
    const kImageBackgroundPosition = "kImageBackgroundPosition";
    const kSliderTextWidthStyle = "kSliderTextWidthStyle";
    const kSliderArrowsPadding = "kSliderArrowsPadding";
    const kSliderInfoPadding = "kSliderInfoPadding";
    const kShowInfoMobile = "kShowInfoMobile";
    const kColumnCalcAlgo = "kColumnCalcAlgo";
    const kScreenSize = "kScreenSize";
    const kDesktopMaxWidth = "kDesktopMaxWidth";
    const kDesktopMinWidth = "kDesktopMinWidth";
    const kMobileMaxWidth = "kMobileMaxWidth";
    const kDesktopMaxWidthDefault = 1280;
    const kDesktopMinWidthDefault = 769;
    const kMobileMaxWidthDefault = 420;
    const kLgDesktopCols = "kLgDesktopCols";
    const kDesktopCols = "kDesktopCols";
    const kTabletCols = "kTabletCols";
    const kMobileCols = "kMobileCols";
    const kHeightCalcAlgo = "kHeightCalcAlgo";
    const kTileProportion = "kTileProportion";


    //Carousel options
    const kShowBorder = "kShowBorder";
    const kShowShadow = "kShowShadow";
    const kShowBorderOnHover = "kShowBorderOnHover";
    const kShowShadowOnHover = "kShowShadowOnHover";
    const kShowButton = "kShowButton";
    const kAppearButtonOnHover = "kAppearButtonOnHover";
    const kInfoDisplayStyle = "kInfoDisplayStyle";
    const kButtonStyle = "kButtonStyle";
    const kButtonIcon = "kButtonIcon";
    const kBorderRadius = "kBorderRadius";
    const kBorderWidth = "kBorderWidth";
    const kSlideBgColor = "kSlideBgColor";
    const kSlideBgOpacity = "kSlideBgOpacity";
    const kSlideBgHoverColor = "kSlideBgHoverColor";
    const kSlideBgHoverOpacity = "kSlideBgHoverOpacity";
    const kBorderColor = "kBorderColor";
    const kShadowColor = "kShadowColor";
    const kSpaceBtwSlides = "kSpaceBtwSlides";
    const kSlideStep = "kSlideStep";
    const kButtonBgColor = "kButtonBgColor";
    const kButtonBgOpacity = "kButtonBgOpacity";
    const kButtonBgHoverColor = "kButtonBgHoverColor";
    const kButtonBgHoverOpacity = "kButtonBgHoverOpacity";
    const kButtonIconColor = "kButtonIconColor";
    const kSlidePadding = "kSlidePadding";

    public static function getTileProportions() {
        return [
            '1x1' => '1',
            '0.25x1' => '0.25',
            '0.5x1' => '0.5',
            '0.75x1' => '0.75',
            '1.25x1' => '1.25',
            '1.5x1' => '1.5',
            '1.75x1' => '1.75',
            '2x1' => '2',
            '2.25x1' => '2.25',
            '2.5x1' => '2.5',
            '2.75x1' => '2.75',
            '3x1' => '3',
        ];
    }
}


abstract class GKSHeightCalcAlgo {
    const Fixed = 'Fixed';
    const Proportional = 'Proportional';
}

abstract class GKSScreenSize {
    const Std = 'Std';
    const Custom = 'Custom';
}

abstract class GKSColumnCalcAlgo {
    const Dynamic = 'Dynamic';
    const Fixed = 'Fixed';
}

abstract class GKSSliderTextWidthStyle {
    const Auto = 'Auto';
    const Fill = 'Fill';
}

abstract class GKSSliderPaginationStyle {
    const Dots = 'Dots';
    const Squares = 'Squares';
    const Rectangles = 'Rectangles';
    const Ovals = 'Ovals';
}

abstract class GKSSliderPaginationPosition {
    const AfterSlider = 'AfterSlider';
    const BeforeSlider = 'BeforeSlider';
    const OnSliderBottom = 'OnSliderBottom';
    const OnSliderTop = 'OnSliderTop';
}

abstract class GKSSliderArrowBgStyle {
    const Dot = 'Dot';
    const Square = 'Square';
    const None = 'None';
}

abstract class GKSSliderArrowPosition {
    const Top = 'Top';
    const Bottom = 'Bottom';
    const Center = 'Center';
}

abstract class GKSSliderTextPosition {
    const TopLeft = 'TopLeft';
    const TopRight = 'TopRight';
    const LeftBottom = 'LeftBottom';
    const RightBottom = 'RightBottom';
    const TopCenter = 'TopCenter';
    const BottomCenter = 'BottomCenter';
}

abstract class GKSInfoDisplayStyle{
    const OnTop = 'OnTop'; // on slide, picture top
    const OnTopHover = 'OnTopHover'; // on slide, picture top on hover
    const OnBottom = 'OnBottom'; // on slide picture bottom,
    const OnBottomHover = 'OnBottomHover'; // on slide picture bottom on hover,
    const OnCenter = 'OnCenter'; // on slide picture center,
    const OnCenterHover = 'OnCenterHover'; // on slide picture center on hover,
    const After = 'After'; // after slide picture
    const Before = 'Before'; // before slide picture
}

abstract class GKSButtonDisplayStyle{
    const ShowOnHover = 'ShowOnHover';
    const ShowAlways = 'ShowAlways';
}

abstract class GKSButtonStyle{
    const Rect = 'Rect';
    const Circle = 'Circle';
}
abstract class GKSSlideStep {
    const Slide = 'Slide';
    const Page = 'Page';
}

abstract class GKSVar {
    const kVarTitle = '{{title}}';
}

?>
