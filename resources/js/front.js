$("document").ready(function() {
    $(".alert").delay(3000).slideUp();

    $(window).scroll(function() {
        var $height = $(window).scrollTop();
        if($height > 150) {
            $('#anchor').addClass('d-flex').show();
        } else {
            $('#anchor').removeClass('d-flex').hide();
        }
    });

    $("#anchor").on("click", function () {
        $("html").animate({ scrollTop: 0 }, 300);
    });

    $("#avatar-input").on("change", function () {
        if($(this)[0].files[0].size > 2097152) {
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
        $(this).find('.order_circle').css('transition', 'transform 0.1s linear').css('transform', $('#new-order').css('display') == 'none' ? 'rotate(360deg)' : 'rotate(0deg)').text($('#new-order').css('display') == 'none' ? '-' : '+')
    });

    $('#reset_order-toggle').on('click', function () {
        let style = $('#reset-order').css('display');

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
            if(confirm('Ви впевнені?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    url: '/delete_proposal',
                    data: {'location': window.location.href},
                    success: function (response) {
                        document.location.reload(true);
                    }
                });
            }
        }
    });

    $("#type").on("change", function() {
        let item = $(this).children("option:selected"),
            input = $('input[name="categories"]');

        input.val(input.val() + item.val() + '|');

        $(this).val(0);
        item.hide();

        $("#themes_block").append("<span class='badge badge-pill badge-primary m-1 p-1' class='theme_badge' id='"+item.val()+"'>"+item.text()+" <span class='theme_remove pointer'>&times;</span></span>");
    });

    $("#themes_block").on("click", ".theme_remove", function () {
        let item = $("#themes_block").find($(this).parent()),
            input = $('input[name="categories"]');

        input.val(input.val().replace(item.attr('id') + '|', ''));

        $("#type").find("option[value='"+item.attr("id")+"']").show();

        item.remove();
    });

    if (window.location.href.indexOf('/profile') >= 0 && window.location.href.indexOf('/profile/') < 0 || window.location.href.indexOf('/orders') >= 0 && $("#themes_block").length) {
        theme_badges_build();
    }

    function theme_badges_build() {
        $("#themes_block").empty();

        let input = $('input[name="categories"]'),
            str = input.val().split("|");

        input.val("");

        for (let i = 0; i < str.length - 1; i++) {
            $("#type").val(str[i]).trigger("change");
        }

        $("#type").val(0);
    }

    $('.add-review').on('click', function () {
       $(this).hide();
    });

    $('.sort-btn').on('click', function () {
        let temp = $(this).find('span').text();

        $(this).parent().find('button').removeClass('sort-selected');
        $(this).addClass('sort-selected');
        $(this).parent().find('span').text('');
        $(this).find('span').text(temp === 'v' ? '^' : 'v');

        ajax_filter(parseInt($('.pagination-selected').text()));
    });

    $('.categories_tag').on('click', function (e) {
        e.preventDefault();

        $('.categories_tag').removeClass('font-weight-bold');
        $(this).addClass('font-weight-bold');

        ajax_filter(parseInt($('.pagination-selected').text()));
    });

    let time;

    $('#filter').on('keyup', function () {
        clearTimeout(time);

        if ($(this).val() === "") {
            ajax_filter(parseInt($('.pagination-selected').text()));
        }
        else {
            time = setTimeout(() => {
                ajax_filter(parseInt($('.pagination-selected').text()));
            }, 1000);
        }
    });

    $('#pagination').on('click', 'button', function() {
        let page = $(this).text(),
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
        let data = {
            'what': $('.sort-selected').attr('id') === 'date-btn' ? 'id_order' : 'price',
            'how': $('.sort-selected span').text() === 'v' ? 'desc' : 'asc',
            'filter': $('#filter').val(),
            'category': parseInt($('.categ .font-weight-bold').attr('data-id')),
            'page': isNaN(page) ? 1 : page
        };

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            url: '/filter',
            data: data,
            success: function (response) {
                refresh_orders(response);
            }
        });
    }

    function refresh_orders(response) {
        let array = response['array'],
            count = response['count'],
            page = parseInt($('.pagination-selected').text());
        page = isNaN(page) ? 1 : page;

        $('#pagination').empty();
        $('.orders .flex-row').remove();
        $('#drop-filter').removeClass('d-none');

        if (array.length) {
            for (let i = 0; i < array.length; i++) {
                let order = `<div class="flex-row mb-3 mt-2 d-flex">
                        <div class="col-10 shadow bg-white work-order pointer" data-id="` + array[i]['id_order'] + `">
                            <div class="font-weight-bold mt-2 order-title">` + array[i]['title'] + `</div>
                            <div class="tag-list">`;

                for (let j = 0; j < array[i]['categories'].length; j++) {
                    order += `<span class="tags font-italic font-size-10">` + array[i]['categories'][j]['name'] + `</span>&nbsp;`;
                }

                order += `</div>
                        <div>` + array[i]['description'] + `</div>
                        <div class="text-right font-size-10">` + array[i]['created_at'] + `</div>
                    </div>
                    <div class="col c_rounded-right mt-3 bg-green text-white px-0 align-self-end" style="height: 54px; !important;">
                        <div class="text-center font-weight-bold mt-1">` + array[i]['price'] + `</div>
                        <div class="text-right font-italic font-size-10 mt-2 pr-2">` + array[i]['time'] + `</div>
                    </div>
                </div>`;

                $('#orders-list').append(order);
            }

            if (page > Math.ceil(count / 10)) {
                page = parseInt($('.pagination-num:last').text());
            }

            let pagination = `<button class="btn btn-outline-p"` + (page === 1 ? 'disabled' : '') + `><<</button>&nbsp;
                            <button class="btn btn-outline-p" ` + (page === 1 ? 'disabled' : '') + `><</button>&nbsp;`;

            for (let i = 1; i <= Math.ceil(count / 10); i++) {
                pagination += `<button class="pagination-num btn btn-outline-p ` + (page === i ? 'pagination-selected active' : '') + `" id="num-` + i + `">` + i + `</button>&nbsp;`;
            }

            pagination += `<button class="btn btn-outline-p" ` + (page === Math.ceil(count / 10) ? 'disabled' : '') + `>></button>&nbsp;
                        <button class="btn btn-outline-p" ` + (page === Math.ceil(count / 10) ? 'disabled' : '') + `>>></button>`;

            $('#pagination').append(pagination);
            $('#pagination').removeClass('d-flex');
            $('#pagination').removeClass('d-none');
            $('#pagination').addClass(Math.ceil(count / 10) < 2 ? 'd-none' : 'd-flex');
        }
        else {
            $('#drop-filter').addClass('d-none');

            $('#orders-list').append(`<div class="flex-row">
                        <div class="col font-weight-bold font-size-18 text-center mt-4">Немає замовленнь з такими параметрами</div>
                    </div>`);
        }
    }

    $.ajaxSetup({
        beforeSend: function () {
            $("#load").modal({
                backdrop: "static",
                keyboard: false,
                show: true
            });
        },
        complete: function() {
            $("#load").modal("hide");
        }
    });

    $(".toggle-box").on('click', '.toggle-plus', function () {
        var counter = 0; // id of elem
        var name = $(this).closest('.container').attr('id');
        var str = "<div class='form-row input-group'><input type='text' class='form-control col-10' id='"+name+"-"+counter+"'><input type='button' class='btn-outline-danger form-control col-1 toggle-minus' value='-'></div>";
        $(this).closest('.toggle-box').append(str);
    });
    $(".toggle-box").on('click', '.toggle-minus', function () {
        $(this).closest('.form-row').remove();
    })
});
