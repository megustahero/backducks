<?php

    include_once "config/database.php"; // Include the Database class

    $database = new Database();
    $db = $database->getConnection();

    require_once "model/model.php";
    require_once "controller/controller.php";

?>