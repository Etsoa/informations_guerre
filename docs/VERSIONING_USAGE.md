# Système de Versioning des Articles - Guide d'Utilisation

## 📋 Vue d'ensemble

Le système de versioning permet de conserver l'historique complet de chaque article et de restaurer des versions antérieures si nécessaire.

## ✨ Fonctionnalités

### 1. **Sauvegarde automatique des versions**
- À chaque modification d'un article, la version précédente est automatiquement archivée
- Chaque version est associée à:
  - Un numéro de version
  - L'utilisateur qui a fait la modification
  - La date et l'heure
  - Une description optionnelle du changement (changelog)

### 2. **Historique des versions**
- Accédez à l'historique complet via le bouton "📋 Voir l'historique" sur la page d'édition
- Affiche toutes les versions avec:
  - Numéro de version
  - Titre
  - Auteur de la modification
  - Date
  - Description du changement

### 3. **Affichage détaillé d'une version**
- Consultez le contenu exact d'une version passée
- Visualisez les métadonnées (qui a modifié, quand, etc.)

### 4. **Restauration des versions**
- Restaurez un article à n'importe quelle version précédente
- L'état actuel devient automatiquement une nouvelle version
- Traçabilité complète avec archivage automatique

## 🗄️ Structure de la Base de Données

### Table `article_versions`
```sql
CREATE TABLE article_versions (
    id SERIAL PRIMARY KEY,
    article_id INTEGER -- Référence à l'article
    titre VARCHAR(250) -- Titre de la version
    description TEXT -- Description courte
    contenu TEXT -- Contenu complet
    version_number INTEGER -- Numéro séquentiel
    created_at TIMESTAMP -- Date de création
    updated_by INTEGER -- Utilisateur qui a modifié
    changelog TEXT -- Description du changement
);
```

### Index pour performance
- `idx_article_versions_article` - Recherche rapide par article
- `idx_article_versions_date` - Tri par date
- `idx_article_versions_version` - Recherche article + version

## 🔄 Flux de Travail

### Modification d'un article
1. Accédez à la page d'édition
2. Modifiez le contenu
3. **Optionnel:** Décrivez votre changement dans "Description du changement"
   - Exemple: "Correction orthographe", "Ajout sources bibliographiques"
4. Cliquez sur "Sauvegarder"
5. L'état précédent est automatiquement archivé

### Consulter l'historique
1. Sur la page d'édition, cliquez sur "📋 Voir l'historique"
2. Vous voyez toutes les versions avec:
   - Qui a modifié
   - Quand
   - Quelle description de changement

### Restaurer une version
1. Allez à "Voir l'historique"
2. Trouvez la version à restaurer
3. Cliquez sur "Voir" pour vérifier son contenu
4. Cliquez sur "Restaurer"
5. Confirmez l'action
6. La version est restaurée et l'état précédent est archivé

## 📊 Cas d'usage

### ✓ Correction d'une erreur
- Modifiez l'article
- Description: "Correction typo ligne 3"
- Sauvegardez

### ✓ Restauration après modification erronée
- Allez à l'historique
- Trouvez la dernière version correcte
- Restaurez-la

### ✓ Audit et traçabilité
- Consultez l'historique pour voir qui a modifié quoi et quand
- Chaque modification est tracée avec nom d'utilisateur

### ✓ Collaboration
- Plusieurs auteurs peuvent modifier le même article
- Chacun voit qui a fait quelle modification

## 🚀 Implémentation Technique

### Modèles PHP

#### `ArticleVersion` - Gère les opérations sur les versions
```php
- getByArticleId() - Récupère l'historique
- create() - Crée une nouvelle version
- restore() - Restaure une version
- getSpecificVersion() - Affiche une version
- compareVersions() - Compare deux versions
```

#### `Article` - Intégration du versioning
```php
- update($id, $data, $userId, $changelog)
  // Maintenant accepte l'userId et le changelog
  // Sauvegarde automatiquement l'ancienne version
```

### Routes Admin

```
/admin?page=article-historique&id=1
  → Affiche l'historique de l'article 1

/admin?page=article-version&id=1&version=5
  → Affiche la version 5 de l'article 1

/admin?page=article-restaurer&id=1&version=5
  → Restaure la version 5 de l'article 1
```

## 💾 Espace Disque

Le système conserve 50 dernières versions par défaut (configurable).
Chaque version stocke:
- Titre (~250 caractères)
- Description (~500 caractères)
- Contenu (~plusieurs KB)

**Exemple:** Pour un article avec contenu moyen (50 KB), 50 versions = ~2.5 MB par article

## 🔐 Sécurité

✓ Authentification requise (session utilisateur)
✓ Traçabilité complète (utilisateur + timestamp)
✓ Suppression en cascade si un article est supprimé
✓ Contrôle d'accès via le système d'authentification existant

## 📝 Données d'Exemple

```sql
-- Version 1: Création
INSERT INTO article_versions VALUES (
    1, 1, 'Mon article', 'Description', 'Contenu initial', 
    1, CURRENT_TIMESTAMP, 1, 'Création initiale'
);

-- Version 2: Première modification
INSERT INTO article_versions VALUES (
    2, 1, 'Mon article', 'Description', 'Contenu initial', 
    2, CURRENT_TIMESTAMP, 1, 'Correction orthographe'
);

-- Version 3: Restauration depuis v1
INSERT INTO article_versions VALUES (
    3, 1, 'Mon article', 'Description', 'Contenu initial', 
    3, CURRENT_TIMESTAMP, 2, 'Restaurée depuis version 1'
);
```

## ✅ Checklist - Vérification

- [x] Table `article_versions` créée dans SQL
- [x] Modèle `ArticleVersion` développé
- [x] Intégration dans le modèle `Article`
- [x] Routes admin ajoutées
- [x] Vues créées (historique, affichage version)
- [x] Button "Voir l'historique" sur edit.php
- [x] Champ "Description du changement" dans edit.php
- [x] Restauration avec archivage automatique

## 🎯 Améliorations Futures

- [ ] Comparaison diff entre deux versions
- [ ] Prise de snapshot automatique à heure fixe
- [ ] Limitation du nombre de versions conservées
- [ ] Export de l'historique en PDF
- [ ] Notifications sur modifications
- [ ] Timeline visuelle de l'historique
