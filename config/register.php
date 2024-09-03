<?php
include 'config.php'; // Conexão com o banco de dados
session_start(); // Inicia a sessão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Criptografa a senha
    $token = bin2hex(random_bytes(16)); // Gera um token aleatório
    $afiliacoes = implode(',', $_POST['afiliacoes']); // Converte o array de afiliações em uma string separada por vírgulas

    // Verifica se o email já existe
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo "Email já cadastrado!";
    } else {
        // Insere novo usuário com as afiliações
        $query = $conn->prepare("INSERT INTO users (email, full_name, password, token, afiliacoes, login_method) VALUES (?, ?, ?, ?, ?, 'traditional')");
        $query->bind_param("sssss", $email, $fullName, $password, $token, $afiliacoes);
        if ($query->execute()) {
            // Define a sessão do usuário
            $_SESSION['user_token'] = $token;
            // Redireciona para o dashboard do usuário
            header("Location: ../public/user_dashboard.php");
            exit();
        } else {
            echo "Erro ao registrar usuário.";
        }
    }
}
?>