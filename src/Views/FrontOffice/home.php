<?php
$pageTitle = 'Accueil - Informations Guerre';
require __DIR__ . '/layouts/header.php';
?>

<div class="hero">
    <h1>Dernieres Informations sur la Guerre en Iran</h1>
    <p>Restez informe</p>
    <form class="search-bar" method="GET" action="<?= BASE_URL ?>infos">
        <input type="text" name="q" placeholder="Rechercher un article" value="<?= sanitize($_GET['q'] ?? '') ?>">
        <button type="submit">Rechercher</button>
    </form>
</div>

<section class="articles">
    <h2>Articles Recents</h2>
    <div class="articles-list">
        <?php if (count($articles) > 0): ?>
            <?php foreach ($articles as $article): ?>
                <article class="admin-card">
                    <!-- En-tête de l'article -->
                    <div class="admin-card-header article-list-header">
                        <h3 class="article-list-title">
                            <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>">
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
                        <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                            Lire l'article complet <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouve.</p>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
