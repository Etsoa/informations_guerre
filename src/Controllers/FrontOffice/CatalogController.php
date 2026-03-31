<?php
// FrontOffice - CatalogController

class CatalogController {
    private $articleModel;
    private $categorieModel;
    private $auteurModel;

    public function __construct($pdo) {
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/Categorie.php';
        require_once __DIR__ . '/../../Models/Auteur.php';
        $this->articleModel = new Article($pdo);
        $this->categorieModel = new Categorie($pdo);
        $this->auteurModel = new Auteur($pdo);
    }

    public function liste($categorieId = null) {
        $filters = [];
        if (!empty($categorieId)) {
            $filters['categorie_id'] = $categorieId;
        }
        if (!empty($_GET['q'])) {
            $filters['q'] = trim($_GET['q']);
        }

        $articles = $this->articleModel->getFiltered($filters);
        foreach ($articles as &$article) {
            $article['auteurs'] = $this->auteurModel->getByArticleId($article['id']);
            $article['categories'] = $this->categorieModel->getByArticleId($article['id']);
        }
        unset($article);

        $categories = $this->categorieModel->getAll();
        $activeCategory = null;
        if (!empty($categorieId)) {
            $activeCategory = $this->categorieModel->getById($categorieId);
        }

        require __DIR__ . '/../../Views/FrontOffice/articles-list.php';
    }
}
