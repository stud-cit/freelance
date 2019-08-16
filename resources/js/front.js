$("document").ready(function(){

    $(".alert").delay(3000).slideUp();

    //$("#avatar-input-label").text($("#avatar-input").val());
    $("#avatar-input").on("change", function() {
        $("#avatar-input-label").text($(this).val().split("\\").pop());
    })
});
