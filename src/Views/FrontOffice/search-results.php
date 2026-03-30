<?php
$pageTitle = !empty($q) ? 'Recherche : ' . sanitize($q) . ' - ' . SITE_NAME : 'Recherche - ' . SITE_NAME;
$pageDescription = 'Resultats de recherche sur ' . SITE_NAME;
require __DIR__ . '/layouts/header.php';
?>

<section class="latest-block" aria-labelledby="search-title">
    <h1 id="search-title">Recherche</h1>

    <?php if (empty($q)): ?>
        <p>Saisissez un mot-cle dans la barre de recherche.</p>
    <?php else: ?>
        <p><?= (int) $totalArticles ?> resultat(s) pour "<?= sanitize($q) ?>".</p>

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
                <nav class="pagination" aria-label="Pagination des resultats">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="<?= $i === $page ? 'active' : '' ?>" href="<?= BASE_URL ?>search?q=<?= urlencode($q) ?>&p=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <p>Aucun article trouve pour cette recherche.</p>
        <?php endif; ?>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
