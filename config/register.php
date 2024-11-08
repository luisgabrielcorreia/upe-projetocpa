<?php
include 'config.php'; // Conexão com o banco de dados

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Criptografa a senha
    $token = bin2hex(random_bytes(16)); // Gera um token aleatório

    // Verifica se o campo afiliações foi enviado e retorna erro se estiver vazio
    if (empty($_POST['afiliacoes'])) {
        echo json_encode(["status" => "error", "message" => "Por favor, selecione pelo menos uma afiliação."]);
        exit();
    }

    // Converte as afiliações em uma string separada por vírgulas
    $afiliacoes = implode(',', $_POST['afiliacoes']);

    // Verifica se o email já existe
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Erro: Email já cadastrado!"]);
    } else {
        // Insere novo usuário com as afiliações
        $query = $conn->prepare("INSERT INTO users (email, full_name, password, token, afiliacoes, login_method) VALUES (?, ?, ?, ?, ?, 'traditional')");
        $query->bind_param("sssss", $email, $fullName, $password, $token, $afiliacoes);
        if ($query->execute()) {
            // Define a sessão do usuário
            $_SESSION['user_token'] = $token;
            // Retorna sucesso
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao registrar usuário."]);
        }
    }
}
?>
