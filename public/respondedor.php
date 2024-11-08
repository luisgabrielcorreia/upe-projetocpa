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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Primeiro tenta recuperar respostas incompletas
    $sql = "SELECT respostas FROM respostas WHERE form_id = ? AND user_id = ? AND status = 'incomplete'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $respostas_salvas = json_decode($row['respostas'], true);
        echo "<script>const respostas_salvas = " . json_encode($respostas_salvas) . ";</script>";
    } else {
        // Se não encontrar respostas incompletas, carrega o formulário original
        $sql = "SELECT json_formulario FROM formulario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $formulario = json_decode($row['json_formulario'], true);
            echo "<script>const formulario = " . json_encode($formulario) . ";</script>";
        } else {
            echo "Formulário não encontrado.";
        }
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <title>Respondedor de Avaliações</title>
    <style>
        .form-footer {
            display: flex;
            justify-content: center; 
            margin-top: 20px; 
            margin-bottom: 20px; 
        }
        header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 20px 0;
            margin-top: 56px;
        }
        header .container {
            text-align: center;
        }
        header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        header p {
            font-size: 1.2rem;
            color: #6c757d;
        }
        header a {
            color: #007bff;
        }
        .Explicacao {
            font-size: 0.9rem;
            color: #ff0000; /* Azul padrão do Bootstrap */
            margin-top: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" id="pageTitle">Respondedor de Avaliações</a>
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
    <form id="formulario" method="post" action="../includes/salvar_respostas.php">
        <div class="container" id="formularioContainer">
            <!-- Conteúdo do formulario -->
        </div>
        <input type="hidden" id="formId" name="formId" value="<?php echo $id; ?>">
        <div class="form-footer">
            <button type="submit" class="btn btn-primary">Enviar Respostas</button>
        </div>
    </form>

    <script src="js/utilsEditor.js"></script>
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const formularioContainer = document.getElementById('formularioContainer');
    if (formulario) {
        const formHtml = formulario.map(elem => {
            const comentario = elem.explicacao ? `<div class="Explicacao"><i>${elem.explicacao}</i></div>` : "";
            const condicao = elem.condicao ? `data-condicao="${elem.condicao}"` : 'data-condicao="sempre"';
            switch (elem.type) {
                case "Section":
                    return `<div class="Secao_${elem.qid}" ${condicao}><h2>${elem.label}</h2>${comentario}</div>`;
                case 'Texto':
                    return `<div class="Frame FormItem Texto" ${condicao}>
                        <div class="Titulo Texto">${elem.label}</div>
                         ${comentario}
                        <input type="text" class="inputData Texto" id="${elem.qid}" name="${elem.qid}_${elem.questionVar}" data-var="${elem.qid}_${elem.questionVar}">
                    </div>`;
                case 'MEscolha':
                    return `<div class="Frame FormItem MEscolha" ${condicao}>
                        <div class="Titulo MEscolha">${elem.label}</div>
                         ${comentario}
                        <div class="inputData iMEscolha">
                            ${elem.opcoes.map((opcao, index) => `
                                <input type="checkbox" id="${elem.qid}_${index}" value="${opcao}" name="${elem.questionVar}[]" data-var="${elem.questionVar}">
                                <label for="${elem.qid}_${index}">${opcao}</label><br>
                            `).join('')}
                        </div>
                    </div>`;
                case 'Escolha2':
                    return `<div class="Frame FormItem MEscolha" ${condicao}>
                        <div class="Titulo MEscolha">${elem.label}</div>
                         ${comentario}
                        <div class="inputData iMEscolha">
                            ${elem.opcoes.map((opcao, index) => `
                                <input type="radio" id="${elem.qid}_${index}" name="${elem.qid}_${elem.questionVar}" value="${opcao}" data-var="${elem.questionVar}">
                                <label for="${elem.qid}_${index}">${opcao}</label><br>
                            `).join('')}
                        </div>
                    </div>`;
                case 'Escolha1':
                    return `<div class="Frame FormItem Escolha1" ${condicao}>
                        <div class="Titulo Escolha1">${elem.label}</div>
                         ${comentario}
                        <select class="inputData Escolha1" id="${elem.qid}" name="${elem.qid}_${elem.questionVar}" data-var="${elem.questionVar}">
                            ${elem.opcoes.map(opcao => `<option value="${opcao}">${opcao}</option>`).join('')}
                        </select>
                    </div>`;
                case 'Grade':
                    return `<div class="Frame FormItem Grade" ${condicao}>
                        <div class="Titulo Grade">${elem.label}</div>
                         ${comentario}
                        <table border="" class="inputData iGrade" id="${elem.qid}_${elem.questionVar}" data-var="${elem.questionVar}">
                            <tbody>
                                <tr><td></td>${elem.opcoes.map(opcao => `<th>${opcao}</th>`).join('')}</tr>
                                ${elem.questoes.map((questao, indexQ) => `
                                    <tr>
                                        <th>${questao}</th>
                                        ${elem.opcoes.map((opcao, indexOp) => `
                                            <td>
                                                <input type="radio" id="${elem.qid}_${indexQ}_${indexOp}" name="${elem.qid}_${indexQ}_${elem.questionVar}" value="${opcao}" data-var="${elem.qid}_${elem.questionVar}">
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
        }).join('');
        formularioContainer.innerHTML += formHtml;
        initializeConditionalLogic();
    } else {
        console.error('Nenhum formulário foi encontrado no banco de dados.');
        formularioContainer.innerHTML = '<p>Nenhum formulário foi encontrado.</p>';
    }
});

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

    <script>
        const form = document.getElementById('formulario');
        let formSubmitted = false;

// Função para salvar as respostas no localStorage
function saveAnswers(autoSave = true) {
        if (formSubmitted) return;  // Pula o auto-save se o formulário foi enviado

        const formData = new FormData(form);
        const answers = {};

        formData.forEach((value, key) => {
            if (answers[key]) {
                if (Array.isArray(answers[key])) {
                    answers[key].push(value);
                } else {
                    answers[key] = [answers[key], value];
                }
            } else {
                answers[key] = value;
            }
        });

    localStorage.setItem('formAnswers', JSON.stringify(answers));

    // Envia as respostas para o servidor
    fetch('teste.php', {
            method: 'POST',
            body: JSON.stringify({
                form_id: <?php echo $id; ?>, // ID do formulário passado do PHP
                respostas: answers,
                user_id: <?php echo $_SESSION['user_id']; ?>, // Supondo que o ID do usuário está na sessão
                auto_save: autoSave
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log('Respostas auto-salvas no servidor');
            } else {
                console.error('Erro ao salvar respostas:', data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao salvar as respostas automaticamente:', error);
        });
}

// Salva as respostas a cada 10 segundos
setInterval(saveAnswers, 10000);

// Salva as respostas antes de sair da página
window.addEventListener('beforeunload', saveAnswers);;

// Função para carregar as respostas do localStorage
function loadAnswers() {
        const savedAnswers = JSON.parse(localStorage.getItem('formAnswers'));
        if (savedAnswers) {
            Object.keys(savedAnswers).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        if (Array.isArray(savedAnswers[key])) {
                            savedAnswers[key].forEach(value => {
                                const checkbox = form.querySelector(`[name="${key}"][value="${value}"]`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }
                            });
                        } else {
                            const radio = form.querySelector(`[name="${key}"][value="${savedAnswers[key]}"]`);
                            if (radio) {
                                radio.checked = true;
                            }
                        }
                    } else {
                        input.value = savedAnswers[key];
                    }
                }
            });
    }
}
// Carrega as respostas quando a página é carregada
window.onload = loadAnswers;


// Event listener para salvar as respostas ao enviar o formulário
form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (confirm("Você deseja realmente enviar as respostas?")) {
        formSubmitted = true; // Marca o formulário como enviado
        const formData = new FormData(form);

        fetch('../includes/salvar_respostas.php', { // Certifique-se de que o caminho do arquivo PHP está correto
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            alert("Respostas enviadas com sucesso!");
            localStorage.removeItem('formAnswers');  // Remove respostas salvas após envio bem-sucedido
            window.location.href = 'user_dashboard.php';
        })
        .catch(error => {
            console.error('Erro ao enviar as respostas:', error);
            alert("Erro ao enviar as respostas. Tente novamente!");
        });
    } else {
        console.log("Envio cancelado pelo usuário.");
    }
});
    </script>
</body>
</html>
