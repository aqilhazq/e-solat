<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "esolat";

$conn = new mysqli($host, $user, $pass, $db);

$today = date('Y-m-d');
$sql = "SELECT * FROM solat WHERE tarikh = '$today'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "NO DATA!!!"]);
}

$conn->close();
?>