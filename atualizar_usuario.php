<?php
include 'db.php';
header("Content-Type: application/json; charset=UTF-8");

$dados = json_decode(file_get_contents("php://input"));

if (!isset($dados->id) || !isset($dados->name) || !isset($dados->email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dados incompletos. ID, nome e email são obrigatórios.']);
    exit();
}

$id = $dados->id;
$nome = $dados->name;
$email = $dados->email;
$senha = $dados->password ?? '';
$role = $dados->role ?? '';

$params = [];
$tipos = "";

$sql = "UPDATE usuarios SET name = ?, email = ?";
$params[] = $nome;
$params[] = $email;
$tipos .= "ss";

if (!empty($senha)) {
    $sql .= ", password = ?";
    $params[] = $senha;
    $tipos .= "s";
}

if (!empty($role)) {
    $sql .= ", role = ?";
    $params[] = $role;
    $tipos .= "s";
}

$sql .= " WHERE id = ?";
$params[] = $id;
$tipos .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($tipos, ...$params);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Usuário atualizado com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhum dado foi alterado ou usuário não encontrado.']);
    }
} else {
    if ($conn->errno == 1062) {
        echo json_encode(['success' => false, 'message' => 'O e-mail informado já está em uso por outro usuário.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar usuário: ' . $stmt->error]);
    }
}

$stmt->close();
$conn->close();
?>