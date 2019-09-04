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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/front.js":
/*!*******************************!*\
  !*** ./resources/js/front.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$("document").ready(function () {
  $(".alert").delay(3000).slideUp();
  $("#avatar-input").on("change", function () {
    $("#avatar-input-label").text($(this).val().split("\\").pop());
  });
  $(".to-profile").on('click', function () {
    window.location.href = '/profile/' + $(this).attr('data-id');
  });
  $(".work-order").on('click', function () {
    window.location.href = '/orders/' + $(this).attr('data-id');
  });
  $('.propose-toggle').on('click', function () {
    var style = $('#prop').css('display');

    if (style == 'none') {
      $('#prop').show();
    } else {
      $('#prop').hide();
    }
  });
  /*$('#new_order-toggle').on('click', function () {
      let style = $('#new-order').css('display');
        if (style == 'none') {
          $('#new-order').show();
      } else {
          $('#new-order').hide();
      }
  });*/

  $('#reset_order-toggle').on('click', function () {
    var style = $('#reset-order').css('display');

    if (style == 'none') {
      $('#reset-order').show();
    } else {
      $('#reset-order').hide();
    }
  });
  $('.disable-comment').on('change', function () {
    if (!$('.reviews-rating,.reviews-comment').prop('disabled')) {
      $('.reviews-rating,.reviews-comment').prop('disabled', true);
      $('.reviews-rating,.reviews-comment').prop('required', false);
    } else {
      $('.reviews-rating,.reviews-comment').prop('disabled', false);
      $('.reviews-rating,.reviews-comment').prop('required', true);
    }
  });
  $('.pass_change').on('submit', function (e) {
    var pass = $("input[name = 'new_password']"),
        new_pass = $("input[name = 'new_password_confirmation']");

    if (pass.val().length < 8 || pass.val() !== new_pass.val()) {
      e.preventDefault();
      $('.invalid-feedback').text(pass.val().length < 8 ? 'Довжина паролю має бути хоча б 8 символів' : 'Паролі не співпадають');
      new_pass.addClass('is-invalid');
    }
  });
  $('input[name = "select_worker"]').on('change', function () {
    $('input[name = "selected_worker"]').val($(this).attr('data-id'));
  });
  $('.select_worker').on('submit', function (e) {
    if ($('input[name = "select_worker"]:checked').length === 0) {
      e.preventDefault();
    }
  });
  $('#rating').on('input', function () {
    $('#rating_val').text($(this).val());
  });
  $('button[name="delete_proposal"]').on('click', function () {
    $('button[name="form_proposals"]').submit();
  });
  $('button[name="cancel_worker"]').on('click', function () {
    $('input[name="cancel_check"]').val('2');
  });
  $('button[name="ok_worker"]').on('click', function () {
    $('input[name="cancel_check"]').val('1');
  });
  $('#sort_form > button').on('click', function () {
    $('#sort_form').submit();
  });

  if (window.location.href.indexOf('/orders') >= 0 && window.location.href.indexOf('/orders/') < 0) {
    var test = function test() {
      if ($('input[name="prev_filter"]').val().length !== $('#filter').val().length || !$('input[name="prev_filter"]').val().length) {
        $('input[name="prev_filter"]').val($('#filter').val());
        $('.order-title').each(function () {
          if ($(this).text().toLowerCase().indexOf($('#filter').val().toLowerCase()) < 0) {
            $(this).closest('.flex-row').hide();
            $(this).closest('.flex-row').removeClass('d-flex');
          } else {
            $(this).closest('.flex-row').show();
            $(this).closest('.flex-row').addClass('d-flex');
          }
        });
      }
    };

    test();
    $('#filter').on('keyup keydown', test);
  }

  $("#type").on("change", function () {
    var item = $(this).children("option:selected"),
        input = $('input[name="categories"]');
    input.val(input.val() + item.val() + '|');
    $(this).val(1);
    item.hide();
    $("#themes_block").append("<span class='badge badge-pill badge-primary m-1 p-1' class='theme_badge' id='" + item.val() + "'>" + item.text() + " <span class='theme_remove pointer'>&times;</span></span>");
  });
  $("#themes_block").on("click", ".theme_remove", function () {
    var item = $("#themes_block").find($(this).parent()),
        input = $('input[name="categories"]');
    input.val(input.val().replace(item.attr('id') + '|', ''));
    $("#type").find("option[value='" + item.attr("id") + "']").show();
    item.remove();
  });
  $('.add-review').on('click', function () {
    $(this).hide();
  });
});

/***/ }),

/***/ 1:
/*!*************************************!*\
  !*** multi ./resources/js/front.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\OSPanel\domains\freelance\resources\js\front.js */"./resources/js/front.js");


/***/ })

/******/ });