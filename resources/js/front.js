$("document").ready(function() {
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

    $('.propose-toggle').on('click', function () {
        let style = $('#prop').css('display');

        if (style == 'none') {
            $('#prop').show();
        } else {
            $('#prop').hide();
        }
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
        let pass = $("input[name = 'new_password']"),
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

        $(this).parent().find('span').text('');
        $(this).find('span').text(temp === 'v' ? '^' : 'v');

        let data = {
            'what': $(this).attr('id') === 'date-btn' ? 'id_order' : 'price',
            'how': temp === 'v' ? 'asc' : 'desc',
            'ids': get_array_orders(),
        };

        $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            url: '/sort_order',
            data: data,
            success: function (response) {
                refresh_orders(response);
            },
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
            data: {'category': $(this).attr('data-id')},
            success: function (response) {
                refresh_orders(response);
            },
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
        let ids = [];

        $('.work-order').each(function () {
            ids.push($(this).attr('data-id'));
        });

        return ids;
    }

    function refresh_orders(array) {
        $('.work-order').closest('.flex-row').remove();

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
    }
});
