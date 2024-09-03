<?php
require_once '../config/config.php'; 

if (!isset($_GET['formulario_id'])) {
    echo "Formulário não especificado.";
    exit();
}

$formulario_id = $_GET['formulario_id'];

// Selecionar respostas do formulário específico
$sql = "SELECT respostas FROM respostas WHERE form_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $formulario_id);
$stmt->execute();
$result = $stmt->get_result();

$respostas_array = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $respostas_array[] = json_decode($row['respostas'], true);
    }
}

// Processar os dados das respostas
$contagens = []; // Array para armazenar contagens de respostas
foreach ($respostas_array as $resposta) {
    foreach ($resposta as $pergunta => $resposta_valor) {
        if (!isset($contagens[$pergunta])) {
            $contagens[$pergunta] = [];
        }
        if (!isset($contagens[$pergunta][$resposta_valor])) {
            $contagens[$pergunta][$resposta_valor] = 0;
        }
        $contagens[$pergunta][$resposta_valor]++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Respostas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Relatório de Respostas</h2>

        <?php foreach ($contagens as $pergunta => $opcoes): ?>
            <h4><?php echo htmlspecialchars($pergunta); ?></h4>
            <canvas id="<?php echo 'chart_' . $pergunta; ?>" width="400" height="200"></canvas>
            <script>
                var ctx = document.getElementById('<?php echo 'chart_' . $pergunta; ?>').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode(array_keys($opcoes)); ?>,
                        datasets: [{
                            label: 'Número de Respostas',
                            data: <?php echo json_encode(array_values($opcoes)); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        <?php endforeach; ?>
    </div>
</body>
</html>
