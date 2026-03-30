<?php
// FrontOffice - ArticleController

class ArticleController {
    private $pdo;
    private $articleModel;
    private $imageModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/Image.php';
        $this->articleModel = new Article($pdo);
        $this->imageModel = new Image($pdo);
    }

    public function show($id) {
        $article = $this->articleModel->getById($id);
        if (!$article) {
            http_response_code(404);
            require __DIR__ . '/../../Views/404.php';
            return;
        }

        $images = $this->imageModel->getByArticleId($article['id']);
        
        require __DIR__ . '/../../Views/FrontOffice/article-detail.php';
    }
}
