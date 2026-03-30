<?php
// FrontOffice - HomeController

class HomeController {
    private $pdo;
    private $articleModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        $this->articleModel = new Article($pdo);
    }

    public function index() {
        $articles = $this->articleModel->getAll(6, 0);
        
        require __DIR__ . '/../../Views/FrontOffice/home.php';
    }
}
