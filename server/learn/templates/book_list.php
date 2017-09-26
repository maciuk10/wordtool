<?php
  include "../mysql_connect/connect.php";
  $sql = "SELECT name FROM books WHERE book_id!=".$_POST['bookid'];
  $result = $conn->query($sql);

  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      echo "<li role='presentation'><a href='#'>".$row['name']."</a></li>";
    }
  }
?>
