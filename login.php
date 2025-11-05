<?php
include 'db.php'; 
header("Content-Type: application/json; charset=UTF-8");

$email = $_GET['email'] ?? '';
$password = $_GET['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode([]);
    exit();
}

$stmt = $conn->prepare("SELECT id, name, email, password, role FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user_from_db = $result->fetch_assoc();

$response = [];

if ($user_from_db && password_verify($password, $user_from_db['password'])) {
    
    $user_data = [
        'id' => $user_from_db['id'],
        'name' => $user_from_db['name'],
        'email' => $user_from_db['email'],
        'role' => $user_from_db['role']
    ];
    $response[] = $user_data;
}

echo json_encode($response);

$stmt->close();
$conn->close();

?>