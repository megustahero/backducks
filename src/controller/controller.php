<?php

    require_once "config/database.php"; // Include the Database class

    $database = new Database();
    $db = $database->getConnection();

    include_once "model/model.php"; // Include the Model class

    $model = new DetourModel($db);
    $detours = $model->getDetours();

    include "view/view.php";

?>