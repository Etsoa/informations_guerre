<?php
$pageTitle = isset($activeCategory['nom'])
    ? 'Dossiers - ' . sanitize($activeCategory['nom'])
    : 'Dossiers - Guerre en Iran';
require __DIR__ . '/layouts/header.php';
?>

<section class="catalog-hero">
    <h1>Panorama des articles</h1>
    <p>Consultez l'ensemble des publications disponibles et filtrez par categorie.</p>
</section>

<section class="catalog-filters">
    <h2>Categories</h2>
    <div class="filter-chips">
        <a class="chip <?= empty($activeCategory) ? 'chip-active' : '' ?>" href="<?= BASE_URL ?>infos">Toutes</a>
        <?php foreach ($categories as $cat): ?>
            <a class="chip <?= (!empty($activeCategory) && $activeCategory['id'] === $cat['id']) ? 'chip-active' : '' ?>" href="<?= BASE_URL ?>infos/categorie/<?= $cat['id'] ?>">
                <?= sanitize($cat['nom']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="catalog-list">
    <h2><?= !empty($activeCategory) ? 'Articles : ' . sanitize($activeCategory['nom']) : 'Tous les articles' ?></h2>

    <?php if (!empty($articles)): ?>
        <div class="article-grid">
            <?php foreach ($articles as $article): ?>
                <article class="article-card">
                    <header>
                        <p class="article-date">Publie le <?= formatDate($article['date_publication']) ?></p>
                        <h3>
                            <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>">
                                <?= sanitize($article['titre']) ?>
                            </a>
                        </h3>
                    </header>

                    <?php if (!empty($article['categories'])): ?>
                        <p class="article-tags">
                            <?php foreach ($article['categories'] as $cat): ?>
                                <span class="tag">#<?= sanitize($cat['nom']) ?></span>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>

                    <p class="article-description"><?= sanitize(truncate($article['description'], 160)) ?></p>

                    <?php if (!empty($article['auteurs'])): ?>
                        <p class="article-authors">Par
                            <?php
                                $authorNames = array_map(function($a) {
                                    return sanitize($a['nom'] . ' ' . $a['prenom']);
                                }, $article['auteurs']);
                                echo implode(', ', $authorNames);
                            ?>
                        </p>
                    <?php endif; ?>

                    <a class="btn-link" href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>">Lire l'article</a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun article disponible pour le moment.</p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
