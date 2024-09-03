<?php
require_once '../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT user_type, full_name FROM users WHERE token ='{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
    
    if ($userinfo['user_type'] != 'user' && $userinfo['user_type'] != 'admin') {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT respostas.id AS resposta_id, respostas.form_id, respostas.respostas, respostas.data_resposta, formulario.json_formulario
        FROM respostas
        INNER JOIN formulario ON respostas.form_id = formulario.id";
$result = $conn->query($sql);

$respostas = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formulario = json_decode($row['json_formulario'], true);
        
        $respostas_usuario = json_decode($row['respostas'], true);
        var_dump($respostas_usuario);
        
        $enunciados = [];
        foreach ($formulario as $pergunta) {
            $qid = $pergunta['qid'];
            $enunciados[$qid] = $pergunta['label'];
        }
    
        $respostas[] = array(
            'resposta_id' => $row['resposta_id'],
            'form_id' => $row['form_id'],
            'data_resposta' => $row['data_resposta'],
            'enunciados' => $enunciados,
            'respostas' => $respostas_usuario, 
        );
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Listar Respostas</title>
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
                        <a class="btn btn-primary" href="admin_visualizador.php">Voltar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h3>Respostas do Usuário:</h3>
        <br>
        <?php foreach ($respostas as $resposta): ?>
    <div>
        <?php foreach ($resposta['enunciados'] as $qid => $enunciado): ?>
            <div class='mb-3'>
                <label class='form-label'><?= htmlspecialchars($enunciado) ?></label>
                <?php
                if (array_key_exists($qid, $resposta['respostas'])) {
                    $resposta_usuario = $resposta['respostas'][$qid];
                    if (is_array($resposta_usuario)) {
                        foreach ($resposta_usuario as $elemento) {
                            echo "<input type='text' class='form-control' value='" . htmlspecialchars($elemento) . "' readonly>";
                        }
                    } else { 
                        echo "<input type='text' class='form-control' value='" . htmlspecialchars($resposta_usuario) . "' readonly>";
                    }
                } else {
                    echo "<input type='text' class='form-control' value='Resposta não encontrada' readonly>";
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
    </div>

    <script src="js/utilsEditor.js"></script>
</body>
</html>
