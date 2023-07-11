<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../class/detours.php';

    $database = new Database();
    $db = $database->getConnection();
    $items = new Detour($db);
    $alldet = $items->getDetours();
    $itemCount = $alldet->rowCount();

    echo json_encode($itemCount);

    if($itemCount > 0){
        $detourArr = array();
        $detourArr["body"] = array();
        $detourArr["itemCount"] = $itemCount;
        while ($row = $alldet->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "parcel_number" => $parcel_number,
                "type" => $delivery_day,
                "insert_date" => $insert_date
            );
            array_push($detourArr["body"], $e);
        }
        echo json_encode($detourArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>