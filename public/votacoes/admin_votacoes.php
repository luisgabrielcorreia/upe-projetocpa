<?php
require_once '../../config/config.php'; // Certifique-se de que o caminho para o arquivo config.php está correto

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION['user_token']) || empty($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT user_type FROM users WHERE token ='{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
    
    if ($userinfo['user_type'] != 'admin') {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $opcoes = explode(',', $_POST['opcoes']);

    // Insere a nova votação na tabela de votações
    $sql = "INSERT INTO votacoes (titulo, descricao, data_inicio) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $titulo, $descricao);
    $stmt->execute();
    $votacao_id = $stmt->insert_id;

    // Insere as opções de voto na tabela de opções de voto
    $sql = "INSERT INTO opcoes_voto (votacao_id, opcao) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    foreach ($opcoes as $opcao) {
        $stmt->bind_param("is", $votacao_id, trim($opcao));
        $stmt->execute();
    }

    echo "<script>alert('Votação criada com sucesso!'); window.location.href='lista_votacoes.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Votação</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Criar Nova Votação</h2>
        <form action="../../includes/criar_votacao.php" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título da Votação:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição (opcional):</label>
                <textarea class="form-control" id="descricao" name="descricao"></textarea>
            </div>
            <div class="mb-3">
                <label for="opcoes" class="form-label">Opções de Voto (separadas por vírgula):</label>
                <input type="text" class="form-control" id="opcoes" name="opcoes" placeholder="Opção 1, Opção 2, Opção 3" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar Votação</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
