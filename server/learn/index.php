<?php
  if(!isset($_POST['choosen'])){
    header('Location: ../../index.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wt_learn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button1.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
</head>

<body>
  <input type="hidden" name="bookid" value='<?php echo $_POST["bookid"]; ?>'>
  <input type="hidden" name="bookname" value='<?php echo $_POST["title"]; ?>'>
  <input type="hidden" name="bookpublisher" value='<?php echo $_POST["publisher"]; ?>'>
    <div>
        <nav class="navbar navbar-default navigation-clean-button navbar-fixed-top" style="background-color:rgb(17,2,112);">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#" style="color:rgb(255,255,255);">Wordtool - Moduł Nauki</a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li role="presentation"><a href="../../index.php" style="color:rgb(255,255,255);">Home</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#" style="color:rgb(255,255,255);"><?php echo substr($_POST['title'], 0, 15)."..."; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                              <?php include "./templates/book_list.php"; ?>
                            </ul>
                        </li>
                    </ul>
                    <p class="navbar-text navbar-right actions"><a class="navbar-link login" href="#" style="color:rgb(255,255,255);">Logowanie </a> <a class="btn btn-default action-button" role="button" href="#" style="background-color:rgb(10,1,74);">Rejestracja </a></p>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-sm-offset-3 col-md-offset-2 main">
                <div class="page-header">
                    <h2><?php echo $_POST['title'];?><small><?php echo " ".$_POST['publisher'];?></small></h2></div>
                <div class="panel panel-default" style="min-height:400px;">
                  <div class="panel-body">
                    <div class="loading">
                        <img src="../../img/page-loader-learn.svg" class="gif"/>
                    </div>
                    <div class="choose-unit text-center">
                      <span class="glyphicon glyphicon-hand-left left-hand" aria-hidden="true"></span>
                      <p>Wybierz rozdział z listy</p>
                    </div>
                    <div class="learn-mode">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-xs-12">
            <div class="progress green corrector">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value"><span class="glyphicon glyphicon-question-sign"></span></div>
            </div>
        </div>
                        </div>
                        <div class="row text-center">
                          <div class="col-xs-12">
                            <p class="text-center upper-form">Wylosowane słówko to: <span class="display_word"></span></p>
                            <form class="typed-word form-inline">
                              <div class="form-group">
                                <input type="text" name="word" class="form-control word-control" placeholder="Wpisz tłumaczenie słówka">
                              </div>
                              <div class="form-group">
                                <button type="button" class="btn btn-success form-control give-a-hint" name="button"><span class="glyphicon glyphicon-gift"></span></button>
                                <button type="button" class="btn btn-primary form-control check-result" name="button"><span class="glyphicon glyphicon-fire"></span></button>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="row counters">
                          <div class="col-md-4 col-sm-12">
            <div class="progress green">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value goodWords">19</div>
            </div>
            <p class="text-center text-uppercase">poprawne</p>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="progress red">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value badWords">135</div>
            </div>
            <p class="text-center text-uppercase">niepoprawne</p>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="progress orange">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value allWords">76</div>
            </div>
            <p class="text-center text-uppercase">zostało</p>
        </div>
                      </div>
                    </div>
                  </div>
</div>
            </div>
            <div class="col-md-2 col-sm-3 sidebar">
                <h4 class="text-center sidebar-title">Wybierz rozdział:</h4>
                <?php include "./templates/unit_list.php" ?>
            </div>
        </div>
    </div>

    <!-- Learn finish modal  -->

    <div id="endOfLearn" class="modal fade" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Gratulację!!!</h4>
    </div>
    <div class="modal-body">
      <p>Brawo!!! Udało ci się pomyślnie zakończyć naukę w tym dziale. Nie poprzestawaj na tym!!! Zdobywaj kolejne szczyty wybierając kolejne rozdziały i książki</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Chcę więcej!!!</button>
      <button type="button" class="btn btn-default">Daj mi chwilę odpoczynku</button>
    </div>
  </div>

</div>
</div>

    <!-- Learn finish modal - end -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./assets/js/learn.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</body>
</html>
