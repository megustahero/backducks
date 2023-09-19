<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/detours.php';

    $database = new Database();
    $db = $database->getConnection();
    $detObj = new Detour($db);

    $detourTable = 'detour';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'GET') {
        if (isset($_GET['id'])) {
            $detId = $_GET['id'];
            $getDetourDetails = $detObj->getLastDetour($detourTable, $detId);
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

    #$stmt = $items->getDetours();
    #$itemCount = $stmt->rowCount();

    #echo json_encode($itemCount);

    #if($itemCount > 0){
    #    $detourArr = array();
    #    $detourArr["body"] = array();
    #    $detourArr["itemCount"] = $itemCount;
    #    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    #        extract($row);
    #        $e = array(
    #            "id" => $id,
    #            "parcel_number" => $parcel_number,
    #            "type" => $type,
    #            "delivery_day" => $delivery_day,
    #            "insert_date" => $insert_date
    #        );
    #        array_push($detourArr["body"], $e);
    #    }
    #    echo json_encode($detourArr);
    #}
    #else{
    #    http_response_code(404);
    #    echo json_encode(
    #        array("message" => "No detour found.")
    #    );
    #}
?>