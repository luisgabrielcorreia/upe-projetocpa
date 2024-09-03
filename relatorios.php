<?php
require_once 'config/config.php';

if (isset($_SESSION['user_token'])) {
    $sql = "SELECT user_type FROM users WHERE token ='{$_SESSION['user_token']}'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $userinfo = mysqli_fetch_assoc($result);
        
        if ($userinfo['user_type'] == 'admin') {
            header("Location: public/admin_dashboard.php");
        } else {
            header("Location: public/user_dashboard.php");
        }
        
        exit(); 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sobre a Comissão Própria de Avaliação - UPE</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }
        body {
            display: flex;
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
            transition: width 0.3s, transform 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar.hidden-mobile {
            transform: translateX(-100%);
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
            width: 100%;
            justify-content: flex-start;
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
            margin-top: auto;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s, width 0.3s;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .content.minimized {
            margin-left: 80px;
            width: calc(100% - 80px);
        }
        .content-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            flex-wrap: wrap;
            width: 100%;
        }
        .content-container .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 900px;
            width: 100%;
        }
        .img-fluid {
            height: auto;
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            width: calc(100% - 250px);
            bottom: 0;
            left: 250px;
            transition: left 0.3s, width 0.3s;
        }
        footer.minimized {
            left: 80px;
            width: calc(100% - 80px);
        }
        .sidebar img {
            width: 80px;
            margin-bottom: 20px;
        }
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #343a40;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            z-index: 1100;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }
            .sidebar.visible {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            footer {
                left: 0;
                width: 100%;
            }
            .menu-toggle {
                display: block;
            }
            .content-container .container {
                padding: 15px;
            }
            .img-fluid {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <div class="sidebar" id="sidebar">
        <img src="imgs/upe.png" alt="logo-upe">
        <a href="index.php"><i class="bi bi-house-door"></i> <span>Inicio</span></a>
        <a href="sobre.php"><i class="bi bi-info-circle"></i> <span>Sobre</span></a>
        <a href="relatorios.php" class="active"><i class="bi bi-file-earmark-text"></i><span>Relatórios</span></a>
        <a href="documentos.php"><i class="bi bi-file-earmark"></i> <span>Documentos</span></a>
        <a href="contato.php"><i class="bi bi-envelope"></i> <span>Contato</span></a>
        <a href="<?php echo $client->createAuthUrl(); ?>"><i class="bi bi-google"></i> <span>Entrar com google</span></a>
        <a href="#" data-toggle="modal" data-target="#loginModal"><i class="bi bi-box-arrow-in-right"></i> <span>Login</span></a>
        <a href="#" data-toggle="modal" data-target="#registerModal"><i class="bi bi-person-plus"></i> <span>Registrar-se</span></a>
    </div>
    <div class="content" id="content">
    <div class="content-container">
        <div class="container">
            <h2 class="mb-4">Relatórios Passados:</h2>
            <div class="list-group">
                <a href="https://drive.google.com/uc?export=download&id=1N7yg4T2XRz0NJl4DcUl_DzRkDZ84clwu" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional da UPE - Triênio 2021-2023
                </a>
                <a href="https://drive.google.com/file/d/19IGHYbY1aUFjz8YuSUwxDxZ9PEYaiSqe/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional Base de Dados 2022
                </a>
                <a href="https://drive.google.com/file/d/1jAy9t09YKE_cI3SEbUB2DyHQ3w3Y8kmt/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional Base de Dados 2021
                </a>
                <a href="https://drive.google.com/file/d/1JXZlAbMr7ZFFyChGozI2ahFwqqm6z-en/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional da UPE - Triênio 2018-2020
                </a>
                <a href="https://drive.google.com/file/d/1nwzDJrxY2efZgSSWKoqFMQGix9KWJaMe/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional Base de Dados 2019
                </a>
                <a href="https://drive.google.com/file/d/1NP7hwpLFJAaiXUCZzOTYMLnoeWYOe9Fu/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional Base de Dados 2018
                </a>
                <a href="https://drive.google.com/file/d/1v4qJLcUm5Nop7MzqlrUbjMNd0Ovf9CSs/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional Base de Dados 2017
                </a>
                <a href="https://drive.google.com/file/d/1ucILmgsi6uPU9WcZIZf5KwQ3tj5fcS0d/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional Base de Dados 2016
                </a>
                <a href="https://drive.google.com/file/d/1_Df78YZFR9FnSZAYH5cb-Sft-h1LxLXb/view?usp=sharing" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-pdf me-3" style="font-size: 1.5rem; color: #ff0000;"></i> Relatório de Autoavaliação Institucional Base de Dados 2015
                </a>
            </div>
        </div>
    </div>
</div>


    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="config/login.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-dialog" style="color: #ff0000"><strong>Importante:</strong> Registre-se, preferencialmente, usando seu e-mail institucional.</p>
                    <form action="config/register.php" method="POST">
                        <div class="form-group">
                            <label for="full_name">Nome completo:</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="afiliacoes">Afiliações:</label><br>
                            <input type="checkbox" name="afiliacoes[]" value="Docente"> Docente<br>
                            <input type="checkbox" name="afiliacoes[]" value="Discente"> Discente<br>
                            <input type="checkbox" name="afiliacoes[]" value="Servidores Técnico-Administrativos"> Servidores Técnico-Administrativos<br>
                            <input type="checkbox" name="afiliacoes[]" value="Estudante"> Estudante<br>
                            <input type="checkbox" name="afiliacoes[]" value="Egresso"> Egresso<br>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('menuToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('visible');
            });

            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('minimized');
                document.getElementById('content').classList.toggle('minimized');
                document.getElementById('footer').classList.toggle('minimized');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
