<?php
// Класс для взаимодействия с базой данных пользователей
class user {
    // Метод проверки корректности введенных для входа в систему данных
    function user_valid($name, $password) {
        require 'sql.php';
        $connection = new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        $password = $connection->real_escape_string($password);
        $query=$connection->query("Select * from `users` where login = '".$name."'");
        while($obj[] = $query->fetch_object());
        array_pop($obj);
        if (!empty($obj)) {
            $connection->close();
            if (password_verify($password, $obj[0]->password)) {
                return TRUE;
            }
            return FALSE;
        }
        else {
            $connection->close();
            return FALSE;
        }
    }
    
    // Метод проверки существования пользователя с указанным именем
    function user_exists($name) {
        require 'sql.php';
        $connection = new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        $query=$connection->query("Select * from `users` where login='".$name."'");
        if (empty($query)) {
            return FALSE;
        }
        while($obj[] = $query->fetch_object());
        array_pop($obj);
        if (!empty($obj)) {
            $connection->close();
            return TRUE;
        }
        else {
            $connection->close();
            return FALSE;
        }
    }
    
    // Метод регистрации пользователя в базе данных
    function register_user($name, $password) {
        require 'sql.php';
        $connection = new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        $password = $connection->real_escape_string($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query=$connection->query("Select * from `users` where name= '".$name."'");
        mysqli_query($connection, "INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES (NULL, '".$name."', '".$password."', 'default')");
        $result = mysqli_query($connection, "SELECT * FROM `users`");
        $connection->close();
    }
    
    // Метод получения роли пользователя
    function get_user_role($name) {
        require 'sql.php';
        $connection = new mysqli($host, $sql_admin, $sql_password, $database);
        $connection->set_charset('utf8');
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        $query=$connection->query("Select role from `users` where login ='".$name."'");
        while($obj[] = $query->fetch_object());
        array_pop($obj);
        return $obj[0]->role;
    }
    
    // Метод обновления пользователя
    function update_user($name, $role) {
        require 'sql.php';
        $connection= new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        $role = $connection->real_escape_string($role);
        mysqli_query($connection, "UPDATE `users` SET role='".$role."' WHERE name='".$name."'");
        $connection->close();
    }
    
    // Метод происка пользователя
    function user_search($name) {
        require 'sql.php';
        $connection = new mysqli($host, $sql_admin, $sql_password, $database);
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        $query=$connection->query("Select `login` from `users` where login = '".$name."'");
        while($obj[] = $query->fetch_object());
        array_pop($obj);
        if (!empty($obj)) {
            $connection->close();
            if ($name == $obj[0]->login) {
                return TRUE;
            }
            return FALSE;
        }
        else {
            $connection->close();
            return FALSE;
        }
    }
    
    // Удаление пользователя
    function delete_user($name) {
        require 'sql.php';
        $connection= new mysqli($host, $sql_admin, $sql_password, $database);
        $connection->set_charset('utf8');
        if ($connection == FALSE) {
            die("Ошибка подключения").mysqli_connect_error();
        }
        $name = $connection->real_escape_string($name);
        mysqli_query($connection, "DELETE FROM `users` WHERE login='".$name."'");
        $connection->close();
    }
}
?>

