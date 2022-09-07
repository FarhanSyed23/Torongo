<?php

function wp_ajax_gks_get_slider(){
    global $wpdb;
    $response = new stdClass();

    if(!isset($_GET['id'])){
        $response->status = 'error';
        $response->errormsg = 'Invalid slider identifier!';
        gks_ajax_return($response);
    }

    $sid = (int)$_GET['id'];
    $query = $wpdb->prepare("SELECT * FROM ".GKS_TABLE_SLIDERS." WHERE id = %d", $sid);
    $res = $wpdb->get_results( $query , OBJECT );

    if(count($res)){
        $slider = $res[0];

        $query = $wpdb->prepare("SELECT * FROM ".GKS_TABLE_SLIDES." WHERE sid = %d", $sid);
        $res = $wpdb->get_results( $query , OBJECT );

        $allCats = array();
        $slides = array();
        foreach ($res as $slide) {
            if(!empty($slide->categories)) {
                $slide->categories = explode(',', $slide->categories);
            } else {
                $slide->categories = array();
            }
            if (empty($slider->extoptions)) {
                $allCats = array_merge($allCats, $slide->categories);
            }
            if(!empty($slide->details)) {
                $slide->details = json_decode($slide->details, true);
            }

            $slides[$slide->id] = $slide;

            $picJson = json_decode(base64_decode($slide->cover), true);

            if (!isset($picJson['type']) || $picJson['type'] == GKSAttachmentType::PICTURE) {
                $picId = $picJson['id'];
                $picInfo = GKSHelper::getAttachementMeta($picId, "medium");
                $pic = array(
                    "id" => $picId,
                    "src" => $picInfo ? $picInfo["src"] : '',
                );
                if (isset($picJson['uid'])) {
                    $pic['uid'] = $picJson['uid'];
                }
            } else { // youtube or vimeo
                $pic = $picJson;
            }
            $slide->cover = base64_encode(json_encode($pic));

            $pics = array();
            if($slide->pics && !empty($slide->pics)) {
                $exp = explode(",", $slide->pics);
                foreach ($exp as $item) {
                    $picJson = json_decode(base64_decode($item), true);
                    if (!isset($picJson['type']) || $picJson['type'] == 'pic') {
                        $picId = $picJson['id'];
                        $picInfo = GKSHelper::getAttachementMeta($picId, "medium");
                        $pic = array(
                            "id" => $picId,
                            "src" => $picInfo ? $picInfo["src"] : '',
                            "type" => !isset($picJson['type']) ? GKSAttachmentType::PICTURE : $picJson['type']
                        );
                        if (isset($picJson['uid'])) {
                            $pic['uid'] = $picJson['uid'];
                        }
                    } else { // youtube or vimeo
                        $pic = $picJson;
                    }

                    $pics[] = base64_encode(json_encode($pic));
                }
            }
            $slide->pics = implode(",", $pics);
        }

        if (empty($slider->extoptions)) {
            $allCats = array_unique($allCats);
            sort($allCats, SORT_REGULAR);
            $formattedCats = array();
            for ($i = 0; $i < count($allCats); $i++) {
                $formattedCats[$allCats[$i]] = $i;
            }
            $slider->extoptions = array('all_cats' => $formattedCats);
        } else {
            $extOptions = json_decode($slider->extoptions, true);
            $allCats = isset($extOptions['all_cats']) ? $extOptions['all_cats'] : array();
            $formattedCats = array();
            for ($i = 0; $i < count($allCats); $i++) {
                $formattedCats[$allCats[$i]['name']] = $allCats[$i]['order'];
            }
            $extOptions['all_cats'] = $formattedCats;
            $slider->extoptions = $extOptions;
        }
        $slider->slides = $slides;
        $slider->corder = explode(',',$slider->corder);
        $slider->options = json_decode( base64_decode($slider->options), true);

        $response->status = 'success';
        $response->slider = $slider;
    }else{
        $response->status = 'error';
        $response->errormsg = 'Unknown slider identifier!';
    }

    gks_ajax_return($response);
}

function wp_ajax_gks_save_slider() {

    $newSlider = false;

    global $wpdb;
    $response = new stdClass();

    if(!isset($_POST['slider'])){
        $response->status = 'error';
        $response->errormsg = 'Invalid slider passed!';
        gks_ajax_return($response);
    }
    //Convert to stdClass object
    $slider = json_decode( stripslashes($_POST['slider']), true);
    $sid = isset($slider['id']) ? (int)$slider['id'] : 0;

    $corder = array_map('intval', $slider['corder']);
    $corder = isset($slider['corder']) ? implode(',', $corder)  : "";

    //Insert if slider is draft yet
    $isDraft = isset($slider['isDraft']) && (int)$slider['isDraft'];
    if($isDraft){
        $title = isset($slider['title']) ? filter_var($slider['title'], FILTER_SANITIZE_STRING) : "";

        $wpdb->insert(
            GKS_TABLE_SLIDERS,
            array(
                'title' => $title,
            ),
            array(
                '%s',
            )
        );

        //Get real identifier and use it instead of draft identifier for tmp usage
        $sid = $wpdb->insert_id;

        $newSlider = true;
    }

    $slides = isset($slider['slides']) ? $slider['slides'] : array();
    $catList = array();

    foreach($slides as $id => $slide){
        $cover = isset($slide['cover']) ? $slide['cover'] : "";
        if (empty($cover)) {
            continue;
        }

        if (empty(GKSHelper::validatedBase64String($cover))) {
            continue;
        }

        //NOTE: We allow users to enter custom HTML content, but not only texts, for the title, description
        $title = isset($slide['title']) ? $slide['title'] : "";
        $description = isset($slide['description']) ? $slide['description'] : "";

        $url = isset($slide['url']) ? filter_var($slide['url'], FILTER_VALIDATE_URL) : "";
        $pics = isset($slide['pics']) ? GKSHelper::validatedBase64String($slide['pics']) : "";

        //Details JSON is not supported yet
        $details = ""; //isset($slide['details']) ? $slide['details'] : '';

        $cats = "";
        /* Caretories are not supported for sliders
        $cats = isset($slide['categories']) ? implode(',',$slide['categories']) : "";
        $catList = array_merge($catList, $slide['categories']);
        */

        if(isset($slide['isDraft']) && $slide['isDraft']){
            $wpdb->insert(
                GKS_TABLE_SLIDES,
                array(
                    'title' => $title,
                    'sid' => $sid,
                    'cover' => $cover,
                    'description' => $description,
                    'url' => $url,
                    'pics' => $pics,
                    'categories' => $cats,
                    'cdate' => date('Y-m-d H:i:s'),
                    'details' => json_encode($details)
                ),
                array(
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                )
            );

            $realSlideId = $wpdb->insert_id;
            $corder = str_replace($id,$realSlideId,$corder);
        }else{
            $wpdb->update(
                GKS_TABLE_SLIDES,
                array(
                    'title' => $title,
                    'cover' => $cover,
                    'description' => $description,
                    'url' => $url,
                    'pics' => $pics,
                    'categories' => $cats,
                    'details' => json_encode($details)
                ),
                array( 'id' => $id ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                ),
                array( '%d' )
            );
        }
    }

    $deletions = isset($slider['deletions']) ? $slider['deletions'] : array();
    $deletions = array_map('intval', $deletions);
    foreach($deletions as $deletedSlideId) {
        $wpdb->delete( GKS_TABLE_SLIDES, array( 'id' => $deletedSlideId ) );
    }

    $title = isset($slider['title']) ? filter_var($slider['title'], FILTER_SANITIZE_STRING) : "";

    $catList = array_values(array_unique($catList));
    $extOptions = array(
        'all_cats' => array(),
        'type' => (isset($slider['extoptions']['type']) ? $slider['extoptions']['type'] : GKSLayoutType::SLIDER)
    );
    $layoutType = $extOptions['type']; // for log

    $newOrder = count($catList);
    foreach ($catList as $cat) {
        if (isset($slider['extoptions']['all_cats']) && isset($slider['extoptions']['all_cats'][$cat])) {
            $order = $slider['extoptions']['all_cats'][$cat];
        } else {
            $order = $newOrder;
            $newOrder++;
        }
        $extOptions['all_cats'][] = array(
            'order' => $order,
            'name' => $cat
        );
    }
    $extOptions = json_encode($extOptions);
    $wpdb->update(
        GKS_TABLE_SLIDERS,
        array(
            'title' => $title,
            'corder' => $corder,
            'extoptions' => $extOptions
        ),
        array( 'id' => $sid ),
        array(
            '%s',
            '%s',
            '%s'
        ),
        array( '%d' )
    );

    $response->status = 'success';
    $response->sid = $sid;
    gks_ajax_return($response);
}

function wp_ajax_gks_get_options(){
    global $wpdb;
    $response = new stdClass();

    if(!isset($_GET['id'])){
        $response->status = 'error';
        $response->errormsg = 'Invalid slider identifier!';
        gks_ajax_return($response);
    }

    $sid = (int)$_GET['id'];
    $query = $wpdb->prepare("SELECT * FROM ".GKS_TABLE_SLIDERS." WHERE id = %d", $sid);
    $res = $wpdb->get_results( $query , OBJECT );

    if(count($res)){
        $slider = $res[0];

        //die($slider->options);
        if($slider->options && !empty($slider->options)){
            $response->options = $slider->options;
        }else{
            $layoutType = GKSLayoutType::SLIDER;
            if (!empty($slider->extoptions)) {
                $extoptions = json_decode($slider->extoptions);
                if (!empty($extoptions->type)) {
                    $layoutType = $extoptions->type;
                }
            }
            $response->options = GKSHelper::getDefaultOptions(0, $layoutType);
        }

        $options = json_decode(base64_decode($response->options), true);
        if (!empty($options[GKSOption::kCustomFields])) {
            $options[GKSOption::kCustomFields] = GKSHelper::sortCustomFields($options[GKSOption::kCustomFields]);
        }
        $response->options = base64_encode(json_encode($options));

        $response->status = 'success';
    } else {
        $response->status = 'error';
        $response->errormsg = 'Slider was not found!';
    }

    gks_ajax_return($response);
}

function wp_ajax_gks_save_options() {
    global $wpdb;
    $response = new stdClass();

    if(!isset($_POST['options']) || !isset($_POST['sid'])){
        $response->status = 'error';
        $response->errormsg = 'Invalid data passed!';
        gks_ajax_return($response);
    }

    $sid = (int)$_POST['sid'];
    //We don't sanitize options, because this options comes from our settings/UI section. User can hack and post anyting he/she wants, but this will end up with not showing sliders, nothing else!
    $options = $_POST['options'];

    $wpdb->update(
        GKS_TABLE_SLIDERS,
        array(
            'options' => $options,
        ),
        array( 'id' => $sid ),
        array(
            '%s',
        ),
        array( '%d' )
    );

    if (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_RECURRING) {
        $query = $wpdb->prepare("SELECT * FROM ".GKS_TABLE_SLIDERS." WHERE id = %d", $sid);
        $res = $wpdb->get_results( $query , OBJECT );

        if(count($res)) {
            $slider = $res[0];
            $layoutType = GKSLayoutType::SLIDER;
            if (!empty($slider->extoptions)) {
                $extoptions = json_decode($slider->extoptions);
                if (!empty($extoptions->type)) {
                    $layoutType = $extoptions->type;
                }
            }
            $licenseManager = new GKSLicenseManager();
            $fakeSliderObject = new stdClass();
            $fakeSliderObject->id = $sid;
            $fakeSliderObject->options = json_decode(base64_decode($options), true);
            $licenseManager->generateCustomCSS($fakeSliderObject, ($layoutType == GKSLayoutType::SLIDER));
        }
    }

    $response->status = 'success';
    gks_ajax_return($response);
}

function wp_ajax_gks_load_tiles() {
    require_once(GKS_FRONT_VIEWS_DIR_PATH."/gks-front.php");
    require_once(GKS_FRONT_VIEWS_DIR_PATH."/components/gks-tile-inflatter.php");

    $id = (int)$_GET['sid'];
    $gks_slider = GKSHelper::getSliderWithId($id);
    list($gks_categories, $gks_slider) = gks_Front::processSlider($gks_slider);

    $tilesHtml = gksGetTilesHtml($gks_slider, $gks_categories, true);
    $html = gksPrepareTilesXHR($gks_slider, $tilesHtml);

    gks_ajax_return(array('html' => $html));
}

function gks_get_visitor_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty( $_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//Helper functions
function gks_ajax_return( $response ){
    echo  json_encode( $response );
    die();
}
