<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_token']) || empty($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT user_type, full_name FROM users WHERE token ='{$_SESSION['user_token']}'";
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

$sql = "SELECT id, nome_arquivo FROM formulario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                <a class="navbar-brand" id="pageTitle">Visualizador de Respostas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="btn btn-primary" href="user_dashboard.php">Voltar para Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <div class="container mt-4">
        <h2>Bem-vindo à dashboard de Administrador, <?php echo $userinfo['full_name']; ?>!</h2>
        <div class="card mt-4">
            <div class="card-header">
                Lista de Formulários
            </div>
            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome do Arquivo</th>
                                <th>Respostas Vinculadas</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nome_arquivo']; ?></td>
                                    <td>0</td>
                                    <td>
                                        <a href="#?id=<?php echo $row['id']; ?>" class="btn btn-primary">Gerar Relatório</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Nenhum formulário encontrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
