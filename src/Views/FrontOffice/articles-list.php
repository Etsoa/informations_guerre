<?php
$pageTitle = isset($activeCategory['nom'])
    ? 'Dossiers - ' . sanitize($activeCategory['nom'])
    : 'Dossiers - Guerre en Iran';
require __DIR__ . '/layouts/header.php';
?>

<section class="page-header">
    <h2 class="page-title">
        <?= !empty($activeCategory) ? 'Articles : ' . sanitize($activeCategory['nom']) : 'Tous les articles' ?>
    </h2>
    <form method="GET" action="<?= BASE_URL ?>infos" class="filter-form">
        <div class="form-group">
            <label for="q" class="form-label">Recherche</label>
            <input type="text" id="q" name="q" value="<?= sanitize($_GET['q'] ?? '') ?>" class="form-control" placeholder="Mot cle (titre ou resume)">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Rechercher</button>
    </form>
</section>

<div class="chip-row" style="margin-bottom: 30px;">
    <a class="chip <?= empty($activeCategory) ? 'chip-active' : '' ?>" href="<?= BASE_URL ?>infos">Toutes</a>
    <?php foreach ($categories as $cat): ?>
        <a class="chip <?= (!empty($activeCategory) && $activeCategory['id'] === $cat['id']) ? 'chip-active' : '' ?>" href="<?= BASE_URL ?>infos/categorie/<?= $cat['id'] ?>">
            <?= sanitize($cat['nom']) ?>
        </a>
    <?php endforeach; ?>
</div>

<?php if (!empty($articles)): ?>
    <div class="articles-list">
        <?php foreach ($articles as $article): ?>
            <article class="admin-card">
                <!-- En-tête de l'article -->
                <div class="admin-card-header article-list-header">
                    <h3 class="article-list-title">
                        <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>/<?= slugify($article['titre']) ?>">
                            <?= sanitize($article['titre']) ?>
                        </a>
                    </h3>
                    <div class="article-list-meta">
                        <span><i class="far fa-calendar-alt"></i> Publie le <?= formatDate($article['date_publication']) ?></span>
                        <?php if (!empty($article['auteurs'])): ?>
                            <span class="separator">|</span>
                            <span>
                                <i class="fas fa-pen-nib"></i>
                                <?php
                                    $authorNames = array_map(function($a) { return sanitize($a['nom'] . ' ' . $a['prenom']); }, $article['auteurs']);
                                    echo implode(', ', $authorNames);
                                ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($article['categories'])): ?>
                            <span class="separator">|</span>
                            <span>
                                <i class="fas fa-list-alt"></i>
                                <?php
                                    $catNames = array_map(function($c) { return sanitize($c['nom']); }, $article['categories']);
                                    echo implode(', ', $catNames);
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Contenu de l'article -->
                <div class="admin-card-body article-render" style="padding: 30px;">
                    <div class="tinymce-content">
                        <?= $article['contenu'] ?>
                    </div>
                </div>

                <!-- Lien de lecture complet -->
                <div class="admin-card-footer article-list-footer" style="justify-content: flex-end;">
                    <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>/<?= slugify($article['titre']) ?>" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                        Lire l'article complet <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Aucun article disponible pour le moment.</p>
<?php endif; ?>

<?php require __DIR__ . '/layouts/footer.php'; ?>

