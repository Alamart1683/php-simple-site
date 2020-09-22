<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require 'default_list_menu.html';
    require 'sql.php';
    require 'stuff.php';
    $connection = new mysqli($host, $sql_admin, $sql_password, $database);
    $worker = new stuff();
    // Выбираем все значения из таблицы "stuff"
    $result = mysqli_query($connection, "SELECT * FROM `stuff`");
    $data[] = mysqli_fetch_all($result);
    echo '<HR WIDTH="100%" ALIGN="center" COLOR="2c75ff" SIZE="2">';
    echo '<p>';
    echo '<center><font size="5" color="#3d3dd4" face="garamond">Сотрудники:</font>';
    echo '<p>';
    echo '<center><table bgcolor = "White" border = 4 bordercolor = "#4169e1">';
    echo '<tr>';
    echo '<td>'.'ID'.'</td>';
    echo '<td>'.'Имя'.'</td>';
    echo '<td>'.'Фамилия'.'</td>';
    echo '<td>'.'Дата рождения'.'</td>';
    echo '<td>'.'Зарплата'.'</td>';
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
    echo '<HR WIDTH="100%" ALIGN="center" COLOR="2c75ff" SIZE="2">';
    // Меню поиска информации из базы данных
    require 'default_list_menu_utility.html';
    if (isset($_GET['value'])) {
        if ($_GET['search'] == "Найти сотрудников" && $_GET['atributes'] != "Выберите параметр" && $_GET['value'] != "") {
            $value = $_GET['value'];
            $atribute = $_GET['atributes'];
            $search_data[] = $worker->find_stuff($atribute, $value);
            if (count($search_data[0]) == 0) {
                echo "<center><br><div style=\"font:bold 14px garamond; color:#b00000;\">По вашему запросу ничего не найдено.</center>";
            }
            else {
                echo '<p>';
                echo '<center><b><font size="3" color="#3d3dd4" face="garamond">Результат запроса ('.$atribute.': '.$value.'):</font>';
                echo '<p>';
                echo '<center><table bgcolor = "White" border = 4 bordercolor = "#4169e1">';
                echo '<tr>';
                echo '<td>'.'ID'.'</td>';
                echo '<td>'.'Имя'.'</td>';
                echo '<td>'.'Фамилия'.'</td>';
                echo '<td>'.'Дата рождения'.'</td>';
                echo '<td>'.'Зарплата'.'</td>';
                echo '<td>'.'Рабочая неделя, часы'.'</td>';
                echo '<td>'.'Должность'.'</td>';
                echo '</tr>';
                echo '<tbody>';
                foreach ($search_data as $stuffs) {
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
            }          
        }
    }
    echo '<HR WIDTH="100%" ALIGN="center" COLOR="2c75ff" SIZE="2">';
    echo '<center><font size="3" color="#3d3dd4" face="garamond">All rights reserved (c) 2019';
?>