/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/view/post-carousel.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/view/post-carousel.js":
/*!**************************************!*\
  !*** ./src/js/view/post-carousel.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/*=================================*/\n\n/* 19. Post Carousel\n/*=================================*/\nvar PostCarouselHandler = function PostCarouselHandler($scope, $) {\n  var $postCarousel = $scope.find(\".eael-post-carousel\").eq(0),\n      $autoplay = $postCarousel.data(\"autoplay\") !== undefined ? $postCarousel.data(\"autoplay\") : 999999,\n      $pagination = $postCarousel.data(\"pagination\") !== undefined ? $postCarousel.data(\"pagination\") : \".swiper-pagination\",\n      $arrow_next = $postCarousel.data(\"arrow-next\") !== undefined ? $postCarousel.data(\"arrow-next\") : \".swiper-button-next\",\n      $arrow_prev = $postCarousel.data(\"arrow-prev\") !== undefined ? $postCarousel.data(\"arrow-prev\") : \".swiper-button-prev\",\n      $items = $postCarousel.data(\"items\") !== undefined ? $postCarousel.data(\"items\") : 3,\n      $items_tablet = $postCarousel.data(\"items-tablet\") !== undefined ? $postCarousel.data(\"items-tablet\") : 3,\n      $items_mobile = $postCarousel.data(\"items-mobile\") !== undefined ? $postCarousel.data(\"items-mobile\") : 3,\n      $margin = $postCarousel.data(\"margin\") !== undefined ? $postCarousel.data(\"margin\") : 10,\n      $margin_tablet = $postCarousel.data(\"margin-tablet\") !== undefined ? $postCarousel.data(\"margin-tablet\") : 10,\n      $margin_mobile = $postCarousel.data(\"margin-mobile\") !== undefined ? $postCarousel.data(\"margin-mobile\") : 10,\n      $effect = $postCarousel.data(\"effect\") !== undefined ? $postCarousel.data(\"effect\") : \"slide\",\n      $speed = $postCarousel.data(\"speed\") !== undefined ? $postCarousel.data(\"speed\") : 400,\n      $loop = $postCarousel.data(\"loop\") !== undefined ? $postCarousel.data(\"loop\") : 0,\n      $grab_cursor = $postCarousel.data(\"grab-cursor\") !== undefined ? $postCarousel.data(\"grab-cursor\") : 0,\n      $pause_on_hover = $postCarousel.data(\"pause-on-hover\") !== undefined ? $postCarousel.data(\"pause-on-hover\") : \"\",\n      $centeredSlides = $effect == \"coverflow\" ? true : false;\n  var $carouselOptions = {\n    direction: \"horizontal\",\n    speed: $speed,\n    effect: $effect,\n    centeredSlides: $centeredSlides,\n    grabCursor: $grab_cursor,\n    autoHeight: true,\n    loop: $loop,\n    autoplay: {\n      delay: $autoplay\n    },\n    pagination: {\n      el: $pagination,\n      clickable: true\n    },\n    navigation: {\n      nextEl: $arrow_next,\n      prevEl: $arrow_prev\n    }\n  };\n\n  if ($effect === 'slide' || $effect === 'coverflow') {\n    $carouselOptions.breakpoints = {\n      1024: {\n        slidesPerView: $items,\n        spaceBetween: $margin\n      },\n      768: {\n        slidesPerView: $items_tablet,\n        spaceBetween: $margin_tablet\n      },\n      320: {\n        slidesPerView: $items_mobile,\n        spaceBetween: $margin_mobile\n      }\n    };\n  } else {\n    $carouselOptions.items = 1;\n  }\n\n  var eaelPostCarousel = new Swiper($postCarousel, $carouselOptions);\n\n  if ($autoplay === 0) {\n    eaelPostCarousel.autoplay.stop();\n  }\n\n  if ($pause_on_hover && $autoplay !== 0) {\n    $postCarousel.on(\"mouseenter\", function () {\n      eaelPostCarousel.autoplay.stop();\n    });\n    $postCarousel.on(\"mouseleave\", function () {\n      eaelPostCarousel.autoplay.start();\n    });\n  }\n\n  var $tabContainer = $('.eael-advance-tabs'),\n      nav = $tabContainer.find('.eael-tabs-nav li'),\n      tabContent = $tabContainer.find('.eael-tabs-content > div');\n  nav.on('click', function () {\n    var currentContent = tabContent.eq($(this).index()),\n        sliderExist = $(currentContent).find('.swiper-container-wrap.eael-post-carousel-wrap');\n\n    if (sliderExist.length) {\n      new Swiper($postCarousel, $carouselOptions);\n    }\n  });\n};\n\njQuery(window).on(\"elementor/frontend/init\", function () {\n  elementorFrontend.hooks.addAction(\"frontend/element_ready/eael-post-carousel.default\", PostCarouselHandler);\n});\n\n//# sourceURL=webpack:///./src/js/view/post-carousel.js?");

/***/ })

/******/ });