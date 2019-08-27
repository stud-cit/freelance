$("document").ready(function(){

    $(".alert").delay(3000).slideUp();

    //$("#avatar-input-label").text($("#avatar-input").val());
    $("#avatar-input").on("change", function() {
        $("#avatar-input-label").text($(this).val().split("\\").pop());
    });

    $(".to-profile").on('click', function () {
        window.location.href = '/profile/' + $(this).attr('data-id');
    });

    $(".work-order").on('click', function () {
        window.location.href = '/orders/' + $(this).attr('data-id');
    });

    $('#propose-toggle').on('click', function () {
        let style = $('#prop').css('display');

        if(style == 'none') {
            $('#prop').show();
        }
        else {
            $('#prop').hide();
        }
    });

    $('#new_order-toggle').on('click', function () {
        let style = $('#new-order').css('display');

        if(style == 'none') {
            $('#new-order').show();
        }
        else {
            $('#new-order').hide();
        }
    });
    $('#reset_order-toggle').on('click', function () {
        let style = $('#reset-order').css('display');

        if(style == 'none') {
            $('#reset-order').show();
        }
        else {
            $('#reset-order').hide();
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
        $('#rating_val').text($(this).val())
    });

    $('button[name="delete_proposal"]').on('click', function () {
        $('input[name="delete_check"]').val('1');
    });
});
