<?php
require_once '../../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['update_profile'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $afiliacoes = $_POST['afiliacoes'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, afiliacoes = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $afiliacoes, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Informações atualizadas com sucesso!');</script>";
        echo "<script>window.location.href = 'perfil.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar as informações. Tente novamente.');</script>";
    }

    $stmt->close();
}

$sql = "SELECT id, email, first_name, last_name, gender, full_name, afiliacoes FROM users WHERE token = '{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $userinfo['id'];
} else {
    header("Location: ../index.php");
    exit();
}

function formatAffiliations($affiliations) {
    return $affiliations;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Perfil - User Dashboard</title>
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
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .profile-container p {
            width: 100%;
            margin-bottom: 10px;
            font-size: 16px;
            line-height: 1.5;
            display: flex;
            justify-content: space-between;
        }
        .profile-container p span {
            color: #6c757d;
        }
        .profile-container .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 2px solid #6c757d;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>CPA - UPE</h2>
        <a href="../user_dashboard.php"><i class="bi bi-house-door"></i> <span>Inicio</span></a>
        <a href="perfil.php" class="active"><i class="bi bi-person"></i> <span>Perfil</span></a>
        <a href="avaliacoes.php"><i class="bi bi-file-earmark-text"></i> <span>Avaliacoes</span></a>
        <a href="votacoes.php"><i class="bi bi-file-earmark-text"></i> <span>Votacoes</span></a>
        <a href="ajuda.php"><i class="bi bi-question-circle"></i> <span>Ajuda</span></a>
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
                <div class="profile-container">
                    <h2>Dados Pessoais</h2>
                    <p><strong>Nome Completo:</strong> <span><?php echo htmlspecialchars($userinfo['full_name']); ?></span></p>
                    <p><strong>Email:</strong> <span><?php echo htmlspecialchars($userinfo['email']); ?></span></p>
                    <p><strong>Senha:</strong> <span>*************</span></p>
                    <p><strong>Afiliacões:</strong> <span><?php echo htmlspecialchars($userinfo['afiliacoes']); ?></span></p>
                    <p>Necessita alterar alguma informacao? <strong><a href="#" id="editProfileBtn">Clique aqui</a></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="perfil.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Informações</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="full_name">Nome completo:</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($userinfo['full_name']); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userinfo['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" value="********" disabled>
                        </div>
                        <div class="form-group">
                            <label for="afiliacoes">Afiliações:</label>
                            <input type="text" class="form-control" id="afiliacoes" name="afiliacoes" value="<?php echo htmlspecialchars($userinfo['afiliacoes']); ?>" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" name="update_profile" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('minimized');
            document.getElementById('content').classList.toggle('minimized');
            document.getElementById('navbar').classList.toggle('minimized');
        });

        document.getElementById('editProfileBtn').addEventListener('click', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+pPzJt8iRfZlfIY2C0BfTV5t5QCd5ETZjBJFH5PLGxEpVHviWh4y5qXHgG5ic8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
