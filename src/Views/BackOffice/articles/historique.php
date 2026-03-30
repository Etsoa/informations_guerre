<?php
// Vue BackOffice - Historique des versions d'un article

require __DIR__ . '/layouts/header.php';
?>

<div class="container">
    <h1>Historique - <?php echo htmlspecialchars($article['titre']); ?></h1>

    <div class="article-info">
        <p>
            <strong>Article:</strong> 
            <a href="<?php echo ADMIN_URL . '?page=article-edit&id=' . $article['id']; ?>">
                <?php echo htmlspecialchars($article['titre']); ?>
            </a>
        </p>
        <p><strong>Versions enregistrées:</strong> <?php echo count($versions); ?></p>
    </div>

    <?php if (!empty($versions)): ?>
        <table class="table">
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
                        <td><strong>v<?php echo $version['version_number']; ?></strong></td>
                        <td><?php echo htmlspecialchars(substr($version['titre'], 0, 50)) . (strlen($version['titre']) > 50 ? '...' : ''); ?></td>
                        <td><?php echo htmlspecialchars($version['auteur_nom'] ?? 'Système'); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($version['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($version['changelog'] ?? '-'); ?></td>
                        <td>
                            <a href="<?php echo ADMIN_URL . '?page=article-version&id=' . $article['id'] . '&version=' . $version['version_number']; ?>" class="btn btn-info btn-sm">
                                Voir
                            </a>
                            <a href="<?php echo ADMIN_URL . '?page=article-restaurer&id=' . $article['id'] . '&version=' . $version['version_number']; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Restaurer cette version?');">
                                Restaurer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            Aucune version enregistrée pour cet article.
        </div>
    <?php endif; ?>

    <div class="actions">
        <a href="<?php echo ADMIN_URL . '?page=article-edit&id=' . $article['id']; ?>" class="btn btn-primary">
            Modifier l'article
        </a>
        <a href="<?php echo ADMIN_URL . '?page=articles'; ?>" class="btn btn-secondary">
            Retour à la liste
        </a>
    </div>
</div>

<style>
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th {
        background: #f5f5f5;
        padding: 12px;
        text-align: left;
        border-bottom: 2px solid #ddd;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    .table tr:hover {
        background: #f9f9f9;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        margin: 2px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 12px;
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-warning {
        background: #ffc107;
        color: black;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn:hover {
        opacity: 0.8;
    }

    .article-info {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .actions {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }
</style>

<?php require __DIR__ . '/layouts/footer.php'; ?>
