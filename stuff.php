<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class stuff {
    // Метод удаления сотрудника
    function stuff_delete($id) {
        require 'sql.php';
        $connection= new mysqli($host, $sql_admin, $sql_password, $database);
        $connection->set_charset('utf8');
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $id = $connection->real_escape_string($id);
        mysqli_query($connection, "DELETE FROM `stuff` WHERE id='".$id."'");
        $connection->close();
    }
    
    // Метод поиска существующего id
    function id_search($id) {
        require 'sql.php';
        $connection = new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($id);
        $query=$connection->query("Select `id` from `stuff` where id = '".$id."'");
        while($obj[] = $query->fetch_object());
        array_pop($obj);
        if (!empty($obj)) {
            $connection->close();
            if ($name == $obj[0]->id) {
                return TRUE;
            }
            return FALSE;
        }
        else {
            $connection->close();
            return FALSE;
        }
    }
    
    // Метод обновления сотрудника
    function update_stuff($id, $atribute, $value) {
        require 'sql.php';
        $connection= new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $id = $connection->real_escape_string($id);
        $atribute = $connection->real_escape_string($atribute);
        $value = $connection->real_escape_string($value);
        if ($atribute == "Зарплата") {
            mysqli_query($connection, "UPDATE `stuff` SET `wage` = '".$value."' WHERE `stuff`.`id` = '".$id."'");
        }
        else if ($atribute == "Рабочая неделя") {
            mysqli_query($connection, "UPDATE `stuff` SET `workweek` = '".$value."' WHERE `stuff`.`id` = '".$id."'");
        }
        else if ($atribute == "Должность") {
            mysqli_query($connection, "UPDATE `stuff` SET `post` = '".$value."' WHERE `stuff`.`id` = '".$id."'");
        }
        $connection->close();
    }
    
    // Метод проверки даты
    function data_controller($date) {
        if (preg_match("/[0-9]{4}[-](0[1-9]|1[012])[-](0[1-9]|1[0-9]|2[0-9]|3[01])/", $date)) {
            $array = preg_split("/[-]/", $date);
            if (checkdate($array[1], $array[2], $array[0])) {
                return True;
            }
            else 
                return False;
        }
        else
            return False;
    }
    
    // Метод добавления сотрудника
    function add_stuff($name, $surname, $date, $wage, $workweek, $post) {
        require 'sql.php';
        $connection= new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        $surname = $connection->real_escape_string($surname);
        $date = $connection->real_escape_string($date);
        $wage = $connection->real_escape_string($wage);
        $workweek = $connection->real_escape_string($workweek);
        $post = $connection->real_escape_string($post);
        mysqli_query($connection, "INSERT INTO `stuff` (`id`, `name`, `surname`, `birthdate`, `wage`, `workweek`, `post`)"
                . " VALUES (NULL, '".$name."', '".$surname."', '".$date."', '".$wage."', '".$workweek."', '".$post."')");
        $connection->close();
    }
    
    // Метод поиска сотрудника по указанному критерию
    function find_stuff($atribute, $value) {
        require 'sql.php';
        $connection = new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $atribute = $connection->real_escape_string($atribute);
        $value = $connection->real_escape_string($value);
        if ($atribute == "ID") {
            $result = mysqli_query($connection, "SELECT * FROM `stuff` WHERE `id` = '$value'");
        }
        else if ($atribute == "Имя") {
            $result = mysqli_query($connection, "SELECT * FROM `stuff` WHERE `name` = '$value'");
        }
        else if ($atribute == "Фамилия") {
            $result = mysqli_query($connection, "SELECT * FROM `stuff` WHERE `surname` = '$value'");
        }
        else if ($atribute == "Дата рождения") {
            $result = mysqli_query($connection, "SELECT * FROM `stuff` WHERE `birthdate` = '$value'");
        }
        else if ($atribute == "Зарплата") {
            $result = mysqli_query($connection, "SELECT * FROM `stuff` WHERE `wage` = '$value'");
        }
        else if ($atribute == "Рабочая неделя"){
            $result = mysqli_query($connection, "SELECT * FROM `stuff` WHERE `workweek` = '$value'");
        }
        else if ($atribute == "Должность") {
            $result = mysqli_query($connection, "SELECT * FROM `stuff` WHERE `post` = '$value'");
        }
        $data = mysqli_fetch_all($result);
        $connection->close();
        return $data;
    }
}
?>
