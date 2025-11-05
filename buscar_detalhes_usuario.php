<?php
include 'db.php';
header("Content-Type: application/json; charset=UTF-8");

$id_usuario = $_GET['id'] ?? 0;

if ($id_usuario > 0) {
    $stmt = $conn->prepare("SELECT id, name, email, role FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        echo json_encode($usuario);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Usuário não encontrado."]);
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["message" => "ID de usuário inválido."]);
}
$conn->close();
?>