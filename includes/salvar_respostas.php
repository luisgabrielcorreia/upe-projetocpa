<?php
require_once '../config/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_token'])) {
    echo "Acesso negado. Usuário não autenticado.";
    exit();
}

$sql = "SELECT id, user_type FROM users WHERE token ='{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
} else {
    echo "Usuário não encontrado.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formId = $_POST['formId'];
    $userId = $userinfo['id'];
    
    $respostas = [];
    foreach ($_POST as $key => $value) {
        if ($key != 'formId') {
            $respostas[$key] = $value;
        }
    }

    $json_respostas = json_encode($respostas);
    $data_resposta = date("Y-m-d H:i:s");

    // Verifica se já existe uma resposta incompleta para o formulário e usuário
    $sql = "SELECT id FROM respostas WHERE form_id = ? AND user_id = ? AND status = 'incomplete'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $formId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Atualiza o registro existente para "complete"
        $row = $result->fetch_assoc();
        $resposta_id = $row['id'];
        $sql = "UPDATE respostas SET respostas = ?, data_resposta = ?, status = 'complete' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $json_respostas, $data_resposta, $resposta_id);

        if ($stmt->execute()) {
            echo "Resposta salva com sucesso.";
        } else {
            echo "Erro ao atualizar a resposta.";
        }
    } else {
        echo "Nenhum registro incompleto encontrado.";
    }

    $stmt->close();
} else {
    echo "Método de requisição inválido.";
}

$conn->close();
?>
