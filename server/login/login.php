<?php
session_start();
include "../mysql_connect/connect.php";

$decoded = json_decode($_POST['data'], true);
$result = array();
$dataToDB = array();

foreach($decoded as $input){
    array_push($dataToDB, $input['value']);
}

$searchForEmail = 'SELECT user_email, user_password, user_activated FROM users WHERE user_email="'.$dataToDB[0].'"';
$searchForEmail_q = $conn->query($searchForEmail);

if($searchForEmail_q->num_rows > 0){
    $row = $searchForEmail_q->fetch_array();
    if($row[0] == $dataToDB[0] && md5($dataToDB[1]) == $row[1] && $row[2] == 1){
        $redirect = 'http://'.$_SERVER['SERVER_NAME'].'/wordtool/index.php';
        array_push($result, array('info'=>'Zalogowano się', 'redirect' => $redirect, 'returnCode'=> 'S001'));
        $_SESSION['logged'] = true;
        $_SESSION['logged_email'] = $dataToDB[0];
        echo json_encode($result);
    }else {
        array_push($result, array('info'=>'Niepoprawne hasło', 'returnCode'=> 'E001'));
        echo json_encode($result);
    }
}else {
    array_push($result, array('info'=>'Niepoprawne email lub hasło', 'returnCode'=> 'E002'));
    echo json_encode($result);
}

$conn->close();

?>