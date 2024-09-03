// registrar_voto.php

<?php
require_once '../config/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['votacao_id']) && isset($_POST['opcao']) && isset($_POST['user_token'])) {
        $votacao_id = $_POST['votacao_id'];
        $opcao_voto = $_POST['opcao'];
        $user_token = $_POST['user_token'];

        // Certifique-se de que a votação existe e está aberta
        $sql_votacao = "SELECT id FROM votacoes WHERE id = ? AND aberta = 1";
        $stmt_votacao = $conn->prepare($sql_votacao);
        $stmt_votacao->bind_param("i", $votacao_id);
        $stmt_votacao->execute();
        $result_votacao = $stmt_votacao->get_result();

        if ($result_votacao->num_rows > 0) {
            // Inserir o voto
            $sql_insert = "INSERT INTO votos (votacao_id, opcao_id, user_token) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iis", $votacao_id, $opcao_voto, $user_token);

            if ($stmt_insert->execute()) {
                echo "Voto registrado com sucesso!";
                header("Location: ../public/user_dashboard.php"); // Redireciona após o voto ser registrado
                exit();
            } else {
                echo "Erro ao registrar o voto.";
            }
        } else {
            echo "A votação não está aberta ou não existe.";
        }
    } else {
        echo "Dados insuficientes para registrar o voto.";
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
