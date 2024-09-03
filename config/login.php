<?php
include 'config.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica se o usuário existe e o método de login
    $query = $conn->prepare("SELECT * FROM users WHERE email = ? AND login_method = 'traditional'");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sessão ou retornar sucesso
        $_SESSION['user_token'] = $user['token'];
        if ($user['user_type'] == 'admin') {
            header("Location: ../public/admin_dashboard.php");
        } else {
            header("Location: ../public/user_dashboard.php");
        }
        exit();
    } else {
        // Email ou senha incorretos - exibe alerta e redireciona
        echo "<script>alert('Email ou senha incorretos.'); window.location.href='../index.php';</script>";
    }
}
?>
