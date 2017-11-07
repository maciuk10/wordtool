<?php
session_start();
include "./server/mysql_connect/connect.php";

    if(isset($_GET['user_email']) && isset($_GET['activate_token'])) {
        $isEmailActivated_q = "SELECT user_activated, user_activate_code FROM users WHERE user_email='".$_GET['user_email']."'";
        $isEmailActivated = $conn->query($isEmailActivated_q);
        if($isEmailActivated->num_rows > 0){
            $row = $isEmailActivated->fetch_assoc();
            if($row['user_activated'] == '0' && $row['user_activate_code'] == $_GET['activate_token']){
                $activateAccount_q = "UPDATE users SET user_activated=1 WHERE user_email='".$_GET['user_email']."'";
                if($conn->query($activateAccount_q) === TRUE){
                    setcookie("activate_info", "Konto zostało aktywowane. Możesz się teraz zalogować", time()+30, '/');
                    header("Location: index.php");
                }else {
                    setcookie("activate_info", "Wystąpił błąd aktywacji. Prosimy spróbować ponownie później", time()+30, '/');
                    header("Location: index.php");
                }
            }else {
                setcookie("activate_info", "Niepoprawny token aktywacji lub konto już aktywowane", time()+30, '/');
                header("Location: index.php");
            }
        }
    }else {
        header("Location: index.php");
    }
?>