<?php
require_once '../config/config.php';
require '../vendor/autoload.php'; // Carregar o autoload do Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;

// Verificar se o ID do formulário foi passado como parâmetro
if (!isset($_GET['form_id']) || empty($_GET['form_id'])) {
    die("ID do formulário não especificado.");
}

$form_id = $_GET['form_id'];

// Recuperar as respostas do formulário
$sql = "SELECT respostas FROM respostas WHERE form_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Nenhuma resposta encontrada para o formulário especificado.");
}

// Criar uma nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('AnaliseRespostas');

// Agregar dados para análise
$analysisData = [];
while ($resposta = $result->fetch_assoc()) {
    $respostas = json_decode($resposta['respostas'], true);
    foreach ($respostas as $pergunta => $resposta_valor) {
        // Certifique-se de que $pergunta e $resposta_valor são strings
        $pergunta = (string) $pergunta;
        // Verifica se $resposta_valor é um array, e converte para string se necessário
        $resposta_valor = is_array($resposta_valor) ? implode(', ', $resposta_valor) : (string) $resposta_valor;
    
        if (strpos($pergunta, 'QDiscursiva') === false) {
            if (!isset($analysisData[$pergunta])) {
                $analysisData[$pergunta] = [];
            }
            if (!isset($analysisData[$pergunta][$resposta_valor])) {
                $analysisData[$pergunta][$resposta_valor] = 0;
            }
            $analysisData[$pergunta][$resposta_valor]++;
        }
    }
}

// Preencher a aba de análise com dados agregados
$row = 1;
foreach ($analysisData as $pergunta => $respostas) {
    $sheet->setCellValue("A$row", $pergunta);
    $col = 'B';
    foreach ($respostas as $resposta_valor => $count) {
        $sheet->setCellValue("$col$row", $resposta_valor);
        $sheet->setCellValue($col . ($row + 1), $count);
        $col++;
    }
    $row += 3;
}

// Criar gráficos para cada pergunta de escolha única/múltipla
$chartIndex = 0;
foreach ($analysisData as $pergunta => $respostas) {
    $categories = [];
    $values = [];
    
    // Cria arrays de categorias e valores de respostas
    foreach ($respostas as $resposta_valor => $count) {
        $categories[] = new DataSeriesValues('String', 'AnaliseRespostas!$B$' . ($chartIndex * 3 + 1) . ':$' . $col . '$' . ($chartIndex * 3 + 1), null, count($respostas));
        $values[] = new DataSeriesValues('Number', 'AnaliseRespostas!$B$' . ($chartIndex * 3 + 2) . ':$' . $col . '$' . ($chartIndex * 3 + 2), null, count($respostas));
    }

    $dataSeries = new DataSeries(
        DataSeries::TYPE_PIECHART,
        null,
        range(0, count($values) - 1),
        [],
        $categories,
        $values
    );

    $plotArea = new PlotArea(null, [$dataSeries]);
    $chartTitle = new Title($pergunta);
    $chart = new Chart('chart' . $chartIndex, $chartTitle, new Legend(), $plotArea);

    $chart->setTopLeftPosition('K' . ($chartIndex * 15 + 1));
    $chart->setBottomRightPosition('P' . ($chartIndex * 15 + 15));
    $sheet->addChart($chart);

    $chartIndex++;
}

// Adicionar uma aba para cada resposta individual
$resposta_num = 1;
foreach ($result as $resposta) {
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle("Resposta$resposta_num");

    $respostas = json_decode($resposta['respostas'], true);

    $sheet->setCellValue('A1', 'ID da Pergunta');
    $sheet->setCellValue('B1', 'Resposta');

    $row = 2;
    foreach ($respostas as $pergunta => $resposta_valor) {
        $pergunta = (string) $pergunta;
        $resposta_valor = is_array($resposta_valor) ? implode(', ', $resposta_valor) : (string) $resposta_valor;

        $sheet->setCellValue("A$row", $pergunta);
        $sheet->setCellValue("B$row", $resposta_valor);
        $row++;
    }

    $resposta_num++;
}

// Configurar cabeçalhos para download
$filename = "relatorio_formulario_$form_id.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Criar o escritor do Excel e salvar o arquivo com gráficos
$writer = new Xlsx($spreadsheet);
$writer->setIncludeCharts(true);
$writer->save('php://output');
exit();
?>
