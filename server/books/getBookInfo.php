<?php
    include '../mysql_connect/connect.php';

function array_push_assoc($array, $key, $value){
    $array[$key] = $value;
    return $array;
}

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

    $units = array();

    $sql2 = "SELECT unit_no, name FROM units WHERE book_id LIKE ".$bookid;
    $result2 = $conn->query($sql2);
    if($result2->num_rows > 0){
        while($row = $result2->fetch_array()){
            array_push($units, array('number' => $row[0], 'name' => $row[1]));
        }
    }
    $conn->close();
    $all = array_merge($data, $units);
    echo json_encode($all);
?>