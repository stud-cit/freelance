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
  $(window).scroll(function () {
    var $height = $(window).scrollTop();

    if ($height > 150) {
      $('#anchor').addClass('d-flex').show();
    } else {
      $('#anchor').removeClass('d-flex').hide();
    }
  });
  $("#anchor").on("click", function () {
    $("html").animate({
      scrollTop: 0
    }, 300);
  });
  $("#avatar-input").on("change", function () {
    if ($(this)[0].files[0].size > 2097152) {
      $(this).val("").addClass('is-invalid');
      return;
    }

    $(this).removeClass('is-invalid');
    $("#avatar-input-label").text($(this).val().split("\\").pop());
  });
  $(".to-profile").on('click', function () {
    window.location.href = '/profile/' + $(this).attr('data-id');
  });
  $(".orders").on('click', ".work-order", function () {
    window.location.href = '/orders/' + $(this).attr('data-id');
  });
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
  $(".badges_reset").on('click', function (e) {
    e.preventDefault();
    $(this).closest('form').get(0).reset();
    theme_badges_build();
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
  $('#rating').on('input', function () {
    $('#rating_val').text($(this).val());
  });
  $('button[name="delete_proposal"]').on('click', function (e) {
    if ($(this).attr('type') !== 'reset') {
      e.preventDefault();

      if (confirm('Ви впевнені?')) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: 'post',
          url: '/delete_proposal',
          data: {
            'location': window.location.href
          },
          success: function success(response) {
            document.location.reload(true);
          }
        });
      }
    }
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
    theme_badges_build();
  }

  function theme_badges_build() {
    $("#themes_block").empty();
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
    $(this).parent().find('button').removeClass('sort-selected');
    $(this).addClass('sort-selected');
    $(this).parent().find('span').text('');
    $(this).find('span').text(temp === 'v' ? '^' : 'v');
    ajax_filter(parseInt($('.pagination-selected').text()));
  });
  $('.categories_tag').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.card-body').find('.categories_tag').removeClass('font-weight-bold');
    $(this).addClass('font-weight-bold');
    ajax_filter(parseInt($('.pagination-selected').text()));
  });
  var time;
  $('#filter').on('keyup', function () {
    clearTimeout(time);

    if ($(this).val() === "") {
      ajax_filter(parseInt($('.pagination-selected').text()));
    } else {
      time = setTimeout(function () {
        ajax_filter(parseInt($('.pagination-selected').text()));
      }, 1000);
    }
  });
  $('#pagination').on('click', 'button', function () {
    var page = $(this).text(),
        prevPage = parseInt($('.pagination-selected').text());

    switch (page) {
      case '<<':
        page = 1;
        break;

      case '<':
        page = parseInt($('.pagination-selected').text()) - 1;
        break;

      case '>':
        page = parseInt($('.pagination-selected').text()) + 1;
        break;

      case '>>':
        page = parseInt($('.pagination-num:last').text());
        break;
    }

    if (!page || page > parseInt($('.pagination-num:last').text()) || prevPage == page) {
      return;
    }

    $('#pagination button').removeClass('pagination-selected');
    $('#num-' + page).addClass('pagination-selected');
    ajax_filter(page);
  });

  function ajax_filter(page) {
    var data = {
      'what': $('.sort-selected').attr('id') === 'date-btn' ? 'id_order' : 'price',
      'how': $('.sort-selected span').text() === 'v' ? 'desc' : 'asc',
      'filter': $('#filter').val(),
      'category': parseInt($('#categs .categ .font-weight-bold').attr('data-id')),
      'page': isNaN(page) ? 1 : page,
      'dept': parseInt($('#depts .categ .font-weight-bold').attr('data-id'))
    };
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: 'post',
      url: '/filter',
      data: data,
      success: function success(response) {
        refresh_orders(response);
      }
    });
  }

  function refresh_orders(response) {
    var array = response['array'],
        count = response['count'],
        page = parseInt($('.pagination-selected').text());
    page = isNaN(page) ? 1 : page;
    $('#pagination').empty();
    $('.orders .flex-row').remove();
    $('#drop-filter').removeClass('d-none');

    if (array.length) {
      for (var i = 0; i < array.length; i++) {
        var order = "<div class=\"flex-row mb-3 mt-2 d-flex\">\n                        <div class=\"col-10 shadow bg-white work-order pointer\" data-id=\"" + array[i]['id_order'] + "\">\n                            <div class=\"font-weight-bold mt-2 order-title\">" + array[i]['title'] + "</div>\n                            <div class=\"tag-list\">";

        for (var j = 0; j < array[i]['categories'].length; j++) {
          order += "<span class=\"tags font-italic font-size-10\">" + array[i]['categories'][j]['name'] + "</span>&nbsp;";
        }

        order += "</div>\n                        <div>" + array[i]['description'] + "</div>";

        if (array[i]['dept'] !== null) {
          order += "<div class=\"text-left float-left font-size-10\">" + array[i]['dept']['name'] + "</div>";
        }

        order += "<div class=\"text-right font-size-10\">" + array[i]['created_at'] + "</div>\n                    </div>\n                    <div class=\"col c_rounded-right mt-3 bg-green text-white px-0 align-self-end\" style=\"height: 54px; !important;\">\n                        <div class=\"text-center font-weight-bold mt-1\">" + array[i]['price'] + "</div>\n                        <div class=\"text-right font-italic font-size-10 mt-2 pr-2\">" + array[i]['time'] + "</div>\n                    </div>\n                </div>";
        $('#orders-list').append(order);
      }

      if (page > Math.ceil(count / 10)) {
        page = parseInt($('.pagination-num:last').text());
      }

      var pagination = "<button class=\"btn btn-outline-p\"" + (page === 1 ? 'disabled' : '') + "><<</button>&nbsp;\n                            <button class=\"btn btn-outline-p\" " + (page === 1 ? 'disabled' : '') + "><</button>&nbsp;";

      for (var _i = 1; _i <= Math.ceil(count / 10); _i++) {
        pagination += "<button class=\"pagination-num btn btn-outline-p " + (page === _i ? 'pagination-selected active' : '') + "\" id=\"num-" + _i + "\">" + _i + "</button>&nbsp;";
      }

      pagination += "<button class=\"btn btn-outline-p\" " + (page === Math.ceil(count / 10) ? 'disabled' : '') + ">></button>&nbsp;\n                        <button class=\"btn btn-outline-p\" " + (page === Math.ceil(count / 10) ? 'disabled' : '') + ">>></button>";
      $('#pagination').append(pagination);
      $('#pagination').removeClass('d-flex');
      $('#pagination').removeClass('d-none');
      $('#pagination').addClass(Math.ceil(count / 10) < 2 ? 'd-none' : 'd-flex');
    } else {
      $('#drop-filter').addClass('d-none');
      $('#orders-list').append("<div class=\"flex-row\">\n                        <div class=\"col font-weight-bold font-size-18 text-center mt-4\">\u041D\u0435\u043C\u0430\u0454 \u0437\u0430\u043C\u043E\u0432\u043B\u0435\u043D\u043D\u044C \u0437 \u0442\u0430\u043A\u0438\u043C\u0438 \u043F\u0430\u0440\u0430\u043C\u0435\u0442\u0440\u0430\u043C\u0438</div>\n                    </div>");
    }
  }

  if (window.location.href.indexOf('/chat') < 0) {
    $.ajaxSetup({
      beforeSend: function beforeSend() {
        $("#load").modal({
          backdrop: "static",
          keyboard: false,
          show: true
        });
      },
      complete: function complete() {
        $("#load").modal("hide");
      }
    });
  }

  $(".toggle-box").on('click', '.toggle-plus', function () {
    var counter = parseInt($('.toggle-box input[type="text"]:last').attr('name').slice(5)) + 1;
    var name = $(this).closest('.container').attr('id');
    var str = "<div class='form-row input-group'><input type='text' class='form-control col-10' name='" + name + "-" + counter + "'><input type='button' class='btn-outline-danger form-control col-1 toggle-minus' value='-'></div>";
    $(this).closest('.toggle-box').append(str);
  });
  $(".toggle-box").on('click', '.toggle-minus', function () {
    $(this).closest('.form-row').remove();
  });

  if (window.location.href.indexOf('/admin') >= 0) {
    dept_block_toggle();
  }

  $("#id_role").on('change', function () {
    dept_block_toggle();
  });

  function dept_block_toggle() {
    if ($("#id_role").val() == "Замовник") {
      $("#dept-block").removeClass('d-none').addClass('d-flex');
    } else {
      $("#dept-block").removeClass('d-flex').addClass('d-none');
    }
  }

  $('#chat-form').on('submit', function (e) {
    e.preventDefault();

    if ($('#message_input').val() !== "") {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/chat',
        method: 'post',
        data: {
          'text': $('#message_input').val(),
          'id_to': $('.open-contact').attr('data-id')
        },
        success: function success(data) {
          update_chat(data);
          update_contact($('.open-contact'));
          $('#message_input').val('');
        }
      });
    }
  });
  $('#file_input').on('change', function () {
    if ($(this).prop('files')[0].size <= 5242880) {
      var data = new FormData(),
          file = $(this).prop('files')[0];
      data.append('file', file);
      data.append('name', file.name);
      data.append('id_to', $('.open-contact').attr('data-id'));
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/send_file',
        method: 'post',
        data: data,
        contentType: false,
        processData: false,
        success: function success(res) {
          update_chat(res);
          update_contact($('.open-contact'));
        }
      });
    } else {
      alert('Файли можуть бути лише менш, ніж 5мб');
    }

    $('#file_input').val('');
  });
  $('#contacts-list').on('click', '.contact', function () {
    if (!$(this).hasClass('open-contact')) {
      $('.open-contact').removeClass('open-contact');
      $(this).addClass('open-contact');
      $('.contact').removeClass('pointer');
      $('.contact:not(.open-contact)').addClass('pointer');
      $(this).find('.messages-count').addClass('d-none');
      $('#chat-form .d-none').removeClass('d-none');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/get_messages',
        method: 'post',
        data: {
          'id': $(this).attr('data-id')
        },
        success: function success(data) {
          update_chat(data);
        }
      });
    }
  });
  $('#messages-list').on('click', '.this-is-file', function () {
    $('#get-file-form input[name="id"]').val($(this).attr('data-id'));
    $('#get-file-form input[name="name"]').val($(this).find('span:first').text());
    $('#get-file-form').submit();
  });

  if (window.location.href.indexOf('/chat') >= 0) {
    setTimeout(function () {
      check_messages();
    }, 4000);
  }

  function check_messages() {
    var elems = $('.messages-count:not(.d-none)'),
        data = [];
    elems.each(function () {
      var id = $(this).closest('.contact').attr('data-id');
      data[id] = $(this).text();
    });
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/check_messages',
      method: 'post',
      data: {
        'id': $('.open-contact').attr('data-id'),
        'data': data
      },
      success: function success(data) {
        if ('data' in data) {
          $.each(data['data'], function (key, count) {
            var user = $('.contact[data-id="' + key + '"]'),
                span = user.find('.messages-count');
            span.removeClass('d-none');
            span.text(count);
            update_contact(user);
          });
        }

        if ('messages' in data) {
          update_chat(data['messages']);
        }
      }
    }).done(function () {
      setTimeout(function () {
        check_messages();
      }, 4000);
    });
  }

  function update_contact(user) {
    var contact = user;
    user.remove();
    $('#contacts-list').prepend(contact);
  }

  function update_chat(data) {
    var new_chat = '';

    for (var i = 0; i < data.length; i++) {
      new_chat += "<div class=\"flex-row\"><div class=\"" + ($('#my_id').attr('data-id') == data[i]['id_from'] ? 'float-left' : 'float-right') + (data[i]['file'] ? ' bg-green this-is-file pointer' : ' bg-light') + " m-2 p-2\" data-id=\"" + data[i]['id_message'] + "\"><span title=\"" + data[i]['created_at'] + "\">" + data[i]['text'] + "</span><span class=\"font-italic\">" + data[i]['time'] + "</span></div></div>";
    }

    $('#messages-list div').remove();
    $('#messages-list').append(new_chat);
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