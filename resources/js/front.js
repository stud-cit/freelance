$("document").ready(function() {
    const Swal = require('sweetalert2');

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

    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }
    });

    update_listeners();

    $(".to-profile").on('click', function () {
        window.location.href = '/profile/' + $(this).attr('data-id');
    });

    $('.to-edit').on('click', function () {
        window.location.href = '/profile';
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

            Swal.fire({
                title: 'Видалення',
                text: "Ви впевнені, що хочете це зробити?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaaaaa',
                confirmButtonText: 'Видалити',
                cancelButtonText: 'Скасувати'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        method: 'post',
                        url: '/delete_proposal',
                        data: {'location': window.location.href},
                        success: function () {
                            document.location.reload(true);
                        }
                    });
                }
            });
        }
    });

    $('#finish_order').on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Завершення',
            text: "Завершити замовлення?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaaaaa',
            confirmButtonText: 'Завершити',
            cancelButtonText: 'Скасувати'
        }).then((result) => {
            if (result.value) {
                $(this).closest('form').submit();
            }
        });
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

        $(this).closest('.for-filter').find('.categories_tag').removeClass('selected-category');
        $(this).addClass('selected-category');

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

    function ajax_filter(page) {
        let data = {
            'what': $('.sort-selected').attr('id') === 'date-btn' ? 'id_order' : 'price',
            'how': $('.sort-selected span').text() === 'v' ? 'desc' : 'asc',
            'filter': $('#filter').val(),
            'category': parseInt($('#categs .selected-category').attr('data-id')),
            'page': isNaN(page) ? 1 : page,
            'dept': parseInt($('#depts .selected-category').attr('data-id')),
        };

        $.ajax({
            method: 'post',
            url: '/filter',
            data: data,
            success: function (response) {
                $('#orders-list').remove();
                $('#orders-block').append(response);

                let drop = $('#drop-filter');

                if ($('.orders').length) {
                    drop.removeClass('d-none');
                    drop.addClass('d-flex');
                }
                else {
                    drop.removeClass('d-flex');
                    drop.addClass('d-none');
                }

                update_listeners();
            }
        });
    }

    function update_listeners() {
        $('#pagination').off('click');
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

        $('.work-order').off('click');
        $(".work-order").on('click', function () {
            window.location.href = '/orders/' + $(this).attr('data-id');
        });
    };

    $('#add-files').on('change', function () {
        if ($(this).prop('files').length > 3) {
            Swal.fire({
                icon: 'error',
                title: 'Помилка',
                text: 'Додати можна не більш 3 файлів'
            });

            $(this).val('');
        }

        let size = 0;

        $.each($(this).prop('files'), function () {
            size += $(this)[0].size;
        });

        if (size > 20971520) {
            Swal.fire({
                icon: 'error',
                title: 'Помилка',
                text: 'Розмір файлів не має перевищувати 20мб'
            });

            $(this).val('');
        }
    });

    $(".toggle-box").on('click', '.toggle-plus', function () {
        let counter = parseInt($(this).closest('.container').attr('data-id')) + 1;
        let name = 'new-' + $(this).closest('.container').attr('id');
        let str = "<div class='form-row input-group'><input type='text' class='form-control col-10 bg-deep-dark text-white' name='"+name+"-"+counter+"'><input type='button' class='btn-outline-danger form-control col-1 toggle-minus bg-deep-dark text-white' value='-'></div>";

        $(this).closest('.container').attr('data-id', counter);
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
        }
        else {
            $("#dept-block").removeClass('d-flex').addClass('d-none');
        }
    }

    $('#message_input').on('keypress', function (e) {
        if(e.which == 13) {
            e.preventDefault();

            $('#chat-form').submit();
        }
    });

    $('#chat-form').on('submit', function(e) {
        e.preventDefault();

        let text = $('#message_input').val();

        if (text !== "") {
            $('#message_input').val('');

            $.ajax({
                url: '/chat',
                method: 'post',
                data: {
                    'text': text,
                    'id_to': $('.open-contact').attr('data-id'),
                },
                success: function (data) {
                    update_chat(data);
                    update_contact($('.open-contact'));
                }
            });
        }
    });

    $('#file_input').on('change', function () {
        if ($(this).prop('files')[0].size <= 5242880) {
            let data = new FormData(),
                file = $(this).prop('files')[0];

            data.append('file', file);
            data.append('name', file.name);
            data.append('id_to', $('.open-contact').attr('data-id'));

            $.ajax({
                url: '/send_file',
                method: 'post',
                data: data,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Помилка',
                            text: 'Виникла помилка при збереженні файлу'
                        });
                    }
                    else {
                        update_chat(res);
                        update_contact($('.open-contact'));
                    }
                }
            });
        }
        else {
            Swal.fire({
                icon: 'error',
                title: 'Помилка',
                text: 'Розмір файлів не має перевищувати 5мб'
            });
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
                    'id': $(this).attr('data-id'),
                },
                success: function (data) {
                    update_chat(data);
                }
            });
        }
    });

    $('.app-event').on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            text: "Ви впевнені, що хочете це зробити?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaaaaa',
            confirmButtonText: 'Так',
            cancelButtonText: 'Ні'
        }).then((result) => {
            if (result.value) {
                $(this).closest('form').submit();
            }
        });
    });

    $('#messages-list').on('click', '.this-is-file', function () {
        $('#get-file-form input[name="id"]').val($(this).attr('data-id'));
        $('#get-file-form input[name="name"]').val($(this).find('span:first').text());

        $('#get-file-form').submit();
    });

    if (window.location.href.indexOf('/chat') >= 0) {
        setTimeout(() => {
            check_messages()
        }, 4000);
    }

    if ($('#routes').length) {
        setTimeout(() => {
            check_header()
        }, 4000);
    }

    $('#file_selector').on('click', function(e) {
        e.preventDefault();

        $('#file_input').trigger('click');
    });

    function check_header() {
        $.ajax({
            url: '/check_header',
            method: 'post',
            success: function (count) {
                if (count != 0) {
                    $('.header-count').removeClass('d-none');
                    $('.header-count').text(count);
                }
                else {
                    $('.header-count').addClass('d-none');
                }
            }
        });

        setTimeout(() => {
            check_header()
        }, 4000);
    }

    function check_messages() {
        let elems = $('.messages-count:not(.d-none)'),
            data = [];

        elems.each(function() {
            let id = $(this).closest('.contact').attr('data-id');

            data[id] = $(this).text();
        });

        $.ajax({
            url: '/check_messages',
            method: 'post',
            data: {
                'id': $('.open-contact').attr('data-id'),
                'data': data
            },
            success: function (data) {
                if ('data' in data) {
                    $.each(data['data'], function (key, count) {
                        const user = $('.contact[data-id="' + key + '"]'),
                            span = user.find('.messages-count');

                        span.removeClass('d-none');
                        span.text('(' + count + ')');

                        update_contact(user);
                    });
                }

                if ('messages' in data) {
                    update_chat(data['messages']);
                }
            }
        });

        setTimeout(() => {
            check_messages()
        }, 4000);
    }

    function update_contact(user) {
        const contact = user;

        user.remove();

        $('#contacts-list').prepend(contact);
    }

    function update_chat(data) {
        let new_chat = '';

        for (let i = 0; i < data.length; i++) {
            new_chat += `<div class="flex-row"><div class="`
                + ($('#my_id').attr('data-id') == data[i]['id_from'] ? 'float-left' : 'float-right')
                + (data[i]['file'] ? ' bg-green this-is-file pointer' : ' bg-light') + ` m-2 p-2  min-width-25 rounded" data-id="`
                + data[i]['id_message'] + `"><span title="`
                + data[i]['created_at'] + `">`
                + data[i]['text'] + `</span><br><span class="float-right font-italic">`
                + data[i]['time'] + `</span></div></div>`;
        }

        $('#messages-list div').remove();
        $('#messages-list').append(new_chat);
    }


    $("#dept_type").on("change", function() {
        let item = $(this).children("option:selected").attr("id"),
            input = $('input[name="id_dept"]');

        $(".depts").hide();
        $("#dept-block ."+item).show();

    });

});
