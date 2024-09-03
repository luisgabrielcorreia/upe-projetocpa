<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['congelado'])) {
        $id = $_POST['id'];
        $congelado = $_POST['congelado'];

        $new_congelado = $congelado == 1 ? 0 : 1;

        $sql = "UPDATE formulario SET congelado = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_congelado, $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar o status de congelamento do formulário."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Parâmetros incompletos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método não permitido."]);
}

$conn->close();
?>
