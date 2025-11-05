<?php
header('Content-Type: application/json; charset=UTF-8');
include 'db.php'; 

$nome = $_POST['nome'] ?? '';
$data = $_POST['data'] ?? '';
$local = $_POST['local'] ?? '';
$preco = $_POST['preco'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$imagem_url = $_POST['imagem_url'] ?? '';
$id_usuario = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;

if (empty($nome) || empty($data) || empty($local) || $id_usuario == 0) {
    echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes.']);
    exit;
}

$data_mysql = '';
try {
    $date_obj = DateTime::createFromFormat('d/m/Y H:i', $data);
    if ($date_obj) {
        $data_mysql = $date_obj->format('Y-m-d H:i:s');
    } else {
        echo json_encode(['success' => false, 'message' => 'Formato de data inválido.']);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao processar a data.']);
    exit;
}

$sql = "INSERT INTO eventos (nome, data, local, preco, descricao, imagem_url, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a query: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssssssi", $nome, $data_mysql, $local, $preco, $descricao, $imagem_url, $id_usuario);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Evento criado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao criar evento: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>