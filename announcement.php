<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "esolat");

$result = $conn->query("SELECT tajuk, kandungan FROM hadis WHERE status = 'aktif'");
$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>