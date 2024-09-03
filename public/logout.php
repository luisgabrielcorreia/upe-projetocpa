<?php

session_start();
unset($_SESSION['user_token']);
header("Location: ../index.php");
session_destroy();
