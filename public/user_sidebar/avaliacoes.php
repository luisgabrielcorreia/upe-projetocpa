<?php
require_once '../../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT user_type, full_name, id, afiliacoes FROM users WHERE token ='{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
    
    if ($userinfo['user_type'] != 'user') {
        header("Location: ../index.php");
        exit();
    }

    // Armazenar o ID do usuário na sessão
    $_SESSION['user_id'] = $userinfo['id'];
    $_SESSION['afiliacoes'] = $userinfo['afiliacoes'];
} else {
    header("Location: ../index.php");
    exit();
}

function isUserEligible($form_affiliations, $user_affiliations) {
    $form_affiliations = explode(',', $form_affiliations);
    $user_affiliations = explode(',', $user_affiliations);
    return count(array_intersect($form_affiliations, $user_affiliations)) > 0;
}

function isFrozen($fileName) {
    global $conn;
    $sql = "SELECT is_frozen FROM js_forms WHERE file_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $fileName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $isFrozen);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $isFrozen == 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Avaliações - User Dashboard</title>
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
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            margin-bottom: 20px;
        }
        .card .card-title {
            margin-bottom: 10px;
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
        .btn-disabled {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-disabled:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>CPA - UPE</h2>
        <a href="../user_dashboard.php"><i class="bi bi-house-door"></i> <span>Inicio</span></a>
        <a href="perfil.php"><i class="bi bi-person"></i> <span>Perfil</span></a>
        <a href="avaliacoes.php" class="active"><i class="bi bi-file-earmark-text"></i> <span>Avaliacoes</span></a>
        <a href="votacoes.php"><i class="bi bi-file-earmark-text"></i> <span>Votacoes</span></a>
        <a href="ajuda.php"><i class="bi bi-question-circle"></i> <span>Ajuda</span></a>
        <a href="notificacoes.php"><i class="bi bi-bell"></i> <span>Notificacoes</span></a>
        <a href="../logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
    </div>
    <div class="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary" id="toggleSidebar"><i class="bi bi-list"></i></button>
            </div>
        </nav>
        <div class="content-container">
            <div class="container mt-5">
                <h1 class="mb-4">Olá, <?php echo htmlspecialchars($userinfo['full_name']); ?>!</h1>

                <div class="row">
                    <h3 class="mb-3">Avaliações Disponíveis:</h3>
                    <?php
                    $sql = "SELECT id, nome_arquivo, json_formulario, disponivel, congelado, afiliacoes FROM formulario WHERE disponivel = 1";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Verifica se o usuário é elegível para ver o formulário
                            if (!isUserEligible($row['afiliacoes'], $_SESSION['afiliacoes'])) {
                                continue;
                            }

                            // Verifica se o usuário já respondeu ao formulário
                            $formulario_id = $row['id'];
                            $usuario_id = $_SESSION['user_id'];
                            $query = $conn->prepare("SELECT status FROM respostas WHERE user_id = ? AND form_id = ?");
                            $query->bind_param("ii", $usuario_id, $formulario_id);
                            $query->execute();
                            $resposta_result = $query->get_result();
                    
                            $status_resposta = null;
                            if ($resposta_result->num_rows > 0) {
                                $resposta_row = $resposta_result->fetch_assoc();
                                $status_resposta = $resposta_row['status'];
                            }
                    
                            ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['nome_arquivo']); ?></h5>
                                    <?php
                                        if ($row['congelado']) {
                                            echo "<button class='btn btn-info' disabled>Visualizar Avaliação</button> ";
                                            echo "<button class='btn btn-secondary' disabled>Responder Avaliação</button>";
                                        } elseif ($status_resposta === 'complete') {
                                            echo "<a href='../visualizador.php?id={$row['id']}' class='btn btn-primary'>Visualizar Repostas</a> ";
                                            echo "<button class='btn btn-secondary' disabled>Você já respondeu este formulário</button>";
                                        } elseif ($status_resposta === 'incomplete') {
                                            echo "<a href='../visualizador.php?id={$row['id']}' class='btn btn-primary'>Visualizar Avaliação</a> ";
                                            echo "<a href='../respondedor.php?id={$row['id']}' class='btn btn-secondary'>Continuar Respondendo</a>";
                                        } else {
                                            echo "<a href='../visualizador.php?id={$row['id']}' class='btn btn-primary'>Visualizar Avaliação</a> ";
                                            echo "<a href='../respondedor.php?id={$row['id']}' class='btn btn-secondary'>Responder Avaliação</a>";
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>Nenhuma avaliação disponível no momento.</p>";
                    }
                    
                    $conn->close();
                    ?>
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