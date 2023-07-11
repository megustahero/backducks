<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/db_config.php';
    include_once '../class/detours.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new Detour($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->parcel_number = $data->parcel_number;
    $item->type = $data->type;
    $item->delivery_day = $data->delivery_day;
    $item->insert_date = date('Y-m-d H:i:s');
        
    if($item->createDetour()){
        echo 'Detour created successfully.';
    } else{
        echo 'Detour could not be created.';
    }
?>