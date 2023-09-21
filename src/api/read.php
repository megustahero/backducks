<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/detours.php';

    $database = new Database();
    $db = $database->getConnection();
    $detObj = new Detour($db);

    $detourTable = 'detour';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'GET') {
        if (isset($_GET['parcel_number'])) {
            $parcel_number = $_GET['parcel_number'];
            $getDetourDetails = $detObj->getLastDetour($detourTable, $parcel_number);
        } else {
            $getDetourDetails = $detObj->getDetours($detourTable);
        }
        echo $getDetourDetails;
    } else {
        $data = [
            'status'  => 405,
            'message' => $requestMethod. ' Method not allowed',
        ];
        header("HTTP/1.0 405 Method not allowed");
        echo json_encode($data);
    }

?>