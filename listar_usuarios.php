<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT id, name, email FROM usuarios";
$result = $conn->query($sql);

$usuarios = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

echo json_encode($usuarios);

$conn->close();
?>