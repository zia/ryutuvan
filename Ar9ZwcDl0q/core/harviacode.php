<?php

class Harviacode
{

    private $host;
    private $user;
    private $password;
    private $database;
    private $sql;

    function __construct()
    {
        $this->connection();
    }

    function connection()
    {
        $subject = file_get_contents('../application/config/database.php');
        $string = str_replace("defined('BASEPATH') OR exit('No direct script access allowed');", "", $subject);
        
        $con = 'core/connection.php';
        $create = fopen($con, "w") or die("Change your permision folder for application and harviacode folder to 777");
        fwrite($create, $string);
        fclose($create);
        
        require $con;

        /**
        * CRUD generation is possible from both local and global machine.
        * To Remove Global Access just remove 'global' below these codes
        */

        $this->host = $db['local']['hostname'];
        $this->user = $db['local']['username'];
        $this->password = $db['local']['password'];
        $this->database = $db['local']['database'];

        $this->sql = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->sql->connect_error)
        {
            //echo $this->sql->connect_error . ", please check 'application/config/database.php'.";
            echo "You don't have permission to aceess here!";
            die();
        }
        
        unlink($con);
    }

    function table_list()
    {
        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=?";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('s', $this->database);
        $stmt->bind_result($table_name);
        $stmt->execute();
        while ($stmt->fetch()) {
            $fields[] = array('table_name' => $table_name);
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

    function primary_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_KEY = 'PRI'";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key);
        $stmt->execute();
        $stmt->fetch();
        return $column_name;
        $stmt->close();
        $this->sql->close();
    }

    function not_primary_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_KEY <> 'PRI'";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key, $data_type);
        $stmt->execute();
        while ($stmt->fetch()) {
            $fields[] = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type);
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

    function all_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=?";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key, $data_type);
        $stmt->execute();
        while ($stmt->fetch()) {
            $fields[] = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type);
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

}

$hc = new Harviacode();
?>