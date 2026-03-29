-- ============================================
-- Script d'initialisation de la base de données
-- Ce fichier est exécuté automatiquement par
-- PostgreSQL au premier lancement du container
-- ============================================

-- Ordre d'exécution dans docker-entrypoint-initdb.d :
--   1. script.sql  → Création des tables
--   2. data.sql    → Insertion des données

-- Ajouter ici la création des tables
-- Exemple :
-- CREATE TABLE IF NOT EXISTS utilisateur (
--     id SERIAL PRIMARY KEY,
--     nom VARCHAR(100) NOT NULL,
--     email VARCHAR(255) UNIQUE NOT NULL,
--     mot_de_passe VARCHAR(255) NOT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );
