<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/Article.php';
require_once __DIR__ . '/../src/Models/Categorie.php';
require_once __DIR__ . '/../src/Models/Image.php';

try {
    echo "<h2>Test Database</h2>";
    
    // Test modèles
    $articleModel = new Article($pdo);
    $categorieModel = new Categorie($pdo);
    $imageModel = new Image($pdo);
    
    echo "<h3>1. Articles (getAll(7, 0))</h3>";
    $articles = $articleModel->getAll(7, 0);
    echo "Résultat: " . count($articles) . " articles<br>";
    echo "<pre>";
    print_r($articles);
    echo "</pre>";
    
    echo "<h3>2. Catégories (getAllWithCount())</h3>";
    $categories = $categorieModel->getAllWithCount();
    echo "Résultat: " . count($categories) . " catégories<br>";
    echo "<pre>";
    print_r(array_slice($categories, 0, 3));
    echo "</pre>";
    
    echo "<h3>3. Images pour article 1</h3>";
    $images = $imageModel->getByArticleId(1);
    echo "Résultat: " . count($images) . " images<br>";
    echo "<pre>";
    print_r($images);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "<br>";
    echo $e->getTraceAsString();
}

