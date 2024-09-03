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
$form_result = $conn->query($sql);
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
        
        <!-- Filtros para geração de relatórios -->
        <div class="card mt-4">
            <div class="card-header">
                Filtros para Geração de Relatórios
            </div>
            <div class="card-body">
                <form id="filtrosForm">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exibirDadosPessoais" name="exibirDadosPessoais">
                        <label class="form-check-label" for="exibirDadosPessoais">Exibir Dados Pessoais</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="incluirRespostasDiscursivas" name="incluirRespostasDiscursivas">
                        <label class="form-check-label" for="incluirRespostasDiscursivas">Incluir Respostas Discursivas</label>
                    </div>
                    <div class="form-group mt-3">
                        <label for="dataInicio">Data de Início:</label>
                        <input type="date" id="dataInicio" name="dataInicio" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label for="dataFim">Data de Fim:</label>
                        <input type="date" id="dataFim" name="dataFim" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Aplicar Filtros</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Lista de Formulários
            </div>
            <div class="card-body">
                <?php if ($form_result->num_rows > 0): ?>
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
                            <?php while ($row = $form_result->fetch_assoc()): ?>
                                <?php
                                    // Contar o número de respostas vinculadas a este formulário
                                    $count_sql = "SELECT COUNT(*) as resposta_count FROM respostas WHERE form_id = ?";
                                    $count_stmt = $conn->prepare($count_sql);
                                    $count_stmt->bind_param("i", $row['id']);
                                    $count_stmt->execute();
                                    $count_result = $count_stmt->get_result();
                                    $count_row = $count_result->fetch_assoc();
                                    $resposta_count = $count_row['resposta_count'];
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nome_arquivo']; ?></td>
                                    <td><?php echo $resposta_count; ?></td>
                                    <td>
                                        <a href="#?id=<?php echo $row['id']; ?>" class="btn btn-primary">Gerar Relatório</a>
                                        <a href="../includes/gerar_csv.php?form_id=<?php echo $row['id']; ?>" class="btn btn-primary">Baixar Relatório CSV</a>
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
