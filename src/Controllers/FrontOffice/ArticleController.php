<?php
// FrontOffice - ArticleController

class ArticleController {
    private $pdo;
    private $articleModel;
    private $imageModel;
    private $categorieModel;
    private $sourceModel;
    private $auteurModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/Image.php';
        require_once __DIR__ . '/../../Models/Categorie.php';
        require_once __DIR__ . '/../../Models/Source.php';
        require_once __DIR__ . '/../../Models/Auteur.php';
        $this->articleModel = new Article($pdo);
        $this->imageModel = new Image($pdo);
        $this->categorieModel = new Categorie($pdo);
        $this->sourceModel = new Source($pdo);
        $this->auteurModel = new Auteur($pdo);
    }

    public function show($id) {
        $article = $this->articleModel->getById($id);
        if (!$article) {
            http_response_code(404);
            $pageTitle = 'Article non trouvé - ' . SITE_NAME;
            $categories = $this->categorieModel->getAllWithCount();
            require __DIR__ . '/../../Views/FrontOffice/404.php';
            return;
        }

        $images = $this->imageModel->getByArticleId($article['id']);
        $articleCategories = $this->categorieModel->getCategoriesByArticle($article['id']);
        $sources = $this->sourceModel->getByArticleId($article['id']);
        $auteurs = $this->auteurModel->getByArticleId($article['id']);
        $relatedArticles = $this->articleModel->getRelated($article['id'], 4);

        // Charger images pour articles liés
        foreach ($relatedArticles as &$related) {
            $relImages = $this->imageModel->getByArticleId($related['id']);
            $related['image'] = $relImages[0]['nom'] ?? null;
        }

        $categories = $this->categorieModel->getAllWithCount();
        $pageTitle = sanitize($article['titre']) . ' - ' . SITE_NAME;
        $pageDescription = sanitize(truncate($article['description'], 160));

        require __DIR__ . '/../../Views/FrontOffice/article-detail.php';
    }
}
