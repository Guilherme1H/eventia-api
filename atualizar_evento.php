<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID do evento não fornecido.']);
    exit();
}

$id = $_POST['id'];
$new_imagem_url = null;

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
    $res = $conn->query("SELECT imagemUrl FROM eventos WHERE id = $id");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $url_parts = explode('/', $row['imagemUrl']);
        $filename = end($url_parts);
        if ($filename && file_exists('uploads/' . $filename)) {
            unlink('uploads/' . $filename);
        }
    }
    
    $upload_dir = 'uploads/';
    $file_extension = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $unique_filename = uniqid('evento_', true) . '.' . $file_extension;
    $target_file = $upload_dir . $unique_filename;
    if(move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $server_name = $_SERVER['SERVER_NAME'];
        $api_folder = '/api_eventia/';
        $new_imagem_url = $protocol . $server_name . $api_folder . $target_file;
    }
}

$date_obj = DateTime::createFromFormat('d/m/Y H:i', $_POST['data']);
$data_mysql = $date_obj->format('Y-m-d H:i:s');

if ($new_imagem_url !== null) {
    $stmt = $conn->prepare("UPDATE eventos SET nome=?, data=?, local=?, preco=?, descricao=?, imagemUrl=? WHERE id=?");
    $stmt->bind_param("sssdssi", $_POST['nome'], $data_mysql, $_POST['local'], $_POST['preco'], $_POST['descricao'], $new_imagem_url, $id);
} else {
    $stmt = $conn->prepare("UPDATE eventos SET nome=?, data=?, local=?, preco=?, descricao=? WHERE id=?");
    $stmt->bind_param("sssdsi", $_POST['nome'], $data_mysql, $_POST['local'], $_POST['preco'], $_POST['descricao'], $id);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Evento atualizado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar evento: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>