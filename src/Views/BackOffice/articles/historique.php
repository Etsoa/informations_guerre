<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Historique des Versions</h2>

<h3>Article: <?= htmlspecialchars($article['titre']) ?></h3>

<div style="margin: 15px 0; padding: 10px; border: 1px solid #17a2b8; background: #d1ecf1; border-radius: 4px;">
    <p><strong>Article ID:</strong> <?= $article['id'] ?></p>
    <p><strong>Versions enregistrées:</strong> <?= count($versions) ?></p>
    <p>
        <a href="<?= ADMIN_URL ?>?page=article-edit&id=<?= $article['id'] ?>">
            ← Retour à l'édition
        </a>
    </p>
</div>

<?php if (!empty($versions)): ?>
    <table border="1" cellpadding="10" width="100%">
        <thead>
            <tr>
                <th>Version</th>
                <th>Titre</th>
                <th>Modifié par</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($versions as $version): ?>
                <tr>
                    <td><strong>v<?= $version['version_number'] ?></strong></td>
                    <td><?= htmlspecialchars(substr($version['titre'], 0, 50)) ?></td>
                    <td><?= htmlspecialchars($version['auteur_nom'] ?? 'Système') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($version['created_at'])) ?></td>
                    <td><em><?= htmlspecialchars($version['changelog'] ?? '-') ?></em></td>
                    <td>
                        <a href="<?= ADMIN_URL ?>?page=article-version&id=<?= $article['id'] ?>&version=<?= $version['version_number'] ?>">Voir</a>
                        |
                        <button 
                            onclick="restoreVersion(<?= $article['id'] ?>, <?= $version['version_number'] ?>)"
                            style="background: none; border: none; color: blue; cursor: pointer; text-decoration: underline;"
                        >
                            Restaurer
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div style="margin: 20px 0; padding: 15px; border: 1px solid #ffc107; background: #fff3cd; border-radius: 4px;">
        <em>Aucune version enregistrée pour cet article.</em>
    </div>
<?php endif; ?>

<div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #ddd;">
    <a href="<?= ADMIN_URL ?>?page=articles">← Retour à la liste des articles</a>
</div>

<script>
    function restoreVersion(articleId, versionNumber) {
        if (!confirm('Êtes-vous sûr de vouloir restaurer cette version? L\'état actuel sera archivé.')) {
            return;
        }
        
        ajax('POST', '<?= ADMIN_URL ?>', {
            page: 'article-restaurer',
            id: articleId,
            version: versionNumber
        }, function(response, status) {
            if (status === 200) {
                showAlert('Version restaurée avec succès', 'success');
                setTimeout(() => location.href = '<?= ADMIN_URL ?>?page=article-historique&id=' + articleId, 1500);
            } else {
                showAlert('Erreur lors de la restauration', 'error');
            }
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>