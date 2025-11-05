<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT id, nome, data, local, preco, descricao, imagem_url AS imagemUrl, id_usuario FROM eventos";
$result = $conn->query($sql);

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
$conn->close();
?>