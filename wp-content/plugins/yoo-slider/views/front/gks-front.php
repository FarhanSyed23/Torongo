<?php

class gks_Front
{

    static function processSlider($gks_slider)
    {
        global $gksParams;

        $gks_categories = gks_Front::getGeneralCategories($gks_slider);

        $sid = (isset($gksParams['sid'])) ? $gksParams['sid'] : '';
        $filter = (isset($gksParams['filter'])) ? stripslashes($gksParams['filter']) : '';
        $hideAllCategoryFilter = isset($gks_slider->options[GKSOption::kHideAllCategoryFilter]) ? $gks_slider->options[GKSOption::kHideAllCategoryFilter] : false;
        if ($hideAllCategoryFilter) {
            if (($sid == $gks_slider->id && $filter == '') || $sid != $gks_slider->id) {
                $filter = !empty($gks_categories) ? $gks_categories[0] : '';
            }
        } elseif ($sid != $gks_slider->id) {
            $filter = '';
        }
        $gks_slider->filter = $filter;

        $layoutType = GKSLayoutType::SLIDER;
        if (!empty($gks_slider->extoptions)) {
            $extoptions = json_decode($gks_slider->extoptions);
            if (!empty($extoptions->type)) {
                $layoutType = $extoptions->type;
            }
        }
        $gks_slider->type = $layoutType;

        //Setup ordered slides array
        $gks_slider->slides = gks_Front::getOrderedSlides($gks_slider);

        //Setup pagination
        if ($gks_slider->options && isset($gks_slider->options[GKSOption::kEnablePagination]) && $gks_slider->options[GKSOption::kEnablePagination]) {
            $gks_slider->totalSlidesCount = count($gks_slider->slides);
            $gks_slider->slides = gks_Front::paginateSlides($gks_slider);
        }
        return array($gks_categories, $gks_slider);
    }

    static function render() {

        if (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_RECURRING) {
            $lastValidatedAt = get_option(GKS_LAST_VALIDATED_AT);
            $lastValidatedAt = !empty($lastValidatedAt) ? $lastValidatedAt : 0;
            if ($lastValidatedAt == 0 || time() - $lastValidatedAt > 1 * 24 * 60 * 60) {
                $licenseManager = new GKSLicenseManager();
                $licenseManager->validateKey($licenseManager->getKey());
            }
            if (get_option(GKS_VALIDATOR_FLAG) != 1) {
                return;
            }
        }

        global $gks_slider;

        //Validation goes here
        if($gks_slider) {
            list($gks_categories, $gks_slider) = self::processSlider($gks_slider);

            if($gks_slider->options){

                if ($gks_slider->type == GKSLayoutType::SLIDER) {
                    require(GKS_FRONT_VIEWS_DIR_PATH . "/layouts/gks-front-slider.php");
                }
            }else {
                echo "Ooooops!!! Short-code options aren't found in your database!";
            }
        }else{
            echo "Ooooops!!! Short-code related slider wasn't found in your database!";
        }
    }

    static function sortCategories($cat1, $cat2){
        return $cat1['order'] > $cat2['order'];
    }

    static function getGeneralCategories($gks_slider){
        $categories = array();

        if(!empty($gks_slider->extoptions)) {
            $extOptions = json_decode($gks_slider->extoptions, true);
            if(!empty($extOptions['all_cats'])) {
                $cats = $extOptions['all_cats'];
                usort($cats, 'self::sortCategories');
                foreach ($cats as $cat) {
                    $categories []= $cat['name'];
                }
                return $categories;
            }
        }

        $tmp = array();
        if(isset($gks_slider->slides)){
            foreach($gks_slider->slides as $gks_slide){
                foreach($gks_slide->categories as $category){
                    if(!isset($tmp[$category])){
                        if(!empty($category)){
                            $categories[] = $category;
                            $tmp[$category] = $category;
                        }
                    }
                }
            }
        }

        @sort($categories, SORT_REGULAR);
        return $categories;
    }

    static function getOrderedSlides($gks_slider){
        global $gksParams;
        $filteredSlides = array();
        foreach ($gks_slider->slides as $slide) {
            if ($gks_slider->filter != '' && !in_array($gks_slider->filter, $slide->categories)) {
                continue;
            }
            if (!empty($gksParams['gks-s']) && !empty($gksParams['sid']) && $gksParams['sid'] == $gks_slider->id) {
                if (function_exists('mb_stripos')) {
                    if (mb_stripos(base64_decode($slide->title), $gksParams['gks-s']) === false) {
                        continue;
                    }
                } else {
                    if (stripos(base64_decode($slide->title), $gksParams['gks-s']) === false) {
                        continue;
                    }
                }

            }

            $filteredSlides[$slide->id]= $slide;
        }

        $orderedSlides = array();
        $canBeRandomized = true;
        if (!empty($gksParams['sid']) && $gksParams['sid'] == $gks_slider->id) {
            if (isset($gksParams['sort-by']) && $gksParams['sort-by'] == 'date') {
                if (isset($gksParams['sort-in']) && $gksParams['sort-in'] == 'asc') {
                    uasort($filteredSlides, 'self::catalogSortByDateAsc');
                } else {
                    uasort($filteredSlides, 'self::catalogSortByDateDesc');
                }
                $canBeRandomized = false;
            } elseif (isset($gksParams['sort-by']) && $gksParams['sort-by'] == 'price') {
                if (isset($gksParams['sort-in']) && $gksParams['sort-in'] == 'asc') {
                    uasort($filteredSlides, 'self::catalogSortByPriceAsc');
                } else {
                    uasort($filteredSlides, 'self::catalogSortByPriceDesc');
                }
                $canBeRandomized = false;
            } elseif (isset($gksParams['sort-by']) && $gksParams['sort-by'] == 'rating') {
                if (isset($gksParams['sort-in']) && $gksParams['sort-in'] == 'asc') {
                    uasort($filteredSlides, 'self::catalogSortByRatingAsc');
                } else {
                    uasort($filteredSlides, 'self::catalogSortByRatingDesc');
                }
                $canBeRandomized = false;
            }
        }

        if (isset($gks_slider->options[GKSOption::kRandomizeTileOrder]) && $gks_slider->options[GKSOption::kRandomizeTileOrder] && $canBeRandomized) {
            shuffle($filteredSlides);
            return $filteredSlides;
        }

        $orderedSlides = array();
        if(empty($gksParams['sid']) || (!empty($gksParams['sid']) && $gksParams['sid'] == $gks_slider->id && !isset($gksParams['sort-by']) && !empty($filteredSlides) && isset($gks_slider->corder))){

            foreach($gks_slider->corder as $sid){
                if (isset($filteredSlides[$sid])) {
                    $orderedSlides[] = $filteredSlides[$sid];
                }
            }
            $filteredSlides = $orderedSlides;
        }

        return $filteredSlides;
    }

    static function paginateSlides($slider) {
        global $gksParams;
        $sliderId = isset($gksParams['sid']) ? $gksParams['sid'] : '';
        $page = (isset($gksParams['pg']) && $sliderId == $slider->id) ? intval($gksParams['pg']) : 1;
        $itemsPerPage = isset($slider->options[GKSOption::kItemsPerPage]) ? $slider->options[GKSOption::kItemsPerPage] : GKSOption::kItemsPerPageDefault;
        return array_splice($slider->slides, ($page - 1) * $itemsPerPage, $itemsPerPage);
    }
}

?>
