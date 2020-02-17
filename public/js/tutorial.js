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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/tutorial.js":
/*!**********************************!*\
  !*** ./resources/js/tutorial.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$("document").ready(function () {
  $('.tutorial-logo').animate({
    opacity: 1,
    top: "+=530px"
  }, 1000, function () {
    $('.tutorial-logo').animate({
      top: "-=30px"
    }, 1000);
    $('.tutorial-bg-image').animate({
      opacity: 1
    }, 1000);
    $('.scroll-down').animate({
      opacity: 1
    }, 1000);
  });
  var counter = 0;
  $('.tutorial-layout').bind('mousewheel', function (e) {
    e.preventDefault();

    if (e.originalEvent.wheelDelta / 120 <= 0 && counter < 1) {
      $('.tutorial-bg-image').animate({
        opacity: 0
      }, 1500);
      $('.tutorial-logo').animate({
        top: "-150%"
      }, 1500, function () {});
      $('.dots').animate({
        'max-height': '500px'
      }, 500, function () {
        $('.scroll-down').animate({
          top: "-=40vh"
        }, 1500, function () {
          $('.tutorial-layout').hide();
          $('#tutorial_main').show(1000);
        });
      });
      counter = 1;
    }
  });
  var counter2 = 0;
  $('#tutorial_main').bind('mousewheel', function (e) {
    e.preventDefault();

    if (counter2 != 1) {
      counter2 = 1;

      if (e.originalEvent.wheelDelta / 120 <= 0) {
        var curentEl = $('.tutorial-item.active');
        var nextEl = curentEl.next();

        if (nextEl && nextEl.hasClass('tutorial-item')) {
          curentEl.removeClass('active');
          nextEl.addClass('active');
          nextEl.find('.num').addClass('active');
          console.log(curentEl.height());
          $('#tutorial_main').animate({
            scrollTop: nextEl.position().top
          }, 500);
        }

        setTimeout(function () {
          counter2 = 0;
        }, 600);
      } else {
        var _curentEl = $('.tutorial-item.active');

        var prevEl = _curentEl.prev();

        if (prevEl && prevEl.hasClass('tutorial-item')) {
          _curentEl.removeClass('active');

          prevEl.addClass('active');
          prevEl.find('.num').addClass('active');
          $('#tutorial_main').animate({
            scrollTop: prevEl.position().top
          }, 500);
        }

        setTimeout(function () {
          counter2 = 0;
        }, 600);
      }
    }
  });
  $('.tutorial-item').on('click', function () {
    var curentStep = $(this).find('.num').text();
    $('.tutorial-item .num').each(function (index, value) {
      if (!value.classList.contains('active') && value.innerHTML < curentStep) {
        value.classList.add('active');
      }
    });
    $('.tutorial-item.active').removeClass('active');
    $(this).addClass('active');
    $(this).find('.num').addClass('active');
    $('#tutorial_main').animate({
      scrollTop: $(this).position().top
    }, 500);
  });
});

/***/ }),

/***/ 2:
/*!*************************************!*\
  !*** multi ./resources/js/tutorial ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\OSPanel\domains\freelance\resources\js\tutorial */"./resources/js/tutorial.js");


/***/ })

/******/ });