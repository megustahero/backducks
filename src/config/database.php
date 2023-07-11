<?php

class Database {
    private $host = "127.0.0.1";
    private $database_name = "backducks";
    private $username = "backducks";
    private $password = "unholy-trinity-bear";
    public $conn;
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "ERROR: Could not connect. " . $exception->getMessage();
        }
        return $this->conn;
    }
}

/*

    OLD METHOD

    # Database credentials.
    define('DB_SERVER', 'db');
    define('DB_USERNAME', 'backducks');
    define('DB_PASSWORD', 'unholy-trinity-bear');
    define('DB_NAME', 'backducks');

    # Attempt to connect to PostgreSQL database
    try{
        $pdo = new PDO("pgsql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }

*/

?>