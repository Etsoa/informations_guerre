-- =========================
-- UTILISATEURS
-- =========================
INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES
('Admin', 'admin@guerre-iran.com', '$2y$10$JB06xO/WMHGsPk3uSKKqOu04OJm0xpS8dA67ZkYArLv949xaR41Vy');

-- =========================
-- AUTEURS
-- =========================
INSERT INTO auteurs (nom, prenom, email) VALUES
('Dupont', 'Jean', 'jean.dupont@mail.com'),
('Rakoto', 'Aina', 'aina.rakoto@mail.com'),
('Martin', 'Claire', 'claire.martin@mail.com'),
('Smith', 'David', 'david.smith@mail.com'),
('Razanamasy', 'Andry', 'andry.razana@mail.com');

-- =========================
-- CATEGORIES
-- =========================
INSERT INTO categories (nom) VALUES
('Politique'),
('Militaire'),
('Économie'),
('Diplomatie'),
('Humanitaire'),
('International');

-- =========================
-- ARTICLES (avec TinyMCE HTML)
-- =========================
INSERT INTO articles (titre, description, contenu, date_publication) VALUES
('Tensions croissantes au Moyen-Orient',
 'Les tensions entre plusieurs puissances régionales continuent de s intensifier.',
 '<p>Les tensions entre l Iran et ses voisins continuent de croître.</p>
  <img src="/uploads/tensions-moyen-orient.jpg"/>
  <p>Plusieurs incidents militaires ont été signalés.</p>
  <p><strong>Source :</strong> <a href="https://www.reuters.com">Reuters</a></p>',
 NOW()),

('Sanctions économiques renforcées',
 'De nouvelles sanctions impactent fortement l économie iranienne.',
 '<p>Les sanctions internationales ont été renforcées.</p>
  <img src="/uploads/sanctions-economiques.jpg"/>
  <p>Le secteur pétrolier est fortement touché.</p>
  <p><strong>Source :</strong> <a href="https://www.bbc.com">BBC News</a></p>',
 NOW()),

('Négociations diplomatiques en cours',
 'Des discussions sont en cours pour éviter une escalade militaire.',
 '<p>Des discussions diplomatiques sont en cours.</p>
  <img src="/uploads/desescalade-diplomatie.jpg"/>
  <p>Les négociations restent fragiles.</p>
  <p><strong>Source :</strong> <a href="https://www.aljazeera.com">Al Jazeera</a></p>',
 NOW()),

('Crise humanitaire émergente',
 'La population civile commence à subir les effets du conflit.',
 '<p>La situation humanitaire se dégrade rapidement.</p>
  <img src="/uploads/crise-humanitaire.jpg"/>
  <p>Les ONG tirent la sonnette d alarme.</p>
  <p><strong>Source :</strong> <a href="https://news.un.org">UN News</a></p>',
 NOW()),

('Renforcement militaire dans la région',
 'Des mouvements de troupes ont été observés.',
 '<p>Plusieurs armées renforcent leur présence.</p>
  <img src="/uploads/renforcement-militaire.jpg"/>
  <p>Une escalade est possible.</p>
  <p><strong>Source :</strong> <a href="https://www.france24.com">France24</a></p>',
 NOW());

-- =========================
-- ARTICLE_AUTEUR
-- =========================
INSERT INTO article_auteur (article_id, auteur_id) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 2),
(3, 4),
(4, 5),
(5, 1),
(5, 3);

-- =========================
-- ARTICLE_CATEGORIE
-- =========================
INSERT INTO article_categorie (article_id, categorie_id) VALUES
(1, 2),
(1, 6),
(2, 3),
(3, 4),
(4, 5),
(5, 2),
(5, 1);

-- =========================
-- SOURCES
-- =========================
INSERT INTO sources (article_id, nom, url) VALUES
(1, 'Reuters', 'https://www.reuters.com'),
(2, 'BBC News', 'https://www.bbc.com'),
(3, 'Al Jazeera', 'https://www.aljazeera.com'),
(4, 'UN News', 'https://news.un.org'),
(5, 'France24', 'https://www.france24.com');

-- =========================
-- IMAGES (min 3 par article, pool de 5 fichiers)
-- =========================
INSERT INTO images (nom, article_id) VALUES
-- Article 1
('tensions-moyen-orient.jpg', 1),
('impact-economique.jpg', 1),
('explosion-base.jpg', 1),
-- Article 2
('explosion-base.jpg', 2),
('desescalade-diplomatie.jpg', 2),
('crise-humanitaire.jpg', 2),
-- Article 3
('impact-economique.jpg', 3),
('sanctions-economiques.jpg', 3),
('renforcement-militaire.jpg', 3),
-- Article 4
('desescalade-diplomatie.jpg', 4),
('tensions-moyen-orient.jpg', 4),
('impact-economique.jpg', 4),
-- Article 5
('crise-humanitaire.jpg', 5),
('explosion-base.jpg', 5),
('renforcement-militaire.jpg', 5),
-- Article 6
('sanctions-economiques.jpg', 6),
('impact-economique.jpg', 6),
('desescalade-diplomatie.jpg', 6),
-- Article 7
('renforcement-militaire.jpg', 7),
('tensions-moyen-orient.jpg', 7),
('crise-humanitaire.jpg', 7);

-- =========================
-- ARTICLE_VERSIONS
-- =========================
INSERT INTO article_versions 
(article_id, titre, description, contenu, auteurs_json, version_number, updated_by, changelog)
VALUES
(1,
 'Tensions croissantes au Moyen-Orient',
 'Version initiale',
 '<p>Première version.</p>',
 '[{"nom":"Dupont","prenom":"Jean"},{"nom":"Rakoto","prenom":"Aina"}]',
 1,
 1,
 'Création'),

(1,
 'Tensions croissantes au Moyen-Orient',
 'Mise à jour',
 '<p>Ajout des frappes récentes.</p>',
 '[{"nom":"Dupont","prenom":"Jean"},{"nom":"Rakoto","prenom":"Aina"}]',
 2,
 1,
 'Update'),

(2,
 'Sanctions économiques renforcées',
 'Version initiale',
 '<p>Première version.</p>',
 '[{"nom":"Martin","prenom":"Claire"}]',
 1,
 1,
 'Création'),

(3,
 'Négociations diplomatiques en cours',
 'Version initiale',
 '<p>Début des discussions.</p>',
 '[{"nom":"Rakoto","prenom":"Aina"},{"nom":"Smith","prenom":"David"}]',
 1,
 1,
 'Création');