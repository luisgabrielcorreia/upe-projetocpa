<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM formulario WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao excluir formulário."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Parâmetros incompletos."]);
}

$conn->close();
?>