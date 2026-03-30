<?php
$pageTitle = sanitize($article['titre'] ?? 'Article');
require __DIR__ . '/layouts/header.php';
?>

<article class="article-detail">
    <h1><?= sanitize($article['titre']) ?></h1>
    <p class="meta">Publie le <?= formatDate($article['date_publication']) ?></p>

    <div class="article-content">
        <h2><?= sanitize($article['description']) ?></h2>
        <?= $article['contenu'] // TinyMCE HTML ?>
    </div>

    <div class="article-actions">
        <a href="<?= BASE_URL ?>" class="btn btn-secondary">← Retour</a>
    </div>
</article>

<?php require __DIR__ . '/layouts/footer.php'; ?>
