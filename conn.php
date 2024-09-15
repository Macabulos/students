<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die('Could not connect to mysql server: ' . mysqli_connect_error());
}

?>