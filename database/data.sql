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
