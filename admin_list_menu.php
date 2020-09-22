<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require 'admin_list_menu.html';
    require 'sql.php';
    require 'stuff.php';
    $worker = new stuff();
    $connection = new mysqli($host, $sql_admin, $sql_password, $database);
    // Выбираем все значения из таблицы "stuff"
    $result = mysqli_query($connection, "SELECT * FROM `stuff`");
    $data[] = mysqli_fetch_all($result);
    echo '<br><p><HR WIDTH="100%" ALIGN="center" COLOR="2c75ff" SIZE="2">';
    echo '<p>';
    echo '<center><font size="5" color="#3d3dd4" face="garamond">Сотрудники:</font>';
    echo '<p>';
    echo '<center><table bgcolor = "White" border = 4 bordercolor = "#4169e1"  width = 60% height = 30%>';
    echo '<tr>';
    echo '<td>'.'ID'.'</td>';
    echo '<td>'.'Имя'.'</td>';
    echo '<td>'.'Фамилия'.'</td>';
    echo '<td>'.'Дата рождения'.'</td>';
    echo '<td>'.'Зарплата, рубли'.'</td>';
    echo '<td>'.'Рабочая неделя, часы'.'</td>';
    echo '<td>'.'Должность'.'</td>';
    echo '</tr>';
    echo '<tbody>';
    foreach ($data as $stuffs) {
        foreach ($stuffs as $stuff) {
            echo '<tr>';
            foreach ($stuff as $element) {
                echo '<td>'.$element.'</td>';
            }
            echo '</tr>';
        }
    }
    echo '</tbody>';
    echo '</table></center>';
    $connection->close();
    require 'admin_list_menu_utility.html';
    // Проверяем пользователя и удаляем его
    if (isset($_GET['id1'])) {
        if ($_GET['delete'] == "Удалить сотрудника") {
            $id = $_GET['id1'];
            // Проверка существования пользователя в базе данных
            if ($worker->id_search($id)) {
                $worker->stuff_delete($id);
                echo'<meta http-equiv="refresh" content="0;admin_list_menu.php">';
            }
            else {
                echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Введен id несуществующего сотрудника.</center>";
            }
        }
    }
    // Проверяем данные и обновляем пользователя
    if (isset($_GET['id2']) && isset($_GET['atributes']) && isset($_GET['value'])) {
        if ($_GET['update'] == "Изменить сотрудника")
            $id = $_GET['id2'];
            $value = $_GET['value'];
            $atribute = $_GET['atributes'];
            // Обновление зарплаты
            if ($atribute == "Зарплата") {
                if (preg_match("/^[0-9]{1,10}$/", $value)) {
                    if ($value > 0) {
                        if ($worker->id_search($id)) {
                            $worker->update_stuff($id, $atribute, $value);
                            echo'<meta http-equiv="refresh" content="0;admin_list_menu.php">';
                        }
                        else {
                            echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Введен id несуществующего сотрудника.</center>";
                        }
                    }
                    else {
                         echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Введено отрицательное число.</center>";
                    }
                }
                else 
                {
                    echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Зарплата должна являться числом.</center>";
                }
            }
            // Обновление рабочей недели
            else if ($atribute == "Рабочая неделя") {
                if (preg_match("/^[0-9]{1,2}$/", $value)) {
                    if ($value > 0 && $value < 61) {
                        if ($worker->id_search($id)) {
                            $worker->update_stuff($id, $atribute, $value);
                            echo'<meta http-equiv="refresh" content="0;admin_list_menu.php">';
                        }
                        else {
                            echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Введен id несуществующего сотрудника.</center>";
                        }
                    }
                    else {
                         echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Рабочая неделя находится в интервале от 1 до 60 часов.</center>";
                    }
                }
                else 
                {
                    echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Рабочая неделя является числом часов.</center>";
                }
            }
            // Обновление должности
            else if ($atribute == "Должность") {
                if (preg_match('/[А-Яа-я]/', $value)) {
                    if (strlen($value) > 5) {
                        $worker->update_stuff($id, $atribute, $value);
                        echo'<meta http-equiv="refresh" content="0;admin_list_menu.php">';
                    }
                    else {
                        echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Длина не должна быть меньше 6 символов.</center>";
                    }
                }
                else {
                    echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Введены недопустимые символы.</center>";
                }
            }
            else {
                echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Не все поля заполнены корректно.</center>";
            }
    }
    // Подключение меню добавления сотрудника
    require 'admin_list_menu_new_stuff.html';
    if (isset($_GET['name']) && isset($_GET['surname'])&& isset($_GET['date']) && isset($_GET['wage'])&& isset($_GET['workweek']) && isset($_GET['post'])) {
        if ($_GET['add'] == "Добавить сотрудника") {
            $name = $_GET['name']; $surname = $_GET['surname'];
            $date = $_GET['date']; $wage = $_GET['wage'];
            $workweek = $_GET['workweek']; $post = $_GET['post'];
            // Проверка корректности переменных
            if ((preg_match('/[А-Яа-я]{3,20}/', $name)) && preg_match('/[А-Яа-я]{1,20}/', $surname) &&
            $worker->data_controller($date) && ((preg_match("/^[0-9]{1,20}$/", $wage)) && $wage > 0) &&
                    (preg_match("/^[0-9]{1,2}$/", $workweek) && ($workweek > 0 && $workweek < 61)) && 
                    (preg_match('/[А-Яа-я]{3,25}/', $post) && strlen($post) > 5)) {
                $worker->add_stuff($name, $surname, $date, $wage, $workweek, $post);
                echo'<meta http-equiv="refresh" content="0;admin_list_menu.php">';
            }
            else 
                echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">Не все поля заполнены корректно.</center>";
        }   
    }
    echo '<br><HR WIDTH="100%" ALIGN="center" COLOR="2c75ff" SIZE="2">';
    echo '<center><font size="3" color="#3d3dd4" face="garamond">All rights reserved (c) 2019';
?>