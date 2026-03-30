# Systeme de Versioning des Articles - Guide d'Utilisation

## 📋 Vue d'ensemble

Le systeme de versioning permet de conserver l'historique complet de chaque article et de restaurer des versions anterieures si necessaire.

## ✨ Fonctionnalites

### 1. **Sauvegarde automatique des versions**
- À chaque modification d'un article, la version precedente est automatiquement archivee
- Chaque version est associee à:
  - Un numero de version
  - L'utilisateur qui a fait la modification
  - La date et l'heure
  - Une description optionnelle du changement (changelog)

### 2. **Historique des versions**
- Accedez à l'historique complet via le bouton "📋 Voir l'historique" sur la page d'edition
- Affiche toutes les versions avec:
  - Numero de version
  - Titre
  - Auteur de la modification
  - Date
  - Description du changement

### 3. **Affichage detaille d'une version**
- Consultez le contenu exact d'une version passee
- Visualisez les metadonnees (qui a modifie, quand, etc.)

### 4. **Restauration des versions**
- Restaurez un article à n'importe quelle version precedente
- L'etat actuel devient automatiquement une nouvelle version
- Traçabilite complete avec archivage automatique

## 🗄️ Structure de la Base de Donnees

### Table `article_versions`
```sql
CREATE TABLE article_versions (
    id SERIAL PRIMARY KEY,
    article_id INTEGER -- Reference à l'article
    titre VARCHAR(250) -- Titre de la version
    description TEXT -- Description courte
    contenu TEXT -- Contenu complet
    version_number INTEGER -- Numero sequentiel
    created_at TIMESTAMP -- Date de creation
    updated_by INTEGER -- Utilisateur qui a modifie
    changelog TEXT -- Description du changement
);
```

### Index pour performance
- `idx_article_versions_article` - Recherche rapide par article
- `idx_article_versions_date` - Tri par date
- `idx_article_versions_version` - Recherche article + version

## 🔄 Flux de Travail

### Modification d'un article
1. Accedez à la page d'edition
2. Modifiez le contenu
3. **Optionnel:** Decrivez votre changement dans "Description du changement"
   - Exemple: "Correction orthographe", "Ajout sources bibliographiques"
4. Cliquez sur "Sauvegarder"
5. L'etat precedent est automatiquement archive

### Consulter l'historique
1. Sur la page d'edition, cliquez sur "📋 Voir l'historique"
2. Vous voyez toutes les versions avec:
   - Qui a modifie
   - Quand
   - Quelle description de changement

### Restaurer une version
1. Allez à "Voir l'historique"
2. Trouvez la version à restaurer
3. Cliquez sur "Voir" pour verifier son contenu
4. Cliquez sur "Restaurer"
5. Confirmez l'action
6. La version est restauree et l'etat precedent est archive

## 📊 Cas d'usage

### ✓ Correction d'une erreur
- Modifiez l'article
- Description: "Correction typo ligne 3"
- Sauvegardez

### ✓ Restauration apres modification erronee
- Allez à l'historique
- Trouvez la derniere version correcte
- Restaurez-la

### ✓ Audit et traçabilite
- Consultez l'historique pour voir qui a modifie quoi et quand
- Chaque modification est tracee avec nom d'utilisateur

### ✓ Collaboration
- Plusieurs auteurs peuvent modifier le même article
- Chacun voit qui a fait quelle modification

## 🚀 Implementation Technique

### Modeles PHP

#### `ArticleVersion` - Gere les operations sur les versions
```php
- getByArticleId() - Recupere l'historique
- create() - Cree une nouvelle version
- restore() - Restaure une version
- getSpecificVersion() - Affiche une version
- compareVersions() - Compare deux versions
```

#### `Article` - Integration du versioning
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

Le systeme conserve 50 dernieres versions par defaut (configurable).
Chaque version stocke:
- Titre (~250 caracteres)
- Description (~500 caracteres)
- Contenu (~plusieurs KB)

**Exemple:** Pour un article avec contenu moyen (50 KB), 50 versions = ~2.5 MB par article

## 🔐 Securite

✓ Authentification requise (session utilisateur)
✓ Traçabilite complete (utilisateur + timestamp)
✓ Suppression en cascade si un article est supprime
✓ Contrôle d'acces via le systeme d'authentification existant

## 📝 Donnees d'Exemple

```sql
-- Version 1: Creation
INSERT INTO article_versions VALUES (
    1, 1, 'Mon article', 'Description', 'Contenu initial', 
    1, CURRENT_TIMESTAMP, 1, 'Creation initiale'
);

-- Version 2: Premiere modification
INSERT INTO article_versions VALUES (
    2, 1, 'Mon article', 'Description', 'Contenu initial', 
    2, CURRENT_TIMESTAMP, 1, 'Correction orthographe'
);

-- Version 3: Restauration depuis v1
INSERT INTO article_versions VALUES (
    3, 1, 'Mon article', 'Description', 'Contenu initial', 
    3, CURRENT_TIMESTAMP, 2, 'Restauree depuis version 1'
);
```

## ✅ Checklist - Verification

- [x] Table `article_versions` creee dans SQL
- [x] Modele `ArticleVersion` developpe
- [x] Integration dans le modele `Article`
- [x] Routes admin ajoutees
- [x] Vues creees (historique, affichage version)
- [x] Button "Voir l'historique" sur edit.php
- [x] Champ "Description du changement" dans edit.php
- [x] Restauration avec archivage automatique

## 🎯 Ameliorations Futures

- [ ] Comparaison diff entre deux versions
- [ ] Prise de snapshot automatique à heure fixe
- [ ] Limitation du nombre de versions conservees
- [ ] Export de l'historique en PDF
- [ ] Notifications sur modifications
- [ ] Timeline visuelle de l'historique
