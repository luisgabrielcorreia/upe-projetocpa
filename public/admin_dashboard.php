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
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Admin Dashboard</title>
    <style>
        .action-btns button,
        .action-btns a {
            margin-right: 5px; /* Adiciona espaço à direita de cada botão */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Comissão Própria de Avaliação</a>
            <a href="../public/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Bem-vindo à dashboard de Administrador, <?php echo $userinfo['full_name']; ?>!</h2>
        <div class="card mt-4">
            <a href="editor.php" class="btn btn-success">Criar Avaliação</a>
            <br>
            <a href="votacoes/admin_votacoes.php" class="btn btn-success">Criar Votacao</a>
            <br>
            <a href="admin_visualizador.php" class="btn btn-primary">Gerenciar Respostas</a>
            <br>
            <a href="gerador_relatorios.php" class="btn btn-secondary">Gerador de Relatórios</a>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Gerenciador de Avaliações
            </div>
            <div class="card-body">
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="file" class="form-label">Selecione um arquivo JavaScript:</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".js">
                </div>
                <button type="button" class="btn btn-primary" id="uploadBtn">Enviar Avaliação</button>
            </form>

                <hr>

                <h5>Avaliações no Servidor:</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome da Avaliação</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id, nome_arquivo, disponivel, congelado FROM formulario";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['nome_arquivo']}</td>"; 
                                echo "<td class='status'>";
                                echo $row['congelado'] ? "Congelado" : "Descongelado";
                                echo "</td>";
                                echo "<td class='action-btns'>";
                                if ($row['disponivel']) {
                                    echo "<button class='btn btn-dark toggle-availability' data-id='{$row['id']}' data-disponivel='0' data-bs-toggle='modal' data-bs-target='#disponibilizarModal'>Disponibilizar</button>";
                                }

                                $toggleText = $row['congelado'] ? 'Descongelar' : 'Congelar';
                                $toggleValue = $row['congelado'] ? 0 : 1;

                                echo "<button class='btn btn-secondary toggle-freeze' data-id='{$row['id']}' data-congelado='{$row['congelado']}'>{$toggleText}</button>";
                                echo "<a href='visualizador.php?id={$row['id']}' class='btn btn-info'>Visualizar</a>";
                                echo "<a href='editor.php?id={$row['id']}' class='btn btn-warning'>Editar</a>";
                                echo "<a href='#' class='btn btn-danger delete-btn' data-id='{$row['id']}' data-toggle='modal' data-target='#confirmDeleteModal'>Excluir</a>";
                                echo "<a href='../includes/download.php?id={$row['id']}' class='btn btn-primary'>Download</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum formulário encontrado.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disponibilizarModal" tabindex="-1" aria-labelledby="disponibilizarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disponibilizarModalLabel">Disponibilizar Formulário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="disponibilizarForm" action="toggle_availability.php" method="POST">
                        <input type="hidden" name="form_id" id="form_id">
                        <div class="form-group">
                            <label for="afiliacoes">Disponibilizar para as seguintes afiliações:</label><br>
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
                        <button type="submit" class="btn btn-primary">Disponibilizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

    function viewForm(formId) {
        window.location.href = `visualizador.php?id=${formId}`;
    }
    </script>
    
    <script>
        $(document).ready(function() {
            $('.toggle-availability').on('click', function() {
                var button = $(this);
                var id = button.data('id');
                var formInput = $('#disponibilizarModal').find('#form_id');
                formInput.val(id);
            });

            $('#disponibilizarForm').on('submit', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../includes/toggle_availability.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            $('#disponibilizarModal').modal('hide');
                            location.reload();
                        } else {
                            alert('Erro: ' + data.message);
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.toggle-freeze').on('click', function() {
                var button = $(this);
                var id = button.data('id');
                var congelado = button.data('congelado');

                $.ajax({
                    url: '../includes/toggle_freeze.php',
                    type: 'POST',
                    data: {
                        id: id,
                        congelado: congelado
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            if (congelado == 1) {
                                button.text('Congelar');
                                button.data('congelado', 0);
                            } else {
                                button.text('Descongelar');
                                button.data('congelado', 1);
                            }

                            var newStatus = data.new_congelado ? "Congelado" : "Descongelado";
                            button.closest('tr').find('.status').text(newStatus);
                        } else {
                            alert('Erro: ' + data.message);
                        }
                    }
                });
            });
        });

        
    </script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var id = $(this).data('id');
                var confirmDelete = confirm("Tem certeza de que deseja excluir este formulário?");
                if (confirmDelete) {
                    $.ajax({
                        url: '../includes/excluir.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            console.log(response);
                            var data = JSON.parse(response);
                            if (data.success) {
                                $(this).closest('tr').remove();
                            } else {
                                alert('Erro ao excluir o formulário: ' + data.message);
                            }
                        }.bind(this)
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#uploadBtn').on('click', function(event) {
                event.preventDefault(); 
                var form = $('#uploadForm')[0];
                var formData = new FormData(form);

                $.ajax({
                    url: '../includes/upload.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            alert('Avaliação enviada com sucesso.');
                            form.reset();
                        } else {
                            alert('Erro ao enviar a avaliação: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Erro ao enviar a requisição.');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
    