<?php

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
    $query = "INSERT INTO users(user_email, user_password) VALUES ('".$dataToDB[0]."','".md5($dataToDB[1])."')";

    if($conn->query($query) === TRUE){

        require_once '../../vendor/autoload.php';

        /*array_push($result, array('info'=>'Problem z obsługą email', 'returnCode'=> 'E002'));
        echo json_encode($result);
        die();*/

        $email = $dataToDB[0];
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "maciekgrzela45";
            $mail->Password = "maciuk33";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            $mail->setLanguage("pl");
            $mail->CharSet = "UTF-8";

            $mail->From = "wordtool@wordtool.com";
            $mail->FromName = "WordTool";
            $mail->addAddress($dataToDB[0]);

            $mail->isHTML(true);
            $mail->Subject = "Wiadomość z portalu WordTool";
            $mail->Body = "Gratulacje!!! Twoje konto na portalu Wordtool zostało utworzone. Otwórz poniższy link aby aktywować konto: <br>"."[ link - link ]"."<br><br><br><hr>"."W razie zapomnienia lub utraty hasła kliknij w poniższy link<br>"."[link - link]"."<br><br><br><hr>"."Wiadomość wygenerowana automatycznie z Wordtool";
            $mail->send();

            array_push($result, array('info'=>'Konto w systemie Wordtool zostało utworzone. W celu aktywacji konta udaj się pod podany adres email', 'returnCode'=> 'S001'));
            echo json_encode($result);
        }catch (Exception $e){
            array_push($result, array('info'=>'Niestety wystąpił błąd!', 'returnCode'=> 'E003'));
            echo json_encode($result);
        }

    } else {
        array_push($result, array('info'=>'Niestety wystąpił błąd!', 'returnCode'=> 'E002'));
        echo json_encode($result);
    }
}

$conn->close();

?>