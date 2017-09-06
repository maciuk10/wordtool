<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>WordTool</title>

    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/pe-icon-7-stroke.css" rel="stylesheet">
    <link href="./css/ct-navbar.css" rel="stylesheet">
    <link href="./css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:100,300,400,700,800,900|Alegreya+Sans:100,300,400,700,800,900|Armata|Athiti:200,300,400,500,600,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="./css/slick.css" rel="stylesheet" type="text/css" />
    <link href="./css/slick-theme.css" rel="stylesheet" type="text/css" />
    <link href="./css/font-awesome.min.css" rel="stylesheet" />
    <link href="./fonts/ionicons.min.css" rel="stylesheet">
</head>

<body>
<div class="loading">
    <img src="./img/page-loader.svg" class="gif"/>
</div>
<div class="login-loading">
    <img src="./img/page-loader.svg" class="gif"/>
</div>
<div class="signup-loading">
    <div class="content text-center">
        <img src="./img/Ellipsis.svg" class="gif"/>
        <p class="text-center sending">Tworzenie konta. Proszę czekać</p>
    </div>
</div>
<section class="main-page" id="main-page">
    <nav class="navbar navbar-ct-black navbar-fixed-top navbar-transparent" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand navbar-brand-logo" href="http://www.google.pl">
                    <div class="logo">
                        <img class="wt_logo" src="./img/wt_logo_white.png">
                    </div>
                </a>
                <div class="nav-right hidden-sm hidden-md hidden-lg">
                    <ul class="nav navbar-nav navbar-right navbar-ul">
                        <li>
                            <a href="#books" data-toggle="search">
                                <i class="pe-7s-search"></i>
                                <p class="hidden-xxs">Szukaj książki</p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="pe-7s-cart">
                                    <span class="label">0</span>
                                </i>
                                <p class="hidden-xxs">Koszyk</p>
                            </a>
                        </li>
                        <li class="login-button">
                            <a href="#main-page" class="login-btn">
                                <i class="pe-7s-user">
                                </i>
                                <p class="hidden-xxs">Zaloguj się</p>
                            </a>
                        </li>
                        <?php
                        if (isset($_SESSION['logged'])){
                            echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="pe-7s-user"></i>
                        <p>Użytkownik <b class="caret"></b></p>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moje dane</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Postęp nauki</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Moje książki</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span>  Regulamin</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Wyloguj</a></li>
                    </ul>
                </li>';
                        }
                        ?>
                    </ul>
                    <form class="navbar-form navbar-right navbar-search-form" role="search">
                        <div class="form-group">
                            <input type="text" value="" class="form-control nav-search hidden-xs" placeholder="Szukaj!">
                        </div>
                    </form>
                </div>
            </div>
            <div class="nav-right hidden-xs">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#books" data-toggle="search" class="hidden-xs">
                            <i class="pe-7s-search"></i>
                            <p>Szukaj książki</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="pe-7s-cart">
                                <span class="label">0</span>
                            </i>
                            <p>Koszyk</p>
                        </a>
                    </li>
                    <li class="login-button">
                        <a href="!" class="login-btn">
                            <i class="pe-7s-user">
                            </i>
                            <p>Zaloguj się</p>
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['logged'])){
                        echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="pe-7s-user"></i>
                        <p>Użytkownik <b class="caret"></b></p>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moje dane</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Postęp nauki</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Moje książki</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span>  Regulamin</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Wyloguj</a></li>
                    </ul>
                </li>';
                    }
                    ?>
                </ul>
                <form class="navbar-form navbar-right navbar-search-form" role="search">
                    <div class="form-group">
                        <input type="text" value="" class="form-control nav-search" placeholder="Szukaj!">
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <div class="blurred-container">
        <div class="img-src" style="background-image: url('./img/3.jpg');">
            <div class="container-fluid container-wth-margin welcome-container">
                <h1 class="page-heading text-center">Witaj w WordTool!</h1>
                <div class="container blurred-div">
                    <p class="page-caption">Witaj w interaktywnym systemie nauki słówek WordTool! Jesteś już zmęczony mozolnym "wkuwaniem" słówek na pamięć? Zacznij się efektywnie i z przyjemnością :) <b>Do dzieła!</b></p>
                </div>
            </div>
            <div class="down-arrow down-arrow-floating" aria-hidden="true">
                <a href="#description">
                    <i class="down-arrow-icon pe-7s-angle-down"></i>
                </a>
            </div>
            <div class="container middle-container login-container">
              <?php include "./server/templates/login.html" ?>
            </div>
        </div>
    </div>
</section>
<section class="description" id="description">
    <div class="container container-custom">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <h1 class="page-header desc-heading">Miło, że tu jesteś!</h1>
                <p class="text-justify desc-caption">Z dumą przedstawiamy Ci interaktywny system nauki słówek WordTool! Pozwala on na łatwiejsze opanowanie słownictwa z języka angielskiego bez konieczności kilkugodzinnego przesiadywania nad książkami. W naszej ofercie znajduje się wiele podręczników, więc jest bardzo duża szansa, że znajdziesz także swój! Jeśli nie? Daj nam znać a my przygotujemy go dla Ciebie! Tymczasem zapraszamy do zobaczenia jak działa WordTool. Kliknij przycisk poniżej i testuj całkowicie za darmo!</p>
                <p class="text-center"><button type="button" class="btn btn-default btn-lg btn-custom">Zobacz, jak działa WordTool!</button></p>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="container slider">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="./img/slide1.png" alt="Los Angeles" style="width:100%;">
                            </div>

                            <div class="item">
                                <img src="./img/slide2.png" alt="Chicago" style="width:100%;">
                            </div>

                            <div class="item">
                                <img src="./img/slide3.png" alt="New york" style="width:100%;">
                            </div>

                            <div class="item">
                                <img src="./img/slide4.png" alt="New york" style="width:100%;">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="books" id="books">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="books_header">Dostępne materiały</h1>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-12 slider-col">
                <p class="input-wrapper"><input type="text" class="input-custom" placeholder="Szukaj!" required></p>
                <p class="n-to-s"></p>
            </div>
        </div>
        <?php
        include "server/static/showBooks.php";
        ?>
    </div>
</section>
<section class="contact" id="contact">
    <div class="form-loading">
        <img src="./img/page-loader.svg" class="gif"/>
        <p class="text-center sending">Wysyłanie formularza. Proszę czekać</p>
    </div>
    <div class="contact-container container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="books_header">Kontakt</h1>
                <p class="text-left contact-desc">Jeśli chcesz dowiedzieć się więcej na temat serwisu lub pragniesz z niego korzystać lecz brakuje twojej książki, daj nam znać! Najlepiej poprzez poniższy formularz kontaktowy :)</p>
            </div>
        </div>
        <form action="server/email/send.php" method="post" class="contact-form" autocomplete="off">
            <div class="form-group row contact-group">
                <div class="col-md-4 col-xs-12">
                    <input type="text" class="form-control contact-input firstname" placeholder="Imię:" name="firstname"/>
                </div>
                <div class="col-md-4 col-xs-12">
                    <input type="text" class="form-control contact-input lastname" placeholder="Nazwisko:" name="lastname" />
                </div>
                <div class="col-md-4 col-xs-12">
                    <input type="email" class="form-control contact-input email" placeholder="Email:" name="email"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-xs-12">
                    <textarea name="msg" class="form-control contact-input msg-textarea" id="msg" rows="7" placeholder="Treść zapytania"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class=" col-md-push-10 col-md-2 col-xs-12">
                    <button type="submit" class="btn btn-default btn-contact">Wyślij</button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-xs-12">
                    <div class="well done-well">Wiadomość została wysłana. Wkrótce się z tobą skontaktujemy</div>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="donate" id="donate">

    <?php

    require './vendor/autoload.php';

    use PayPal\Api\Payment;
    use PayPal\Api\PaymentExecution;

    define('START_URL', 'http://'.$_SERVER['SERVER_NAME'].'/wordtool');
    define('SUCCESS_ICON', 'pe-7s-smile');
    define('SUCCESS_TEXT', 'Dziękujemy za wsparcie!!! Dzięki Tobie WordTool będzie jeszcze lepszy :)');
    define('FAILURE_ICON', 'pe-7s-shield');
    define('FAILURE_TEXT', 'Coś poszło nie tak? Nie martw się i spróbuj ponownie :)');


    $paypal = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AQ4aGPTUz_4D_440GKYA5F2fzyrYPjpyx6uWGbfh-FFfbIec8qlkH9HDXJRWX734meHZAXWAgiVwUvO3',
            'EHrJv13iK2RS0g5rgCnsOJ1vVQukL0OYJ2Cjzc4ij663OyqJV2vm2UHNCikbPRzvwdEqNWHmA_l_pFeu'
        )
    );

    if(!(isset($_GET['success']))){
        echo '<div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="books_header">Wesprzyj nas!</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="contact-desc">Serwis WordTool jest projektem działającym na zasadzie dotacji. Jeśli więc spodobała Ci się nasza aplikacja, przekaż parę groszy aby stała się jeszcze lepsza :) </p>
            </div>
        </div>
        <div class="row text-center">
            <form class="form-inline" method="post" action="server/checkout.php" autocomplete="off">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="btn-toggleable" data-toggle="buttons">
                            <button type="button" class="btn btn-price"><input type="radio" name="price" value="15" />15zł</button>
                            <button type="button" class="btn btn-price"><input type="radio" name="price" value="10" />10zł</button>
                            <button type="button" class="btn btn-price"><input type="radio" name="price" value="5" />5zł</button>
                            <label class="btn btn-price">
                                <input type="number" name="price_oth" class="price-oth" min="1" placeholder="Inna kwota (zł)">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                <div class="row">
                <div class="col-xs-12"><button type="submit" class="btn btn-price btn-contribute">Wesprzyj!</button>
</div>
</div>
                </div>
            </form>
        </div>
    </div>';
    }else{

        if((!(isset($_GET['paymentId'], $_GET['PayerID']))) || (bool)$_GET['success'] === false) {
            echo '<div class="container">
        <div class="row text-center">
            <div class="col-xs-12 success">
                <i class="'.FAILURE_ICON.'"></i>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-12">
                <p class="success-caption">'.FAILURE_TEXT.'</p>
            </div>
        </div>
    </div>';
        }else {
            $paymentID = $_GET['paymentId'];
            $payerID = $_GET['PayerID'];

            $payment = Payment::get($paymentID, $paypal);

            $execute = new PaymentExecution();
            $execute->setPayerId($payerID);

            try {
                $result = $payment->execute($execute, $paypal);
            }catch (Exception $e){
                die($e);
            }

            echo '<div class="container">
        <div class="row text-center">
            <div class="col-xs-12 success">
                <i class="'.SUCCESS_ICON.'"></i>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-12">
                <p class="success-caption">'.SUCCESS_TEXT.'</p>
            </div>
        </div>
    </div>';
        }
    }

    ?>
</section>
<footer class="footer" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="page-header">
                    <h1 class="footer-header">Nawigacja</h1>
                </div>
                <ul class="list-group footer-list">
                    <li class="list-group-item"><a href="#description">Czym jest WordTool?</a></li>
                    <li class="list-group-item"><a href="#books"> Dostępne materiały</a></li>
                    <li class="list-group-item"><a href="#contact">Kontakt</a></li>
                    <li class="list-group-item"><a href="#donate">Wesprzyj nas!</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="page-header">
                    <h1 class="footer-header">Korzystaj z WordTool!</h1>
                </div>
                <ul class="list-group footer-list">
                    <li class="list-group-item"><a href="#main-page" class="login-btn">Logowanie</a></li>
                    <li class="list-group-item"><a href="#main-page" class="login-btn">Rejestracja</a></li>
                    <li class="list-group-item"><a href="./server/static/shoppings.html">Zakupy</a></li>
                    <li class="list-group-item"><a href="./server/static/rules.html">Regulamin</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="page-header">
                    <h1 class="footer-header">Podążaj za nami!</h1>
                </div>
                <ul class="list-group footer-list text-center">
                    <li class="list-group-item list-group-item-social">
                        <a href="http://facebook.com" target="_blank"><i class="fa fa-facebook-official fb" aria-hidden="true"></i></a>
                        <a href="http://twitter.com" target="_blank"><i class="fa fa-twitter tw" aria-hidden="true"></i></a>
                        <a href="http://plus.google.com" target="_blank"><i class="fa fa-google-plus-official gplus" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script>
    document.write('<script src="http://' +
        (location.host || 'localhost').split(':')[0] +
        ':35729/livereload.js?snipver=1"></' + 'script>')
</script>
<script>window.jQuery || document.write('<script src="./js/jquery.js"><\/script>')</script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/ct-navbar.js"></script>
<script src="./js/main.js"></script>
<script src="./js/slick.min.js"></script>
</body>
</html>
