<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="article-edit-container">
    <div class="article-header">
        <h2>Éditer Article</h2>
        <div class="article-actions">
            <a href="<?= ADMIN_URL ?>?page=article-historique&id=<?= $article['id'] ?>" class="btn btn-info">
                📋 Voir l'historique
            </a>
        </div>
    </div>

    <form method="POST" class="article-form">
        <div class="form-group">
            <label>Titre</label>
            <input type="text" name="titre" value="<?= sanitize($article['titre']) ?>" required maxlength="250">
        </div>

        <div class="form-group">
            <label>Description courte</label>
            <textarea name="description" required rows="3" maxlength="500"><?= sanitize($article['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Contenu</label>
            <textarea name="contenu" required rows="10"><?= sanitize($article['contenu']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="changelog">Description du changement (optionnel)</label>
            <input type="text" id="changelog" name="changelog" placeholder="Ex: Correction orthographe, Ajout de sources..." maxlength="255">
            <small>Cette description sera enregistrée dans l'historique des versions</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Sauvegarder</button>
            <a href="<?= ADMIN_URL ?>?page=articles" class="btn btn-secondary">✗ Annuler</a>
        </div>
    </form>
</div>

<style>
    .article-edit-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .article-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e0e0e0;
    }

    .article-actions {
        display: flex;
        gap: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #333;
    }

    .form-group input[type="text"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input[type="text"]:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }

    .form-group small {
        display: block;
        margin-top: 5px;
        color: #666;
        font-size: 12px;
    }

    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        text-align: center;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        margin: 0 5px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        border: none;
        font-size: 14px;
        transition: opacity 0.3s;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn:hover {
        opacity: 0.8;
    }
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

