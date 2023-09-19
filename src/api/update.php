<?php

    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/detours.php';

    $database = new Database();
    $db = $database->getConnection();
    $detObj = new Detour($db);
    
    $detourTable = 'detour';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'PUT') {
        $formData = json_decode(file_get_contents("php://input"), true);
        $updateDetourRecord = $detObj->updateDetour($detourTable, $formData, $_GET);
        echo $updateDetourRecord;
    } else {
        $data = [
            'status'  => 405,
            'message' => $requestMethod . ' Method not allowed',
        ];
        header("HTTP/1.0 405 Method not allowed");
        echo json_encode($data);
    }

?>