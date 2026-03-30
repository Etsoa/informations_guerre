<?php
// FRONTOFFICE ROUTEUR

session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../src/Helpers/Functions.php';
require_once '../src/Helpers/Session.php';

$action = $_GET['action'] ?? 'home';
$id = $_GET['id'] ?? null;

switch($action) {
    case 'article':
        require_once '../src/Controllers/FrontOffice/ArticleController.php';
        $controller = new ArticleController($pdo);
        $controller->show($id);
        break;

    default:
        require_once '../src/Controllers/FrontOffice/HomeController.php';
        $controller = new HomeController($pdo);
        $controller->index();
}
