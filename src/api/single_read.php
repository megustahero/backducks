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
    $item = new Detour($db);
    $item->parcel_number = isset($_GET['parcel_number']) ? $_GET['parcel_number'] : die();
  
    $item->getLatestDetour();
    if($item->parcel_number != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "parcel_number" => $item->parcel_number,
            "type" => $item->type,
            "delivery_day" => $item->delivery_day,
            "insert_date" => $item->insert_date
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Detour not found.");
    }
