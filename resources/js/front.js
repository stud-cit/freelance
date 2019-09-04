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
    /*
    $('#new_order-toggle').on('click', function () {
        let style = $('#new-order').css('display');

        if (style == 'none') {
            $('#new-order').show();
        } else {
            $('#new-order').hide();
        }
    });*/
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
        test();
        $('#filter').on('keyup keydown', test);

        function test() {
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
        }
    }

    $("#type").on("change", function() {
        let item = $(this).children("option:selected"),
            input = $('input[name="categories"]');

        input.val(input.val() + item.val() + '|');

        $(this).val(1);
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

    $('.add-review').on('click', function () {
       $(this).hide();
    });
});
