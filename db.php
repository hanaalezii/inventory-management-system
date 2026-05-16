<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adiconditioner";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Lidhja me databazën dështoi: " . $conn->connect_error);
}

?>
