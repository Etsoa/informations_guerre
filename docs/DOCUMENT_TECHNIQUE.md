# Document Technique - Informations Guerre Iran

## 1) Objectifs realises
- Site FrontOffice d'information sur la guerre en Iran
- BackOffice de gestion des contenus
- Base de donnees PostgreSQL avec donnees de demo
- URL rewriting active (Apache + .htaccess)
- Optimisation SEO de base (title, meta description, structure h1-h6, alt images)
- Recherche avec endpoint AJAX

## 2) Architecture
- Langage: PHP 8.2
- Base de donnees: PostgreSQL 15
- Serveur web: Apache (mod_rewrite actif)
- Conteneurisation: Docker + docker-compose

## 3) Modelisation base de donnees
Tables principales:
- utilisateurs
- articles
- categories
- auteurs
- images
- sources
- article_categorie
- article_auteur
- article_versions

Scripts SQL:
- schema: database/script.sql
- donnees initiales: database/data.sql
- reset: database/reset.sql

## 4) URLs normalisees (rewriting)
Routes principales:
- / -> accueil FrontOffice
- /article/{id}-{slug} -> detail article
- /category/{id}-{slug} -> liste par categorie
- /search?q=motcle -> recherche
- /search-ajax?q=mo -> suggestions AJAX
- /admin -> espace BackOffice

## 5) FrontOffice
- Menu categories dans l'en-tete
- Mise en page editoriale
- Page article detaillee avec categories, auteurs, sources, contenus lies
- Page categorie
- Page recherche
- Page 404

## 6) BackOffice
- Login
- Gestion des articles
- Historique des versions

Identifiants par defaut:
- Email: admin@guerre-iran.com
- Mot de passe: admin123

## 7) SEO - checklist
- URL lisibles: OK
- Balises titres h1/h2/h3: OK
- Balise title par page: OK
- Meta description par page: OK
- Attribut alt sur les images: OK

## 8) Test Lighthouse local
Effectuer les tests sur:
- Mobile
- Desktop

Pages a tester:
- /
- /article/1-tensions-accrues-au-moyen-orient-analyse-de-la-situation-en-iran
- /category/2-militaire
- /search?q=iran

Conseils avant test:
- executer en local avec Docker
- activer le cache navigateur
- verifier qu'aucune erreur 404 asset n'apparait

## 9) Livraison
A fournir:
- Archive .zip du projet complet (fonctionnel avec Docker)
- Depot public GitHub/GitLab
- Ce document technique complete avec:
  - captures ecran FrontOffice
  - captures ecran BackOffice
  - schema/modelisation de la base
  - numero etudiant (NUM ETU)

## 10) Commandes de demarrage
```bash
docker-compose up -d --build
docker-compose ps
```

Acces:
- FrontOffice: http://localhost
- BackOffice: http://localhost/admin
