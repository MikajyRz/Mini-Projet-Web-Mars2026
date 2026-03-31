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
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- admin / admin123
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$ggPWsY3jqeWADMOBiuZWke0oeB5XG35Vjrg3fhiS0ZMreAheQMnyy');

-- =========================================
-- Table des catégories
-- =========================================
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO categories (id, name) VALUES 
(1, 'International'),
(2, 'Politique'),
(3, 'Économie'),
(4, 'Culture'),
(5, 'Sports');

-- Synchroniser la séquence des IDs pour les catégories
SELECT setval('categories_id_seq', (SELECT MAX(id) FROM categories));

-- =========================================
-- Table des articles
-- =========================================
CREATE TABLE articles (
    id SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    chapeau TEXT NOT NULL,
    corps TEXT NOT NULL,
    image_principale VARCHAR(255) DEFAULT NULL,
    image_alt VARCHAR(255) DEFAULT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category_id INT NOT NULL,
    meta_title VARCHAR(255) DEFAULT NULL,
    date_publication TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE INDEX idx_slug ON articles(slug);
CREATE INDEX idx_date_pub ON articles(date_publication);

-- =========================================
-- Insertion des données initiales (8 articles)
-- =========================================

INSERT INTO articles (titre, slug, chapeau, corps, category_id, image_principale, image_alt) VALUES
(
    'Conflit en Iran : ce que change (vraiment) l’entrée en guerre des Houthis', 
    'conflit-en-iran-ce-que-change-vraiment-l-entree-en-guerre-des-houthis',
    'L’intervention de ce groupe allié à l’Iran pourrait déstabiliser les flux énergétiques en mer Rouge.',
    '<p>L''entrée en guerre des rebelles Houthis marque un tournant dans le conflit. Ces derniers ont multiplié les attaques de drones et de missiles, ciblant principalement des infrastructures stratégiques. Le président du Sanaa Center souligne que leur capacité de nuisance est réelle.</p><p>Cette situation oblige les puissances internationales à repenser leur stratégie de sécurité dans la zone, avec une surveillance accrue des détroits maritimes.</p>',
    1,
    '69cb60b6398e3_1774936246.webp',
    'Conflit en Iran et les Houthis'
),
(
    'Guerre en Iran : Israël se prépare à des conséquences économiques décalées',
    'guerre-en-iran-israel-se-prepare-a-des-consequences-economiques-decalees',
    'L’économie israélienne, déjà sous pression, anticipe de nouveaux chocs sur le marché de l’énergie.',
    '<p>Les experts économiques à Tel-Aviv analysent les risques de contagion. Si le conflit s''enlise en Iran, les prix du pétrole pourraient subir une volatilité sans précédent. Le gouvernement prévoit des mesures d''ajustement budgétaire pour pallier d''éventuels surcoûts liés à la défense nationale.</p>',
    3,
     '69cb723c4187b_1774940732.webp',
    'Économie et guerre en Iran'
),
(
    'Pétrole : après un mois de conflit, une production en chute libre',
    'petrole-apres-un-mois-de-conflit-une-production-en-chute-libre',
    'Les exportations iraniennes ont chuté de 40%, créant un vide sur les marchés mondiaux.',
    '<p>Les raffineries à travers le monde commencent à ressentir les effets de la raréfaction du brut iranien. L''OPEP discute activement d''une hausse de production des autres membres pour stabiliser les cours, mais l''incertitude demeure quant à la pérennité de l''offre mondiale.</p>',
    3,
    '69cb73603f235_1774941024.webp',
    'Pétrole et production iranienne'
),
(
    'Sanctions contre l’Iran : l’UE renforce son arsenal diplomatique',
    'sanctions-contre-l-iran-l-ue-renforce-son-arsenal-diplomatique',
    'Bruxelles adopte de nouvelles mesures ciblant le secteur financier et technologique de Téhéran.',
    '<p>Le nouveau paquet de sanctions vise à restreindre l''accès de l''Iran aux technologies à double usage. L''Union Européenne espère ainsi limiter les capacités de développement militaire tout en appelant au retour à la table des négociations diplomatiques.</p>',
    2,
    '69cb70ed8a2f2_1774940397.webp',
    'Sanctions diplomatique UE'
),
(
    'L’impact culturel du conflit : les artistes iraniens s’expriment',
    'l-impact-culturel-du-conflit-les-artistes-iraniens-s-expriment',
    'Malgré la guerre, la scène artistique iranienne reste un bastion de résistance et de créativité.',
    '<p>Au-delà des lignes de front, des artistes de Téhéran et de la diaspora organisent des expositions virtuelles. Leurs œuvres témoignent de la résilience d''un peuple et de sa volonté de préserver son héritage culturel face à la tourmente géopolitique.</p>',
    4,
    '69cb95ecbd83b_1774949868.webp',
    'Culture et art iranien'
),
(
    'Le Conseil de Sécurité discute d’une trêve humanitaire urgente',
    'le-conseil-de-securite-discute-d-une-treve-humanitaire-urgente',
    'Réunis à New York, les membres permanents cherchent un compromis pour acheminer l’aide.',
    '<p>Les Nations Unies alertent sur la situation humanitaire préoccupante dans les zones de combat. Une trêve de 72 heures est proposée pour permettre le passage de convois alimentaires et médicaux. Les négociations achoppent encore sur les modalités de contrôle des convois.</p>',
    1,
     '69cb63acbab6d_1774937004.webp',
    'ONU et aide humanitaire'
),
(
    'Sport et géopolitique : l’annulation du match symbolique Iran-Israël',
    'sport-et-geopolitique-l-annulation-du-match-symbolique-iran-israel',
    'La FIFA annonce le report sine die de la rencontre amicale prévue en terrain neutre.',
    '<p>Le football est rattrapé par la réalité du terrain. Ce qui devait être une rencontre pour la paix a été annulé par crainte pour la sécurité des joueurs et des supporters. Cette décision illustre une fois de plus la porosité entre les enjeux sportifs et les tensions globales.</p>',
    5,
    '69cb744fb1d17_1774941263.webp',
    'Match annulé Iran Israël'
),
(
    'Sébastien Lecornu cultive la discrétion face à la crise',
    'sebastien-lecornu-cultive-la-discretion-face-a-la-crise',
    'Le ministre français de la Défense multiplie les entretiens discrets avec ses homologues régionaux.',
    '<p>Occupé à se montrer "utile" à un an de la présidentielle, le ministre préfère les canaux diplomatiques souterrains aux coups d''éclat médiatiques. Sa stratégie vise à positionner la France comme médiateur crédible dans un Moyen-Orient en pleine ébullition.</p>',
    2,
    '69cb6fc9be38e_1774940105.webp',
    'Diplomatie française'
);

-- Synchroniser la séquence des IDs pour les articles
SELECT setval('articles_id_seq', (SELECT MAX(id) FROM articles));