<?php 
session_start();
require_once '../config/config.php';
require_once '../src/Classes/Autoloader.php';
require_once '../templates/base_index.phtml';

use App\Classes\Autoloader;
use App\Classes\Core\Router;

Autoloader::register();

$app = new Router();
$app->run();




?>