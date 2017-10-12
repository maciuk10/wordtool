$.expr[":"].contains = $.expr.createPseudo(function (arg) {
    return function(elem){
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    }
});

var asyncRequest = function (url, type, data, async, beforeSend_callback, success_callback) {
    $.ajax({
        url: url,
        type: type,
        data: data,
        async: async,
        beforeSend: beforeSend_callback,
        success: success_callback
    });
};

$(document).on('click', '.already', function(){
    asyncRequest('./server/templates/login.html', 'POST', {}, true, function(){}, function (data) {
        $('.login-loading').fadeIn("slow");
        $('.register-photo').fadeOut("slow");
        $('.login-loading').fadeOut("slow");
        $('.login-container').fadeOut(0).delay(500).html(data).fadeIn("slow");
    });
});

$(document).on('click', '.jump-to-register', function () {
    asyncRequest('./server/templates/register.html', 'POST', {}, true, function(){}, function (data) {
        $('.login-loading').fadeIn("slow");
        $('.login-dark').fadeOut("slow");
        $('.login-loading').fadeOut("slow");
        $('.login-container').fadeOut(0).delay(500).html(data).fadeIn("slow");
    });
});

$(document).on('submit', 'form.register-form', function (event) {
    var data = $(this).serializeArray();
    console.log(data);
    $(data).each(function (iterator, field) {
        if (field.value == ""){
            $('input[name='+field.name+']').addClass('error-form');
        }else {
            if($('input[name='+field.name+']').hasClass('error-form')){
                $('input[name='+field.name+']').removeClass('error-form');
            }
        }
    });

    if(!($('input[name=password]').val() === $('input[name=password-repeat]').val())){
        $('input[name=password]').addClass('error-form');
        $('input[name=password-repeat]').addClass('error-form');
    }

    if(!($('.agree').is(':checked'))){
        $('.agree-label').addClass('error-form');
    }

    if($('.agree').is(':checked')){
        $('.agree-label').removeClass('error-form');
    }

    if($(".error-form").length == 0){
        console.log('Everything is OK');
        asyncRequest($(this).attr('action'),$(this).attr('method'), {data: JSON.stringify(data)}, true, function () {
            $('.login-container').fadeOut("slow");
            $('.signup-loading').delay(500).fadeIn("slow");
        }, function (msg) {
            try {
                msg = JSON.parse(msg);
                $('.signup-loading .content p').html(msg[0].info);
                $('.signup-loading').delay(1000).fadeOut("slow");
                if(msg[0].returnCode.substr(0,1) == 'E'){
                    $('.login-container').delay(1500).fadeIn("slow");
                }else {
                    $('.welcome-container').delay(2000).fadeIn("slow");
                }
            }catch (jsonParseException) {
                console.log(jsonParseException.message);
            }
            $('input').val("");
        });
        $('input:-webkit-autofill').each(function(){
            var text = $(this).val();
            var name = $(this).attr('name');
            $(this).after(this.outerHTML).remove();
            $('input[name=' + name + ']').val(text);
        });
    }
    event.preventDefault();
});

$(document).ready(function () {


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
});
