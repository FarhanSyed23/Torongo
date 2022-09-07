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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/view/post-list.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/view/post-list.js":
/*!**********************************!*\
  !*** ./src/js/view/post-list.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var postListHandler = function postListHandler($scope, $) {\n  // category\n  $('.post-categories', $scope).on('click', 'a', function (e) {\n    e.preventDefault(); // tab class\n\n    $('.post-categories a', $scope).removeClass('active');\n    $(this).addClass('active'); // collect props\n\n    $class = $('.post-categories', $scope).data('class');\n    $args = $('.post-categories', $scope).data('args');\n    $settings = $('.post-categories', $scope).data('settings');\n    $page = 1;\n    $taxonomy = {\n      taxonomy: $('.post-categories a.active', $scope).data('taxonomy'),\n      field: 'term_id',\n      terms: [$('.post-categories a.active', $scope).data('id')]\n    }; // ajax\n\n    $.ajax({\n      url: localize.ajaxurl,\n      type: 'post',\n      data: {\n        action: 'load_more',\n        \"class\": $class,\n        args: $args,\n        taxonomy: $taxonomy,\n        settings: $settings,\n        page: $page\n      },\n      success: function success(response) {\n        var $content = $(response);\n\n        if ($content.hasClass('no-posts-found') || $content.length == 0) {// do nothing\n        } else {\n          $('.eael-post-appender', $scope).empty().append($content); // update page\n\n          $('.post-list-pagination', $scope).data('page', 1); // update nav\n\n          $('.btn-prev-post', $scope).prop('disabled', true);\n          $('.btn-next-post', $scope).prop('disabled', false);\n        }\n      },\n      error: function error(response) {\n        console.log(response);\n      }\n    });\n  }); // load more\n\n  $('.post-list-pagination', $scope).on('click', 'button', function (e) {\n    e.preventDefault();\n    e.stopPropagation();\n    e.stopImmediatePropagation(); // collect props\n\n    var $this = $(this),\n        $class = $this.parent('.post-list-pagination').data('class'),\n        $args = $this.parent('.post-list-pagination').data('args'),\n        $settings = $this.parent('.post-list-pagination').data('settings'),\n        $page = $this.hasClass('btn-prev-post') ? parseInt($this.parent('.post-list-pagination').data('page')) - 1 : parseInt($this.parent('.post-list-pagination').data('page')) + 1,\n        $taxonomy = {\n      taxonomy: $('.post-categories a.active', $scope).data('taxonomy'),\n      field: 'term_id',\n      terms: [$('.post-categories a.active', $scope).data('id')]\n    };\n\n    if ($taxonomy.taxonomy == '' || $taxonomy.taxonomy != 'all' || $taxonomy.taxonomy == 'undefined') {\n      $taxonomy.taxonomy = 'all';\n    }\n\n    ;\n    $this.prop('disabled', true);\n\n    if ($page <= 0) {\n      return;\n    }\n\n    $.ajax({\n      url: localize.ajaxurl,\n      type: 'post',\n      data: {\n        action: 'load_more',\n        \"class\": $class,\n        args: $args,\n        taxonomy: $taxonomy,\n        settings: $settings,\n        page: $page\n      },\n      success: function success(response) {\n        var $content = $(response);\n\n        if ($content.hasClass('no-posts-found') || $content.length == 0) {// do nothing\n        } else {\n          $('.eael-post-appender', $scope).empty().append($content);\n          $('.post-list-pagination button', $scope).prop('disabled', false);\n          $this.parent('.post-list-pagination').data('page', $page);\n        }\n      },\n      error: function error(response) {\n        console.log(response);\n      }\n    });\n  });\n};\n\njQuery(window).on('elementor/frontend/init', function () {\n  elementorFrontend.hooks.addAction('frontend/element_ready/eael-post-list.default', postListHandler);\n});\n\n//# sourceURL=webpack:///./src/js/view/post-list.js?");

/***/ })

/******/ });