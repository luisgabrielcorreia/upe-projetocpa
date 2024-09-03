<?php
require_once '../../config/config.php';

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT full_name FROM users WHERE token = '{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
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
    <title>Ajuda - User Dashboard</title>
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
        .help-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .help-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .help-container p, .help-container li {
            color: #6c757d;
            font-size: 16px;
            line-height: 1.5;
        }
        .help-container ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>CPA - UPE</h2>
        <a href="../user_dashboard.php"><i class="bi bi-house-door"></i> <span>Inicio</span></a>
        <a href="perfil.php"><i class="bi bi-person"></i> <span>Perfil</span></a>
        <a href="avaliacoes.php"><i class="bi bi-file-earmark-text"></i> <span>Avaliacoes</span></a>
        <a href="votacoes.php"><i class="bi bi-file-earmark-text"></i> <span>Votacoes</span></a>
        <a href="ajuda.php" class="active"><i class="bi bi-question-circle"></i> <span>Ajuda</span></a>
        <a href="notificacoes.php"><i class="bi bi-bell"></i> <span>Notificacoes</span></a>
        <a href="../logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
    </div>
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary" id="toggleSidebar"><i class="bi bi-list"></i></button>
            </div>
        </nav>
        <div class="content-container">
            <div class="container mt-5">
                <div class="help-container">
                    <h2>Ajuda e Suporte</h2>
                    <p>Bem-vindo à seção de ajuda! Aqui você encontra respostas para as perguntas mais frequentes e informações sobre como obter suporte.</p>
                    
                    <h4>Perguntas Frequentes (FAQ)</h4>
                    <ul>
                        <li><strong>Como faço para alterar minha senha?</strong>
                            <p>Para alterar sua senha, entre em contato via e-mail cpa@upe.br.</p>
                        </li>
                        <li><strong>Como posso atualizar minhas informações de perfil?</strong>
                            <p>Você pode atualizar suas informações de perfil na seção de perfil. Clique em "Editar Perfil" para fazer as alterações necessárias.</p>
                        </li>
                        <li><strong>O que faço se esquecer minha senha?</strong>
                            <p>Se você esquecer sua senha, entre em contato via e-mail cpa@upe.br.</p>
                        </li>
                    </ul>
                    
                    <h4>Contato para Suporte</h4>
                    <p>Se você precisar de assistência adicional, entre em contato com nosso suporte:</p>
                    <ul>
                        <li>Email: cpa@upe.br</li>
                        <li>Telefone: (81) 3183-4007</li>
                    </ul>
                    
                    <h4>Links Úteis</h4>
                    <ul>
                        <li><a href="#">Guia do Usuário</a></li>
                        <li><a href="#">Termos de Serviço</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                    </ul>
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
</body>
</html>
