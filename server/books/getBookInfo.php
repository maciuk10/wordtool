<?php
    include '../mysql_connect/connect.php';

    $bookid = $_POST['bookid'];

    $data = array('name' => '',
                  'publisher' => '',
                  'description' => '',
                  'path' => '');

    $sql = "SELECT name, publisher, description, path FROM books WHERE book_id LIKE ".$bookid;
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_array()) {
            $i = 0;
            foreach ($data as $key => $value){
                    $data[$key] = $row[$i];
                    $i++;
            }
        }
    }
    $conn->close();
    echo json_encode($data);
?>