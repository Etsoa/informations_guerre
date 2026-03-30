<?php
// BackOffice - AdminCategoryController

class AdminCategoryController {
    private $pdo;
    private $categorieModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Categorie.php';
        $this->categorieModel = new Categorie($pdo);
    }

    public function index() {
        $categories = $this->categorieModel->getAllWithCount();
        require __DIR__ . '/../../Views/BackOffice/categories/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            if (!empty($nom)) {
                $this->categorieModel->create($nom);
            }
            redirect(ADMIN_URL . 'categories');
        }
        require __DIR__ . '/../../Views/BackOffice/categories/create.php';
    }

    public function edit($id) {
        $category = $this->categorieModel->getById($id);
        if (!$category) {
            redirect(ADMIN_URL . 'categories');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            if (!empty($nom)) {
                $this->categorieModel->update($id, $nom);
            }
            redirect(ADMIN_URL . 'categories');
        }

        require __DIR__ . '/../../Views/BackOffice/categories/edit.php';
    }

    public function delete($id) {
        $this->categorieModel->delete($id);
        redirect(ADMIN_URL . 'categories');
    }
}
