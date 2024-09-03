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
        <a href="relatorios.php"><i class="bi bi-file-earmark-text"></i><span>Relatórios</span></a>
        <a href="documentos.php"><i class="bi bi-file-earmark"></i> <span>Documentos</span></a>
        <a href="contato.php" class="active"><i class="bi bi-envelope"></i> <span>Contato</span></a>
        <a href="<?php echo $client->createAuthUrl(); ?>"><i class="bi bi-google"></i> <span>Entrar com google</span></a>
        <a href="#" data-toggle="modal" data-target="#loginModal"><i class="bi bi-box-arrow-in-right"></i> <span>Login</span></a>
        <a href="#" data-toggle="modal" data-target="#registerModal"><i class="bi bi-person-plus"></i> <span>Registrar-se</span></a>
    </div>
    <div class="content" id="content">
    <div class="content-container">
        <div class="container form-container">
            <h2 class="mb-4">Contato:</h2>
            <form action="#" method="POST" onsubmit="enviarEmail(); return false;">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="message" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            <br>
            <div class="contact-info mt-4">
                <h3 class="mb-3">Informações de Contato</h3>
                <p><i class="bi bi-telephone me-2" style="font-size: 1.2rem;"></i> +55 (81) 3183-4007</p>
                <p><i class="bi bi-envelope me-2" style="font-size: 1.2rem;"></i> cpa@upe.br</p>
                <p><i class="bi bi-clock me-2" style="font-size: 1.2rem;"></i> Atendimento ao público interno: das 9h às 12h - Segunda à Sexta-feira.</p>
                <p><i class="bi bi-geo-alt me-2" style="font-size: 1.2rem;"></i> Avenida Agamenon Magalhães, S/N - Santo Amaro - Recife - PE - 50100-010</p>
            </div>
        </div>
    </div>
</div>


    <!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="config/login.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registerModalLabel">Registro</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><strong>Importante:</strong> Registre-se, preferencialmente, usando seu e-mail institucional.</p>
                <form action="config/register.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="afiliacoes" class="form-label">Afiliações</label><br>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Docente">
                            <label class="form-check-label" for="afiliacao1">Docente</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Discente">
                            <label class="form-check-label" for="afiliacao2">Discente</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Servidores Técnico-Administrativos">
                            <label class="form-check-label" for="afiliacao3">Servidores Técnico-Administrativos</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Estudante">
                            <label class="form-check-label" for="afiliacao4">Estudante</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="afiliacoes[]" value="Egresso">
                            <label class="form-check-label" for="afiliacao5">Egresso</label>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </div>
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
