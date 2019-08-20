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

});
