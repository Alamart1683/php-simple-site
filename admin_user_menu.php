<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'sql.php';
require 'admin_user_menu.html';
require 'user.php';
echo '<br><p><HR WIDTH="100%" ALIGN="center" COLOR="2c75ff" SIZE="2">';
$user = new user();
$connection = new mysqli($host, $sql_admin, $sql_password, $database);
// Выбираем все значения из таблицы "users"
$result = mysqli_query($connection, "SELECT `login`, `role` FROM `users` WHERE `role` != 'admin'");
// Строим таблицу пользователей вида логин-роль
$data[] = mysqli_fetch_all($result);
    echo '<p>';
    echo '<center><font size="5" color="#3d3dd4" face="garamond">Пользователи:</font>';
    echo '<p>';
    echo '<center><table bgcolor = "White" border = 4 bordercolor = "#4169e1" width = 40% height = 20%>';
    echo '<tr>';
    echo '<td>'.'Логин'.'</td>';
    echo '<td>'.'Уровень доступа'.'</td>';
    echo '</tr>';
    echo '<tbody>';
    foreach ($data as $stuffs) {
        foreach ($stuffs as $stuff) {
            echo '<tr>';
            foreach ($stuff as $element) {
                if ($element == 'default')
                    echo '<td>'.'Пользователь'.'</td>';
                else
                    echo '<td>'.$element.'</td>';
            }
            echo '</tr>';
        }
    }
    echo '</tbody>';
    echo '</table></center>';
$connection->close();

// Добавляем меню удаления пользователей
require 'admin_user_menu_utility.html';
// Проверяем пользователя и удаляем его
if (isset($_GET['login'])) {
    // Проверка существования пользователя в базе данных
    if ($user->user_search($_GET['login'])) {
        if ($user->get_user_role($_GET['login']) == "admin") {
            echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Администратору запрещен суицид.</center>";
        }
        else {
            $user->delete_user($_GET['login']);
            echo'<meta http-equiv="refresh" content="0;admin_user_menu.php">';
        }
    }
    else {
        echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Введен несуществующий логин.</center>";
    }
}
echo '<br><HR WIDTH="100%" ALIGN="center" COLOR="2c75ff" SIZE="2">';
echo '<center><font size="3" color="#3d3dd4" face="garamond">All rights reserved (c) 2019';
?>