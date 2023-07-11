<?php

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
?>