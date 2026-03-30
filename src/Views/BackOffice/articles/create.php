<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Créer un Article</h2>

<form method="POST">
    <fieldset>
        <legend>Nouvel Article</legend>
        
        <div style="margin: 15px 0;">
            <label for="titre">
                <strong>Titre:</strong>
            </label>
            <input 
                type="text" 
                id="titre" 
                name="titre" 
                required 
                maxlength="250"
                placeholder="Titre de l'article"
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
                placeholder="Description courte de l'article"
                style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif;"
            ></textarea>
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
                placeholder="Contenu complet de l'article"
                style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif;"
            ></textarea>
        </div>

        <div style="margin: 20px 0; padding-top: 15px; border-top: 1px solid #ddd;">
            <button 
                type="submit" 
                style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; margin-right: 10px;"
            >
                ✓ Créer l'article
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
