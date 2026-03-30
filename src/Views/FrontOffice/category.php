<?php
$pageTitle = sanitize($category['nom']) . ' - ' . SITE_NAME;
$pageDescription = 'Articles de la categorie ' . sanitize($category['nom']);
require __DIR__ . '/layouts/header.php';
?>

<section class="latest-block" aria-labelledby="category-title">
    <h1 id="category-title">Categorie : <?= sanitize($category['nom']) ?></h1>

    <?php if (!empty($articles)): ?>
        <div class="latest-grid">
            <?php foreach ($articles as $article): ?>
                <article class="article-card">
                    <a class="card-image" href="<?= articleUrl($article) ?>">
                        <img src="<?= imageUrl($article['image'] ?? null) ?>" alt="<?= sanitize($article['titre']) ?>">
                    </a>
                    <p class="article-date"><?= formatDateShort($article['date_publication']) ?></p>
                    <h2><a href="<?= articleUrl($article) ?>"><?= sanitize($article['titre']) ?></a></h2>
                    <p><?= sanitize(truncate($article['description'], 170)) ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="Pagination des articles">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a class="<?= $i === $page ? 'active' : '' ?>" href="<?= categoryUrl($category) ?>?p=<?= $i ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <p>Aucun article dans cette categorie.</p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
