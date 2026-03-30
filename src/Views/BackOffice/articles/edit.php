<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Éditer Article</h2>

<div style="margin: 15px 0; padding: 10px; border: 1px solid #17a2b8; background: #d1ecf1; border-radius: 4px;">
    <strong>Article ID:</strong> <?= $article['id'] ?><br>
    <strong>Créé le:</strong> <?= date('d/m/Y H:i', strtotime($article['date_publication'])) ?>
    <div style="margin-top: 10px;">
        <a href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>" style="color: #0c5460; text-decoration: underline;">
            📋 Voir l'historique des versions
        </a>
    </div>
</div>

<form method="POST">
    <fieldset>
        <legend>Modification d'Article</legend>
        
        <div style="margin: 15px 0;">
            <label for="titre">
                <strong>Titre:</strong>
            </label>
            <input 
                type="text" 
                id="titre" 
                name="titre" 
                value="<?= htmlspecialchars($article['titre']) ?>" 
                required 
                maxlength="250"
                style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
            >
        </div>

        <div style="margin: 15px 0;">
            <label for="description">
                <strong>Description courte:</strong>
            </label>
            <textarea 
                id="description" 
                name="description" 
                required 
                rows="3" 
                maxlength="500"
                style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif;"
            ><?= htmlspecialchars($article['description']) ?></textarea>
            <small>500 caractères maximum</small>
        </div>

        <div style="margin: 15px 0;">
            <label for="contenu">
                <strong>Contenu:</strong>
            </label>
            <textarea 
                id="contenu" 
                name="contenu" 
                required 
                rows="12"
                style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif;"
            ><?= htmlspecialchars($article['contenu']) ?></textarea>
        </div>

        <div style="margin: 15px 0;">
            <label for="changelog">
                <strong>Description du changement (optionnel):</strong>
            </label>
            <input 
                type="text" 
                id="changelog" 
                name="changelog" 
                placeholder="Ex: Correction orthographe, Ajout de sources..." 
                maxlength="255"
                style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
            >
            <small>Cette description sera enregistrée dans l'historique des versions</small>
        </div>

        <div style="margin: 20px 0; padding-top: 15px; border-top: 1px solid #ddd;">
            <button 
                type="submit" 
                style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; margin-right: 10px;"
            >
                ✓ Sauvegarder les modifications
            </button>
            <a 
                href="<?= ADMIN_URL ?>/articles"
                style="display: inline-block; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;"
            >
                ✗ Annuler
            </a>
        </div>
    </fieldset>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>