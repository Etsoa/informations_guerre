\c informations_guerre;

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

-- table sources
CREATE TABLE sources(
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id),
    nom VARCHAR(100) NOT NULL UNIQUE,
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

