<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT json_formulario FROM formulario WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $arquivo = $row['json_formulario'];

        $json_formatado = json_encode(json_decode($arquivo), JSON_PRETTY_PRINT);

        header('Content-Type: application/javascript; charset=utf-8');
        header('Content-Disposition: attachment; filename="arquivo_' . $id . '.js"');

        echo $json_formatado;
        exit();
    } else {
        echo "Formulário não encontrado.";
    }
} else {
    echo "ID inválido.";
}

$conn->close();
?>
