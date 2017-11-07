<?php


function generate_activation_code($length){
    $code = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUWXYZabcdefghijklmnopqrstuwxyz1234567890";
    for($i = 0; $i < $length; $i++){
        $code .= $chars[rand(0, strlen($chars))];
    }
    return $code;
}

include "../mysql_connect/connect.php";

$decoded = json_decode($_POST['data'], true);
$result = array();
$dataToDB = array();
foreach ($decoded as $input){
    array_push($dataToDB, $input['value']);
}

$selectEmails ='SELECT user_email FROM users WHERE user_email="'.$dataToDB[0].'"';

$seakResult = $conn->query($selectEmails);


if($seakResult->num_rows > 0){
    array_push($result, array('info'=>'Konto o podanym adresie email już istnieje', 'returnCode'=> 'E001'));
    echo json_encode($result);
}else{
    $str_activate_code = $dataToDB[0].rand(100, 999);
    $activate_code = md5($str_activate_code);
    $query = "INSERT INTO users(user_email, user_password, user_activated, user_activate_code) VALUES ('".$dataToDB[0]."','".md5($dataToDB[1])."',0,'".$activate_code."')";
    if($conn->query($query) === TRUE){
        require_once '../../vendor/autoload.php';
        $email = $dataToDB[0];
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "maciekgrzela45";
            $mail->Password = "Maciejka97";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            $mail->setLanguage("pl");
            $mail->CharSet = "UTF-8";

            $mail->From = "wordtool@wordtool.com";
            $mail->FromName = "WordTool";
            $mail->addAddress($dataToDB[0]);

            $mail->isHTML(true);
            $mail->Subject = "Wiadomość z portalu WordTool";

            $today = date('Y-m-d H:i:s');
            $activationLink = "<a href='http://".$_SERVER['SERVER_NAME']."/wordtool/activate.php?user_email=".$dataToDB[0]."&activate_token=".$activate_code."'>"."Aktywuj konto"."</a>";
            $forgetPasswordLink = "<a href='http://".$_SERVER['SERVER_NAME']."/wordtool/server/templates/forget_password.html'>"."Zapomniałem hasła"."</a>";
            $mail->Body = "Gratulacje!!! Twoje konto na portalu Wordtool zostało utworzone. Otwórz poniższy link aby aktywować konto: <br><br><br><hr>".$activationLink."<br><br><br><hr>"."W razie zapomnienia lub utraty hasła kliknij w poniższy link<br>".$forgetPasswordLink."<br><br><br><hr>"."Wiadomość wygenerowana automatycznie z Wordtool: ".$today;
            $mail->send();

            array_push($result, array('info'=>'Konto w systemie Wordtool zostało utworzone. W celu aktywacji konta udaj się pod podany adres email', 'returnCode'=> 'S001'));
            echo json_encode($result);
        }catch (Exception $e){
            $rollback = "DELETE FROM users WHERE user_email='".$dataToDB[0]."'";
            $conn->query($rollback);
            array_push($result, array('info'=>'Niestety wystąpił błąd!', 'returnCode'=> $e->getMessage()));
            echo json_encode($result);
        }
    } else {
        array_push($result, array('info'=>'Niestety wystąpił błąd!', 'returnCode'=> 'E002'));
        echo json_encode($result);
    }
}

$conn->close();

?>