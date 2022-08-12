<?php
include('vendor/autoload.php');

use App\Request;
use App\Controllers\PlayerController;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION["loaded"]);

$request = new Request();

$controller = new PlayerController();

echo $controller->show($request->query('id'));

$_SESSION["loaded"] = true;
