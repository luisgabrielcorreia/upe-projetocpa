<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $opcoes = explode(',', $_POST['opcoes']);

    // Inserir votação na tabela votacoes
    $sql = "INSERT INTO votacoes (titulo, descricao) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $titulo, $descricao);
    
    if ($stmt->execute()) {
        $votacao_id = $stmt->insert_id;

        // Inserir opções na tabela opcoes_voto
        $sql = "INSERT INTO opcoes_voto (votacao_id, opcao) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        
        foreach ($opcoes as $opcao) {
            $stmt->bind_param("is", $votacao_id, trim($opcao));
            $stmt->execute();
        }

        // Redirecionar para listar_votacoes.php após criar a votação
        header("Location: ../public/votacoes/listar_votacoes.php");
        exit(); // Certifique-se de que o script para de executar após o redirecionamento
    } else {
        echo "Erro ao criar a votação: " . $stmt->error;
    }
}
?>
