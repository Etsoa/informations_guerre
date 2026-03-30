<?php
$pageTitle = sanitize($article['titre'] ?? 'Article');
require __DIR__ . '/layouts/header.php';
?>

<article class="article-detail">
    <header class="detail-header">
        <h2 class="section-label">Analyse</h2>
        <h1><?= sanitize($article['titre']) ?></h1>
        <p class="meta">Publie le <?= formatDate($article['date_publication']) ?></p>

        <?php if (!empty($articleCategories)): ?>
            <p class="tags">
                <?php foreach ($articleCategories as $cat): ?>
                    <a href="<?= categoryUrl($cat) ?>" class="tag"><?= sanitize($cat['nom']) ?></a>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
    </header>

    <?php if (count($images) > 0): ?>
        <div class="article-images" aria-label="Illustrations de l'article">
            <?php foreach ($images as $image): ?>
                <figure>
                    <img src="<?= imageUrl($image['nom']) ?>" alt="<?= sanitize($image['description'] ?? $article['titre']) ?>">
                    <?php if (!empty($image['description'])): ?>
                        <figcaption><?= sanitize($image['description']) ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="article-content">
        <h2><?= sanitize($article['description']) ?></h2>
        <?= nl2br(sanitize($article['contenu'])) ?>
    </div>

    <?php if (!empty($auteurs)): ?>
        <section class="article-meta-block" aria-labelledby="authors-title">
            <h3 id="authors-title">Auteurs</h3>
            <ul>
                <?php foreach ($auteurs as $auteur): ?>
                    <li><?= sanitize($auteur['prenom'] . ' ' . $auteur['nom']) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($sources)): ?>
        <section class="article-meta-block" aria-labelledby="sources-title">
            <h3 id="sources-title">Sources</h3>
            <ul>
                <?php foreach ($sources as $source): ?>
                    <li>
                        <a href="<?= sanitize($source['url']) ?>" target="_blank" rel="noopener noreferrer">
                            <?= sanitize($source['nom']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($relatedArticles)): ?>
        <section class="related-articles" aria-labelledby="related-title">
            <h3 id="related-title">A lire aussi</h3>
            <div class="latest-grid">
                <?php foreach ($relatedArticles as $related): ?>
                    <article class="article-card">
                        <a class="card-image" href="<?= articleUrl($related) ?>">
                            <img src="<?= imageUrl($related['image'] ?? null) ?>" alt="<?= sanitize($related['titre']) ?>">
                        </a>
                        <h4><a href="<?= articleUrl($related) ?>"><?= sanitize($related['titre']) ?></a></h4>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <div class="article-actions">
        <a href="<?= BASE_URL ?>" class="btn btn-secondary">Retour a l'accueil</a>
    </div>
</article>

<?php require __DIR__ . '/layouts/footer.php'; ?>
