<?php
require_once '../../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

// Verifica se o usuário é um administrador
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

// Exclui uma votação se for solicitado
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_sql = "DELETE FROM votacoes WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    echo "<script>alert('Votação excluída com sucesso!'); window.location.href='listar_votacoes.php';</script>";
    exit();
}

// Busca todas as votações
$sql = "SELECT id, titulo, descricao, data_inicio FROM votacoes ORDER BY data_inicio DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Votações</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Votações</h2>
        <a href="criar_votacao.php" class="btn btn-success mb-3">Criar Nova Votação</a>
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Data de Início</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($row['data_inicio']); ?></td>
                            <td>
                                <a href="visualizar_votacao.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Ver Detalhes</a>
                                <a href="listar_votacoes.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta votação?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhuma votação encontrada.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
