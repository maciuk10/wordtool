<?php
    require_once "../../vendor/autoload.php";

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $message = $_POST['message'];


    $mail = new PHPMailer;

    $mail->SMTPDebug = 3;
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
    $mail->addAddress("maciekgrzela@outlook.com", "Maciek");

    $mail->isHTML(true);
    $mail->Subject = "Wiadomość z portalu WordTool";
    $mail->Body = "Imię: ".$firstname."<br/>"."Nazwisko: ".$lastname."<br/>"."Email: ".$email."<br/>"."Wiadomość: ".$message."<br/><hr>Wiadomość wygenerowana automatycznie z Wordtool";

    if(!$mail->send()){
        echo "Mailer error: ".$mail->ErrorInfo;
    }else {
        echo "Message has been sent successfully";
    }
?>
