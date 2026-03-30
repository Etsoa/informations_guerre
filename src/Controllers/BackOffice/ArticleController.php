<?php
// BackOffice - ArticleController

class AdminArticleController {
    private $pdo;
    private $articleModel;
    private $versionModel;
    private $auteurModel;
    private $categorieModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/ArticleVersion.php';
        require_once __DIR__ . '/../../Models/Auteur.php';
        require_once __DIR__ . '/../../Models/Categorie.php';
        $this->articleModel = new Article($pdo);
        $this->versionModel = new ArticleVersion($pdo);
        $this->auteurModel = new Auteur($pdo);
        $this->categorieModel = new Categorie($pdo);
    }

    public function ListerArticles() {
        $filters = [];
        if (!empty($_GET['categorie_id'])) $filters['categorie_id'] = $_GET['categorie_id'];
        if (!empty($_GET['date_publication'])) $filters['date'] = $_GET['date_publication'];
        
        $articles = $this->articleModel->getFiltered($filters);
        foreach ($articles as &$article) {
            $article['auteurs'] = $this->auteurModel->getByArticleId($article['id']);
            $article['categories'] = $this->categorieModel->getByArticleId($article['id']);
        }
        $categories = $this->categorieModel->getAll();
        require __DIR__ . '/../../Views/BackOffice/articles/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu']
            ];
            $articleId = $this->articleModel->create($data);

            // Ajout des auteurs
            if (!empty($_POST['auteurs']) && is_array($_POST['auteurs'])) {
                foreach ($_POST['auteurs'] as $auteurId) {
                    $this->auteurModel->addToArticle($articleId, $auteurId);
                }
            }

            // Ajout des categories
            if (!empty($_POST['categories']) && is_array($_POST['categories'])) {
                foreach ($_POST['categories'] as $catId) {
                    $this->categorieModel->addToArticle($articleId, $catId);
                }
            }

            redirect(ADMIN_URL . '/articles');
        }

        $auteurs = $this->auteurModel->getAll();
        $categories = $this->categorieModel->getAll();
        require __DIR__ . '/../../Views/BackOffice/articles/create.php';
    }

    public function edit($id) {
        $article = $this->articleModel->getById($id);
        if (!$article) {
            redirect(ADMIN_URL . '/articles');
        }

        $articleAuteurs = $this->auteurModel->getByArticleId($id);
        $currentAuteursIds = array_column($articleAuteurs, 'id');
        
        $articleCategories = $this->categorieModel->getByArticleId($id);
        $currentCategoriesIds = array_column($articleCategories, 'id');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu']
            ];
            $changelog = $_POST['changelog'] ?? null;
            $userId = $_SESSION['user_id'] ?? null;

            // Mettre à jour avec versioning (ceci va creer la version AVANT la mise à jour des relations)
            $this->articleModel->update($id, $data, $userId, $changelog);

            // Mise à jour des auteurs
            $this->auteurModel->removeAllFromArticle($id);
            if (!empty($_POST['auteurs']) && is_array($_POST['auteurs'])) {
                foreach ($_POST['auteurs'] as $auteurId) {
                    $this->auteurModel->addToArticle($id, $auteurId);
                }
            }

            // Mise à jour des categories
            $this->categorieModel->removeAllFromArticle($id);
            if (!empty($_POST['categories']) && is_array($_POST['categories'])) {
                foreach ($_POST['categories'] as $catId) {
                    $this->categorieModel->addToArticle($id, $catId);
                }
            }

            redirect(ADMIN_URL . '/article-edit/' . $id);
        }

        $auteurs = $this->auteurModel->getAll();
        $categories = $this->categorieModel->getAll();
        require __DIR__ . '/../../Views/BackOffice/articles/edit.php';
    }

    public function delete($id) {
        $this->articleModel->delete($id);
        redirect(ADMIN_URL . '/articles');
    }

    public function VoirHistorique($articleId) {
        $article = $this->articleModel->getById($articleId);
        if (!$article) {
            redirect(ADMIN_URL . '/articles');
        }

        $versions = $this->versionModel->getByArticleId($articleId);
        require __DIR__ . '/../../Views/BackOffice/articles/historique.php';
    }

    public function restaurer($articleId, $versionNumber) {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            redirect(ADMIN_URL . '/articles');
        }

        $changelog = $_GET['changelog'] ?? "Restauree depuis version $versionNumber";
    }

    public function AfficherVersion($articleId, $versionNumber) {
        $article = $this->articleModel->getById($articleId);
        if (!$article) {
            redirect(ADMIN_URL . '/articles');
        }

        $version = $this->versionModel->getSpecificVersion($articleId, $versionNumber);
        if (!$version) {
            redirect(ADMIN_URL . '/article-historique/' . $articleId);
        }

        $versions = $this->versionModel->getByArticleId($articleId);
        require __DIR__ . '/../../Views/BackOffice/articles/afficher-version.php';
    }
}
