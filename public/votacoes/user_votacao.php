<?php
require_once '../../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

// Verifica se o parâmetro votacao_id está presente
if (!isset($_GET['votacao_id'])) {
    echo "Votação não especificada.";
    exit();
}

$votacao_id = $_GET['votacao_id'];

// Busca as informações da votação
$sql_votacao = "SELECT id, titulo, descricao FROM votacoes WHERE id = ?";
$stmt_votacao = $conn->prepare($sql_votacao);
$stmt_votacao->bind_param("i", $votacao_id);
$stmt_votacao->execute();
$result_votacao = $stmt_votacao->get_result();

if ($result_votacao->num_rows == 0) {
    echo "Votação não encontrada.";
    exit();
}

$votacao = $result_votacao->fetch_assoc();

// Gerar um token único para o usuário se ele ainda não tiver um
if (!isset($_COOKIE["votacao_token_$votacao_id"])) {
    $user_token = bin2hex(random_bytes(16)); // Gera um token aleatório
    setcookie("votacao_token_$votacao_id", $user_token, time() + (86400 * 30), "/"); // Expira em 30 dias
} else {
    $user_token = $_COOKIE["votacao_token_$votacao_id"];
}

// Verifica se o usuário já votou com esse token
$sql_verificar_voto = "SELECT id FROM votos WHERE votacao_id = ? AND user_token = ?";
$stmt_verificar_voto = $conn->prepare($sql_verificar_voto);
$stmt_verificar_voto->bind_param("is", $votacao_id, $user_token);
$stmt_verificar_voto->execute();
$result_verificar_voto = $stmt_verificar_voto->get_result();

$ja_votou = $result_verificar_voto->num_rows > 0;

// Busca as opções de voto
$sql_opcoes = "SELECT id, opcao FROM opcoes_voto WHERE votacao_id = ?";
$stmt_opcoes = $conn->prepare($sql_opcoes);
$stmt_opcoes->bind_param("i", $votacao_id);
$stmt_opcoes->execute();
$result_opcoes = $stmt_opcoes->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Votação - <?php echo htmlspecialchars($votacao['titulo']); ?></title>
</head>
<body>
    <div class="container mt-5">
        <h2>Votação: <?php echo htmlspecialchars($votacao['titulo']); ?></h2>
        <p><?php echo htmlspecialchars($votacao['descricao']); ?></p>

        <?php if ($ja_votou): ?>
            <div class="alert alert-info">Você já votou nesta votação. Obrigado pela sua participação!</div>
        <?php else: ?>
            <form method="POST" action="../../includes/registrar_voto.php">
                <input type="hidden" name="votacao_id" value="<?php echo htmlspecialchars($votacao['id']); ?>">
                <input type="hidden" name="user_token" value="<?php echo htmlspecialchars($user_token); ?>">
                <?php while ($opcao = $result_opcoes->fetch_assoc()): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opcao" id="opcao_<?php echo $opcao['id']; ?>" value="<?php echo $opcao['id']; ?>">
                        <label class="form-check-label" for="opcao_<?php echo $opcao['id']; ?>">
                            <?php echo htmlspecialchars($opcao['opcao']); ?>
                        </label>
                    </div>
                <?php endwhile; ?>
                <button type="submit" class="btn btn-primary mt-3">Votar</button>
            </form>
        <?php endif; ?>

        <a href="../user_sidebar/votacoes.php" class="btn btn-secondary mt-3">Voltar para Votações</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+pPzJt8iRfZlfIY2C0BfTV5t5QCd5ETZjBJFH5PLGxEpVHviWh4y5qXHgG5ic8" crossorigin="anonymous"></script>
</body>
</html>
