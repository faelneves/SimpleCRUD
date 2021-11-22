<?php
    include("UserController.php");
    $controller = new UserController();

    header('Content-type: application/json');
    date_default_timezone_set('America/Sao_Paulo');

    $action = $_GET['route'];
    
    switch ($action) {
        case 'createUser':
            http_response_code(201);
            $controller->createUser($_POST);
        break;
        case 'login':
            http_response_code(200);
            $controller->login($_POST);
        break;
        default:
        # code...
        break;
    }
?>