SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS gestion
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE gestion;

CREATE TABLE niveaux (
    id_niveaux INT AUTO_INCREMENT PRIMARY KEY,
    niveau_libelle VARCHAR(50) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE etats_utilisateurs (
    id_etats_utilisateurs INT AUTO_INCREMENT PRIMARY KEY,
    etat_utilisateur_libelle VARCHAR(50) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE etablissements (
    id_etablissement INT AUTO_INCREMENT PRIMARY KEY,
    etablissement_nom VARCHAR(100),
    etablissement_adresse VARCHAR(255) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE etages (
    id_etage INT AUTO_INCREMENT PRIMARY KEY,
    id_etablissement INT NOT NULL,
    etage_nom VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_etablissement) REFERENCES etablissements(id_etablissement) ON DELETE CASCADE,
    INDEX (id_etablissement)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE types_lieux (
    id_types_lieu INT AUTO_INCREMENT PRIMARY KEY,
    type_lieu_libelle VARCHAR(50) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE lieux (
    id_lieux INT AUTO_INCREMENT PRIMARY KEY,
    lieu_nom VARCHAR(150) NOT NULL,
    id_types_lieu INT NOT NULL,
    id_etage INT NOT NULL,
    FOREIGN KEY (id_types_lieu) REFERENCES types_lieux(id_types_lieu) ON DELETE RESTRICT,
    FOREIGN KEY (id_etage) REFERENCES etages(id_etage) ON DELETE CASCADE,
    INDEX (id_types_lieu),
    INDEX (id_etage)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE utilisateurs (
    id_utilisateurs INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_nom VARCHAR(100) NOT NULL,
    utilisateur_prenom VARCHAR(100) NOT NULL,
    utilisateur_pseudo VARCHAR(19) NOT NULL UNIQUE,
    utilisateur_email VARCHAR(150) NOT NULL UNIQUE,
    utilisateur_motdepasse VARCHAR(255) NOT NULL,
    utilisateur_photo VARCHAR(255),
    utilisateur_telephone VARCHAR(20),
    utilisateur_theme ENUM('clair', 'sombre') DEFAULT 'clair',
    utilisateur_langue VARCHAR(10) DEFAULT 'fr',
    utilisateur_notifications BOOL DEFAULT TRUE,
    id_niveaux INT NOT NULL,
    id_etats_utilisateurs INT NOT NULL,
    utilisateur_date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    utilisateur_derniere_connexion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    utilisateur_est_supprime TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_niveaux) REFERENCES niveaux(id_niveaux) ON DELETE RESTRICT,
    FOREIGN KEY (id_etats_utilisateurs) REFERENCES etats_utilisateurs(id_etats_utilisateurs) ON DELETE RESTRICT,
    INDEX (id_niveaux),
    INDEX (id_etats_utilisateurs),
    INDEX (utilisateur_est_supprime)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categories_produits (
    id_categories INT AUTO_INCREMENT PRIMARY KEY,
    categorie_nom VARCHAR(100) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE etats_produits (
    id_etats INT AUTO_INCREMENT PRIMARY KEY,
    etat_libelle VARCHAR(50) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE fournisseurs (
    id_fournisseurs INT AUTO_INCREMENT PRIMARY KEY,
    fournisseur_nom VARCHAR(150) NOT NULL UNIQUE,
    fournisseur_adresse VARCHAR(255),
    fournisseur_telephone VARCHAR(30),
    fournisseur_email VARCHAR(150),
    fournisseur_site_web VARCHAR(255),
    fournisseur_commentaire TEXT,
    fournisseur_est_actif TINYINT(1) NOT NULL DEFAULT 1,
    fournisseur_est_supprime TINYINT(1) NOT NULL DEFAULT 0,
    fournisseur_date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX (fournisseur_est_supprime),
    INDEX (fournisseur_est_actif)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE produits (
    id_produits INT AUTO_INCREMENT PRIMARY KEY,
    produit_photo VARCHAR(255),
    produit_code_barres VARCHAR(100) NOT NULL UNIQUE,
    produit_code_barre_code39 VARCHAR(100) UNIQUE,
    produit_denomination VARCHAR(150) NOT NULL,
    id_categories INT NOT NULL,
    produit_description TEXT,
    produit_date_arrivee DATETIME DEFAULT CURRENT_TIMESTAMP,
    produit_date_fabrication DATE,
    produit_marque_modele VARCHAR(150),
    produit_numero_serie VARCHAR(100),
    produit_quantite INT NOT NULL DEFAULT 1,
    id_etats INT NOT NULL,
    id_fournisseurs INT DEFAULT NULL,
    id_lieux INT,
    produit_date_sortie DATE,
    produit_date_retour_prevue DATE,
    produit_valeur_estimee DECIMAL(10,2) DEFAULT 0.00,
    produit_garantie_fin DATE,
    produit_commentaire TEXT,
    produit_modifiee DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_utilisateurs INT DEFAULT NULL,
    produit_est_supprime TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_categories) REFERENCES categories_produits(id_categories) ON DELETE RESTRICT,
    FOREIGN KEY (id_etats) REFERENCES etats_produits(id_etats) ON DELETE RESTRICT,
    FOREIGN KEY (id_fournisseurs) REFERENCES fournisseurs(id_fournisseurs) ON DELETE SET NULL,
    FOREIGN KEY (id_lieux) REFERENCES lieux(id_lieux) ON DELETE SET NULL,
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE SET NULL,
    INDEX (id_categories),
    INDEX (id_etats),
    INDEX (id_fournisseurs),
    INDEX (id_lieux),
    INDEX (id_utilisateurs),
    INDEX (produit_est_supprime)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE historique_etats_produits (
    id_historique_etats_produits INT AUTO_INCREMENT PRIMARY KEY,
    id_produits INT NOT NULL,
    id_etats INT NOT NULL,
    id_utilisateurs INT,
    historique_etat_produit_date_changement DATETIME DEFAULT CURRENT_TIMESTAMP,
    historique_etat_produit_commentaire TEXT,
    FOREIGN KEY (id_produits) REFERENCES produits(id_produits) ON DELETE CASCADE,
    FOREIGN KEY (id_etats) REFERENCES etats_produits(id_etats) ON DELETE RESTRICT,
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE SET NULL,
    INDEX (id_produits),
    INDEX (id_etats),
    INDEX (id_utilisateurs)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE mouvements (
    id_mouvements INT AUTO_INCREMENT PRIMARY KEY,
    id_produits INT NOT NULL,
    id_utilisateurs INT,
    mouvement_date_sortie DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    mouvement_date_retour_prevue DATETIME,
    mouvement_date_retour_reelle DATETIME,
    mouvement_type ENUM('réel', 'réservation') DEFAULT 'réel',
    mouvement_signature_base64 TEXT,
    id_lieux INT,
    mouvement_commentaire TEXT,
    mouvement_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    mouvement_modifiee DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produits) REFERENCES produits(id_produits) ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE SET NULL,
    FOREIGN KEY (id_lieux) REFERENCES lieux(id_lieux) ON DELETE SET NULL,
    INDEX (id_produits),
    INDEX (id_utilisateurs),
    INDEX (id_lieux)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE etats_maintenance (
    id_etats_maintenance INT AUTO_INCREMENT PRIMARY KEY,
    etat_maintenance_libelle VARCHAR(50) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE maintenance (
    id_maintenance INT AUTO_INCREMENT PRIMARY KEY,
    id_produits INT NOT NULL,
    maintenance_date_declaration DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    maintenance_type_probleme VARCHAR(255) NOT NULL,
    id_etats_maintenance INT NOT NULL,
    id_utilisateurs INT,
    maintenance_prestataire_externe VARCHAR(255),
    maintenance_date_resolution DATE,
    maintenance_photo_avant VARCHAR(255),
    maintenance_photo_apres VARCHAR(255),
    maintenance_cout DECIMAL(10,2) DEFAULT 0.00,
    maintenance_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    maintenance_modifiee DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produits) REFERENCES produits(id_produits) ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE SET NULL,
    FOREIGN KEY (id_etats_maintenance) REFERENCES etats_maintenance(id_etats_maintenance) ON DELETE RESTRICT,
    INDEX (id_produits),
    INDEX (id_etats_maintenance),
    INDEX (id_utilisateurs)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE journal_connexions (
    id_journal_connexions INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateurs INT NOT NULL,
    date_connexion DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_deconnexion DATETIME DEFAULT NULL,
    adresse_ip VARCHAR(45),
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE CASCADE,
    INDEX (id_utilisateurs)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE journal_actions (
    id_action INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateurs INT NOT NULL,
    action_type VARCHAR(100),
    action_description TEXT,
    action_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE CASCADE,
    INDEX (id_utilisateurs)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE favoris (
    id_favoris INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateurs INT NOT NULL,
    id_produits INT NOT NULL,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE CASCADE,
    FOREIGN KEY (id_produits) REFERENCES produits(id_produits) ON DELETE CASCADE,
    UNIQUE (id_utilisateurs, id_produits),
    INDEX (id_utilisateurs),
    INDEX (id_produits)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE rapports (
    id_rapport INT AUTO_INCREMENT PRIMARY KEY,
    rapport_nom VARCHAR(100),
    rapport_type VARCHAR(50),
    rapport_format VARCHAR(10),
    rapport_date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    rapport_fichier_path VARCHAR(255)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE documents_produits (
    id_document INT AUTO_INCREMENT PRIMARY KEY,
    id_produits INT NOT NULL,
    document_nom VARCHAR(255) NOT NULL,
    document_type VARCHAR(50),
    document_path VARCHAR(255) NOT NULL,
    document_date_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produits) REFERENCES produits(id_produits) ON DELETE CASCADE,
    INDEX (id_produits)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE accessoires_produits (
    id_produit_principal INT NOT NULL,
    id_accessoire INT NOT NULL,
    PRIMARY KEY (id_produit_principal, id_accessoire),
    FOREIGN KEY (id_produit_principal) REFERENCES produits(id_produits) ON DELETE CASCADE,
    FOREIGN KEY (id_accessoire) REFERENCES produits(id_produits) ON DELETE CASCADE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tags (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    tag_nom VARCHAR(50) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE produits_tags (
    id_produit INT NOT NULL,
    id_tag INT NOT NULL,
    PRIMARY KEY (id_produit, id_tag),
    FOREIGN KEY (id_produit) REFERENCES produits(id_produits) ON DELETE CASCADE,
    FOREIGN KEY (id_tag) REFERENCES tags(id_tag) ON DELETE CASCADE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE affectations_produits (
    id_affectation INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_utilisateur INT NOT NULL,
    date_affectation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_fin_affectation DATETIME,
    FOREIGN KEY (id_produit) REFERENCES produits(id_produits) ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateurs) ON DELETE CASCADE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE types_notifications (
    id_type_notification INT AUTO_INCREMENT PRIMARY KEY,
    type_libelle VARCHAR(100) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE notifications (
    id_notification INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateurs INT NOT NULL,
    id_type_notification INT NOT NULL,
    notification_message TEXT NOT NULL,
    notification_lue TINYINT(1) NOT NULL DEFAULT 0,
    notification_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs(id_utilisateurs) ON DELETE CASCADE,
    FOREIGN KEY (id_type_notification) REFERENCES types_notifications(id_type_notification) ON DELETE RESTRICT,
    INDEX (id_utilisateurs),
    INDEX (id_type_notification),
    INDEX (notification_lue)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Données initiales

INSERT INTO niveaux (niveau_libelle) VALUES
('Admin'),
('Technicien'),
('Stagiaire'),
('Invité');

INSERT INTO etats_utilisateurs (etat_utilisateur_libelle) VALUES
('En ligne'),
('Absent'),
('Déconnecté'),
('En réunion'),
('Inactif'),
('Suspendu'),
('Supprimé');

INSERT INTO utilisateurs (
    utilisateur_nom,
    utilisateur_prenom,
    utilisateur_pseudo,
    utilisateur_email,
    utilisateur_motdepasse,
    utilisateur_photo,
    utilisateur_telephone,
    utilisateur_theme,
    utilisateur_langue,
    utilisateur_notifications,
    id_niveaux,
    id_etats_utilisateurs,
    utilisateur_date_inscription,
    utilisateur_derniere_connexion,
    utilisateur_est_supprime
) VALUES (
    'SEHIM',
    'Isaac',
    'IsaacS',
    'IsaacS',
    '$2y$10$sU8gQw9OQJtWDP5UrFOQKuAuwAWdeD4ABz9q5UN3WRhyYJFiEcTbi',
    'assets/images/utilisateurs/admin_photo.jpg',
    '0632821199',
    'sombre',
    'fr',
    TRUE,
    (SELECT id_niveaux FROM niveaux WHERE niveau_libelle = 'Admin'),
    (SELECT id_etats_utilisateurs FROM etats_utilisateurs WHERE etat_utilisateur_libelle = 'Déconnecté'),
    NOW() - INTERVAL 2 YEAR,
    NOW() - INTERVAL 1 MONTH,
    0
);

INSERT INTO etats_produits (etat_libelle) VALUES
('Neuf'),
('Bon état'),
('À réparer'),
('Hors service'),
('Perdu'),
('En maintenance'),
('Réformé');

INSERT INTO etats_maintenance (etat_maintenance_libelle) VALUES
('En cours'),
('Résolu'),
('Abandonné'),
('À diagnostiquer'),
('En attente de pièces'),
('Non réparable');

INSERT INTO etablissements (etablissement_nom, etablissement_adresse) VALUES
('Siège Iéna', '45 rue d’Iéna'),
('Annexe Iéna', '53 rue d’Iéna'),
('Annexe Rispal A', '48 ter rue Rispal'),
('Annexe Rispal B', '50 ter rue Rispal');

INSERT INTO etages (id_etablissement, etage_nom) VALUES
(1, 'RDC'),
(1, '1er'),
(1, '2e'),
(2, '1er'),
(3, 'RDC'),
(3, '1er'),
(4, 'RDC'),
(4, '1er');

INSERT INTO types_lieux (type_lieu_libelle) VALUES
('Déploiement'),
('Stockage'),
('Salle de cours'),
('Bureau'),
('Salle de repos'),
('Espace informatique'),
('Armoire'),
('Plafond'),
('Étagère');

INSERT INTO lieux (lieu_nom, id_types_lieu, id_etage) VALUES
('Armoire bureau 1 niveau 2', 7, 1),
('Plafond salle informatique', 8, 2),
('Étagère droite niveau 1', 9, 3),
('Étagère droite niveau 2', 9, 4),
('Étagère droite niveau 3', 9, 5),
('Étagère gauche (à droite) niveau 1', 9, 6),
('Étagère gauche (à droite) niveau 2', 9, 7),
('Étagère gauche (à droite) niveau 3', 9, 8);

INSERT INTO tags (tag_nom) VALUES
('éco-responsable'),
('récent'),
('reconditionné'),
('portable'),
('usage intensif'),
('fragile'),
('urgent'),
('neuf'),
('occasion'),
('hors garantie'),
('sous garantie'),
('à tester'),
('à surveiller');

INSERT INTO categories_produits (categorie_nom) VALUES
    ('Ordinateurs'), 
    ('Écrans'), 
    ('Périphériques'),
    ('Claviers'),
    ('Souris'),
    ('Routeurs'),
    ('Switchs'),
    ('Serveurs'),
    ('Disques durs'),
    ('Disques SSD'),
    ('Cartes graphiques'),
    ('Cartes réseau'),
    ('Câbles réseaux'),
    ("Câbles d'alimentation"),
    ('Imprimantes'),
    ('Scanners'),
    ('Projecteurs'),
    ('Tablettes'),
    ('Smartphones'),
    ('Batteries'),
    ('Stations de travail'),
    ('Équipements audio'),
    ('Équipements vidéo'),
    ('Accessoires PC'),
    ('Casques audio'),
    ('Webcams'),
    ('Moniteurs tactiles'),
    ('Onduleurs'),
    ('Chargeurs'),
    ('Commutateurs KVM'),
    ('Équipements de stockage externe'),
    ('Cartes mères'),
    ('Ventilateurs'),
    ('Clés USB'),
    ('Racks de serveurs'),
    ('UPS'),
    ('Périphériques de sécurité'),
    ('Équipements réseau sans fil'),
    ('Boîtiers PC'),
    ('Périphériques de sauvegarde'),
    ('Logiciels et licences'),
    ('Accessoires pour data center'),
    ('Imprimantes 3D'),
    ('Serveurs de sauvegarde'),
    ("Stations d’accueil"),
    ('Boîtiers de stockage NAS'),
    ('Équipements de surveillance réseau'),
    ('Dispositifs de sécurité'),
    ('Équipements de virtualisation'),
    ('Cartes audio'),
    ('Stations de charge pour appareils'),
    ('Outils de test et diagnostic'),
    ('Serveurs de bases de données'),
    ('Commutateurs PoE'),
    ('Systèmes de gestion des câbles'),
    ('Modules de RAM'),
    ('Équipements de monitoring de système'),
    ('Serveurs de fichiers'),
    ('Équipements pour conférence vidéo'),
    ("Dispositifs de gestion d'identité"),
    ('Processeurs'),
    ('Barrettes de RAM'),
    ("Cartes d'extension PCI"),
    ('SSD NVMe'),
    ('Modules de stockage RAID'),
    ('Cartes de capture vidéo'),
    ('Périphériques USB-C'),
    ('Câbles HDMI'),
    ('Câbles DisplayPort'),
    ('Câbles VGA'),
    ('Hubs USB'),
    ('Docking stations'),
    ('Écrans tactiles'),
    ('Supports de montage pour écrans'),
    ('Systèmes de refroidissement'),
    ('Chauffages pour data center'),
    ('Bac de rangement pour câbles'),
    ('Connecteurs RJ45'),
    ('Antennes réseau'),
    ('Équipements de test réseau'),
    ('Gestionnaires de câbles'),
    ('Filtres anti-poussière pour PC'),
    ('Câbles DisplayPort vers HDMI'),
    ('Câbles HDMI vers DisplayPort'),
    ('Câbles VGA vers HDMI'),
    ('Câbles HDMI vers VGA'),
    ('Câbles DVI vers HDMI'),
    ('Câbles DisplayPort vers VGA');

INSERT INTO types_notifications (type_libelle) VALUES
('Maintenance'),
('Nouvelle affectation'),
('Mise à jour produit'),
('Message système'),
('Alerte sécurité');

INSERT INTO fournisseurs (fournisseur_nom, fournisseur_adresse, fournisseur_telephone, fournisseur_email)
VALUES
('Heliaq', '12 rue de l’Industrie, Lyon', '0478123400', 'contact@heliaq.com'),
('HexaTech', '28 avenue Gutenberg, Nantes', '0253129876', 'commercial@hexatech.fr'),
('ProMedia', '7 bd du Commerce, Paris', '0182539785', 'info@promedia.fr');

INSERT INTO produits (
    produit_photo,
    produit_code_barres,
    produit_code_barre_code39,
    produit_denomination,
    id_categories,
    produit_description,
    produit_date_arrivee,
    produit_date_fabrication,
    produit_marque_modele,
    produit_numero_serie,
    produit_quantite,
    id_etats,
    id_fournisseurs,
    id_lieux,
    produit_date_sortie,
    produit_date_retour_prevue,
    produit_valeur_estimee,
    produit_garantie_fin,
    produit_commentaire,
    produit_modifiee,
    id_utilisateurs,
    produit_est_supprime
) VALUES
(
    'assets/images/produits/pc-portable.jpg',
    '1234567890123',
    'PC001',
    'PC Portable Dell Latitude 5490',
    1,
    'PC portable performant pour usage bureautique.',
    NOW(),
    '2022-10-12',
    'Dell Latitude 5490',
    'SN12345D5490',
    1,
    1,
    1,
    1,
    NULL,
    NULL,
    950.00,
    '2025-10-11',
    'Acheté pour la salle informatique.',
    NOW(),
    1,
    0
),
(
    'assets/images/produits/ecran-lg.jpg',
    '2345678901234',
    'ECR001',
    'Écran LG 27 pouces 4K',
    2,
    'Écran de haute qualité pour graphisme.',
    NOW(),
    '2023-01-22',
    'LG 27UL500',
    'SN-LG-UL500-001',
    1,
    2,
    1,
    2,
    NULL,
    NULL,
    299.99,
    '2026-01-22',
    'Livré sans câble HDMI.',
    NOW(),
    1,
    0
),
(
    NULL,
    '3456789012345',
    'CLAV001',
    'Clavier Logitech K120',
    4,
    'Clavier filaire pour PC.',
    NOW(),
    '2021-07-15',
    'Logitech K120',
    'SN-K120-9876',
    1,
    1,
    1,
    1,
    NULL,
    NULL,
    17.99,
    '2024-07-15',
    NULL,
    NOW(),
    1,
    0
),
(
    'assets/images/produits/laptop1.jpg',
    'PC-20250001',
    NULL,
    'Dell Latitude 5410',
    1,
    'Ordinateur portable dédié au support technique.',
    NOW() - INTERVAL 45 DAY,
    NULL,
    'Dell Latitude 5410',
    'DLT5410SN123',
    1,
    2,
    1,
    1,
    NULL,
    NULL,
    880.00,
    '2026-05-30',
    'Affecté au support',
    NOW(),
    1,
    0
),
(
    'assets/images/produits/ecran1.jpg',
    'MON-20250002',
    NULL,
    'Samsung 24\" Full HD',
    2,
    'Écran secondaire pour open-space.',
    NOW() - INTERVAL 20 DAY,
    NULL,
    'Samsung S24F350',
    'SAM24SN456',
    1,
    1,
    2,
    2,
    NULL,
    NULL,
    160.00,
    '2025-12-01',
    'Installé salle open-space',
    NOW(),
    1,
    0
),
(
    'assets/images/produits/souris1.jpg',
    'MOUSE-20250003',
    NULL,
    'Logitech MX Master 3',
    3,
    'Souris ergonomique prêtée aux formateurs.',
    NOW() - INTERVAL 60 DAY,
    NULL,
    'Logitech MX Master 3',
    'LOGIMX3SN789',
    1,
    1,
    3,
    3,
    NULL,
    NULL,
    89.99,
    '2025-09-09',
    'Usage intensif formation',
    NOW(),
    1,
    0
);

INSERT INTO produits (produit_denomination, id_categories, produit_code_barres, id_etats, produit_quantite, produit_est_supprime)
VALUES ('Câble HDMI 2m', 13, 'HDMI-20250004', 1, 1, 0);

INSERT INTO accessoires_produits (id_produit_principal, id_accessoire)
VALUES (5, 7);

INSERT INTO documents_produits (id_produits, document_nom, document_type, document_path)
VALUES
(5, 'Garantie Samsung', 'pdf', 'assets/documents/garantie_samsung24.pdf'),
(4, 'Notice Latitude 5410', 'pdf', 'assets/documents/notice_dell_latitude5410.pdf');

INSERT INTO historique_etats_produits (id_produits, id_etats, id_utilisateurs, historique_etat_produit_date_changement, historique_etat_produit_commentaire) VALUES
(4, 1, 1, NOW() - INTERVAL 45 DAY, 'Arrivée du produit, état neuf.'),
(4, 2, 1, NOW() - INTERVAL 30 DAY, 'Déballé et testé, bon état.'),
(4, 3, 1, NOW() - INTERVAL 5 DAY, 'Clavier abîmé, signalé pour réparation.'),
(5, 1, 1, NOW() - INTERVAL 20 DAY, 'Écran mis en stock'),
(6, 1, 1, NOW() - INTERVAL 60 DAY, 'Sortie stock pour prêt à utilisateur.');

INSERT INTO mouvements (id_produits, id_utilisateurs, mouvement_date_sortie, mouvement_date_retour_prevue, mouvement_type, id_lieux, mouvement_commentaire)
VALUES
(4, 1, NOW() - INTERVAL 20 DAY, NOW() - INTERVAL 18 DAY, 'réel', 1, 'Sortie pour intervention.'),
(4, 1, NOW() - INTERVAL 5 DAY, NULL, 'réel', 1, 'En attente de réparation.'),
(5, 1, NOW() - INTERVAL 10 DAY, NULL, 'réel', 2, 'Mis en service en open-space.'),
(6, 1, NOW() - INTERVAL 30 DAY, NOW() - INTERVAL 28 DAY, 'réservation', 3, 'Prêt formateur.'),
(6, 1, NOW() - INTERVAL 8 DAY, NOW() - INTERVAL 3 DAY, 'réel', 3, 'Utilisé en salle de formation.');

INSERT INTO maintenance (id_produits, maintenance_type_probleme, id_etats_maintenance, id_utilisateurs, maintenance_date_declaration, maintenance_photo_avant, maintenance_photo_apres)
VALUES (4, 'Touches clavier cassées', 1, 1, NOW() - INTERVAL 4 DAY, 'assets/images/maintenance/avant_clavier.jpg', 'assets/images/maintenance/apres_clavier.jpg');

INSERT INTO rapports (rapport_nom, rapport_type, rapport_format, rapport_fichier_path)
VALUES
('Rapport d’utilisation Dell Latitude 5410', 'Utilisation', 'pdf', 'assets/rapports/rapport_latitude5410.pdf'),
('Synthèse mouvements souris', 'Synthèse', 'pdf', 'assets/rapports/rapport_souris_mx3.pdf');

INSERT INTO produits_tags (id_produit, id_tag) VALUES
(4, 1), (4, 5),
(5, 2), (5, 6),
(6, 4), (6, 13);

INSERT INTO affectations_produits (id_produit, id_utilisateur, date_affectation, date_fin_affectation)
VALUES (6, 1, NOW() - INTERVAL 30 DAY, NOW() - INTERVAL 25 DAY);

INSERT INTO favoris (id_utilisateurs, id_produits)
VALUES (1, 4);

INSERT INTO notifications (id_utilisateurs, id_type_notification, notification_message)
VALUES (1, 3, 'Votre souris Logitech MX Master 3 a été enregistrée dans le système.');

INSERT INTO mouvements (id_produits, id_utilisateurs, mouvement_date_sortie, mouvement_date_retour_prevue, mouvement_type, id_lieux, mouvement_commentaire)
VALUES
(
    1,
    (SELECT id_utilisateurs FROM utilisateurs WHERE utilisateur_pseudo = 'IsaacS'),
    NOW() - INTERVAL 35 DAY,
    NOW() - INTERVAL 33 DAY,
    'réel',
    2,
    'Déplacement vers stockage pour maintenance'
);

INSERT INTO rapports (rapport_nom, rapport_type, rapport_format, rapport_date_creation, rapport_fichier_path)
VALUES
(
    'Etat de parc général',
    'Inventaire',
    'pdf',
    NOW() - INTERVAL 32 DAY,
    'assets/rapports/inventaire_IsaacS.pdf'
);

INSERT INTO favoris (id_utilisateurs, id_produits, date_ajout)
VALUES (
    (SELECT id_utilisateurs FROM utilisateurs WHERE utilisateur_pseudo = 'IsaacS'),
    2,
    NOW() - INTERVAL 60 DAY
);

INSERT INTO notifications (id_utilisateurs, id_type_notification, notification_message, notification_date)
VALUES (
    (SELECT id_utilisateurs FROM utilisateurs WHERE utilisateur_pseudo = 'IsaacS'),
    3,
    'Votre rapport d’inventaire a été généré avec succès.',
    NOW() - INTERVAL 32 DAY
);

INSERT INTO journal_connexions (id_utilisateurs, date_connexion, adresse_ip)
VALUES
((SELECT id_utilisateurs FROM utilisateurs WHERE utilisateur_pseudo = 'IsaacS'), NOW() - INTERVAL 1 MONTH, '192.168.1.23');

INSERT INTO journal_actions (id_utilisateurs, action_type, action_description, action_date)
VALUES
((SELECT id_utilisateurs FROM utilisateurs WHERE utilisateur_pseudo = 'IsaacS'), 'Déconnexion', 'Déconnexion volontaire', NOW() - INTERVAL 1 MONTH);

INSERT INTO historique_etats_produits (id_produits, id_etats, id_utilisateurs, historique_etat_produit_date_changement, historique_etat_produit_commentaire)
VALUES
(
    2,
    3,
    (SELECT id_utilisateurs FROM utilisateurs WHERE utilisateur_pseudo = 'IsaacS'),
    NOW() - INTERVAL 33 DAY,
    'Produit tombé en panne, signalé par IsaacS'
);
