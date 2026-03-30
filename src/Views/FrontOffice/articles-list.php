<?php
$pageTitle = isset($activeCategory['nom'])
    ? 'Dossiers - ' . sanitize($activeCategory['nom'])
    : 'Dossiers - Guerre en Iran';
require __DIR__ . '/layouts/header.php';
?>

<section class="page-header">
    <div>
        <h2 class="page-title">Articles</h2>
        <p class="page-subtitle">Liste publique, lecture seule</p>
    </div>
    <form method="GET" action="<?= BASE_URL ?>infos" class="filter-form">
        <div class="form-group">
            <label for="q" class="form-label">Recherche</label>
            <input type="text" id="q" name="q" value="<?= sanitize($_GET['q'] ?? '') ?>" class="form-control" placeholder="Mot cle (titre ou resume)">
        </div>
    </form>
</section>

<section class="catalog-list">
    <h3 class="section-title"><?= !empty($activeCategory) ? 'Articles : ' . sanitize($activeCategory['nom']) : 'Tous les articles' ?></h3>

    <?php if (!empty($articles)): ?>
        <div class="chip-row">
            <a class="chip <?= empty($activeCategory) ? 'chip-active' : '' ?>" href="<?= BASE_URL ?>infos">Toutes</a>
            <?php foreach ($categories as $cat): ?>
                <a class="chip <?= (!empty($activeCategory) && $activeCategory['id'] === $cat['id']) ? 'chip-active' : '' ?>" href="<?= BASE_URL ?>infos/categorie/<?= $cat['id'] ?>">
                    <?= sanitize($cat['nom']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="article-grid">
            <?php foreach ($articles as $article): ?>
                <?php $thumb = firstImageSrc($article['contenu'] ?? ''); ?>
                <article class="article-card">
                    <?php if ($thumb): ?>
                        <img class="article-thumb" src="<?= $thumb ?>" alt="Illustration article">
                    <?php endif; ?>

                    <header class="article-list-header">
                        <h3>
                            <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>">
                                <?= sanitize($article['titre']) ?>
                            </a>
                        </h3>
                        <div class="article-meta-row">
                            <span class="article-date">Publie le <?= formatDate($article['date_publication']) ?></span>
                            <?php if (!empty($article['auteurs'])): ?>
                                <span class="separator">|</span>
                                <span class="article-authors">
                                    <?php
                                        $authorNames = array_map(function($a) {
                                            return sanitize($a['nom'] . ' ' . $a['prenom']);
                                        }, $article['auteurs']);
                                        echo implode(', ', $authorNames);
                                    ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($article['categories'])): ?>
                                <span class="separator">|</span>
                                <span class="article-tags">
                                    <?php foreach ($article['categories'] as $cat): ?>
                                        <span class="tag">#<?= sanitize($cat['nom']) ?></span>
                                    <?php endforeach; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <p class="article-description"><?= sanitize(truncate($article['description'], 180)) ?></p>

                    <div class="card-footer-inline">
                        <a class="btn-link" href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>">Lire l'article</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun article disponible pour le moment.</p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
