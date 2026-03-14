<?php
//connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarymanagementdb";

//connecting mysql to php
$conn = new mysqli($servername, $username, $password , $dbname);

//check connection
if($conn -> connect_error){
    die("connection failed:" . $conn -> connect_error);
}
?>