CREATE DATABASE IF NOT EXISTS youdemy;
USE youdemy;

CREATE TABLE `roles` (
    `id_role` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `role` VARCHAR(255) NOT NULL
);

INSERT INTO `roles` (`role`) 
VALUES ('admin'), ('enseignant'), ('etudiant');

CREATE TABLE `admins` (
    `id_admin` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `telephone` VARCHAR(20) NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `id_role_fk` INT(11) DEFAULT 1,
    FOREIGN KEY (`id_role_fk`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `enseignants` (
    `id_enseignant` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `telephone` VARCHAR(20) NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `adresse` TEXT NOT NULL,
    `id_role_fk` INT(11) NOT NULL,
    `statut` ENUM('inactive', 'active', 'blocked') DEFAULT 'inactive',
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (`id_role_fk`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `etudiants` (
    `id_etudiant` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `telephone` VARCHAR(20) NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `adresse` TEXT NOT NULL,
    `id_role_fk` INT(11) NOT NULL,
    `statut` ENUM('inactive', 'active', 'blocked') DEFAULT 'active',
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (`id_role_fk`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `categories` (
    `id_categorie` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `image_url` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `cours` (
    `id_cour` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `image_url` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `statut` ENUM('inactive', 'active', 'blocked') DEFAULT 'inactive',
    `id_enseignant_fk` INT(11) NOT NULL,
    `id_categorie_fk` INT(11) NOT NULL,
    FOREIGN KEY (`id_enseignant_fk`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`id_categorie_fk`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `cours_documents` (
    `id_document` INT AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `image_url` VARCHAR(255),
    `id_cour_fk` INT(11) NOT NULL,
    `nombre_pages` INT,
    `taille` VARCHAR(50),
    `fichier` VARCHAR(255) NOT NULL,
    `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_cour_fk`) REFERENCES `cours` (`id_cour`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `cours_videos` (
    `id_video` INT AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `image_url` VARCHAR(255),
    `id_cour_fk` INT(11) NOT NULL,
    `duree` TIME,
    `qualite` VARCHAR(50),
    `fichier` VARCHAR(255) NOT NULL,
    `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_cour_fk`) REFERENCES `cours` (`id_cour`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `tags` (
    `id_tag` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(25) NOT NULL UNIQUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `tags_cours` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_tag_fk` INT(11) NOT NULL,
    `id_cour_fk` INT(11) NOT NULL,
    FOREIGN KEY (`id_tag_fk`) REFERENCES `tags` (`id_tag`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`id_cour_fk`) REFERENCES `cours` (`id_cour`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `reservations` (
    `id_reservation` INT AUTO_INCREMENT PRIMARY KEY,
    `id_user_fk` INT(11) NOT NULL,
    `id_cour_fk` INT(11) NOT NULL,
    FOREIGN KEY (`id_user_fk`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`id_cour_fk`) REFERENCES `cours` (`id_cour`) ON DELETE CASCADE ON UPDATE CASCADE
);
