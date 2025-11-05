<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name) || !isset($data->email) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dados incompletos. Nome, email e senha são obrigatórios.']);
    exit();
}

$name = $data->name;
$email = $data->email;
$password = $data->password;
$role = 'user'; 

$stmt = $conn->prepare("INSERT INTO usuarios (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $role);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso!']);
} else {
    if ($conn->errno == 1062) {
        echo json_encode(['success' => false, 'message' => 'Este e-mail já está em uso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar usuário: ' . $stmt->error]);
    }
}

$stmt->close();
$conn->close();
?>