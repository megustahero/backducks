<?php

class Database {
    private $host = "db";
    private $database_name = "backducks";
    private $username = "backducks";
    private $password = "unholy-trinity-bear";
    public $conn;
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("SET NAMES 'UTF8'");
        }catch(PDOException $exception){
            echo "ERROR: Could not connect. " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>