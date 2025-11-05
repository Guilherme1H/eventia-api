<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if (empty($name) || empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(["message" => "Dados incompletos."]);
        exit();
    }

    $sql = "INSERT INTO usuarios (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["message" => "Usuário criado com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Erro ao criar usuário: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Método não permitido."]);
}
?>