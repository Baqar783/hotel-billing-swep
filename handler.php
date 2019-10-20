<?php
    if(!isset($_SESSION)){
        session_start();
    }
    require_once 'classes/Dashboard.php';
    $obj = new Dashboard();
    $request = $_POST['request'];
    if($request == 'login'){
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        echo json_encode($obj->login($username, $password));
    }else if($request == 'save_category'){
        echo json_encode($obj->saveCategory($_POST));
    }else if($request == 'save_room'){
        echo json_encode($obj->saveRoom($_POST));
    }else if($request == 'save_reservation'){
        echo json_encode($obj->saveReservation($_POST));

    }else if($request == 'get_categories'){
        echo json_encode($obj->getCategories());
    }else if($request == 'get_rooms'){
        echo json_encode($obj->getRooms($_POST));
    }else if($request == 'get_all_rooms'){
        echo json_encode($obj->getAllRooms($_POST));
    }
?>