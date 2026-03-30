<?php
$pageTitle = 'Accueil - ' . SITE_NAME;
$pageDescription = SITE_DESCRIPTION;
require __DIR__ . '/layouts/header.php';
?>

<section class="headline-block">
    <h1>Actualites de la guerre en Iran</h1>
    <h2 class="section-label">A la une</h2>
    <?php if ($featuredArticle): ?>
        <article class="headline-article">
            <a class="headline-image" href="<?= articleUrl($featuredArticle) ?>">
                <img src="<?= imageUrl($featuredArticle['image'] ?? null) ?>" alt="<?= sanitize($featuredArticle['titre']) ?>">
            </a>
            <div class="headline-content">
                <p class="article-date"><?= formatDate($featuredArticle['date_publication']) ?></p>
                <h3><a href="<?= articleUrl($featuredArticle) ?>"><?= sanitize($featuredArticle['titre']) ?></a></h3>
                <p><?= sanitize($featuredArticle['description']) ?></p>
            </div>
        </article>
    <?php endif; ?>
</section>

<section class="latest-block" aria-labelledby="latest-title">
    <h2 id="latest-title">Derniers Articles</h2>
    <?php if (!empty($latestArticles)): ?>
        <div class="latest-grid">
            <?php foreach ($latestArticles as $article): ?>
                <article class="article-card">
                    <a class="card-image" href="<?= articleUrl($article) ?>">
                        <img src="<?= imageUrl($article['image'] ?? null) ?>" alt="<?= sanitize($article['titre']) ?>">
                    </a>
                    <p class="article-date"><?= formatDateShort($article['date_publication']) ?></p>
                    <h3><a href="<?= articleUrl($article) ?>"><?= sanitize($article['titre']) ?></a></h3>
                    <p><?= sanitize(truncate($article['description'], 170)) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun article disponible.</p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
