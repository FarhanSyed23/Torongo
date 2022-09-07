<?php

if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
  require_once(GKS_CLASSES_DIR_PATH."/premium/GKSPremiumFuncs.php");
}

class GKSHelper {

    static public function shortcodeWithPID($sid){
        return "[yooslider id={$sid}]";
    }

    static public function tcButtonShortcodes(){
        global $wpdb;

        $results = $wpdb->get_results( "SELECT * FROM ".GKS_TABLE_SLIDERS , ARRAY_A );

        $shortcodes = array();
        for($i=0; $i<count($results); $i++){
            $shortcode = new stdClass();

            $shortcode->id = $results[$i]["id"];
            $shortcode->title = $results[$i]["title"];
            $shortcode->shortcode = GKSHelper::shortcodeWithPID($results[$i]["id"]);

            $shortcodes[] = $shortcode;
        }

        return $shortcodes;
    }

    static public function getSliderWithId($sid){
        $sid = (int)$sid;
        if(!$sid) return null;

        global $wpdb;
        $slider = null;

        $query = $wpdb->prepare("SELECT * FROM ".GKS_TABLE_SLIDERS." WHERE id = %d", $sid);
        $res = $wpdb->get_results( $query , OBJECT );

        if(count($res)) {
            $slider = $res[0];

            $query = $wpdb->prepare("SELECT * FROM " . GKS_TABLE_SLIDES . " WHERE sid = %d", $sid);
            $res = $wpdb->get_results($query, OBJECT);

            $slides = array();
            foreach ($res as $slide) {
                $slide->pics = explode(',', $slide->pics);
                $slide->categories = explode(',', $slide->categories);
                $slide->details = json_decode($slide->details);
                $slides[$slide->id] = $slide;
            }

            $slider->slides = $slides;
            $slider->corder = explode(',', $slider->corder);

            $layoutType = GKSLayoutType::SLIDER;
            if (!empty($slider->extoptions)) {
                $extoptions = json_decode($slider->extoptions);
                if (!empty($extoptions->type)) {
                    $layoutType = $extoptions->type;
                }
            }
            $slider->type = $layoutType;

            if($slider->options && !empty($slider->options)){
                $slider->options = json_decode( base64_decode($slider->options), true);
            }else{
                $slider->options = json_decode( base64_decode(GKSHelper::getDefaultOptions(0, $layoutType)), true);
            }

            $slider->options[GKSOption::kDisableAlbumStylePresentation] = ($layoutType != GKSLayoutType::SLIDER);
        }

        return $slider;
    }

    static public function getDefaultOptions($sid = 0, $layoutType = GKSLayoutType::SLIDER){
        $colCalcAlgo = '"kColumnCalcAlgo":"Dynamic","kScreenSize":"Std","kDesktopMaxWidth":"'.GKSOption::kDesktopMaxWidthDefault.'","kDesktopMinWidth":"'.GKSOption::kDesktopMinWidthDefault.'","kMobileMaxWidth":"'.GKSOption::kMobileMaxWidthDefault.'","kLgDesktopCols":"6","kDesktopCols":"4","kTabletCols":"3","kMobileCols":"1","kScrollerScreenSize":"Std","kScrollerDesktopMaxWidth":"'.GKSOption::kDesktopMaxWidthDefault.'","kScrollerDesktopMinWidth":"'.GKSOption::kDesktopMinWidthDefault.'","kScrollerMobileMaxWidth":"'.GKSOption::kMobileMaxWidthDefault.'","kScrollerLgDesktopCols":"6","kScrollerDesktopCols":"4","kScrollerTabletCols":"3","kScrollerMobileCols":"1"';

        $options = '{"id":"' . $sid . '","kShowPopupOnClick":false,"kHeightCalcAlgo":"Fixed","kThumbnailQuality":"large","kScrollerShowTitle":false,"kScrollerShowCover":true,"kScrollerShowBorder":true,"kShowTitle":true,"kShowDetails":true,"kShowArrows":true,"kShowInfoMobile":"true","kShowPagination":true,"kShowPaginationMobile":true,"kEnableGridLazyLoad":false,"kLoadUrlBlank":false,"kTileOverlayOpacity":"A6","kTileTitleFont":"","kFont":"","kTileTitleFontStyle":"bold","kFontStyle":"normal","kTileTitleAlignment":"center","kTileDescAlignment":"center","kPaginationColor":"#b1b0b0","kPaginationHoverColor":"#000000","kTileTitleColor":"#ffffff","kTileDescColor":"#ffffff","kTileOverlayColor":"#000000","kCustomJS":"","kCustomCSS":"","kSliderHeight":"450",'.$colCalcAlgo.',"kTileMargins": "0", "kTilePaddings": "20","kSliderArrowsPadding": "20","kSliderInfoPadding": "20","kTileTitleFontSize":"18","kFontSize":"13","kArrowFontSize":"60","kSliderAutoplay":false,"kSliderAutoHeight":false,"kImageBackgroundSize":"cover","kImageBackgroundPosition":"center","kSliderLoop":false,"kSliderPauseOnHover":false,"kArrowIconStyle":"fa-angle-","kSliderPaginationStyle":"Dots","kSliderPaginationPosition":"AfterSlider","kSliderTextWidthStyle":"Auto","kArrowBgStyle":"None","kArrowPosition":"Center","kSlideAnimation":"","kSliderTextPosition":"BottomCenter","kArrowBgColor":"#000000","kArrowBgHoverColor":"#000000","kArrowBgOpacity":"A6","kArrowBgHoverOpacity":"BF","kScrollerThumbBgColor":"#555555","kScrollerActiveThumbBgColor":"#aaaaaa","kScrollerThumbBorderColor":"#cc0000","kScrollerActiveThumbBorderColor":"#333333", "kScrollerThumbTitleColor":"#ffffff","kArrowColor":"#e2e2e2","kArrowHoverColor":"#ffffff","kSliderAutoplaySpeed":"5", "kViewType":"1","kScrollerHeight":"70","kScrollerPosition":"after"}';

        $options = str_replace("'", '"', $options);
        $options = base64_encode($options);
        return $options;
    }

    static public function thumbWithQuality($picInfo, $quality){
        if(!isset($picInfo)) return "";
        if(!isset($quality)) return $picInfo->medium;

        if($quality === "medium"){
            return $picInfo->medium;
        }elseif($quality === "large"){
            return $picInfo->large;
        }elseif($quality === "small"){
            return $picInfo->small;
        }else{
            return $picInfo->original;
        }
    }

    static function truncWithEllipsis($text, $limit, $appendix = '...'){
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . $appendix;
        }
        return $text;
    }

    static function hex2rgba($color) {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        $opacity = 255;

        //Check if color has 8, 6 or 3 characters and get values
        if (strlen($color) == 8) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            $opHex = array ($color[6] . $color[7]);
        } elseif (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        //Convert hexadec to rgba
        $rgb =  array_map('hexdec', $hex);
        $opacity = array_map('hexdec',$opHex);
        $opacity = $opacity[0]/255;

        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

        //Return rgb(a) color string
        return $output;
    }

    static function inverseColor($color){
        $color = str_replace('#', '', $color);
        if (strlen($color) != 6){ return '000000'; }
        $rgb = '';
        for ($x=0;$x<3;$x++){
            $c = 255 - hexdec(substr($color,(2*$x),2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
        return '#'.$rgb;
    }

    static function decode2Str($val){
        $str = base64_decode($val);
        return $str;
    }

    static function decode2Obj($str){
        $obj = json_decode($str);
        return $obj;
    }

    static function getAttachement( $attachment_id ) {
        $attachment = get_post( $attachment_id );

        return array(
            'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => get_permalink( $attachment->ID ),
            'src' => $attachment->guid,
            'title' => $attachment->post_title
        );
    }

    static function getAttachementMeta( $attachmentId, $quality = "full" ) {
        /* full, large, medium */
        $kQualityFull = "full";
        $kQualityLarge = "large";
        $kQualityMedium = "medium";
        $kQualityThumb = "thumbnail";

        $attachment = get_post( $attachmentId );
        if (!$attachment) {
            return false;
        }
        $meta = array();
        $meta["title"] = $attachment->post_title;
        $meta["alt"] = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
        $meta["caption"] = $attachment->post_excerpt;
        $meta["description"] = $attachment->post_content;

        //By default take full size & src
        $info = wp_get_attachment_image_src($attachmentId, $kQualityFull);

        if($quality === $kQualityLarge){
            $interInfo = wp_get_attachment_image_src($attachmentId, $kQualityFull);
            if($interInfo) {
                $info = $interInfo;
            }
        }elseif($quality === $kQualityMedium){
            $interInfo = wp_get_attachment_image_src($attachmentId, $kQualityMedium);
            if($interInfo) {
                $info = $interInfo;
            }
        }elseif($quality === $kQualityThumb){
            $interInfo = wp_get_attachment_image_src($attachmentId, $kQualityThumb);
            if($interInfo) {
                $info = $interInfo;
            }
        }

        $meta["src"] = $info[0];
        $meta["width"] = $info[1];
        $meta["height"] = $info[2];

        return $meta;
    }

    static function getVideoMeta( $attachment, $forThumb = false, $quality = "full" ) {
      if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
        return GKSPremiumFuncs::getVideoMeta($attachment, $forThumb, $quality);
      }

      return null;
    }

    static function getYoutubeMeta( $attachment, $forThumb = false, $quality = "full" ) {
      if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
        return GKSPremiumFuncs::getYoutubeMeta($attachment, $forThumb, $quality);
      }

      return null;
    }

    static function getIframeMeta( $attachment, $forThumb = false, $quality = "full" ) {
      if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
        return GKSPremiumFuncs::getIframeMeta($attachment, $forThumb, $quality);
      }

      return null;
    }

    static function getMapMeta( $attachment, $forThumb = false, $quality = "full" ) {
      if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
        return GKSPremiumFuncs::getMapMeta($attachment, $forThumb, $quality);
      }

      return null;
    }

    static function getVimeoMeta( $attachment, $forThumb = false, $quality = "full" ) {
      if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
        return GKSPremiumFuncs::getVimeoMeta($attachment, $forThumb, $quality);
      }

      return null;
    }

    static function getVimeoData($id)
    {
      if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
        return GKSPremiumFuncs::getVimeoData($id);
      }

      return null;
    }

    static function duplicateSlider($gks_sid)
    {
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM ".GKS_TABLE_SLIDERS." WHERE id = %d", $gks_sid);
        $res = $wpdb->get_results( $query , OBJECT );

        if(count($res)) {
            $slider = $res[0];
            $inserted = $wpdb->insert(
                GKS_TABLE_SLIDERS,
                array(
                    'title' => $slider->title.' 2',
                    'corder' => '',
                    'options' => $slider->options,
                    'extoptions' => $slider->extoptions,
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                )
            );
            if ($inserted) {
                $newSliderId = $wpdb->insert_id;
                $query = $wpdb->prepare("SELECT * FROM " . GKS_TABLE_SLIDES . " WHERE sid = %d", $gks_sid);
                $res = $wpdb->get_results($query, OBJECT);

                $corder = ($slider->corder != '') ? explode(',', $slider->corder) : array();
                $newCorder = array();
                if(count($res)) {
                    foreach($res as $slide) {
                        $wpdb->insert(
                            GKS_TABLE_SLIDES,
                            array(
                                'sid' => $newSliderId,
                                'title' => $slide->title,
                                'description' => $slide->description,
                                'url' => $slide->url,
                                'cover' => $slide->cover,
                                'pics' => $slide->pics,
                                'categories' => $slide->categories,
                                'cdate' => $slide->cdate,
                            ),
                            array(
                                '%d',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                                '%s',
                            )
                        );
                        $newCorder[array_search($slide->id, $corder)] = $wpdb->insert_id;
                    }
                    if(!empty($newCorder)) {
                        ksort($newCorder);
                        $wpdb->update(
                            GKS_TABLE_SLIDERS,
                            array(
                                'corder' => implode(',', $newCorder),
                            ),
                            array( 'id' => $newSliderId ),
                            array(
                                '%s',
                            ),
                            array( '%d' )
                        );
                    }
                }
            }
        }
    }

    static function getSliderOptions($sid)
    {
        global $wpdb;
        $query = $wpdb->prepare("SELECT * FROM ".GKS_TABLE_SLIDERS." WHERE id = %d", $sid);
        $res = $wpdb->get_results( $query , OBJECT );

        if(count($res)) {
            $slider = $res[0];

            if ($slider->options && !empty($slider->options)) {
                return json_decode(base64_decode($slider->options), true);
            } else {
                $layoutType = GKSLayoutType::SLIDER;
                if (!empty($slider->extoptions)) {
                    $extoptions = json_decode($slider->extoptions);
                    if (!empty($extoptions->type)) {
                        $layoutType = $extoptions->type;
                    }
                }
                return json_decode(base64_decode(GKSHelper::getDefaultOptions(0, $layoutType)), true);
            }
        } else {
            return null;
        }
    }

    static public function sortCustomFields($customFields)
    {
        $customFields = array_values($customFields);
        usort($customFields, 'self::sortCustomFieldsFunction');
        return $customFields;

    }

    static public function sortCustomFieldsFunction($f1, $f2)
    {
        return ($f1['order'] > $f2['order']);
    }

    static function formatAmount($amount, $currency, $currencyPosition) {
        if ($currencyPosition == GKSCurrencyPosition::BeforeAmount) {
            return $currency . $amount;
        }
        return $amount . $currency;
    }

    static function getSampleImage()
    {
        $upload_id = get_option(GKS_SAMPLE_IMG_ID);
        if (!empty($upload_id)) {
            $att = wp_get_attachment_url($upload_id);
            if ($att == false) {
                $upload_id = null;
            }
        }

        if (empty($upload_id)) {
            $wordpress_upload_dir = wp_upload_dir();
            $fname = GKS_SAMPLE_IMG_NAME;
            $fpath = GKS_SAMPLE_IMG_PATH;
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $fname;
            $new_file_mime = mime_content_type( $fpath );
            $i = 1;
            while( file_exists( $new_file_path ) ) {
                $i++;
                $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $fname;
            }
            if (copy($fpath, $new_file_path)) {
                $upload_id = wp_insert_attachment( array(
                    'guid'           => $new_file_path,
                    'post_mime_type' => $new_file_mime,
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', $fname ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ), $new_file_path );

                // wp_generate_attachment_metadata() won't work if you do not include this file
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                // Generate and save the attachment metas into the database
                wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

                update_option(GKS_SAMPLE_IMG_ID, $upload_id);
            }
        }
        if (!empty($upload_id)) {
            return $upload_id;
        }
        return false;

    }

    static function getPageUrl($type, $action, $id = null)
    {
        $map = array(
            GKSLayoutType::SLIDER => GKS_PLUGIN_SLAG,
        );
        if ($action == 'edit' && isset($map[$type])) {
            return '?page='.$map[$type].'&action=edit&id='.$id.'&type='.$type;
        } elseif ($action == 'create' && isset($map[$type])) {
            return '?page='.$map[$type].'&action=create&type='.$type;
        }
        return '';
    }

    static function validatedBase64String($str) {
      $str = base64_decode($str);
      if ($str == 'null' || empty($str)) {
          return "";
      }
      return $str;
    }
}
