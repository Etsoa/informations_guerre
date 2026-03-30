<?php
// FrontOffice - CategoryController

class CategoryController {
    private $pdo;
    private $articleModel;
    private $categorieModel;
    private $imageModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/Categorie.php';
        require_once __DIR__ . '/../../Models/Image.php';
        $this->articleModel = new Article($pdo);
        $this->categorieModel = new Categorie($pdo);
        $this->imageModel = new Image($pdo);
    }

    public function show($id) {
        $category = $this->categorieModel->getById($id);
        if (!$category) {
            http_response_code(404);
            $pageTitle = 'Catégorie non trouvée - ' . SITE_NAME;
            $categories = $this->categorieModel->getAllWithCount();
            require __DIR__ . '/../../Views/FrontOffice/404.php';
            return;
        }

        $page = max(1, intval($_GET['p'] ?? 1));
        $limit = DEFAULT_LIMIT;
        $offset = ($page - 1) * $limit;

        $articles = $this->articleModel->getByCategory($id, $limit, $offset);
        $totalArticles = $this->articleModel->countByCategory($id);
        $totalPages = ceil($totalArticles / $limit);

        // Charger images articles
        foreach ($articles as &$article) {
            $images = $this->imageModel->getByArticleId($article['id']);
            $article['image'] = $images[0]['nom'] ?? null;
        }

        $categories = $this->categorieModel->getAllWithCount();
        $pageTitle = $category['nom'] . ' - ' . SITE_NAME;
        $pageDescription = 'Articles de la catégorie ' . $category['nom'] . ' sur la guerre en Iran';

        require __DIR__ . '/../../Views/FrontOffice/category.php';
    }
}
