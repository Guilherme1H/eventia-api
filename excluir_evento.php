<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM eventos WHERE id = ?");
    
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Erro ao preparar a query: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Evento excluído com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum evento encontrado com o ID fornecido.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir o evento: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID do evento não fornecido.']);
}

$conn->close();
?>