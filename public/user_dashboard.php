<?php
require_once '../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT user_type, full_name, id, login_method, afiliacoes FROM users WHERE token ='{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
    
    if ($userinfo['user_type'] != 'user') {
        header("Location: ../index.php");
        exit();
    }

    // Armazenar o ID do usuário na sessão
    $_SESSION['user_id'] = $userinfo['id'];

    // Verificar se o método de login é Google e se as afiliações estão vazias
    $showAffiliationsForm = ($userinfo['login_method'] == 'google' && empty($userinfo['afiliacoes']));
} else {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-calendar/1.4.4/simple-calendar.min.css" rel="stylesheet">
    <title>User Dashboard</title>
    <style>
        body {
            display: flex;
            margin: 0;
            background-color: #f7f8fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            color: white;
            position: fixed;
            transition: width 0.3s;
        }
        .sidebar.minimized {
            width: 80px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            transition: opacity 0.3s;
        }
        .sidebar.minimized h2 {
            opacity: 0;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 15px;
            color: #ddd;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }
        .sidebar a.active {
            background-color: #495057;
            color: white;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar.minimized a {
            justify-content: center;
        }
        .sidebar.minimized a i {
            margin-right: 0;
        }
        .sidebar.minimized a span {
            display: none;
        }
        .sidebar .btn-danger {
            width: 100%;
            margin-top: 20px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s, width 0.3s;
        }
        .content.minimized {
            margin-left: 80px;
            width: calc(100% - 80px);
        }
        .file-box {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            margin-bottom: 20px;
        }
        .btn-reply {
            background-color: #4CAF50;
            border-color: #4CAF50;
            color: #fff;
        }
        .btn-reply:hover {
            background-color: #45a049;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .navbar {
            position: fixed;
            width: calc(100% - 250px);
            left: 250px;
            top: 0;
            z-index: 1;
            transition: left 0.3s, width 0.3s;
        }
        .navbar.minimized {
            left: 80px;
            width: calc(100% - 80px);
        }
        .content-container {
            margin-top: 60px; /* Altura da navbar */
        }
        .container {
            max-width: 900px;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>CPA - UPE</h2>
        <a href="#" class="active"><i class="bi bi-house-door"></i> <span>Inicio</span></a>
        <a href="user_sidebar/perfil.php"><i class="bi bi-person"></i> <span>Perfil</span></a>
        <a href="user_sidebar/avaliacoes.php"><i class="bi bi-file-earmark-text"></i> <span>Avaliacoes</span></a>
        <a href="user_sidebar/votacoes.php"><i class="bi bi-file-earmark-text"></i> <span>Votações</span></a>
        <a href="user_sidebar/ajuda.php"><i class="bi bi-question-circle"></i> <span>Ajuda</span></a>
        <a href="user_sidebar/notificacoes.php"><i class="bi bi-bell"></i> <span>Notificacoes</span></a>
        <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
    </div>
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary" id="toggleSidebar"><i class="bi bi-list"></i></button>
            </div>
        </nav>
        <div class="content-container">
            <div class="container mt-5">
                <!-- Boas-vindas Personalizadas -->
                <div class="alert alert-dark">
                    <h4>Bem-vindo, <?php echo htmlspecialchars($userinfo['full_name']); ?>!</h4>
                    <p>Estamos felizes em ver você. Aqui estão suas atividades recentes.</p>
                </div>

                <!-- Formulário de Afiliações para Usuários do Google -->
                <?php if ($showAffiliationsForm): ?>
                    <div class="alert alert-danger mt-4">
                        <h5>Complete suas informações</h5>
                        <form action="../includes/atualizar_afiliacoes.php" method="POST">
                            <div class="form-group">
                                <label for="afiliacoes">Escolha suas afiliações:</label><br>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Docente">
                                    <label class="form-check-label">Docente</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Discente">
                                    <label class="form-check-label">Discente</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Servidores Técnico-Administrativos">
                                    <label class="form-check-label">Servidores Técnico-Administrativos</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Estudante">
                                    <label class="form-check-label">Estudante</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Egresso">
                                    <label class="form-check-label">Egresso</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Salvar Afiliações</button>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Calendário de Eventos -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Calendário de Avaliações</h5>
                        <div id="calendar"></div>
                    </div>
                </div>

                <!-- Estatísticas de Uso -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Estatísticas de Relatórios</h5>
                        <p>Gráficos e tabelas:</p>
                        <!-- Gráficos podem ser implementados com uma biblioteca JavaScript como Chart.js -->
                    </div>
                </div>

                <!-- Ajuda e Suporte -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Ajuda e Suporte</h5>
                        <p>Precisa de ajuda? <a href="user_sidebar/ajuda.php">Clique aqui</a> para ver as FAQs ou entre em contato com o suporte.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('minimized');
            document.getElementById('content').classList.toggle('minimized');
            document.getElementById('navbar').classList.toggle('minimized');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+pPzJt8iRfZlfIY2C0BfTV5t5QCd5ETZjBJFH5PLGxEpVHviWh4y5qXHgG5ic8" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simple-calendar/1.4.4/simple-calendar.min.js"></script>
</body>
</html>
