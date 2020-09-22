<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require "reg.html";
require "user.php";
$user = new user();

// Процесс регистрации
if (isset($_GET['login'])) {
    if (strlen($_GET['login']) > 4) {
        // Проверка присутствия введенного имени в базе данных
        if ($user->user_exists($_GET['login'])) {
            echo "<br><div style=\"font:bold 14px Arial; color:red;\">Пользователь с таким именем уже зарегистрирован. ";
        }
        else {
            // Проверка совпадения введенных паролей
            if ($_GET['password'] == $_GET['password2']) {
                if (preg_match('/^[a-z0-9а-яё .\-_@]+$/iu', $_GET['login']) and preg_match('/^[a-z0-9а-яё .\-_@]+$/iu', $_GET['password']) and strlen( $_GET['password'] > 8)) {
                    if (preg_match('/[a-zа-я]/iu', $_GET['password']) and preg_match('/[0-9]/', $_GET['password'])) {
                        // Занесение нового пользователя в базу данных
                        $user->register_user($_GET['login'], $_GET['password']);
                        echo "<br><div style=\"font:bold 14px Arial; color:#228b22;\">Регистрация произошла успешно. ";
                    }
                    else {
                        echo "<br><div style=\"bold 14px garamond; color:#b00000;\">Малонадежный пароль - используйте пароль, "
                        . "длиной 8-20 символов содержащий хотя бы одну букву, хотя бы одну цифру.";
                    }
                }
                else {
                    echo "<br><div style=\"font:bold 14px garamond; color:#b00000;\">Были использованы некорректные символы. ";
                }
            }
            else {
               echo "<br><div style=\"font:bold 14px garamond; color:#b00000;\">Введенные пароли не совпадают. ";
            }
        }
    }
    else {
        echo "<br><div style=\"font:bold 14px garamond; color:#b00000;\">Логин должен быть длиннее 4 символов. ";
    }
   }
?>
<html>
    <head></head>
    <body><br><br><img src="Lavender.jpg"></body>
</html>

