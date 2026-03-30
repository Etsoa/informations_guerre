<?php
$pageTitle = sanitize($article['titre'] ?? 'Article');
require __DIR__ . '/layouts/header.php';
?>

<article class="article-detail">
    <h1><?= sanitize($article['titre']) ?></h1>
    <p class="meta">Publié le <?= formatDate($article['date_publication']) ?></p>

    <?php if (count($images) > 0): ?>
        <div class="article-images">
            <?php foreach ($images as $image): ?>
                <figure>
                    <img src="<?= UPLOADS_URL . sanitize($image['nom']) ?>" alt="<?= sanitize($article['titre']) ?>">
                </figure>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="article-content">
        <h2><?= sanitize($article['description']) ?></h2>
        <?= nl2br(sanitize($article['contenu'])) ?>
    </div>

    <div class="article-actions">
        <a href="<?= BASE_URL ?>" class="btn btn-secondary">← Retour</a>
    </div>
</article>

<?php require __DIR__ . '/layouts/footer.php'; ?>
