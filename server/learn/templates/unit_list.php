<?php
  if(isset($_POST['pathToConnect'])){
    include $_POST['pathToConnect'];
  }else {
    include "../mysql_connect/connect.php";
  }
  $sql = "SELECT unit_no, unit_id, name FROM units WHERE book_id=".$_POST['bookid']."";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    echo "<ul class='nav nav-sidebar'>";
    while($row = $result->fetch_assoc()){
      echo "<li><a href='#' class='unit'>".$row['unit_no']." - ".$row['name']."<input type='hidden' name='unitid' value='".$row['unit_id']."'></a></li>";
    }
    echo "</ul>";
  }
?>
