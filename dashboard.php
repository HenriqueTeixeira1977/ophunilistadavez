<?php
require_once 'config/database.php';
require_once 'controllers/DashboardController.php';

$controller = new DashboardController($conn);
$controller->index();
?>