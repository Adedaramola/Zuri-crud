<?php

class Database
{
    private $db;
    private $stmt;

    private $db_host = 'localhost'; //your database host
    private $db_user = 'root'; //your database username 
    private $db_password = ''; //your database password
    private $db_name = ''; //your database name, import sql file

    public function __construct()
    {
        $this->db = null;
        $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
        try {
            $this->db = new PDO($dsn, $this->db_user, $this->db_password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            die();
        }
        return $this->db;
    }

    public function query($sql)
    {
        $this->stmt = $this->db->prepare($sql);
    }

    public function bind($param, $value, $type = null)
    {
        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
