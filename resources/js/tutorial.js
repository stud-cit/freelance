$("document").ready(function() {
    $('.tutorial-logo').animate({
        opacity: 1,
        top: "+=530px",
    }, 1000, function() {
        $('.tutorial-logo').animate({
                top: "-=30px",
            }, 1000);

        $('.tutorial-bg-image').animate({
            opacity: 1
        }, 1000);

        $('.scroll-down').animate({
            opacity: 1
        }, 1000);
    });

    let counter = 0;

    $('.tutorial-layout').bind('mousewheel', function(e) {
        e.preventDefault();

        if (e.originalEvent.wheelDelta / 120 <= 0 && counter < 1) {
            $('.tutorial-bg-image').animate({
                opacity: 0
            }, 1500);

            $('.tutorial-logo').animate({
                top: "-150%",
            }, 1500, function () {
            });

            $('.dots').animate({
                'max-height': '500px'
            }, 500, function (){
                $('.scroll-down').animate({
                    top: "-=40vh",
                }, 1500, function(){
                    $('.tutorial-layout').hide();
                    $('#tutorial_main').show(1000);
                });
            });

            counter = 1;
        }
    });

    let counter2 = 0;

    $('#tutorial_main').bind('mousewheel', function (e) {
        e.preventDefault();
        if(counter2 !=1) {
            counter2 = 1;

            if (e.originalEvent.wheelDelta / 120 <= 0) {
                let curentEl = $('.tutorial-item.active');
                let nextEl = curentEl.next();

                if (nextEl && nextEl.hasClass('tutorial-item')) {
                    curentEl.removeClass('active');
                    nextEl.addClass('active');
                    nextEl.find('.num').addClass('active');
                    console.log(curentEl.height());
                    $('#tutorial_main').scrollTop(nextEl.position().top);
                }
                setTimeout(() => {
                    counter2 = 0;

                }, 500);


            }
            else {
                let curentEl = $('.tutorial-item.active');
                let prevEl = curentEl.prev();

                if (prevEl && prevEl.hasClass('tutorial-item')) {
                    curentEl.removeClass('active');
                    prevEl.addClass('active');
                    prevEl.find('.num').addClass('active');
                    $('#tutorial_main').scrollTop(prevEl.position().top);
                }
                setTimeout(() => {
                    counter2 = 0;

                }, 500);
            }
        }
    });

    // $('.tutorial-item').on('click', function () {
    //     let curentStep = $(this).find('.num').text();
    //
    //     $('.tutorial-item .num').each(function( index, value ) {
    //         if(!value.classList.contains('active') && value.innerHTML < curentStep){
    //             value.classList.add('active');
    //         }
    //     });
    //
    //     $('.tutorial-item.active').removeClass('active');
    //     $(this).addClass('active');
    //     $(this).find('.num').addClass('active');
    // })
});
