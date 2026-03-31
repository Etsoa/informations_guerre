<?php require "config/database.php"; require "src/Models/Article.php"; $db = Database::getInstance(); $article = new Article($db->getConnection()); print_r($article->getFiltered(["q" => "Iran"]));
