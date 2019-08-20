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

    $('.pass_change').on('submit', function (e) {
        let pass = $("input[name = 'new_password']"),
            new_pass = $("input[name = 'new_password_confirmation']");

        if (pass.val() !== new_pass.val()) {
            e.preventDefault();
            new_pass.addClass('is-invalid');
        }
    });
});
