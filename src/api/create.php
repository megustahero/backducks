<?php

    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/detours.php';

    $database = new Database();
    $db = $database->getConnection();
    $detObj = new Detour($db);

    $detourTable = 'detour';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'POST') {
        $formData = json_decode(file_get_contents("php://input"), true);
        if (empty($formData)) {
            $insertDetourRecord = $empObj->createDetour($detourTable, $_POST);
        }else{
            $insertDetourRecord = $empObj->createDetour($detourTable, $formData);
        }
        echo $insertDetourRecord;
    } else {
        $data = [
            'status'  => 405,
            'message' => $requestMethod . ' Method now allowed',
        ];
        header("HTTP/1.0 405 Method now allowed");
        echo json_encode($data);
    }

?>