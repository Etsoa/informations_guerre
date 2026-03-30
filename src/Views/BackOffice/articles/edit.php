<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Éditer Article</h2>

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

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Sauvegarder</button>
        <a href="<?= ADMIN_URL ?>?page=articles" class="btn btn-secondary">Annuler</a>
    </div>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
