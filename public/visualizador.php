<?php
require_once '../config/config.php'; 

if (!isset($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT user_type, full_name, id as user_id FROM users WHERE token ='{$_SESSION['user_token']}'";
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

$user_id = $userinfo['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Inicializa as variáveis JavaScript como vazias
    echo "<script>let formulario = [];</script>";
    echo "<script>let respostas_usuario = {};</script>";

    // Tenta recuperar respostas completas do usuário
    $sql = "SELECT respostas FROM respostas WHERE form_id = ? AND user_id = ? AND status = 'complete'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $respostas_usuario = json_decode($row['respostas'], true);
        echo "<script>respostas_usuario = " . json_encode($respostas_usuario) . ";</script>";
    }

    // Carrega o formulário original
    $sql = "SELECT json_formulario FROM formulario WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $formulario = json_decode($row['json_formulario'], true);
        echo "<script>formulario = " . json_encode($formulario) . ";</script>";
    } else {
        echo "Formulário não encontrado.";
    }

    $stmt->close();
} else {
    echo "ID inválido.";
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
    <title>Visualizador de Formulário</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" id="pageTitle">Visualizador de Avaliações</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-primary" href="user_sidebar/avaliacoes.php">Voltar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="alertaVisualizacao" class="alerta-visualizacao">
        Você está no modo de visualização
    </div>
    <div class="container" id="formularioContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formularioContainer = document.getElementById('formularioContainer');
            let formHtml = '';

            if (Array.isArray(formulario) && formulario.length > 0) {
                formHtml = formulario.map(elem => {
                    const condicao = elem.condicao ? `data-condicao="${elem.condicao}"` : 'data-condicao="sempre"';
                    return createHtmlForElement(elem, condicao);
                }).join('');
            } else {
                console.error('Nenhum formulário foi encontrado no banco de dados.');
                formHtml = '<p>Nenhum formulário foi encontrado.</p>';
            }

            formularioContainer.innerHTML = formHtml;
            initializeConditionalLogic();
            loadAnswers();
        });

        function createHtmlForElement(elem, condicao) {
            let respostaUsuario = respostas_usuario[`${elem.qid}_${elem.questionVar}`] || '';

            if (typeof respostaUsuario === 'string') {
                respostaUsuario = [respostaUsuario];
            }

            switch (elem.type) {
                case "Section":
                    return `<div class="Secao_${elem.qid}" ${condicao}><h2>${elem.label}</h2></div>`;
                case 'Texto':
                    return `<div class="Frame FormItem Texto" ${condicao}>
                        <div class="Titulo Texto">${elem.label}</div>
                        <input type="text" class="inputData Texto" id="${elem.qid}" name="${elem.qid}_${elem.questionVar}" data-var="${elem.qid}_${elem.questionVar}" value="${respostaUsuario.join('')}" readonly>
                    </div>`;
                case 'MEscolha':
                    return `<div class="Frame FormItem MEscolha" ${condicao}>
                        <div class="Titulo MEscolha">${elem.label}</div>
                        <div class="inputData iMEscolha">
                            ${elem.opcoes.map((opcao, index) => `
                                <input type="checkbox" id="${elem.qid}_${index}" value="${opcao}" name="${elem.questionVar}[]" data-var="${elem.questionVar}" disabled checked>
                                <label for="${elem.qid}_${index}">${opcao}</label><br>
                            `).join('')}
                        </div>
                    </div>`;
                case 'Escolha2':
                    return `<div class="Frame FormItem MEscolha" ${condicao}>
                        <div class="Titulo MEscolha">${elem.label}</div>
                        <div class="inputData iMEscolha">
                            ${elem.opcoes.map((opcao, index) => `
                                <input type="radio" id="${elem.qid}_${index}" name="${elem.qid}_${elem.questionVar}" value="${opcao}" data-var="${elem.questionVar}" disabled>
                                <label for="${elem.qid}_${index}">${opcao}</label><br>
                            `).join('')}
                        </div>
                    </div>`;
                case 'Escolha1':
                    return `<div class="Frame FormItem Escolha1" ${condicao}>
                        <div class="Titulo Escolha1">${elem.label}</div>
                        <select class="inputData Escolha1" id="${elem.qid}" name="${elem.qid}_${elem.questionVar}" data-var="${elem.questionVar}" disabled>
                            ${elem.opcoes.map(opcao => `<option value="${opcao}">${opcao}</option>`).join('')}
                        </select>
                    </div>`;
                case 'Grade':
                    return `<div class="Frame FormItem Grade" ${condicao}>
                        <div class="Titulo Grade">${elem.label}</div>
                        <table border="" class="inputData iGrade" id="${elem.qid}_${elem.questionVar}" data-var="${elem.questionVar}">
                            <tbody>
                                <tr><td></td>${elem.opcoes.map(opcao => `<th>${opcao}</th>`).join('')}</tr>
                                ${elem.questoes.map((questao, indexQ) => `
                                    <tr>
                                        <th>${questao}</th>
                                        ${elem.opcoes.map((opcao, indexOp) => `
                                            <td>
                                                <input type="radio" id="${elem.qid}_${indexQ}_${indexOp}" name="${elem.qid}_${indexQ}_${elem.questionVar}" value="${opcao}" data-var="${elem.qid}_${elem.questionVar}" disabled>
                                            </td>
                                        `).join('')}
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>`;
                default:
                    return '';
            }
        }

        function loadAnswers() {
            console.log(respostas_usuario); // Adicionado para depuração
            if (respostas_usuario) {
                Object.keys(respostas_usuario).forEach(key => {
                    const inputs = document.querySelectorAll(`[name="${key}"]`);
                    if (inputs.length > 0) {
                        inputs.forEach(input => {
                            if (input.type === 'checkbox' || input.type === 'radio') {
                                if (Array.isArray(respostas_usuario[key])) {
                                    respostas_usuario[key].forEach(value => {
                                        if (input.value === value) {
                                            input.checked = true;
                                        }
                                    });
                                } else {
                                    if (input.value === respostas_usuario[key]) {
                                        input.checked = true;
                                    }
                                }
                            } else {
                                input.value = respostas_usuario[key];
                            }
                        });
                    }
                });
            }
        }

        function initializeConditionalLogic() {
            const inputs = document.querySelectorAll('.inputData');
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    checkConditions();
                });
            });

            checkConditions();
        }

        function checkConditions() {
            const elems = document.querySelectorAll('[data-condicao]');
            elems.forEach(elem => {
                const condition = elem.getAttribute('data-condicao');
                if (evaluateCondition(condition)) {
                    elem.style.display = 'block';
                } else {
                    elem.style.display = 'none';
                }
            });
        }

        function evaluateCondition(condition) {
            if (condition === 'sempre') return true;
            try {
                return new Function('getValue', `return ${condition};`)(getValue);
            } catch (e) {
                console.error("Erro ao avaliar a condição: ", condition, e);
                return false;
            }
        }

        function getValue(questionVar) {
            const inputs = document.querySelectorAll(`[data-var="${questionVar}"]`);
            if (inputs.length === 0) return null;

            const values = [];
            inputs.forEach(input => {
                if ((input.type === "checkbox" || input.type === "radio") && input.checked) {
                    values.push(input.value);
                } else if (input.type !== "checkbox" && input.type !== "radio") {
                    values.push(input.value);
                }
            });

            return values.length === 1 ? values[0] : values;
        }
    </script>
</body>
</html>
