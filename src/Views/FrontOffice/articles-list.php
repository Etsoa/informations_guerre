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
            <label for="categorie_id" class="form-label">Categorie</label>
            <select name="categorie_id" id="categorie_id" class="form-control">
                <option value="">Toutes</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (!empty($activeCategory) && $activeCategory['id'] === $cat['id']) ? 'selected' : '' ?>>
                        <?= sanitize($cat['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </div>
    </form>
</section>

<section class="catalog-list">
    <h3 class="section-title"><?= !empty($activeCategory) ? 'Articles : ' . sanitize($activeCategory['nom']) : 'Tous les articles' ?></h3>

    <?php if (!empty($articles)): ?>
        <div class="article-grid">
            <?php foreach ($articles as $article): ?>
                <article class="article-card">
                    <header class="article-list-header">
                        <div class="article-meta">
                            <p class="article-date">Publie le <?= formatDate($article['date_publication']) ?></p>
                            <?php if (!empty($article['categories'])): ?>
                                <p class="article-tags">
                                    <?php foreach ($article['categories'] as $cat): ?>
                                        <span class="tag">#<?= sanitize($cat['nom']) ?></span>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <h3>
                            <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>">
                                <?= sanitize($article['titre']) ?>
                            </a>
                        </h3>
                    </header>

                    <p class="article-description"><?= sanitize(truncate($article['description'], 180)) ?></p>

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
