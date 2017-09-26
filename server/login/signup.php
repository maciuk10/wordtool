<?php

include "../mysql_connect/connect.php";

$decoded = json_decode($_POST['data'], true);
$dataToDB = array();
foreach ($decoded as $input){
    array_push($dataToDB, $input['value']);
}

$select = "SELECT user_email FROM users WHERE user_email LIKE '".$dataToDB[2]."'";
$result = $conn->query($select);

if($result->num_rows > 0){
    echo "Konto o danym adresie już istnieje. Użyj innego e-mail";
    die();
}

$query = "INSERT INTO users (user_firstname, user_lastname, user_email, user_password) VALUES ('".$dataToDB[0]."','".$dataToDB[1]."','".$dataToDB[2]."','".md5($dataToDB[3])."')";


if ($conn->query($query) === TRUE) {
    echo "Konto utworzone! Możesz się teraz zalogować";
} else {
    echo "Ups :( Coś poszło nie tak: " . $query . "<br>" . $conn->error;
}

$conn->close();

?>