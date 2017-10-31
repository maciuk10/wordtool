<?php
    if(!isset($_POST['book_id'])){
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/wordtool');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>WordTool</title>

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/pe-icon-7-stroke.css" rel="stylesheet">
    <link href="../../css/ct-navbar.css" rel="stylesheet">
    <link href="../../css/static.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:100,300,400,700,800,900|Alegreya+Sans:100,300,400,700,800,900|Armata|Athiti:200,300,400,500,600,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="../../css/slick.css" rel="stylesheet" type="text/css" />
    <link href="../../css/slick-theme.css" rel="stylesheet" type="text/css" />
    <link href="../../css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>
<input type="hidden" name="bookid" class="bookid" value="<?php echo $_POST['book_id']; ?>">
<div class="loading">
    <img src="../../img/Ellipsis.svg" class="gif"/>
</div>
<nav class="navbar navbar-ct-black nav-book" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-brand-logo" href="#">
                <div class="logo">
                    <img class="wt_logo" src="../../img/wt_logo_white.png" width="200">
                </div>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../../">
                        <i class="pe-7s-home"></i>
                        <p>Strona Główna</p>
                    </a>
                </li>
                <li class="dropdown">
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
                        <li><a href="#"><span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span> WYKUP PREMIUM</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Wyloguj</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-right navbar-search-form" role="search">
                <div class="form-group">
                    <input type="text" value="" class="form-control nav-search" placeholder="Szukaj!">
                </div>
            </form>
        </div>
    </div>
</nav>
<section class="directory book-dir">
    <div class="container-fluid container-wth-margins">
        <div class="row container-wth-margins">
            <div class="col-xs-12 container-wth-margins">
                <ol class="breadcrumb breadcrumb-custom">
                    <li><a href="../../">WordTool</a></li>
                    <li class="active data-name"></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="book-info">
    <div class="container book-container">
        <div class="row book-row">
            <div class="col-md-3 col-xs-12 card">
                <img src="" alt="" class="data-img img-responsive">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-8 col-xs-12 card card-desc">
                <div class="card-body">
                    <p class="data-title"></p>
                    <p class="data-publisher"></p>
                    <p class="data-description"></p>
                    <form class="form-access" action="../learn/index.php" method="post">
                        <button type="submit" class="btn btn-access">Uzyskaj dostęp</button>
                        <input type="hidden" class="data-title" name="title" value="">
                        <input type="hidden" class="data-publisher" name="publisher" value="">
                        <input type="hidden" class="bookid" name="bookid" value="">
                        <input type="hidden" name="choosen" value="">
                    </form>
                    <p class="post-result"></p>
                </div>
            </div>
        </div>
        <div class="row units-row">
            <div class="col-xs-12">
                <p class="text-center text-uppercase text-units">Rozdziały w książce</p>
            </div>
            <div class="col-xs-12 data-units">
                <div class="table-responsive">
                    <table class="table no-border table-hover">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            <div class="col-xs-12">
                <ul class="units"></ul>
            </div>
        </div>
    </div>
</section>
<footer class="footer book-footer" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="page-header">
                    <h1 class="footer-header">Nawigacja</h1>
                </div>
                <ul class="list-group footer-list">
                    <li class="list-group-item"><a href="../../index.php#description">Czym jest WordTool?</a></li>
                    <li class="list-group-item"><a href="../../index.php#books"> Dostępne materiały</a></li>
                    <li class="list-group-item"><a href="../../index.php#contact">Kontakt</a></li>
                    <li class="list-group-item"><a href="../../index.php#donate">Wesprzyj nas!</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="page-header">
                    <h1 class="footer-header">Korzystaj z WordTool!</h1>
                </div>
                <ul class="list-group footer-list">
                    <li class="list-group-item"><a href="./server/login/index.php">Logowanie</a></li>
                    <li class="list-group-item"><a href="./server/login/index.php">Rejestracja</a></li>
                    <li class="list-group-item"><a href="./shoppings.html">Zakupy</a></li>
                    <li class="list-group-item"><a href="#">Regulamin</a></li>
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
<script>window.jQuery || document.write('<script src="../../js/jquery.js"><\/script>')</script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/ct-navbar.js"></script>
<script src="../../js/book.js"></script>
<script src="../../js/slick.min.js"></script>
</body>
</html>
