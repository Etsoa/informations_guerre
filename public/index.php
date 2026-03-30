<?php
// FRONTOFFICE ROUTEUR

session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../src/Helpers/Functions.php';
require_once '../src/Helpers/Session.php';

$action = $_GET['action'] ?? 'home';
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

switch($action) {
    case 'article':
        require_once '../src/Controllers/FrontOffice/ArticleController.php';
        $controller = new ArticleController($pdo);
        $controller->show($id);
        break;

    case 'category':
        require_once '../src/Controllers/FrontOffice/CategoryController.php';
        $controller = new CategoryController($pdo);
        $controller->show($id);
        break;

    case 'search':
        require_once '../src/Controllers/FrontOffice/SearchController.php';
        $controller = new SearchController($pdo);
        $controller->index();
        break;

    case 'search-ajax':
        require_once '../src/Controllers/FrontOffice/SearchController.php';
        $controller = new SearchController($pdo);
        $controller->ajax();
        break;

    default:
        require_once '../src/Controllers/FrontOffice/HomeController.php';
        $controller = new HomeController($pdo);
        $controller->index();
}
