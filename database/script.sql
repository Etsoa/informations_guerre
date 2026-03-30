-- Base de donnees: informations_guerre (Version optimisee pour TinyMCE)
-- Les tables seront creees dans la base definie par docker-compose

-- Table utilisateurs
CREATE TABLE utilisateurs(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Table auteurs
CREATE TABLE auteurs(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100)
);

-- Table categories
CREATE TABLE categories(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

-- Table articles
-- (Les images et les sources sont maintenant gerees directement via le contenu HTML genere par TinyMCE)
CREATE TABLE articles(
    id SERIAL PRIMARY KEY,
    titre VARCHAR(250) NOT NULL,
    description TEXT NOT NULL, -- Utilise comme "chapeau" / resume
    contenu TEXT NOT NULL,     -- Le contenu riche genere par TinyMCE (Rich Text HTML)
    date_publication TIMESTAMP
);

-- Table article_versions (historique des modifications)
CREATE TABLE article_versions (
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    titre VARCHAR(250) NOT NULL,
    description TEXT NOT NULL,
    contenu TEXT NOT NULL,
    auteurs_json TEXT,         -- Backup des auteurs au moment de la version
    version_number INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INTEGER REFERENCES utilisateurs(id),
    changelog TEXT
);

-- Table article_auteur (Relation Many-to-Many pour les metadonnees)
CREATE TABLE article_auteur(
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    auteur_id INTEGER NOT NULL REFERENCES auteurs(id) ON DELETE CASCADE
);

-- Table sources (liens vers sources externes par article)
CREATE TABLE sources(
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    nom VARCHAR(150) NOT NULL,
    url TEXT NOT NULL
);

-- Table images (fichiers associes aux articles)
CREATE TABLE images(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    article_id INTEGER NOT NULL REFERENCES articles(id) ON DELETE CASCADE
);

-- Table article_categorie (Relation Many-to-Many pour filtrage)
CREATE TABLE article_categorie(
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    categorie_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE
);

-- Index pour les performances
CREATE INDEX idx_articles_date ON articles(date_publication);

-- Index pour article_versions
CREATE INDEX idx_article_versions_article ON article_versions(article_id);
CREATE INDEX idx_article_versions_date ON article_versions(created_at);
CREATE INDEX idx_article_versions_version ON article_versions(article_id, version_number);