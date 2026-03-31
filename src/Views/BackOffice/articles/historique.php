<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title"><i class="fas fa-history"></i> Historique des Versions</h2>
    <div>
        <a href="<?= ADMIN_URL ?>/article-edit/<?= $article['id'] ?>/<?= slugify($article['titre']) ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Retour à l'edition
        </a>
        <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary">
            <i class="fas fa-list"></i> Tous les articles
        </a>
    </div>
</div>

<div class="article-meta-cards" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
    <div class="meta-card">
        <div class="meta-icon"><i class="fas fa-file-alt"></i></div>
        <div class="meta-details">
            <span class="meta-label">Article Concerne</span>
            <span class="meta-value"><?= htmlspecialchars($article['titre']) ?></span>
        </div>
    </div>
    <div class="meta-card">
        <div class="meta-icon"><i class="fas fa-layer-group"></i></div>
        <div class="meta-details">
            <span class="meta-label">Versions Enregistrees</span>
            <span class="meta-value"><?= count($versions) ?> version(s)</span>
        </div>
    </div>
    <div class="meta-card">
        <div class="meta-icon"><i class="fas fa-hashtag"></i></div>
        <div class="meta-details">
            <span class="meta-label">Identifiant</span>
            <span class="meta-value">#<?= $article['id'] ?></span>
        </div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        Versions precedentes
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <?php if (!empty($versions)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Version</th>
                        <th>Titre enregistre</th>
                        <th>Modifie par</th>
                        <th>Date et Heure</th>
                        <th>Description (Changelog)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($versions as $version): ?>
                        <tr>
                            <td>
                                <span style="background: var(--bg-hover); padding: 3px 8px; border-radius: 4px; font-weight: bold; font-family: monospace;">
                                    v<?= $version['version_number'] ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars(substr($version['titre'], 0, 50)) ?>...</td>
                            <td><i class="fas fa-user-edit text-muted"></i> <?= htmlspecialchars($version['auteur_nom'] ?? 'Systeme') ?></td>
                            <td><i class="far fa-clock text-muted"></i> <?= date('d/m/Y H:i', strtotime($version['created_at'])) ?></td>
                            <td>
                                <?php if (!empty($version['changelog'])): ?>
                                    <em>"<?= htmlspecialchars($version['changelog']) ?>"</em>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <a href="<?= ADMIN_URL ?>/article-version/<?= $article['id'] ?>/<?= $version['version_number'] ?>/<?= slugify($article['titre']) ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9em;">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    <button 
                                        onclick="restoreVersion(<?= $article['id'] ?>, <?= $version['version_number'] ?>)"
                                        class="btn btn-primary"
                                        style="padding: 5px 10px; font-size: 0.9em; background: var(--accent-color);"
                                    >
                                        <i class="fas fa-undo"></i> Restaurer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="padding: 20px; text-align: center; color: var(--text-muted);">
                <i class="fas fa-info-circle fa-2x" style="margin-bottom: 10px;"></i><br>
                Aucune version enregistree pour cet article.
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function restoreVersion(articleId, versionNumber) {
        if (!confirm('Êtes-vous sûr de vouloir restaurer cette version ? L\'etat actuel sera archive dans l\'historique.')) {
            return;
        }
        
        ajax('POST', '<?= ADMIN_URL ?>/article-restaurer/' + articleId + '/' + versionNumber, {}, function(response, status) {
            if (status === 200) {
                showAlert('Version restauree avec succes', 'success');
                setTimeout(() => location.href = '<?= ADMIN_URL ?>/article-historique/' + articleId + '/<?= slugify($article['titre']) ?>', 1500);
            } else {
                showAlert('Erreur lors de la restauration', 'error');
            }
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>


