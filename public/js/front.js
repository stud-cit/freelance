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
  $(".orders").on('click', ".work-order", function () {
    window.location.href = '/orders/' + $(this).attr('data-id');
  });
  /*
      $('.propose-toggle').on('click', function () {
          let style = $('#prop').css('display');
  
          if (style == 'none') {
              $('#prop').show();
          } else {
              $('#prop').hide();
          }
      });
  */

  $('#new_order-toggle').on('click', function () {
    $(this).find('.order_circle').css('transition', 'transform 0.1s linear').css('transform', $('#new-order').css('display') == 'none' ? 'rotate(360deg)' : 'rotate(0deg)').text($('#new-order').css('display') == 'none' ? '-' : '+');
  });
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
  $("#type").on("change", function () {
    var item = $(this).children("option:selected"),
        input = $('input[name="categories"]');
    input.val(input.val() + item.val() + '|');
    $(this).val(0);
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

  if (window.location.href.indexOf('/profile') >= 0 && window.location.href.indexOf('/profile/') < 0 || window.location.href.indexOf('/orders') >= 0 && $("#themes_block").length) {
    var input = $('input[name="categories"]'),
        str = input.val().split("|");
    input.val("");

    for (var i = 0; i < str.length - 1; i++) {
      $("#type").val(str[i]).trigger("change");
    }

    $("#type").val(0);
  }

  $('.add-review').on('click', function () {
    $(this).hide();
  });
  $('.sort-btn').on('click', function () {
    var temp = $(this).find('span').text();
    $(this).parent().find('span').text('');
    $(this).find('span').text(temp === 'v' ? '^' : 'v');
    var data = {
      'what': $(this).attr('id') === 'date-btn' ? 'id_order' : 'price',
      'how': temp === 'v' ? 'asc' : 'desc',
      'ids': get_array_orders()
    };
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: 'post',
      url: '/sort_order',
      data: data,
      success: function success(response) {
        refresh_orders(response);
      }
    });
  });
  $('.categories_tag').on('click', function (e) {
    e.preventDefault();
    $('#date-btn').find('span').text('v');
    $('#price-btn').find('span').text('');
    $('#filter').val('');
    $('.categories_tag').removeClass('font-weight-bold');
    $(this).addClass('font-weight-bold');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: 'post',
      url: '/select_category',
      data: {
        'category': $(this).attr('data-id')
      },
      success: function success(response) {
        refresh_orders(response);
      }
    });
  });
  $('#filter').on('keyup keydown', function () {
    $('.order-title').each(function () {
      if ($(this).text().toLowerCase().indexOf($('#filter').val().toLowerCase()) < 0) {
        $(this).closest('.flex-row').hide();
        $(this).closest('.flex-row').removeClass('d-flex');
      } else {
        $(this).closest('.flex-row').show();
        $(this).closest('.flex-row').addClass('d-flex');
      }
    });
  });

  function get_array_orders() {
    var ids = [];
    $('.work-order').each(function () {
      ids.push($(this).attr('data-id'));
    });
    return ids;
  }

  function refresh_orders(array) {
    $('.work-order').closest('.flex-row').remove();

    for (var _i = 0; _i < array.length; _i++) {
      var order = "<div class=\"flex-row mb-3 mt-2 d-flex\">\n                        <div class=\"col-10 shadow bg-white work-order pointer\" data-id=\"" + array[_i]['id_order'] + "\">\n                            <div class=\"font-weight-bold mt-2 order-title\">" + array[_i]['title'] + "</div>\n                            <div class=\"tag-list\">";

      for (var j = 0; j < array[_i]['categories'].length; j++) {
        order += "<span class=\"tags font-italic font-size-10\">" + array[_i]['categories'][j]['name'] + "</span>&nbsp;";
      }

      order += "</div>\n                        <div>" + array[_i]['description'] + "</div>\n                        <div class=\"text-right font-size-10\">" + array[_i]['created_at'] + "</div>\n                    </div>\n                    <div class=\"col c_rounded-right mt-3 bg-green text-white px-0 align-self-end\" style=\"height: 54px; !important;\">\n                        <div class=\"text-center font-weight-bold mt-1\">" + array[_i]['price'] + "</div>\n                        <div class=\"text-right font-italic font-size-10 mt-2 pr-2\">" + array[_i]['time'] + "</div>\n                    </div>\n                </div>";
      $('#orders-list').append(order);
    }
  }
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