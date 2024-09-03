<?php
require_once '../config/config.php';

// Receber os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Verificar se os dados foram recebidos corretamente
if (!isset($data['form_id']) || !isset($data['respostas']) || !isset($data['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
    exit();
}

$form_id = $data['form_id'];
$respostas = json_encode($data['respostas']);
$user_id = $data['user_id'];

// Verifica se já existe uma entrada para esse formulário e usuário
$sql = "SELECT id FROM respostas WHERE form_id = ? AND user_id = ? AND status = 'incomplete'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $form_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Atualiza a resposta existente
    $row = $result->fetch_assoc();
    $sql = "UPDATE respostas SET respostas = ?, data_resposta = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $respostas, $row['id']);
    $stmt->execute();
} else {
    // Insere uma nova resposta
    $sql = "INSERT INTO respostas (form_id, respostas, data_resposta, user_id, status) VALUES (?, ?, NOW(), ?, 'incomplete')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $form_id, $respostas, $user_id);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(['status' => 'success']);
?>
