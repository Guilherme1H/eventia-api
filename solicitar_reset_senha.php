<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$data = json_decode(file_get_contents("php://input"));
$email = $data->email ?? '';

if (empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'O campo de e-mail é obrigatório.']);
    exit();
}

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Se o e-mail estiver cadastrado, as instruções de redefinição de senha foram enviadas.'
    ]);
} else {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Se o e-mail estiver cadastrado, as instruções de redefinição de senha foram enviadas.'
    ]);
}

$stmt->close();
$conn->close();
?>