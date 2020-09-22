<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require 'auth.html';
    require 'user.php';
    $user = new user();
    
    // Выход из системы если уже был произведен вход
    if (isset($_SESSION['login'])) {
        $content = $content."<p>Произведен выход из системы.</p>";
        unset($_SESSION['login']);
    }
    
    // Вход в систему
    if (isset($_GET['login'])) {
        // Проверка существования пользователя в базе данных
        if ($user->user_valid($_GET['login'], $_GET['password'])) {
            $_SESSION['login'] = $_GET['login'];
            if ($user->get_user_role($_GET['login']) == "admin") {
                header("Location: admin_info_menu.html");
            }
            else {
               header("Location: default_info_menu.html");
            }
        }
        else {
             echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Введен неправильный логин или пароль.</center>";
        }
    }
?>
<html>
    <head></head>
    <body><br><img src="Lavender.jpg"></body>
</html>

