<?php
  include "../../mysql_connect/connect.php";

  $words = array();

  $unitid = $_POST['unitid'];
  $bookid = $_POST['bookid'];
  if(!(isset($_POST['level']))){
      $sql = "SELECT level, pol, eng FROM words WHERE unit_id=".$unitid." AND book_id=".$bookid;
  }else {
    $sql = "SELECT level, pol, eng FROM words WHERE unit_id=".$unitid." AND book_id=".$bookid." AND level='".$_POST['level']."'";
  }
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_array()){
      array_push($words, array('level'=>$row[0], 'pol'=>$row[1], 'eng'=>$row[2]));
    }
    $conn->close();
    echo json_encode($words);
  }else {
    $conn->close();
    echo json_encode($words);
  }
?>
