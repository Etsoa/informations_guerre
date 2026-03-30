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

<form method="POST" enctype="multipart/form-data">
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
            <label for="auteurs">
                <strong>Auteur(s):</strong>
            </label>
            <select name="auteurs[]" id="auteurs" multiple style="width: 100%; max-width: 600px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
                <?php foreach ($auteurs as $auteur): ?>
                    <option value="<?= $auteur['id'] ?>" <?= in_array($auteur['id'], $currentAuteursIds) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small>Maintenez Ctrl (Windows) ou Cmd (Mac) pour en sélectionner plusieurs</small>
        </div>

        <div style="margin: 15px 0;" id="sources-container">
            <label><strong>Sources:</strong></label>
            
            <?php if (!empty($articleSources)): ?>
                <?php foreach ($articleSources as $index => $source): ?>
                    <div class="source-row" style="display: flex; gap: 10px; margin-top: 5px; max-width: 600px;">
                        <input type="text" name="source_nom[]" value="<?= htmlspecialchars($source['nom']) ?>" placeholder="Nom de la source" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        <input type="url" name="source_url[]" value="<?= htmlspecialchars($source['url']) ?>" placeholder="URL (ex: https://...)" style="flex: 2; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        <?php if ($index === 0): ?>
                            <button type="button" onclick="addSourceRow()" style="padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">+</button>
                        <?php else: ?>
                            <button type="button" onclick="this.parentElement.remove()" style="padding: 8px 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">-</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="source-row" style="display: flex; gap: 10px; margin-top: 5px; max-width: 600px;">
                    <input type="text" name="source_nom[]" placeholder="Nom de la source" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <input type="url" name="source_url[]" placeholder="URL (ex: https://...)" style="flex: 2; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <button type="button" onclick="addSourceRow()" style="padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">+</button>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin: 15px 0;">
            <label><strong>Images Actuelles:</strong></label>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $img): ?>
                        <div id="image-<?= $img['id'] ?>" style="position: relative; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                            <img src="<?= UPLOADS_URL . htmlspecialchars($img['nom']) ?>" alt="Image" style="max-height: 100px; display: block;">
                            <button type="button" onclick="deleteImage(<?= $img['id'] ?>)" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none; cursor: pointer;">X</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <em>Aucune image</em>
                <?php endif; ?>
            </div>
        </div>

        <div style="margin: 15px 0;">
            <label for="images">
                <strong>Ajouter de nouvelles images:</strong>
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

    function deleteImage(imageId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette image?')) return;
        
        ajax('POST', '<?= ADMIN_URL ?>/image-delete', { 
            image_id: imageId
        }, function(response, status) {
            if (status === 200) {
                showAlert('Image supprimée avec succès', 'success');
                document.getElementById('image-' + imageId).remove();
            } else {
                showAlert('Erreur lors de la suppression', 'error');
            }
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>