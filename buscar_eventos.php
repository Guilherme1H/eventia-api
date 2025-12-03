<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$searchQuery = $_GET['query'] ?? '';

$select_cols = "id, nome, data, local, preco, descricao, imagem_url AS imagemUrl, id_usuario, categoria";

if (empty($searchQuery)) {
    $sql = "SELECT $select_cols FROM eventos ORDER BY data DESC";
    $stmt = $conn->prepare($sql);
} else {
    $searchTerm = "%" . $searchQuery . "%";
    $sql = "SELECT $select_cols FROM eventos WHERE nome LIKE ? OR local LIKE ? OR descricao LIKE ? ORDER BY data DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $eventos = [];
    
    while ($row = $result->fetch_assoc()) {
        $row['id'] = (int)$row['id'];
        $row['preco'] = (float)$row['preco'];
        $row['id_usuario'] = (int)$row['id_usuario'];
        
        $eventos[] = $row;
    }
    
    echo json_encode($eventos);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao executar a busca: ' . $stmt->error]);
}

if (isset($stmt)) $stmt->close();
$conn->close();
?>