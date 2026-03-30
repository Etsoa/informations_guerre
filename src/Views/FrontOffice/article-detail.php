<?php
$pageTitle = sanitize($article['titre'] ?? 'Article');
$images = allImageSrc($article['contenu'] ?? '');
$hero = $images[0] ?? null;
$gallery = array_slice($images, 1);
require __DIR__ . '/layouts/header.php';
?>

<div class="detail-spacer">
    <p class="breadcrumb">Infos Guerre / Dossiers / Detail</p>
</div>

<article class="article-detail">
    <h1><?= sanitize($article['titre']) ?></h1>
    <p class="meta">Publie le <?= formatDate($article['date_publication']) ?></p>

    <?php if ($hero): ?>
        <div class="article-hero">
            <img src="<?= $hero ?>" alt="Illustration article">
        </div>
    <?php endif; ?>

    <div class="article-content">
        <h2><?= sanitize($article['description']) ?></h2>
        <?= $article['contenu'] // TinyMCE HTML ?>
    </div>

    <?php if (!empty($gallery)): ?>
        <div class="article-gallery">
            <?php foreach ($gallery as $src): ?>
                <img src="<?= $src ?>" alt="Illustration article complementaire">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="article-actions">
        <a href="<?= BASE_URL ?>infos" class="btn btn-secondary">← Retour</a>
    </div>
</article>

<?php require __DIR__ . '/layouts/footer.php'; ?>
