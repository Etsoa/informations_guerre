<?php
// BackOffice - ArticleController

class AdminArticleController {
    private $pdo;
    private $articleModel;
    private $versionModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/ArticleVersion.php';
        $this->articleModel = new Article($pdo);
        $this->versionModel = new ArticleVersion($pdo);
    }

    public function ListerArticles() {
        $articles = $this->articleModel->getAll(100, 0);
        require __DIR__ . '/../../Views/BackOffice/articles/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu']
            ];
            $this->articleModel->create($data);
            redirect(ADMIN_URL . '/articles');
        }

        require __DIR__ . '/../../Views/BackOffice/articles/create.php';
    }

    public function edit($id) {
        $article = $this->articleModel->getById($id);
        if (!$article) {
            redirect(ADMIN_URL . '/articles');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu']
            ];
            $changelog = $_POST['changelog'] ?? null;
            $userId = $_SESSION['user_id'] ?? null;

            // Mettre à jour avec versioning
            $this->articleModel->update($id, $data, $userId, $changelog);
            redirect(ADMIN_URL . '/articles');
        }

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

        $changelog = $_GET['changelog'] ?? "Restaurée depuis version $versionNumber";
        $success = $this->versionModel->restore($articleId, $versionNumber, $userId, $changelog);

        if ($success) {
            redirect(ADMIN_URL . '/article-historique/' . $articleId);
        }

        redirect(ADMIN_URL . '/articles');
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
