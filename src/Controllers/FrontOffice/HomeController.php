<?php
// FrontOffice - HomeController

class HomeController {
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

    public function index() {
        try {
            // Récupérer tous les articles pour la page d'accueil
            $totalArticles = (int) $this->articleModel->countAll();
            $articles = $this->articleModel->getAll($totalArticles > 0 ? $totalArticles : 10, 0);
            $categories = $this->categorieModel->getAllWithCount();

            // Charger la première image pour chaque article
            foreach ($articles as &$article) {
                $images = $this->imageModel->getByArticleId($article['id']);
                $article['image'] = $images[0]['nom'] ?? null;
            }

            // Séparer article principal et reste
            $featuredArticle = $articles[0] ?? null;
            $latestArticles = array_slice($articles, 1);
            
            $pageTitle = SITE_NAME . ' - ' . SITE_DESCRIPTION;
            $pageDescription = SITE_DESCRIPTION;

            require __DIR__ . '/../../Views/FrontOffice/home.php';
        } catch (Exception $e) {
            error_log("HomeController Error: " . $e->getMessage());
            echo "<!-- Error: " . htmlspecialchars($e->getMessage()) . " -->";
        }
    }
}
