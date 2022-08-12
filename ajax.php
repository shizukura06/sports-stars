<?php
include('vendor/autoload.php');

use App\Request;
use App\Controllers\PlayerController;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(array_key_exists('ajax', $_POST)){
    switch ($_POST['ajax']) {
        case 1:
            $request = new Request();

            $controller = new PlayerController();

            echo $controller->show($_POST['id']);

            break;
        case 2:
            $request = new Request();

            $controller = new PlayerController();

            echo $controller->nba_show($_POST['id']);

            break;

        default:

    }
    return;
}
























