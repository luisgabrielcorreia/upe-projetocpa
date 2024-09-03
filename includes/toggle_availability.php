<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_id = $_POST['form_id'];
    $afiliacoes = isset($_POST['afiliacoes']) ? implode(',', $_POST['afiliacoes']) : '';

    $sql = "UPDATE formulario SET afiliacoes = ?, disponivel = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $afiliacoes, $form_id);
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Erro ao atualizar o formulário.";
    }
}
?>
