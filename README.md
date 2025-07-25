# Orchi – Gestion de matériel pour l'association Recife

Projet développé dans le cadre d’un stage à l’association Recife (Le Havre), réalisé en autonomie.

## Présentation

**Orchi** est une application web simple permettant de gérer et de suivre le matériel informatique au sein d’une association.  
Elle facilite l’inventaire, le suivi des emprunts et retours, la gestion des incidents, et la visualisation rapide de l’état du matériel (disponible, en réparation, réservé, etc.).

Ce projet a été réalisé en PHP, HTML, CSS et JavaScript natif, sans framework, afin de rester accessible et facilement maintenable par des débutants.

## Fonctionnalités principales

- Authentification sécurisée des utilisateurs
- Gestion du matériel (ajout, modification, suppression)
- Historique des mouvements (emprunts, retours)
- Signalement d’incidents et gestion des réparations
- Interface mode sombre pour confort visuel dans les dépôts ou locaux peu éclairés
- Design responsive : utilisable sur ordinateur, tablette et smartphone
- Différents niveaux d’accès (admin, utilisateur standard)

## Installation

### Prérequis

- Serveur web local (type [XAMPP](https://www.apachefriends.org/fr/index.html), [WAMP](https://www.wampserver.com/), [MAMP](https://www.mamp.info/fr/), ou hébergement web avec support PHP/MySQL)
- PHP 7.x ou 8.x
- MySQL/MariaDB

### Étapes

1. **Cloner ce dépôt ou télécharger l’archive ZIP**
    ```
    git clone https://github.com/Isaacsehim/Gestion-materiel.git
    ```

2. **Copier les fichiers dans le dossier web de votre serveur local**

3. **Créer la base de données**
    - Ouvrir `phpMyAdmin`
    - Importer le fichier SQL fourni (ex: `gestion_materiel.sql`)  
      *(À créer ou à demander selon ton export)*

4. **Configurer la connexion à la base de données**
    - Modifier les identifiants MySQL dans le fichier de connexion (ex : `php/connexion.php` ou autre)
    ```php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_materiel';
    ```

5. **Lancer l’application**
    - Ouvrir le navigateur et accéder à `http://localhost/nom-du-dossier/index.php`

## Utilisation

- Se connecter avec un compte utilisateur ou administrateur
- Accéder aux différentes fonctionnalités depuis le tableau de bord
- Ajouter/éditer du matériel, déclarer des incidents, gérer les emprunts/retours

## Stack

- PHP 8
- MySQL 5.7+
- HTML/CSS/JS (sans framework)
- Docker (pour l’environnement de dev)

## Structure du projet

/assets/
/img/
/style/
/js/
php/
login.php
dashboard.php
materiel.php
...
README.md
index.php


## Captures d’écran

*(Soon)*

## Auteurs

- Isaacsehim (https://github.com/Isaacsehim)

## Licence

Projet libre pour usage associatif ou personnel.  
Merci de citer l’auteur en cas de réutilisation !

---

N’hésitez pas à proposer des améliorations ou à me contacter via GitHub !