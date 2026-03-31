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
-- ARTICLES (Avec contenu formaté TinyMCE)
-- =========================
INSERT INTO articles (titre, description, contenu, date_publication) VALUES
(
    'Tensions croissantes à la frontière : Analyse des récents mouvements de troupes', 
    'Suite aux derniers événements diplomatiques, une augmentation significative des manœuvres militaires a été observée. Ce rapport détaille les implications stratégiques de ces mouvements.', 
    '<h2>Contexte géopolitique</h2>
    <p>Les récentes déclarations ont ravivé les tensions historiques. Selon les experts militaires, les déploiements observés au cours des 48 dernières heures sont sans précédent depuis 2021.</p>
    <ul>
        <li><strong>Secteur Nord :</strong> Déploiement de régiments d''artillerie lourde.</li>
        <li><strong>Secteur Sud :</strong> Renforcement des patrouilles frontalières.</li>
    </ul>
    <h3>Impact sur les populations locales</h3>
    <p>Les organisations humanitaires signalent déjà des déplacements préventifs de civils craignant une escalade. <em>« Nous nous préparons à toute éventualité »</em> a déclaré un porte-parole d''une ONG internationale.</p>
    <blockquote>Une solution diplomatique reste la priorité absolue de la communauté internationale.</blockquote>',
    '2026-03-29 10:30:00'
),
(
    'Accord historique sur les exportations d''énergie', 
    'Un nouveau sommet international s''est conclu par un accord majeur concernant la sécurisation des voies d''exportation énergétique de la région.', 
    '<p>Ce matin, les délégations ont officiellement signé le traité de sécurisation des détroits. Un tournant majeur pour la stabilité économique mondiale.</p>
    <h2>Les points clés de l''accord :</h2>
    <ol>
        <li>Libre circulation garantie pour les navires commerciaux.</li>
        <li>Création d''une zone maritime démilitarisée de 50 milles nautiques.</li>
        <li>Mise en place d''un comité d''observation tripartite.</li>
    </ol>
    <p>Les marchés financiers ont immédiatement réagi positivement, le prix du baril connaissant une baisse de <strong>2.5%</strong> à l''ouverture des bourses européennes.</p>
    <p><img src="https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Sommet international" width="500" height="auto"></p>',
    '2026-03-30 14:15:00'
),
(
    'La crise humanitaire s''aggrave dans les provinces de l''Est', 
    'Les agences de l''ONU tirent la sonnette d''alarme concernant l''accès à l''eau potable et aux soins médicaux dans les régions touchées par le blocus.', 
    '<h2>Une urgence invisible</h2>
    <p>L''accès à la région est bloqué depuis près de trois semaines. Plus de <strong>1.5 million de personnes</strong> dépendent actuellement des maigres réserves encore disponibles.</p>
    <p style="text-align: justify; padding: 10px; border-left: 4px solid #cc0000; background-color: #f9f9f9;">
        "Chaque heure qui passe aggrave le risque de crise sanitaire majeure. Nos convois attendent l''autorisation de franchir les checkpoints."
    </p>
    <h3>Les besoins prioritaires identifiés :</h3>
    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Ressource</th>
                <th>Niveau de criticité</th>
                <th>Bénéficiaires cibles</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Kits médicaux d''urgence</td>
                <td><span style="color: red;"><strong>Grave</strong></span></td>
                <td>Hôpitaux de campagne</td>
            </tr>
            <tr>
                <td>Purificateurs d''eau</td>
                <td>Élevé</td>
                <td>Camps de réfugiés</td>
            </tr>
            <tr>
                <td>Couvertures et abris</td>
                <td>Moyen</td>
                <td>Familles déplacées</td>
            </tr>
        </tbody>
    </table>
    <p>Un appel aux dons international a été lancé hier depuis Genève.</p>',
    '2026-03-31 09:00:00'
);

-- =========================
-- RELATIONS ARTICLES - AUTEURS
-- =========================
-- Article 1 : Tensions militaires -> Auteurs 2 (Rakoto), 4 (Smith)
INSERT INTO article_auteur (article_id, auteur_id) VALUES 
(1, 2), 
(1, 4);

-- Article 2 : Accord énergétique -> Auteur 1 (Dupont), 3 (Martin)
INSERT INTO article_auteur (article_id, auteur_id) VALUES 
(2, 1), 
(2, 3);

-- Article 3 : Crise humanitaire -> Auteur 5 (Razanamasy)
INSERT INTO article_auteur (article_id, auteur_id) VALUES 
(3, 5);

-- =========================
-- RELATIONS ARTICLES - CATEGORIES
-- =========================
-- Article 1 : Militaire (2), Diplomatie (4), International (6)
INSERT INTO article_categorie (article_id, categorie_id) VALUES 
(1, 2), 
(1, 4),
(1, 6);

-- Article 2 : Économie (3), Diplomatie (4)
INSERT INTO article_categorie (article_id, categorie_id) VALUES 
(2, 3), 
(2, 4);

-- Article 3 : Humanitaire (5), International (6)
INSERT INTO article_categorie (article_id, categorie_id) VALUES 
(3, 5), 
(3, 6);
