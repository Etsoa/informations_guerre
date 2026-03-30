-- =========================
-- UTILISATEURS
-- =========================
INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES
('Admin', 'admin@guerre-iran.com', 'admin123'),
('Editor', 'editor@guerre-iran.com', 'editor123');

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
('Economie'),
('Diplomatie'),
('Humanitaire'),
('International');

-- =========================
-- ARTICLES
-- =========================
INSERT INTO articles (titre, description, contenu, date_publication) VALUES

(
'Tensions accrues au Moyen-Orient',
'Une montée des tensions est observée dans la région.',
'Depuis plusieurs semaines, les tensions au Moyen-Orient s’intensifient. Des mouvements militaires et des déclarations politiques ont ravivé les inquiétudes internationales. Les analystes craignent une escalade du conflit si aucune solution diplomatique n’est trouvée.',
NOW()
),

(
'Explosion signalée près d’une base stratégique',
'Un incident a été rapporté dans une zone militaire.',
'Une explosion a été signalée à proximité d’une installation stratégique. Les autorités locales ont ouvert une enquête afin de déterminer les causes de l’incident. Aucune information officielle n’a encore été confirmée.',
NOW()
),

(
'Impact économique du conflit',
'L’économie mondiale commence à ressentir les effets.',
'Les marchés internationaux réagissent fortement aux tensions. Le prix du pétrole connaît une hausse, tandis que les investisseurs adoptent une posture prudente face à l’incertitude.',
NOW()
),

(
'Appels à la désescalade',
'La communauté internationale réagit.',
'Plusieurs organisations internationales ont appelé à la retenue et à la reprise du dialogue. Les discussions diplomatiques se poursuivent dans le but d’éviter une aggravation de la situation.',
NOW()
),

(
'Situation humanitaire préoccupante',
'Les populations civiles sont touchées.',
'Les ONG alertent sur la dégradation des conditions de vie dans certaines zones. L’accès aux ressources essentielles devient de plus en plus difficile pour les civils.',
NOW()
),

(
'Nouvelles sanctions économiques',
'De nouvelles mesures internationales.',
'Des sanctions économiques ont été annoncées par plusieurs pays en réponse à la situation actuelle. Ces mesures visent à exercer une pression diplomatique sur les acteurs impliqués.',
NOW()
),

(
'Renforcement militaire dans la région',
'Déploiement de nouvelles forces.',
'Plusieurs pays ont renforcé leur présence militaire dans la région, augmentant ainsi les tensions déjà présentes. Les experts appellent à la vigilance.',
NOW()
);

-- =========================
-- SOURCES
-- =========================
INSERT INTO sources (article_id, nom, url) VALUES
(1, 'Reuters', 'https://www.reuters.com'),
(2, 'BBC News', 'https://www.bbc.com'),
(3, 'Al Jazeera', 'https://www.aljazeera.com'),
(4, 'France24', 'https://www.france24.com'),
(5, 'UN News', 'https://news.un.org'),
(6, 'CNN', 'https://www.cnn.com'),
(7, 'Le Monde', 'https://www.lemonde.fr');

-- =========================
-- IMAGES
-- =========================
INSERT INTO images (nom, article_id) VALUES
('iran_tensions.jpg', 1),
('explosion_zone.jpg', 2),
('economy_impact.jpg', 3),
('diplomacy_meeting.jpg', 4),
('humanitarian_aid.jpg', 5),
('sanctions.jpg', 6),
('military_deployment.jpg', 7);

-- =========================
-- ARTICLE_AUTEUR
-- =========================
INSERT INTO article_auteur (article_id, auteur_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 4),
(6, 5),
(7, 2);

-- =========================
-- ARTICLE_CATEGORIE
-- =========================
INSERT INTO article_categorie (article_id, categorie_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 3),
(7, 2);