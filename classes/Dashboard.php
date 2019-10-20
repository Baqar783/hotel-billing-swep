<?php
    if(!isset($_SESSION)){
        session_start();
    }
    require_once 'Crud.php';
    class Dashboard extends Crud{
        public function __construct(){
            parent::__construct();
        }

        public function login($email, $password){
            $query = "SELECT * FROM users WHERE email= ? AND password = ?";
            $binder = array("ss", "$email", "$password");
            $stmt = $this->read($query, $binder);;
            if($stmt->num_rows > 0){
                $resp['success'] = true;
                $_SESSION['loggedIn'] = true;
                $row = $stmt->fetch_assoc();
                $_SESSION['staff_id'] = $row['user_id'];

            }else{
                $resp['success'] = false;
            }

            return $resp;
        }

        public function saveCategory($data){
            $category = $data['category'];
            $description = $data['description'];
            $price = $data['price'];
            $q = "SELECT category_name FROM categories WHERE category_name = '$category'";
            if($this->read2($q)->num_rows > 0){
                $resp['success'] = false;
                $resp['message'] = "Failed. Category already exists";
                return $resp;
            }
            $query = "INSERT INTO categories (category_name, description, price) 
                        VALUES (?, ?, ?)";
            $binder = array("sss", $category, $description, $price);
            if($this->create($query, $binder)){
                $resp['success'] = true;
                $resp['message'] = "Category created successfully";
            }else{
                $resp['success'] = false;
                $resp['message'] = "Failed. Please try again";
            }
            return $resp;
        }

        public function saveRoom($data){
            $room = $data['room'];
            $category_id = $data['category'];
            $q = "SELECT room_name FROM rooms WHERE room_name = '$room'";
            if($this->read2($q)->num_rows > 0){
                $resp['success'] = false;
                $resp['message'] = "Failed. Room already exists";
                return $resp;
            }
            $query = "INSERT INTO rooms (room_name, category_id) 
                        VALUES (?, ?)";
            $binder = array("ss", $room, $category_id);
            if($this->create($query, $binder)){
                $resp['success'] = true;
                $resp['message'] = "Room created successfully";
            }else{
                $resp['success'] = false;
                $resp['message'] = "Failed. Please try again";
            }
            return $resp;
        }

        public function saveReservation($data){
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $phone = $data['phone'];
            $category_id = $data['category'];
            $room_id = $data['room'];
            $nights = $data['nights'];
            $q = "INSERT INTO users (firstname, lastname, phone, type) VALUES (?,?,?,?)";
            $b = array("ssss", "$firstname", "$lastname", "$phone", "client");
            if($this->create($q, $b)){
                $client_id = $this->conn->insert_id;
                $staff_id = $_SESSION['staff_id'];
                $query = "INSERT INTO reservation_batch (staff_id, client_id) 
                VALUES (?, ?)";
                $binder = array("ss", "$staff_id", "$client_id");
                if($this->create($query, $binder)){
                    $rb_id = $this->conn->insert_id;
                    foreach($room_id as $r){
                        $query2 = "INSERT INTO reservations (room_id, rb_id, nights) VALUES (?, ?, ?)";
                        $binder2 = array("sss", "$r", "$rb_id", "$nights");
                        $this->create($query2, $binder2);
                    }
                    
                    if(true){
                        $resp['success'] = true;
                        $resp['message'] = "Reservation made successfully";
                    }else{
                        $resp['success'] = false;
                        $resp['message'] = "3. Failed. Please try again";
                    }
                    
                }else{
                    $resp['success'] = false;
                    $resp['message'] = "2. Failed. Please try again";
                }
            }else{
                $resp['success'] = false;
                $resp['message'] = "1. Failed. Please try again";
            }
            
            return $resp;
        }

        public function getCategories(){
            $data = array();
            $query = "SELECT * FROM categories";
            $stmt = $this->read2($query);
            while($row = $stmt->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

        public function getRooms($data){
            $resp = array();
            $category_id = $data['category_id'];
            $q = "SELECT * FROM rooms JOIN categories USING(category_id) WHERE category_id = '$category_id'";
            $stmt = $this->read2($q);
            if($stmt->num_rows > 0){
                while($row = $stmt->fetch_assoc()){
                    $resp[] = $row;
                }
            }
            return $resp;
        }

        public function getAllRooms($data){
            $resp = array();
            $q = "SELECT * FROM rooms JOIN categories USING(category_id)";
            $stmt = $this->read2($q);
            if($stmt->num_rows > 0){
                while($row = $stmt->fetch_assoc()){
                    $resp[] = $row;
                }
            }
            return $resp;
        }

    }
?>