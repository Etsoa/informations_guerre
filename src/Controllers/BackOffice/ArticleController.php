<?php
// BackOffice - ArticleController

class AdminArticleController {
    private $pdo;
    private $articleModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        $this->articleModel = new Article($pdo);
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
            redirect(ADMIN_URL . '?page=articles');
        }

        require __DIR__ . '/../../Views/BackOffice/articles/create.php';
    }

    public function edit($id) {
        $article = $this->articleModel->getById($id);
        if (!$article) {
            redirect(ADMIN_URL . '?page=articles');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu']
            ];
            $this->articleModel->update($id, $data);
            redirect(ADMIN_URL . '?page=articles');
        }

        require __DIR__ . '/../../Views/BackOffice/articles/edit.php';
    }

    public function delete($id) {
        $this->articleModel->delete($id);
        redirect(ADMIN_URL . '?page=articles');
    }
}
