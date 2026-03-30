-- Base de données: informations_guerre
-- Les tables seront créées dans la base définie par docker-compose

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

-- Table catégories
CREATE TABLE categories(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

-- Table articles
CREATE TABLE articles(
    id SERIAL PRIMARY KEY,
    titre VARCHAR(250) NOT NULL,
    description TEXT NOT NULL,
    contenu TEXT NOT NULL,
    date_publication TIMESTAMP
);

-- Table article_versions (historique des modifications)
CREATE TABLE article_versions (
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    titre VARCHAR(250) NOT NULL,
    description TEXT NOT NULL,
    contenu TEXT NOT NULL,
    auteurs_json TEXT,
    sources_json TEXT,
    version_number INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INTEGER REFERENCES utilisateurs(id),
    changelog TEXT
);

-- table sources
CREATE TABLE sources(
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id),
    nom VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL
);

-- Table images 
CREATE TABLE images(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    article_id INTEGER NOT NULL REFERENCES articles(id)
);

-- Table article_auteur 
CREATE TABLE article_auteur(
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id),
    auteur_id INTEGER NOT NULL REFERENCES auteurs(id)
);

-- Table article_categorie
CREATE TABLE article_categorie(
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id),
    categorie_id INTEGER NOT NULL REFERENCES categories(id)
);

-- Index pour les performances
CREATE INDEX idx_articles_date ON articles(date_publication);
CREATE INDEX idx_images_article ON images(article_id);

-- Index pour article_versions
CREATE INDEX idx_article_versions_article ON article_versions(article_id);
CREATE INDEX idx_article_versions_date ON article_versions(created_at);
CREATE INDEX idx_article_versions_version ON article_versions(article_id, version_number);

