<?php

$server = $_SERVER['SERVER_NAME'];
$user = "root";
$pass = "";
$db = "wordtool";

$conn = new mysqli($server, $user, $pass);
$conn->set_charset("utf8");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}else {
    $conn->select_db($db);
}

?>