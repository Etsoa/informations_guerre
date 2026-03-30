<?php
// FrontOffice - ArticleController

class ArticleController {
    private $pdo;
    private $articleModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        $this->articleModel = new Article($pdo);
    }

    public function show($id) {
        $article = $this->articleModel->getById($id);
        if (!$article) {
            http_response_code(404);
            require __DIR__ . '/../../Views/404.php';
            return;
        }

        require __DIR__ . '/../../Views/FrontOffice/article-detail.php';
    }
}
