<?php
require_once '../../config/config.php';

// Verificar se o ID da votação foi passado como parâmetro
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID da votação não especificado.";
    exit();
}

$votacao_id = $_GET['id'];

// Recuperar detalhes da votação
$sql = "SELECT titulo, descricao FROM votacoes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $votacao_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Votação não encontrada.";
    exit();
}

$votacao = $result->fetch_assoc();

// Recuperar opções de voto e contagem de votos
$sql = "SELECT opcao, COUNT(votos.id) AS votos_count
        FROM opcoes_voto
        LEFT JOIN votos ON opcoes_voto.id = votos.opcao_id
        WHERE opcoes_voto.votacao_id = ?
        GROUP BY opcoes_voto.id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $votacao_id);
$stmt->execute();
$opcoes_result = $stmt->get_result();

// Preparar dados para o gráfico
$opcoes = [];
$votos_counts = [];
while ($opcao = $opcoes_result->fetch_assoc()) {
    $opcoes[] = $opcao['opcao'];
    $votos_counts[] = $opcao['votos_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Votação</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2><?php echo htmlspecialchars($votacao['titulo']); ?></h2>
        <p><?php echo htmlspecialchars($votacao['descricao']); ?></p>
        
        <h4>Resultados:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Opção</th>
                    <th>Votos</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($opcoes); $i++): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($opcoes[$i]); ?></td>
                        <td><?php echo $votos_counts[$i]; ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <!-- Adicionar Canvas para o Gráfico -->
        <div class="mt-4">
            <h4>Gráfico de Resultados:</h4>
            <canvas id="votosChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        // Configuração do Gráfico
        var ctx = document.getElementById('votosChart').getContext('2d');
        var votosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($opcoes); ?>,
                datasets: [{
                    label: 'Número de Votos',
                    data: <?php echo json_encode($votos_counts); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
