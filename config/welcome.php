<?php
require_once 'config.php'; 

if (isset($_SESSION['user_token'])) {
    $sql = "SELECT user_type FROM users WHERE token ='{$_SESSION['user_token']}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $userinfo = mysqli_fetch_assoc($result);

        if ($userinfo['user_type'] == 'admin') {
            header("Location: ../public/admin_dashboard.php"); 
        } else {
            header("Location: ../public/user_dashboard.php"); 
        }

        exit();
    }
}

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $userinfo = [
        'email' => $google_account_info['email'],
        'first_name' => $google_account_info['givenName'],
        'last_name' => $google_account_info['familyName'],
        'gender' => $google_account_info['gender'],
        'full_name' => $google_account_info['name'],
        'picture' => $google_account_info['picture'],
        'verifiedEmail' => $google_account_info['verifiedEmail'],
        'token' => $google_account_info['id'],
    ];

    $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $userinfo = mysqli_fetch_assoc($result);
        $token = $userinfo['token'];
    } else {

        $sql = "INSERT INTO users (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token) VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $token = $userinfo['token'];
        } else {
            echo "Usuário não foi criado";
            die();
        }
    }

    $_SESSION['user_token'] = $token;

    if ($userinfo['user_type'] == 'admin') {
        header("Location: ../public/admin_dashboard.php"); 
        exit(); 
    } else {
        header("Location: ../public/user_dashboard.php"); 
        exit(); 
    }
}

header("Location: ../index.php"); 
exit();
