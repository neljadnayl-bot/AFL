DROP DATABASE IF EXISTS sherob;
CREATE DATABASE sherob
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sherob;

-- ==========================
-- TABLE DES UTILISATEURS
-- ==========================

CREATE TABLE `Afl-user` (
    user_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(250) NOT NULL,
    email VARCHAR(250) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id)
);

-- ==========================
-- TABLE DES AGENTS
-- ==========================

CREATE TABLE `Agents_Sherob` (
    id INT NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(30) NOT NULL,
    date_naissance DATE NOT NULL,
    role VARCHAR(20) NOT NULL,
    mission VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- ==========================
-- DONNÉE DE TEST
-- ==========================

INSERT INTO `Agents_Sherob` (
    full_name,
    date_naissance,
    role,
    mission
)
VALUES (
    'Jad',
    '2017-01-29',
    'Informatique',
    'mù*k*'
);