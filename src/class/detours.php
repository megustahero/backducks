<?php
    class Detour{
        
        //Connection to my db
        private $conn;
        
        //Define the table where detours are stored
        private $table = "detour";
        
        //Columns in the table
        public $id;
        public $parcel_number;
        public $type;
        public $delivery_day;
        public $insert_date;
        
        // DB connection
        public function __construct($db) {
            $this->conn = $db;
        }
        
        // GET every detour
        public function getDetours($table) {

            $query = "SELECT id, parcel_number, type, delivery_day, insert_date 
                        FROM " . $table . " ORDER BY insert_date DESC";
            
            $result = $this->conn->prepare($query);
            
            if ($result->execute()) {
                $rowCount = $result->rowCount();

                if ($rowCount > 0) {
                    
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

                    $data = [
                        'status'  => 200,
                        'message' => 'Detour record fetch successfull',
                        'data'    => $rows,
                    ];

                    header("HTTP/1.0 20 OK");
                }else{
                    $data = [
                        'status'  => 400,
                        'message' => 'No detour found',
                    ];
                    header("HTTP/1.0 400 No detour found");
                }
            }else{
                $data = [
                    'status'  => 500,
                    'message' => 'Internal server error',
                ];
                header("HTTP/1.0 500 Internal server error");
            }
            return json_encode($data);
            
        }
        
        // READ a detour
        public function getLastDetour($table, $parcel_number){
            try {
                if (is_valid_parcelno($parcel_number)) {
                    $query = "SELECT * FROM $table WHERE parcel_number = '$parcel_number' ORDER BY insert_date DESC LIMIT 1";

                    $result = $this->conn->query($query);
                    
                    if ($result->rowCount() > 0) {
                        $row = $result->fetchAll(PDO::FETCH_ASSOC);
                        $data = [
                            'status'  => 200,
                            'message' => 'Single detour fetch successfull',
                            'data'    => $row,
                        ];
                        header("HTTP/1.0 200 OK");
                    } else {
                        $data = [
                            'status'  => 404,
                            'message' => 'Detour not found',
                        ];
                        header("HTTP/1.0 404 Detour not found");
                    }
                }else{
                    $data = [
                        'status'  => 404,
                        'message' => 'Valid detour parcel number is required',
                    ];
                    header("HTTP/1.0 404 Valid detour parcel number is required");
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }

            return json_encode($data);

        }

        // CREATE a detour, alias POST method
        public function createDetour($table, $post) {
            
            if (!empty($post)) {

                $parcel_number = htmlspecialchars(strip_tags($post['parcel_number']));
                $type          = htmlspecialchars(strip_tags($post['type']));
                $delivery_day  = htmlspecialchars(strip_tags($post['delivery_day']));

                if (is_valid_parcelno($parcel_number) && is_numeric($type) && is_valid_date($delivery_day)) {

                    $query = "INSERT INTO $table (parcel_number, type, delivery_day, insert_date)
                        VALUES (:parcel_number, :type, :delivery_day, now())";
                    
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':parcel_number', $parcel_number);
                    $stmt->bindParam(':type', $type);
                    $stmt->bindParam(':delivery_day', $delivery_day);
                                      
                    if ($stmt->execute()) {
                        $data = [
                            'status'  => 200,
                            'message' => 'Detour created successfully ',
                        ];
                        header("HTTP/1.0 200 Created");
                    } else {
                        $data = [
                            'status'  => 500,
                            'message' => 'Internal server error',
                        ];
                        header("HTTP/1.0 500 Internal server error");
                    }
                } else {
                    $data = [
                        'status'  => 422,
                        'message' => 'All fields are required',
                    ];
                    header("HTTP/1.0 404 Unprocessable entity");
                }

            } else {
                $data = [
                    'status'  => 500,
                    'message' => 'Something went wrong',
                ];
                header("HTTP/1.0 404 Something went wrong");
            }
            return json_encode($data);

        }

        public function updateDetour($table, $post){

            if (!empty($post)) {
        
                $id            = htmlspecialchars(strip_tags($post['id']));
                $parcel_number = htmlspecialchars(strip_tags($post['parcel_number']));
                $type          = htmlspecialchars(strip_tags($post['type']));
                $delivery_day  = htmlspecialchars(strip_tags($post['delivery_day']));
        
                if (is_numeric($id) && is_valid_parcelno($parcel_number) && is_numeric($type) && is_valid_date($delivery_day)) {
        
                    // Check if the record with the given ID exists
                    $check_query = "SELECT id FROM $table WHERE id=?";
                    $check_result = $this->conn->prepare($check_query);
                    $check_result->bindParam(1, $id, PDO::PARAM_INT);
                    $check_result->execute();
        
                    if ($check_result->rowCount() > 0) {
        
                        // Use prepared statement to prevent SQL injection
                        $query = "UPDATE $table SET parcel_number=?, type=?, delivery_day=?, insert_date=now() WHERE id=?";
                        $result = $this->conn->prepare($query);
        
                        // Bind parameters
                        $result->bindParam(1, $parcel_number, PDO::PARAM_STR);
                        $result->bindParam(2, $type, PDO::PARAM_INT);
                        $result->bindParam(3, $delivery_day, PDO::PARAM_STR);
                        $result->bindParam(4, $id, PDO::PARAM_INT);
        
                        if ($result->execute()) {
                            $data = [
                                'status'  => 200,
                                'message' => 'Detour updated successfully',
                            ];
                            header("HTTP/1.0 200 success");
                        } else {
                            $data = [
                                'status'  => 404,
                                'message' => 'Detour not updated',
                            ];
                            header("HTTP/1.0 404 Detour not updated");
                        }
        
                    } else {
                        $data = [
                            'status'  => 404,
                            'message' => 'Detour with the given ID not found',
                        ];
                        header("HTTP/1.0 404 Not found");
                    }
        
                } else {
                    $data = [
                        'status'  => 404,
                        'message' => 'Detour id or data is not valid',
                    ];
                    header("HTTP/1.0 404 Not found");
                }
            }
        
            // Debugging messages
            #error_log("Detour Update Request: " . json_encode($post));
            #error_log("Detour Update Response: " . json_encode($data));
        
            return json_encode($data);
        }
        

        // DELETE a detour
        public function deleteDetour($table, $parcel_number) {
            try {
                if (is_valid_parcelno($parcel_number)) {
                    $query = "DELETE FROM $table WHERE parcel_number = '$parcel_number'";
                    $result = $this->conn->prepare($query);
                    if ($result->execute()) {
                        $data = [
                            'status'  => 200,
                            'message' => 'Detour deleted successfully',
                        ];
                        header("HTTP/1.0 200 OK");
                    } else {
                        $data = [
                            'status'  => 500,
                            'message' => 'Internal server error',
                        ];
                        header("HTTP/1.0 500 Internal server error");
                    } 
                } else {
                    $data = [
                        'status'  => 404,
                        'message' => 'Detour parcel number is required',
                    ];
                    header("HTTP/1.0 404 Not found");
                }
                return json_encode($data);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }

        }

    }

    function is_valid_date($date, $format = 'Y-m-d') {
        $dateTime = DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }

    function is_valid_parcelno($input) {
        // Check if the input is numeric and has exactly 14 characters
        return preg_match('/^\d{14}$/', $input) === 1;
    }
