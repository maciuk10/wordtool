<?php
session_start();
    if(isset($_SESSION)) {
        $_SESSION = array();
        $result = "Wyczyszczono session var";
        session_destroy();
        $result = $result."Użyto funkcji destory";
        $params = session_get_cookie_params();
        $result = $result."Pobrano parametry cookie";
        setcookie(session_name(), '', time()-4200, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        $result = $result."Usunięto cookiesa";
    }
    echo "http://".$_SERVER['SERVER_NAME']."/wordtool/index.php";
?>