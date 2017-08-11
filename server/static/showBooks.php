<?php

include "server/mysql_connect/connect.php";

$sql = "SELECT book_id, name, publisher, cover FROM books";
$result = $conn->query($sql);

if($result->num_rows > 0){
    echo "<div class='container-fluid container-slider'><div class='row text-center'><div class='col-xs-12'><div class='books_slider'>'";
    while($row = $result->fetch_assoc()) {
        echo "<div class='book_item'>";
        echo "<div class='book_img'>";
        echo "<img src='data:image/jpeg;base64,".base64_encode( $row['cover'] )."' />";
        echo "</div>";
        echo "<div class='book_desc'>";
        echo "<p class='desc' style='display: none'>".$row['name']."</p>";
        echo "</div>";
        echo "<div class='book_publisher'>";
        echo "<p class='publisher' style='display: none'><span class='bold'>Wydawnictwo: </span>".$row['publisher']."</p>";
        echo "</div>";
        echo "<form method='post' action='server/books/book.php'>";
        echo "<input type='hidden' name='book_id' value='".$row['book_id']."' >";
        echo "<button type='submit' class='btn btn-default btn-book'>Zacznij naukę!</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div></div></div></div>";
} else {
    echo "<p class='no_results'>"."Ups. Coś musiało pójść nie tak! Przeładuj stronę"."</p>";
}

$conn->close();

?>