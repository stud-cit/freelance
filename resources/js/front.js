$("document").ready(function() {
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

        let ids = [];

        $('.work-order').each(function () {
            ids.push($(this).attr('data-id'));
        });

        let data = {
            'what': $(this).attr('id') === 'date-btn' ? 'id_order' : 'price',
            'how': temp === 'v' ? 'asc' : 'desc',
            'ids': ids,
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

    function refresh_orders(array) {
        let order = `<div class="flex-row mb-3 mt-2 d-flex">
                        <div class="col-10 shadow bg-white work-order pointer" data-id="{{$orders->id_order}}">
                            <div class="font-weight-bold mt-2 order-title">{{$orders->title}}</div>
                            <div class="tag-list">
                                @foreach($orders->categories as $tags)
                                    <span class="tags font-italic font-size-10">{{$tags->name}}</span>
                                @endforeach
                            </div>
                            <div>{{strlen($orders->description) > 50 ? substr($orders->description, 0, 50) . '...' : $orders->description}}</div>
                            <div class="text-right font-size-10">{{$orders->created_at}}</div>
                        </div>
                        <div class="col c_rounded-right mt-3 bg-green text-white px-0 align-self-end" style="height: 54px; !important;">
                            <div class="text-center font-weight-bold mt-1">{{$orders->price}}</div>
                            <div class="text-right font-italic font-size-10 mt-2 pr-2">{{$orders->time}}</div>
                        </div>
                    </div>`;

        $('.work-order').closest('.flex-row').remove();

        array.each(function () {

        });
    }
});
