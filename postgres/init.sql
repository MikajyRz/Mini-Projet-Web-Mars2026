-- =========================================
-- Base de données pour le site d'informations sur la guerre en Iran
-- =========================================

-- Suppression des tables si elles existent déjà
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS categories;

-- =========================================
-- Table des utilisateurs (BackOffice)
-- =========================================
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Stocker des hash (BCRYPT)
    email VARCHAR(100) NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'un utilisateur admin par défaut (mot de passe : admin123)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$ggPWsY3jqeWADMOBiuZWke0oeB5XG35Vjrg3fhiS0ZMreAheQMnyy');

-- =========================================
-- Table des catégories
-- =========================================
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Insertion des catégories de base
INSERT INTO categories (name) VALUES 
('International'),
('Politique'),
('Économie'),
('Culture'),
('Sports');

-- =========================================
-- Table des articles
-- =========================================
CREATE TABLE articles (
    id SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    chapeau TEXT NOT NULL, -- Utilisé aussi pour meta_description
    corps TEXT NOT NULL,
    image_principale VARCHAR(255) DEFAULT NULL,
    image_alt VARCHAR(255) DEFAULT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category_id INT NOT NULL DEFAULT 1, -- Par défaut International
    meta_title VARCHAR(255) DEFAULT NULL, -- SEO Spécifique
    date_publication TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- Indexation pour recherche et SEO
CREATE INDEX idx_slug ON articles(slug);
CREATE INDEX idx_date_pub ON articles(date_publication);

-- =========================================
-- Exemple d'insertion d'un article
-- =========================================
INSERT INTO articles (titre, chapeau, corps, image_principale, image_alt, slug, category_id, meta_title)
VALUES (
    'Conflit en Iran : Situation actuelle',
    'Résumé de la situation en Iran...',
    'Corps complet de l’article détaillant la situation actuelle en Iran...',
    'iran.jpg',
    'Carte de l’Iran',
    'conflit-en-iran-situation-actuelle',
    1,
    'Guerre en Iran - Actualités Internationales'
);