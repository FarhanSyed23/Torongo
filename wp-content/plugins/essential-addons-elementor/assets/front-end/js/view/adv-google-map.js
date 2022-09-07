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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/view/adv-google-map.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/view/adv-google-map.js":
/*!***************************************!*\
  !*** ./src/js/view/adv-google-map.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var AdvGoogleMap = function AdvGoogleMap($scope, $) {\n  window.eaelHasMapAPI = window.google ? window.google : undefined;\n\n  if (!window.eaelHasMapAPI) {\n    var $map_class = $scope.find(\".eael-google-map\").eq(0),\n        $map_notice = $scope.find(\".google-map-notice\").eq(0);\n    $map_class.css(\"display\", \"none\");\n    $map_notice.html(\"Whoops! It' seems like you didn't set Google Map API key. You can set from <b>Elementor > Essential Addons > Elements > Advanced Google Map (Settings)</b>\");\n    $map_notice.addClass(\"alert alert-warning\");\n    $map_notice.css({\n      \"background-color\": \"#f2dede\",\n      color: \"#a94442\",\n      \"font-size\": \"85%\",\n      padding: \"15px\",\n      \"border-radius\": \"3px\"\n    });\n  } else {\n    var $map = $scope.find(\".eael-google-map\"),\n        $thisMap = $(\"#\" + $map.attr(\"id\")),\n        $mapID = $thisMap.data(\"id\"),\n        $mapType = $thisMap.data(\"map_type\"),\n        $mapAddressType = $thisMap.data(\"map_address_type\"),\n        $mapLat = $thisMap.data(\"map_lat\"),\n        $mapLng = $thisMap.data(\"map_lng\"),\n        $mapAddr = $thisMap.data(\"map_addr\"),\n        $mapBasicMarkerTitle = $thisMap.data(\"map_basic_marker_title\"),\n        $mapBasicMarkerContent = $thisMap.data(\"map_basic_marker_content\"),\n        $mapBasicMarkerIconEnable = $thisMap.data(\"map_basic_marker_icon_enable\"),\n        $mapBasicMarkerIcon = $thisMap.data(\"map_basic_marker_icon\"),\n        $mapBasicMarkerIconWidth = $thisMap.data(\"map_basic_marker_icon_width\"),\n        $mapBasicMarkerIconHeight = $thisMap.data(\"map_basic_marker_icon_height\"),\n        $mapZoom = $thisMap.data(\"map_zoom\"),\n        $mapMarkerContent = $thisMap.data(\"map_marker_content\"),\n        $mapMarkers = $thisMap.data(\"map_markers\"),\n        $mapStaticWidth = $thisMap.data(\"map_static_width\"),\n        $mapStaticHeight = $thisMap.data(\"map_static_height\"),\n        $mapStaticLat = $thisMap.data(\"map_static_lat\"),\n        $mapStaticLng = $thisMap.data(\"map_static_lng\"),\n        $mapPolylines = $thisMap.data(\"map_polylines\"),\n        $mapStrokeColor = $thisMap.data(\"map_stroke_color\"),\n        $mapStrokeOpacity = $thisMap.data(\"map_stroke_opacity\"),\n        $mapStrokeWeight = $thisMap.data(\"map_stroke_weight\"),\n        $mapStrokeFillColor = $thisMap.data(\"map_stroke_fill_color\"),\n        $mapStrokeFillOpacity = $thisMap.data(\"map_stroke_fill_opacity\"),\n        $mapOverlayContent = $thisMap.data(\"map_overlay_content\"),\n        $mapRoutesOriginLat = $thisMap.data(\"map_routes_origin_lat\"),\n        $mapRoutesOriginLng = $thisMap.data(\"map_routes_origin_lng\"),\n        $mapRoutesDestLat = $thisMap.data(\"map_routes_dest_lat\"),\n        $mapRoutesDestLng = $thisMap.data(\"map_routes_dest_lng\"),\n        $mapRoutesTravelMode = $thisMap.data(\"map_routes_travel_mode\"),\n        $mapPanoramaLat = $thisMap.data(\"map_panorama_lat\"),\n        $mapPanoramaLng = $thisMap.data(\"map_panorama_lng\"),\n        $mapTheme = JSON.parse(decodeURIComponent(($thisMap.data(\"map_theme\") + \"\").replace(/\\+/g, \"%20\"))),\n        $map_streeview_control = $thisMap.data(\"map_streeview_control\"),\n        $map_type_control = $thisMap.data(\"map_type_control\"),\n        $map_zoom_control = $thisMap.data(\"map_zoom_control\"),\n        $map_fullscreen_control = $thisMap.data(\"map_fullscreen_control\"),\n        $map_scroll_zoom = $thisMap.data(\"map_scroll_zoom\");\n    var eaelMapHeader = new GMaps({\n      el: \"#eael-google-map-\" + $mapID,\n      lat: $mapLat,\n      lng: $mapLng,\n      zoom: $mapZoom,\n      streetViewControl: $map_streeview_control,\n      mapTypeControl: $map_type_control,\n      zoomControl: $map_zoom_control,\n      fullscreenControl: $map_fullscreen_control,\n      scrollwheel: $map_scroll_zoom\n    });\n\n    if ($mapTheme != \"\") {\n      eaelMapHeader.addStyle({\n        styledMapName: \"Styled Map\",\n        styles: JSON.parse($mapTheme),\n        mapTypeId: \"map_style\"\n      });\n      eaelMapHeader.setStyle(\"map_style\");\n    }\n\n    if (\"basic\" == $mapType) {\n      var infoWindowHolder = $mapBasicMarkerContent != \"\" ? {\n        content: $mapBasicMarkerContent\n      } : \"\";\n\n      if ($mapBasicMarkerIconEnable == \"yes\") {\n        var iconHolder = {\n          url: $mapBasicMarkerIcon,\n          scaledSize: new google.maps.Size($mapBasicMarkerIconWidth, $mapBasicMarkerIconHeight)\n        };\n      } else {\n        var iconHolder = null;\n      }\n\n      if ($mapAddressType == \"address\") {\n        GMaps.geocode({\n          address: $mapAddr,\n          callback: function callback(results, status) {\n            if (status == \"OK\") {\n              var latlng = results[0].geometry.location;\n              eaelMapHeader.setCenter(latlng.lat(), latlng.lng());\n              eaelMapHeader.addMarker({\n                lat: latlng.lat(),\n                lng: latlng.lng(),\n                title: $mapBasicMarkerTitle,\n                infoWindow: infoWindowHolder,\n                icon: iconHolder\n              });\n            }\n          }\n        });\n      } else if ($mapAddressType == \"coordinates\") {\n        eaelMapHeader.addMarker({\n          lat: $mapLat,\n          lng: $mapLng,\n          title: $mapBasicMarkerTitle,\n          infoWindow: infoWindowHolder,\n          icon: iconHolder\n        });\n      }\n    } // end of basic map script\n\n\n    if (\"marker\" == $mapType) {\n      var $data = JSON.parse(decodeURIComponent(($mapMarkers + \"\").replace(/\\+/g, \"%20\")));\n\n      if ($data.length > 0) {\n        var MarkersMap = new GMaps({\n          el: \"#eael-google-map-\" + $mapID,\n          lat: $data[0].eael_google_map_marker_lat,\n          lng: $data[0].eael_google_map_marker_lng,\n          zoom: $mapZoom,\n          streetViewControl: $map_streeview_control,\n          mapTypeControl: $map_type_control,\n          zoomControl: $map_zoom_control,\n          fullscreenControl: $map_fullscreen_control,\n          scrollwheel: $map_scroll_zoom\n        });\n        MarkersMap.setCenter($data[0].eael_google_map_marker_lat, $data[0].eael_google_map_marker_lng);\n\n        if ($mapTheme != \"\") {\n          MarkersMap.addStyle({\n            styledMapName: \"Styled Map\",\n            styles: JSON.parse($mapTheme),\n            mapTypeId: \"map_style\"\n          });\n          MarkersMap.setStyle(\"map_style\");\n        }\n\n        $data.forEach(function ($marker) {\n          if ($marker.eael_google_map_marker_content != \"\") {\n            var infoWindowHolder = {\n              content: $marker.eael_google_map_marker_content\n            };\n          } else {\n            var infoWindowHolder = \"\";\n          }\n\n          if ($marker.eael_google_map_marker_icon_enable == \"yes\") {\n            var iconHolder = {\n              url: $marker.eael_google_map_marker_icon.url,\n              scaledSize: new google.maps.Size($marker.eael_google_map_marker_icon_width, $marker.eael_google_map_marker_icon_height) // scaled size\n\n            };\n          } else {\n            var iconHolder = {\n              path: 'M256,0C161.9,0,85.3,76.6,85.3,170.7c0,28.3,7.1,56.3,20.5,81.1c0,0,139,251.3,140.8,254.7s5.4,5.5,9.3,5.5 c3.9,0,7.5-2.1,9.3-5.5l140.9-254.8c13.4-24.8,20.4-52.8,20.4-81C426.7,76.6,350.1,0,256,0z M256,256 c-47.1,0-85.3-38.3-85.3-85.3s38.3-85.3,85.3-85.3s85.3,38.3,85.3,85.3S303.1,256,256,256z',\n              fillColor: $marker.eael_google_map_marker_icon_color,\n              fillOpacity: 1,\n              scale: 1,\n              strokeColor: $marker.eael_google_map_marker_icon_color,\n              strokeWeight: 14\n            };\n          }\n\n          MarkersMap.addMarker({\n            lat: parseFloat($marker.eael_google_map_marker_lat),\n            lng: parseFloat($marker.eael_google_map_marker_lng),\n            title: $marker.eael_google_map_marker_title,\n            infoWindow: infoWindowHolder,\n            icon: iconHolder\n          });\n        });\n      }\n    } // end of multiple markers map\n\n\n    if (\"static\" == $mapType) {\n      var $data = JSON.parse(decodeURIComponent(($mapMarkers + \"\").replace(/\\+/g, \"%20\"))),\n          markersHolder = [];\n\n      if ($data.length > 0) {\n        $data.forEach(function ($marker) {\n          markersHolder.push({\n            lat: parseFloat($marker.eael_google_map_marker_lat),\n            lng: parseFloat($marker.eael_google_map_marker_lng),\n            color: $marker.eael_google_map_marker_icon_color\n          });\n        });\n      }\n\n      var eaelStaticMapUrl = GMaps.staticMapURL({\n        size: [$mapStaticWidth, $mapStaticHeight],\n        lat: $mapStaticLat,\n        lng: $mapStaticLng,\n        markers: markersHolder\n      });\n      $(\"<img />\").attr(\"src\", eaelStaticMapUrl).appendTo(\"#eael-google-map-\" + $mapID);\n    } // End of static map\n\n\n    if (\"polyline\" == $mapType) {\n      var $polylines_data = JSON.parse(decodeURIComponent(($mapPolylines + \"\").replace(/\\+/g, \"%20\"))),\n          $data = JSON.parse(decodeURIComponent(($mapMarkers + \"\").replace(/\\+/g, \"%20\"))),\n          $eael_polylines = [];\n      $polylines_data.forEach(function ($polyline) {\n        $eael_polylines.push([parseFloat($polyline.eael_google_map_polyline_lat), parseFloat($polyline.eael_google_map_polyline_lng)]);\n      });\n      var path = JSON.parse(JSON.stringify($eael_polylines));\n      var eaelPolylineMap = new GMaps({\n        el: \"#eael-google-map-\" + $mapID,\n        lat: path[0][0],\n        lng: path[0][1],\n        zoom: $mapZoom\n      });\n      eaelPolylineMap.drawPolyline({\n        path: path,\n        strokeColor: $mapStrokeColor.toString(),\n        strokeOpacity: $mapStrokeOpacity,\n        strokeWeight: $mapStrokeWeight\n      });\n      $data.forEach(function ($marker) {\n        if ($marker.eael_google_map_marker_content != \"\") {\n          var infoWindowHolder = {\n            content: $marker.eael_google_map_marker_content\n          };\n        } else {\n          var infoWindowHolder = \"\";\n        }\n\n        if ($marker.eael_google_map_marker_icon_enable == \"yes\") {\n          var iconHolder = {\n            url: $marker.eael_google_map_marker_icon.url,\n            scaledSize: new google.maps.Size($marker.eael_google_map_marker_icon_width, $marker.eael_google_map_marker_icon_height) // scaled size\n\n          };\n        } else {\n          var iconHolder = \"\";\n        }\n\n        eaelPolylineMap.addMarker({\n          lat: $marker.eael_google_map_marker_lat,\n          lng: $marker.eael_google_map_marker_lng,\n          title: $marker.eael_google_map_marker_title,\n          infoWindow: infoWindowHolder,\n          icon: iconHolder\n        });\n      });\n\n      if ($mapTheme != \"\") {\n        eaelPolylineMap.addStyle({\n          styledMapName: \"Styled Map\",\n          styles: JSON.parse($mapTheme),\n          mapTypeId: \"polyline_map_style\"\n        });\n        eaelPolylineMap.setStyle(\"polyline_map_style\");\n      }\n    } // End of polyline map\n\n\n    if (\"polygon\" == $mapType) {\n      var $polylines_data = JSON.parse(decodeURIComponent(($mapPolylines + \"\").replace(/\\+/g, \"%20\"))),\n          $eael_polylines = [];\n      $polylines_data.forEach(function ($polyline) {\n        $eael_polylines.push([parseFloat($polyline.eael_google_map_polyline_lat), parseFloat($polyline.eael_google_map_polyline_lng)]);\n      });\n      var path = JSON.parse(JSON.stringify($eael_polylines));\n\n      if (path) {\n        var map = new GMaps({\n          div: \"#eael-google-map-\" + $mapID,\n          lat: path[0][0],\n          lng: path[0][1],\n          zoom: $mapZoom\n        });\n        polygon = map.drawPolygon({\n          paths: path,\n          strokeColor: $mapStrokeColor.toString(),\n          strokeOpacity: $mapStrokeOpacity,\n          strokeWeight: $mapStrokeWeight,\n          fillColor: $mapStrokeFillColor.toString(),\n          fillOpacity: $mapStrokeFillOpacity\n        });\n      }\n    } // End of polygon map\n\n\n    if (\"overlay\" == $mapType) {\n      if ($mapOverlayContent != \"\") {\n        var contentHolder = '<div class=\"eael-gmap-overlay\">' + $mapOverlayContent + \"</div>\";\n      } else {\n        var contentHolder = \"\";\n      }\n\n      eaelMapHeader.drawOverlay({\n        lat: $mapLat,\n        lng: $mapLng,\n        content: contentHolder\n      });\n    } // End of overlay map\n\n\n    if (\"routes\" == $mapType) {\n      var routeMap = new GMaps({\n        el: \"#eael-google-map-\" + $mapID,\n        lat: $mapRoutesOriginLat,\n        lng: $mapRoutesOriginLng,\n        zoom: $mapZoom\n      });\n      routeMap.drawRoute({\n        origin: [$mapRoutesOriginLat, $mapRoutesOriginLng],\n        destination: [$mapRoutesDestLat, $mapRoutesDestLng],\n        travelMode: $mapRoutesTravelMode.toString(),\n        strokeColor: $mapStrokeColor.toString(),\n        strokeOpacity: $mapStrokeOpacity,\n        strokeWeight: $mapStrokeWeight\n      });\n      var $data = JSON.parse(decodeURIComponent(($mapMarkers + \"\").replace(/\\+/g, \"%20\")));\n\n      if ($data.length > 0) {\n        $data.forEach(function ($marker) {\n          if ($marker.eael_google_map_marker_content != \"\") {\n            var infoWindowHolder = {\n              content: $marker.eael_google_map_marker_content\n            };\n          } else {\n            var infoWindowHolder = \"\";\n          }\n\n          if ($marker.eael_google_map_marker_icon_enable == \"yes\") {\n            var iconHolder = {\n              url: $marker.eael_google_map_marker_icon.url,\n              scaledSize: new google.maps.Size($marker.eael_google_map_marker_icon_width, $marker.eael_google_map_marker_icon_height) // scaled size\n\n            };\n          } else {\n            var iconHolder = \"\";\n          }\n\n          eaelMapHeader.addMarker({\n            lat: $marker.eael_google_map_marker_lat,\n            lng: $marker.eael_google_map_marker_lng,\n            title: $marker.eael_google_map_marker_title,\n            infoWindow: infoWindowHolder,\n            icon: iconHolder\n          });\n        });\n      }\n    } // End of map routers\n\n\n    if (\"panorama\" == $mapType) {\n      var eaelPanorama = GMaps.createPanorama({\n        el: \"#eael-google-map-\" + $mapID,\n        lat: $mapPanoramaLat,\n        lng: $mapPanoramaLng\n      });\n    } // end of map panorama\n\n  }\n};\n\njQuery(window).on(\"elementor/frontend/init\", function () {\n  elementorFrontend.hooks.addAction(\"frontend/element_ready/eael-google-map.default\", AdvGoogleMap);\n});\n\n//# sourceURL=webpack:///./src/js/view/adv-google-map.js?");

/***/ })

/******/ });