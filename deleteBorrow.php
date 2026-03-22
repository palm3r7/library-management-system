<?php
include 'connection.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "DELETE FROM borrow WHERE ID = '$id'";
    mysqli_query($conn, $query);

    header("Location: return book.php");
    exit();
}
?>