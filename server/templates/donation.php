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
            <div class="col-xs-12 donate-success">
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
            <div class="col-xs-12 donate-success">
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