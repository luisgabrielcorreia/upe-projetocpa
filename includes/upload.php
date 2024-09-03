<?php
require_once '../config/config.php';

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];

    if ($file["error"] != UPLOAD_ERR_OK) {
        $response['success'] = false;
        $response['message'] = "Erro ao fazer upload do arquivo.";
    } else {
        $content = file_get_contents($file["tmp_name"]);

        $json = json_decode($content);

        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            $response['success'] = false;
            $response['message'] = "O arquivo JavaScript não contém um JSON válido.";
        } else {
            $json_formulario = json_encode($json, JSON_UNESCAPED_UNICODE);
            $nome_arquivo = pathinfo($file['name'], PATHINFO_FILENAME); // Remove a extensão do nome do arquivo

            $stmt = $conn->prepare("INSERT INTO formulario (json_formulario, nome_arquivo) VALUES (?, ?)");
            $stmt->bind_param("ss", $json_formulario, $nome_arquivo);

            if ($stmt->execute() === TRUE) {
                $response['success'] = true;
                $response['message'] = "Avaliação enviada com sucesso.";
            } else {
                $response['success'] = false;
                $response['message'] = "Erro ao enviar a avaliação: " . $conn->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Método de requisição inválido ou nenhum arquivo enviado.";
}

echo json_encode($response);
?>
