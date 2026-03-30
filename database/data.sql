-- =========================
-- UTILISATEURS (mot de passe hashé avec password_hash)
-- Identifiants par défaut: admin@guerre-iran.com / admin123
-- =========================
INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES
('Admin', 'admin@guerre-iran.com', '$2y$10$YMjOx7VYfXqGxJz8Z0hMR.KlYk8eFxHdGqMKzJm5q9vN3tFcW6XHe');

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
-- ARTICLES
-- =========================
INSERT INTO articles (titre, description, contenu, date_publication) VALUES

(
'Tensions accrues au Moyen-Orient : analyse de la situation en Iran',
'Une montée des tensions est observée dans la région du Moyen-Orient, avec des répercussions diplomatiques majeures.',
'Depuis plusieurs semaines, les tensions au Moyen-Orient s''intensifient considérablement. Des mouvements militaires et des déclarations politiques ont ravivé les inquiétudes internationales. Les analystes craignent une escalade du conflit si aucune solution diplomatique n''est trouvée rapidement.

Les experts en géopolitique soulignent que cette crise ne se limite pas à un seul pays mais implique une reconfiguration complète des alliances régionales. Les États-Unis, la Russie et la Chine suivent de près l''évolution de la situation.

La population civile, prise en étau entre les différentes factions, subit les conséquences directes de cette escalade. Les organisations humanitaires alertent sur la nécessité d''un cessez-le-feu immédiat pour permettre l''acheminement de l''aide.',
'2026-03-29 10:00:00'
),

(
'Explosion signalée près d''une base stratégique iranienne',
'Un incident majeur a été rapporté dans une zone militaire sensible, suscitant de vives réactions internationales.',
'Une explosion de forte intensité a été signalée à proximité d''une installation stratégique dans le sud de l''Iran. Les autorités locales ont immédiatement ouvert une enquête afin de déterminer les causes exactes de l''incident.

Selon les premières informations, l''explosion aurait été entendue dans un rayon de plusieurs kilomètres. Les services de secours ont été déployés sur place dans les minutes suivant le blast.

Aucune information officielle n''a encore été confirmée par le gouvernement iranien, mais plusieurs médias internationaux rapportent des versions contradictoires des événements. Les agences de renseignement occidentales analysent les images satellites de la zone.',
'2026-03-28 14:30:00'
),

(
'Impact économique du conflit iranien sur les marchés mondiaux',
'L''économie mondiale commence à ressentir les effets directs du conflit, avec une hausse significative du prix du pétrole.',
'Les marchés internationaux réagissent fortement aux tensions croissantes au Moyen-Orient. Le prix du baril de pétrole a franchi la barre symbolique des 100 dollars, provoquant une onde de choc sur l''ensemble des places financières mondiales.

Les investisseurs adoptent une posture de plus en plus prudente face à l''incertitude géopolitique. Les valeurs refuges comme l''or enregistrent des hausses record, tandis que les devises des pays émergents subissent une pression à la baisse.

Les analystes économiques estiment que si le conflit devait se prolonger au-delà de six mois, les répercussions sur l''économie mondiale pourraient entraîner une récession dans plusieurs pays européens fortement dépendants des importations énergétiques.',
'2026-03-27 09:15:00'
),

(
'Appels internationaux à la désescalade du conflit en Iran',
'La communauté internationale multiplie les initiatives diplomatiques pour éviter un embrasement régional.',
'Plusieurs organisations internationales ont appelé solennellement à la retenue et à la reprise immédiate du dialogue. Les discussions diplomatiques se poursuivent dans le but d''éviter une aggravation de la situation.

Le Secrétaire général des Nations Unies a convoqué une session extraordinaire du Conseil de sécurité. Parallèlement, l''Union européenne a nommé un envoyé spécial pour la médiation dans le conflit.

Les initiatives de paix se multiplient : la Suisse propose ses bons offices pour accueillir des négociations, tandis que le Sultanat d''Oman travaille en coulisses à rapprocher les positions des différentes parties. La route vers la paix reste semée d''obstacles mais l''espoir d''un accord n''est pas totalement éteint.',
'2026-03-26 11:45:00'
),

(
'Crise humanitaire : la situation des civils en Iran s''aggrave',
'Les populations civiles paient le prix fort du conflit, avec un accès de plus en plus limité aux ressources essentielles.',
'Les ONG présentes sur le terrain alertent avec une urgence croissante sur la dégradation rapide des conditions de vie dans les zones les plus touchées par le conflit. L''accès aux ressources essentielles — eau potable, nourriture, médicaments — devient critique pour des millions de civils.

Le Haut Commissariat des Nations Unies pour les réfugiés (HCR) estime que plus de deux millions de personnes ont été déplacées depuis le début des hostilités. Les camps de réfugiés aux frontières sont saturés et les conditions sanitaires se détériorent rapidement.

Médecins Sans Frontières appelle la communauté internationale à agir de toute urgence pour établir des corridors humanitaires et garantir l''accès aux soins pour les populations les plus vulnérables.',
'2026-03-25 16:20:00'
),

(
'Nouvelles sanctions économiques contre l''Iran : portée et conséquences',
'De nouvelles mesures restrictives internationales visent à exercer une pression diplomatique accrue.',
'Des sanctions économiques renforcées ont été annoncées conjointement par l''Union européenne et les États-Unis en réponse à la situation actuelle. Ces mesures visent le secteur bancaire, les exportations de pétrole et les échanges technologiques.

Les nouvelles sanctions prévoient le gel des avoirs de plusieurs hauts responsables iraniens ainsi que l''interdiction de voyage vers les pays signataires. Le secteur pétrolier, principale source de revenus du pays, est particulièrement ciblé.

Les économistes débattent de l''efficacité réelle de ces sanctions. Si elles exercent une pression indéniable, certains experts estiment qu''elles pourraient renforcer le sentiment national et consolider le pouvoir en place plutôt que de favoriser le changement espéré.',
'2026-03-24 13:00:00'
),

(
'Renforcement militaire dans le Golfe Persique : les enjeux stratégiques',
'Le déploiement de nouvelles forces militaires dans la région intensifie les tensions et soulève des questions stratégiques majeures.',
'Plusieurs puissances mondiales ont considérablement renforcé leur présence militaire dans le Golfe Persique au cours des dernières semaines. Les États-Unis ont déployé un groupe aéronaval supplémentaire, tandis que la Russie et la Chine ont intensifié leurs exercices navals dans la région.

Ce déploiement massif de forces soulève des inquiétudes quant au risque d''incident militaire qui pourrait déclencher une escalade incontrôlable. Les experts en stratégie militaire appellent à la mise en place de mécanismes de déconfliction pour éviter tout accident.

Le détroit d''Ormuz, par lequel transite près d''un cinquième du pétrole mondial, reste au cœur des préoccupations. Toute perturbation du trafic maritime dans cette zone aurait des conséquences catastrophiques sur l''approvisionnement énergétique mondial.',
'2026-03-23 08:30:00'
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
('tensions-moyen-orient.jpg', 1),
('explosion-base.jpg', 2),
('impact-economique.jpg', 3),
('desescalade-diplomatie.jpg', 4),
('crise-humanitaire.jpg', 5),
('sanctions-economiques.jpg', 6),
('renforcement-militaire.jpg', 7);

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