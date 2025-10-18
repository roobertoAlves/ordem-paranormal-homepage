<?php
require_once __DIR__ . '/config.php';
use App\Controllers\HomeController;
$controller = new HomeController();
$controller->index();
?>