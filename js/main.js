$.expr[":"].contains = $.expr.createPseudo(function (arg) {
    return function(elem){
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    }
});


$(document).ready(function () {
    var loginWidth = $('.login-container').width();
    if (loginWidth >= 940){
      console.log('Jestem');
      $('.login-container').addClass('login-middle');
    }else {
      $('.login-container').removeClass('login-middle');
    }

    $('form.register-form').on('submit', function (event) {
        var data = $(this).serializeArray();
        $(data).each(function (iterator, field) {
           if (field.value == ""){
               $('#'+field.name).addClass('error-form');
           }else {
               if($('#'+field.name).hasClass('error-form')){
                   $('#'+field.name).removeClass('error-form');
               }
           }
        });

        if($(".error-form").length == 0){
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: {
                    data: JSON.stringify(data)
                },
                beforeSend: function () {
                    $('.login-container').fadeOut("slow");
                    $('.signup-loading').delay(500).fadeIn("slow");
                },
                success: function (msg) {
                    $('.signup-loading .content p').html(msg);
                    $('.signup-loading').delay(1000).fadeOut("slow");
                    $('.login-container').delay(1500).fadeIn("slow");
                    $('input').val("");
                }
            });
        }
        event.preventDefault();
    });


    $('.contact-form').on('submit', function (event) {
        var firstname = $('.firstname').val();
        var lastname = $('.lastname').val();
        var email = $('.email').val();
        var message = $('.msg-textarea').val();

        console.log(message);

        if(firstname == ""){
            $('.firstname').addClass('error-form');
        }else if ($('.firstname').hasClass('error-form')){
            $('.firstname').removeClass('error-form');
        }
        if(lastname == ""){
            $('.lastname').addClass('error-form');
        }else if ($('.lastname').hasClass('error-form')){
            $('.lastname').removeClass('error-form');
        }
        if(email == ""){
            $('.email').addClass('error-form');
        }else if ($('.email').hasClass('error-form')){
            $('.email').removeClass('error-form');
        }
        if(message == ""){
            $('.msg-textarea').addClass('error-form');
        }else if ($('.msg-textarea').hasClass('error-form')){
            $('.msg-textarea').removeClass('error-form');
        }

        if($('.error-form').length == 0){
            $.ajax({
                url: "server/email/send.php",
                type: "POST",
                data: {
                    firstname: firstname,
                    lastname: lastname,
                    email: email,
                    message: message
                },
                beforeSend: function () {
                    $('html, body').animate({
                        scrollTop: $('#contact').offset().top
                    },1000);
                    $('.contact-container').fadeOut("slow");
                    $('.form-loading').delay(500).fadeIn("slow");
                },
                success: function (msg) {
                    $('.form-loading').fadeOut("slow");
                    $('.contact-container').delay(500).fadeIn("slow");
                    $('.done-well').fadeIn("slow").delay(5000).fadeOut("slow");
                    $('.firstname').val("");
                    $('.lastname').val("");
                    $('.email').val("");
                    $('.msg-textarea').val("");
                }
            });
        }
        event.preventDefault();
    });

    $('.navbar-brand-logo').on('click', function (event) {
        $(location).attr('href', 'http://localhost/wordtool');
    });

    $('.login-btn').on('click', function (event) {
        event.preventDefault();
        $('.login-loading').fadeIn("slow");
        $('.welcome-container').fadeOut("slow");
        $('.down-arrow').fadeOut("slow");
        $('.login-container').delay(1000).fadeIn("slow");
        $('.login-loading').fadeOut("slow");
    });

    $('a[href^="#"]').on('click', function (event) {
        var target = $($(this).attr('href'));
        if(!($(this).hasClass('slide'))){
            if(target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                },1000);
            }
        }
    });
    var $slider = $('.books_slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: true,
        infinite: true,
        cssEase: 'linear',
        adaptiveHeight: true,
        centerMode: false,
        centerPadding: "0px",
        responsive: [
            {
                breakpoint: 1052,
                settings : {
                    arrows: true,
                    centerMode: false,
                    centerPadding: "0px",
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 620,
                settings : {
                    arrows: false,
                    centerMode: true,
                    centerPadding: "0px",
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 240,
                settings : {
                    arrows: false,
                    centerMode: true,
                    centerPadding: "0px",
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.input-custom').on('keyup', function () {
        var filter = $(this).val().toUpperCase();
        $slider.slick('slickUnfilter');
        $slider.slick('slickFilter', ':contains('+filter+')');
        if($('.book_item').length == 0){
            $('p.n-to-s').html("Niestety nie posiadamy książki której szukasz :(");
        }else {
            $('p.n-to-s').html("");
        }
    });

    $('.nav-search').on('keyup', function () {
        $('.input-custom').val($(this).val());
        var filter = $(this).val().toUpperCase();
        $slider.slick('slickUnfilter');
        $slider.slick('slickFilter', ':contains('+filter+')');
        if($('.book_item').length == 0){
            $('p.n-to-s').html("Niestety nie posiadamy książki której szukasz :(");
        }else {
            $('p.n-to-s').html("");
        }
    });


    if($('.success').length !== 0){
        var target = $('#donate');
        if(target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top
            },1000);
        }
    }

    $('.navbar-brand-logo').on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        },1000);
    });


    $(window).load(function () {
        $('.loading').fadeOut("slow");
    });
    $(window).resize(function () {
      var loginWidth = $('.login-container').width();
      if (loginWidth >= 940){
        console.log('Jestem');
        $('.login-container').addClass('login-middle');
      }else {
        $('.login-container').removeClass('login-middle');
      }
    });
});
