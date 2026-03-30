<?php
// FrontOffice - SearchController

class SearchController {
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
        $q = trim($_GET['q'] ?? '');
        $page = max(1, intval($_GET['p'] ?? 1));
        $limit = DEFAULT_LIMIT;
        $offset = ($page - 1) * $limit;

        $articles = [];
        $totalArticles = 0;
        $totalPages = 0;

        if (!empty($q)) {
            $articles = $this->articleModel->search($q, $limit, $offset);
            $totalArticles = $this->articleModel->countSearch($q);
            $totalPages = ceil($totalArticles / $limit);

            foreach ($articles as &$article) {
                $images = $this->imageModel->getByArticleId($article['id']);
                $article['image'] = $images[0]['nom'] ?? null;
            }
        }

        $categories = $this->categorieModel->getAllWithCount();
        $pageTitle = 'Recherche : ' . sanitize($q) . ' - ' . SITE_NAME;
        $pageDescription = 'Résultats de recherche pour "' . sanitize($q) . '"';

        require __DIR__ . '/../../Views/FrontOffice/search-results.php';
    }

    /**
     * Endpoint AJAX pour la recherche en direct
     */
    public function ajax() {
        header('Content-Type: application/json');
        $q = trim($_GET['q'] ?? '');
        
        if (strlen($q) < 2) {
            echo json_encode(['articles' => [], 'total' => 0]);
            return;
        }

        $articles = $this->articleModel->search($q, 5, 0);
        $results = [];
        
        foreach ($articles as $article) {
            $images = $this->imageModel->getByArticleId($article['id']);
            $results[] = [
                'id' => $article['id'],
                'titre' => $article['titre'],
                'description' => truncate($article['description'], 100),
                'date' => formatDateShort($article['date_publication']),
                'url' => articleUrl($article),
                'image' => $images[0]['nom'] ?? null
            ];
        }
        
        echo json_encode([
            'articles' => $results,
            'total' => $this->articleModel->countSearch($q)
        ]);
    }
}
