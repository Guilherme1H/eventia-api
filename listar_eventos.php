<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$categoria = $_GET['categoria'] ?? null;

$sql = "SELECT id, nome, data, local, preco, descricao, imagem_url AS imagemUrl, id_usuario, categoria FROM eventos";

if ($categoria !== null && $categoria !== 'Todos') {
    $sql .= " WHERE categoria = ?";
}

$sql .= " ORDER BY data DESC";


if ($categoria !== null && $categoria !== 'Todos') {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}


$eventos = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    $row['id'] = (int)$row['id'];
    $row['preco'] = (float)$row['preco'];
    $row['id_usuario'] = (int)$row['id_usuario'];

    $eventos[] = $row;
    }
}

echo json_encode($eventos);

if (isset($stmt)) $stmt->close();
$conn->close();