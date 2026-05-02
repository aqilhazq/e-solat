<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "esolat";

$conn = new mysqli($host, $user, $pass, $db);

$today = date('Y-m-d');
$sql = "SELECT * FROM solat WHERE tarikh = '$today'";
$result = $conn->query($sql);
?>