<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Usuário excluído com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir ou usuário não encontrado.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID do usuário não fornecido.']);
}

$conn->close();
?>