<?php
include 'connection.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $return_date = date("Y-m-d");

    $query = "UPDATE borrow 
              SET return_date = '$return_date' 
              WHERE ID = '$id'";

    mysqli_query($conn, $query);

    header("Location: return book.php");
}
?>