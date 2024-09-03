<?php
require_once '../config/config.php'; 

if (!isset($_SESSION['user_token']) || empty($_SESSION['user_token'])) {
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
    <title>Gerar Relatório</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Selecione um Formulário para Gerar Relatório</h2>
        <form action="../includes/gerar_relatorio.php" method="GET">
            <div class="form-group">
                <label for="formulario">Formulário:</label>
                <select class="form-control" name="formulario_id" id="formulario" required>
                    <?php while ($formulario = $result->fetch_assoc()): ?>
                        <option value="<?php echo $formulario['id']; ?>"><?php echo htmlspecialchars($formulario['nome_arquivo']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Gerar Relatório</button>
        </form>
    </div>
</body>
</html>
