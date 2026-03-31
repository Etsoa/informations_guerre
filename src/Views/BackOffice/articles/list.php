<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title">Dernieres publications</h2>
    <a href="<?= ADMIN_URL ?>/article-create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvel article
    </a>
</div>

<!-- Filtres de recherche -->
<form method="GET" action="<?= ADMIN_URL ?>/articles" class="filter-form">
    <div class="form-group">
        <label for="categorie_id" class="form-label"><i class="fas fa-filter"></i> Categorie</label>
        <select name="categorie_id" id="categorie_id" class="form-control select-filter">
            <option value="">Toutes les categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= isset($_GET['categorie_id']) && $_GET['categorie_id'] == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="date_publication" class="form-label"><i class="far fa-calendar-alt"></i> Date de publication</label>
        <input type="date" name="date_publication" id="date_publication" class="form-control date-filter" value="<?= $_GET['date_publication'] ?? '' ?>">
    </div>
    <div class="form-group btn-group-filter">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrer</button>
        <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary"><i class="fas fa-undo"></i> Reinitialiser</a>
    </div>
</form>

<div class="articles-list">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <article class="admin-card">
                <!-- En-tête de l'article -->
                <div class="admin-card-header article-list-header">
                    <h3 class="article-list-title">
                        <?= htmlspecialchars($article['titre']) ?>
                    </h3>
                    <div class="article-list-meta">
                        <span><i class="far fa-calendar-alt"></i> Publie le <?= date('d M Y à H:i', strtotime($article['date_publication'])) ?></span>
                        <?php if (!empty($article['auteurs'])): ?>
                            <span class="separator">|</span>
                            <span>
                                <i class="fas fa-pen-nib"></i>
                                <?php
                                    $authorNames = array_map(function($a) { return htmlspecialchars($a['nom'] . ' ' . $a['prenom']); }, $article['auteurs']);
                                    echo implode(', ', $authorNames);
                                ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($article['categories'])): ?>
                            <span class="separator">|</span>
                            <span>
                                <i class="fas fa-list-alt"></i>
                                <?php
                                    $catNames = array_map(function($c) { return htmlspecialchars($c['nom']); }, $article['categories']);
                                    echo implode(', ', $catNames);
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Contenu Brut de TinyMCE -->
                <div class="admin-card-body article-render" style="padding: 30px;">
                    <div class="tinymce-content">
                        <?= $article['contenu'] ?>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="admin-card-footer article-list-footer">
                    <a href="<?= ADMIN_URL ?>/article-edit/<?= $article['id'] ?>/<?= slugify($article['titre']) ?>" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>/<?= slugify($article['titre']) ?>" class="btn btn-warning">
                        <i class="fas fa-history"></i> Historique
                    </a>
                    <button onclick="deleteArticle(<?= $article['id'] ?>)" class="btn btn-danger-solid">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            Aucun article pour le moment.
        </div>
    <?php endif; ?>
</div>

<script>
    function deleteArticle(id) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) return;

        ajax('POST', '<?= ADMIN_URL ?>/article-delete/' + id, null, function(response, status) {
            if (status === 200) {
                showAlert('Article supprime avec succes', 'success');
                setTimeout(() => location.href = '<?= ADMIN_URL ?>/articles', 1500);
            } else {
                showAlert('Erreur lors de la suppression', 'error');
            }
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
