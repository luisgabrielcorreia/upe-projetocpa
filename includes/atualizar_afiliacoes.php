<?php
require_once '../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $afiliacoes = isset($_POST['afiliacoes']) ? $_POST['afiliacoes'] : [];
    $afiliacoesStr = implode(',', $afiliacoes);

    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE users SET afiliacoes = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $afiliacoesStr, $user_id);

    if ($stmt->execute()) {
        header("Location: ../public/user_dashboard.php");
        exit();
    } else {
        echo "Erro ao atualizar as afiliações. Tente novamente.";
    }

    $stmt->close();
}

$conn->close();
?>
