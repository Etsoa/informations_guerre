<?php
// BACKOFFICE ROUTEUR

session_start();
require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../src/Helpers/Functions.php';
require_once '../src/Helpers/Session.php';

// Redirection si pas connecté
if (!isset($_SESSION['user_id']) && $_GET['page'] !== 'login') {
    redirect(ADMIN_URL . '?page=login');
}

$page = $_GET['page'] ?? 'login';
$id = $_GET['id'] ?? null;

switch($page) {
    case 'login':
        require_once '../src/Controllers/BackOffice/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
        break;

    case 'logout':
        require_once '../src/Controllers/BackOffice/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->logout();
        break;

    case 'articles':
        require_once '../src/Controllers/BackOffice/ArticleController.php';
        $controller = new AdminArticleController($pdo);
        $controller->ListerArticles();
        break;

    case 'article-create':
        require_once '../src/Controllers/BackOffice/ArticleController.php';
        $controller = new AdminArticleController($pdo);
        $controller->create();
        break;

    case 'article-edit':
        require_once '../src/Controllers/BackOffice/ArticleController.php';
        $controller = new AdminArticleController($pdo);
        $controller->edit($id);
        break;

    case 'article-delete':
        require_once '../src/Controllers/BackOffice/ArticleController.php';
        $controller = new AdminArticleController($pdo);
        $controller->delete($id);
        break;

    default:
        require_once '../src/Controllers/BackOffice/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
}
