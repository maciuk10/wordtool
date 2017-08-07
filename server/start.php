<?php

require '../vendor/autoload.php';

define('START_URL', 'http://localhost/wordtool');
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

?>