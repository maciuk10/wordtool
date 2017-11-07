$.expr[":"].contains = $.expr.createPseudo(function (arg) {
    return function(elem){
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    }
});

var getMailDomain = function(mailAdress) {
    var from = mailAdress.indexOf('@')+1;
    var result = "";
    var domain = mailAdress.substring(from);
    switch(domain) {
        case "gmail.com":
            result = "http://www.gmail.com";
            break;
        case "onet.pl":
        case "op.pl":
        case "onet.eu":
        case "poczta.onet.eu":
        case "vp.pl":
        case "buziaczek.pl":
        case "autograf.pl":
        case "poczta.onet.pl":
            result = "http://www.poczta.onet.pl";
            break;
        case "wp.pl":
            result = "http://www.poczta.wp.pl";
            break;
        case "interia.pl":
        case "interia.eu":
        case "intmail.pl":
        case "interia.com":
        case "pisz.to":
        case "ogarnij.se":
        case "poczta.fm":
        case "vip.interia.pl":
        case "interiowy.pl":
        case "pacz.to":
            result = "http://www.poczta.interia.pl";
            break;
        case "outlook.com":
        case "hotmail.com":
            result = "http://www.outlook.com";
            break;
        default: 
            result = -1;
    }
    return result;
};

var calculateComplexity = function (password) {
    var complexity = 0;
    var regExps = [
        /[a-z]/,
        /[A-Z]/,
        /[0-9]/,
        /.{8}/,
        /[!-//:-@[-`{-ÿ]/
    ];
    regExps.forEach(function (regexp) {
        if(regexp.test(password)){
            complexity++;
        }
    });

    return {
        value: complexity,
        max: regExps.length
    }
};

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

$(document).on('keyup', '.pass-log', function(){
    var progress = $('.pc-log');
    var complexity = calculateComplexity($('.pass-log').val());
    progress.val(complexity.value);
    progress.attr('max', complexity.max);
});

$(document).on('keyup', '.pass-reg', function(){
    var progress = $('.pc-reg');
    var complexity = calculateComplexity($('.pass-reg').val());
    progress.val(complexity.value);
    progress.attr('max', complexity.max);
});

$(document).on('click', '.logout', function(){
    asyncRequest(
        "./server/login/logout.php",
        "POST",
        {},
        true,
        function(){},
        function(msg){
            try {
                window.location.replace(msg);
            }catch (locationException){
                console.log(locationException.message);
            }
        }
    );
});

$(document).on('submit', '#login-nav', function(event) {
    var data = $(this).serializeArray();
    console.log(data);
    asyncRequest(
        $(this).attr('action'),
        $(this).attr('method'),
        {
            data: JSON.stringify(data)
        },
        true,
        function(){},
        function(msg){
            try {
                msg = JSON.parse(msg);
                if(msg[0].redirect !== null){
                    window.location.replace(msg[0].redirect);
                }
                console.log(msg);
            }catch (jsonParseException) {
                console.log(jsonParseException.message);
            }
        }
    );
    event.preventDefault();
})

$(document).on('submit', '#register-nav', function registerHandler(event) {
    $('#login-dp').fadeOut();
    var data = $(this).serializeArray();
    console.log(data);

    asyncRequest($(this).attr('action'),$(this).attr('method'), {data: JSON.stringify(data)}, true, function () {}, function (msg) {
        try {
            msg = JSON.parse(msg);
            console.log(msg);
        }catch (jsonParseException) {
            console.log(msg);
        }
        var afterLoginMsg = "";
        if(msg[0].returnCode.indexOf('S0') !== -1){
            var mailDomain = getMailDomain(data[0].value);
            if (mailDomain !== -1) {
                afterLoginMsg = msg[0].info+'<p class="text-right">Za chwilę zostaniesz przekierowany do twojego serwera pocztowego</p><p class="text-right"><a class="btn btn-redirect">Przekieruj ręcznie</a></p>';
                setTimeout(function() {
                    window.location.replace(mailDomain);
                }, 10000);
            }else {
                afterLoginMsg = msg[0].info;
            }
            $('.snackbar').html(afterLoginMsg);
            $('.snackbar').addClass('show');
            setTimeout(function(){
                $('.snackbar').removeClass('show');
            },10000);
        }else {
            afterLoginMsg = msg[0].info;
            $('.snackbar').html(afterLoginMsg);
            $('.snackbar').addClass('show');
            setTimeout(function(){
                $('.snackbar').removeClass('show');
            },10000);
        }
    });
    $(this).trigger('reset');
    $(this).find("progress").val(0);

    event.preventDefault();
});

$(document).on('submit', '.contact-form', function(event){
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
        asyncRequest("server/email/send.php", "POST", {firstname: firstname, lastname: lastname, email: email, message:message}, true, function () {
            $('html, body').animate({
                scrollTop: $('#contact').offset().top
            },1000);
            $('.contact-container').fadeOut("slow");
            $('.form-loading').delay(500).fadeIn("slow");
        }, function (msg) {
            $('.form-loading').fadeOut("slow");
            $('.contact-container').delay(500).fadeIn("slow");
            $('.done-well').fadeIn("slow").delay(5000).fadeOut("slow");
            $('.firstname').val("");
            $('.lastname').val("");
            $('.email').val("");
            $('.msg-textarea').val("");
        });
    }
    event.preventDefault();
});

$(document).on('click', '.navbar-brand-logo', function(event){
    $(location).attr('href', 'http://localhost/wordtool');
});

$(document).on('click', 'a[href^="#"]', function (event) {
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

$(document).on('keyup', '.input-custom', function(){
    var filter = $(this).val().toUpperCase();
    $slider.slick('slickUnfilter');
    $slider.slick('slickFilter', ':contains('+filter+')');
    if($('.book_item').length == 0){
        $('p.n-to-s').html("Niestety nie posiadamy książki której szukasz :(");
    }else {
        $('p.n-to-s').html("");
    }
});

$(document).ready(function () {

    if($('input.activate_info').length == 1){
        $('.snackbar').html($('input.activate_info').val());
        $('.snackbar').addClass('show');
        setTimeout(function(){
            $('.snackbar').removeClass('show');
        },3000);
    }

    var $slider = $('.books_slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: true,
        infinite: true,
        cssEase: 'linear',
        adaptiveHeight: true,
        centerMode: false,
        centerPadding: "0px",
        prevArrow: '<button class="btn btn-icon-prev"><i class="fa fa-long-arrow-left icon-prev" aria-hidden="true"></i></button>',
        nextArrow: '<button class="btn btn-icon-next"><i class="fa fa-long-arrow-right icon-next" aria-hidden="true"></i></button>',
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


    if($('.donate-success').length !== 0){
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

});

$(window).load(function () {
    $('.loading').fadeOut("slow");
});
