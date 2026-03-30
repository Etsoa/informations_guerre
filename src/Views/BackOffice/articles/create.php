<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Créer un Article</h2>

<form method="POST" enctype="multipart/form-data">
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

        <div style="margin: 15px 0;">
            <label for="auteurs">
                <strong>Auteur(s):</strong>
            </label>
            <select name="auteurs[]" id="auteurs" multiple style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
                <?php foreach ($auteurs as $auteur): ?>
                    <option value="<?= $auteur['id'] ?>">
                        <?= htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small>Maintenez Ctrl (Windows) ou Cmd (Mac) pour en sélectionner plusieurs</small>
        </div>

        <div style="margin: 15px 0;" id="sources-container">
            <label><strong>Sources:</strong></label>
            <div class="source-row" style="display: flex; gap: 10px; margin-top: 5px; max-width: 600px;">
                <input type="text" name="source_nom[]" placeholder="Nom de la source" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <input type="url" name="source_url[]" placeholder="URL (ex: https://...)" style="flex: 2; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="button" onclick="addSourceRow()" style="padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">+</button>
            </div>
        </div>

        <div style="margin: 15px 0;">
            <label for="images">
                <strong>Images (optionnelles, multiples possibles):</strong>
            </label>
            <input 
                type="file" 
                id="images" 
                name="images[]" 
                multiple 
                accept="image/*"
                style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px;"
            >
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

<script>
function addSourceRow() {
    const container = document.getElementById('sources-container');
    const row = document.createElement('div');
    row.className = 'source-row';
    row.style = 'display: flex; gap: 10px; margin-top: 10px; max-width: 600px;';
    
    row.innerHTML = `
        <input type="text" name="source_nom[]" placeholder="Nom de la source" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <input type="url" name="source_url[]" placeholder="URL (ex: https://...)" style="flex: 2; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="button" onclick="this.parentElement.remove()" style="padding: 8px 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">-</button>
    `;
    
    container.appendChild(row);
}
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
