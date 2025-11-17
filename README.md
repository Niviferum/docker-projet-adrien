# 🎸 Band Name Generator

Générateur de noms de groupes Metal et Speedcore conteneurisé avec Docker.

**Projet réalisé dans le cadre du module Conteneurisation - MyDigitalSchool Rennes**

Auteur : Adrien Derrey
Date : 17 Novembre 2025

---

## 📋 Table des matières

- [Présentation](#présentation)
- [Architecture](#architecture)
- [Prérequis](#prérequis)
- [Lancer le projet](#lancer-le-projet)
- [Accéder aux services](#accéder-aux-services)
- [Gestion des environnements](#gestion-des-environnements)
- [Liens utiles](#liens-utiles)
- [Remarques](#remarques)

---

## Présentation

Cette application web permet de générer aléatoirement des noms de groupes de musique en anglais selon deux genres, le métal qui est un genre bien connu avec des guitares saturées, des chanteurs qui scream, un tempo élevé... et le speedcore, qui est plus underground, qui s'appuie davantage sur l'utilisation de samples et de productions très dubstep / hardcore, mais à des tempos ultra élevés (généralement entre 250BPM et l'infini)


### Fonctionnalités

- ✅ Test de connexion à la base de données
- ✅ Génération de 10 noms aléatoires par genre
- ✅ Interface web responsive et intuitive
- ⌛ Administration de la base de données via Adminer



Le projet est composé de 3 services orchestrés avec Docker Compose :
## Architecture

Le projet est composé de 3 services orchestrés avec Docker Compose :
```
┌─────────────┐     ┌──────────────┐     ┌─────────────┐
│   Browser   │───▶│   Web (PHP)   │───▶│  Database   │
│             │     │  Port 8085   │     │   (MySQL)   │
└─────────────┘     └──────────────┘     └─────────────┘
                            │                     ▲
                            │                     │
                            ▼                     │
                    ┌──────────────┐              │
                    │    Adminer   │─────────────┘
                    │  Port 8086   │
                    └──────────────┘
```

### Services

| Service    | Image                | Port  | Description                          |
|------------|----------------------|-------|--------------------------------------|
| `web`      | Custom (PHP 8.2)     | 8085  | Application web avec Apache          |
| `database` | MySQL 8.0            | -     | Base de données (non exposée)        |
| `admin`    | Adminer              | 8086  | Interface d'administration DB        |

### Note sur le service admin

Le service Adminer (interface d'administration de base de données) a été temporairement désactivé en raison d'un conflit de port sur l'environnement de développement Windows. 

Pour l'activer, décommenter la section `admin:` dans `compose.yaml` et lancer :
```bash
docker compose up -d admin
```

Accès : http://localhost:8086 (ou 8087 selon la configuration)
- Serveur : `database`
- Utilisateur : `banduser`
- Mot de passe : (voir `.env`)

L'application fonctionne parfaitement sans ce service, qui est uniquement un outil de développement.
---

## Prérequis

- [Docker Desktop](https://www.docker.com/products/docker-desktop) (version 24.0+)
- [Docker Compose](https://docs.docker.com/compose/) (inclus avec Docker Desktop)
- Git

**Vérifier l'installation :**
```bash
docker --version
docker compose version
```

---

## Lancer le projet

### 1. Cloner le dépôt
```bash
git clone https://github.com/Niviferum/docker-projet-adrien
cd docker-bandnames
```

### 2. Configurer l'environnement
```bash
cp .env.dist .env
```

> **Note** : Pour des raisons pratiques, les mots de passe sont fournis dans `.env.dist` et fonctionnent immédiatement. En production, ces valeurs seraient remplacées par des secrets sécurisés.

### 3. Démarrer l'application

**Mode développement avec watch :**
```bash
docker compose watch
```

> Le mode `watch` synchronise automatiquement vos modifications de code dans le conteneur.

**Mode détaché (arrière-plan) :**
```bash
docker compose up -d
```

**Avec rebuild forcé :**
```bash
docker compose up --build -d
```

### 4. Arrêter l'application
```bash
# Arrêt simple
docker compose down

# Arrêt avec suppression des volumes (réinitialise la base de données)
docker compose down -v
```

---

## Accéder aux services

Une fois les conteneurs démarrés :

| Service              | URL                        | Credentials              |
|----------------------|----------------------------|--------------------------|
| Application web      | http://localhost:8085      | -                        |
| Adminer (Admin DB)   | http://localhost:8086      | Voir ci-dessous          |

### Connexion à Adminer

- **Système** : MySQL
- **Serveur** : `database`
- **Utilisateur** : `banduser`
- **Mot de passe** : `user1234`
- **Base de données** : `bandnames`

---

## Construction de l'image pour la production

Pour créer l'image Docker du service web avec un tag de version :
```bash
docker build -t bandnamesgenerator:1.0.0 ./web
```

Cette image peut ensuite être poussée sur un registry Docker :
```bash
docker tag bandnamesgenerator:1.0.0 your-registry/bandnamesgenerator:1.0.0
docker push your-registry/bandnamesgenerator:1.0.0
```

---

## Gestion des environnements

### Différences entre développement et production

Lors du passage en production, les éléments suivants devront être modifiés :

#### 🔐 Sécurité et credentials

- **Développement** : Credentials en clair dans `.env`, versionnés dans `.env.dist`
- **Production** : Utilisation de Docker Secrets, variables d'environnement système, ou gestionnaire de secrets (Vault, AWS Secrets Manager)

#### 🗄️ Base de données

- **Développement** : 
  - Volume local Docker
  - Initialisation automatique via `init.sql`
  - Données de test/développement
- **Production** :
  - Base de données managée (AWS RDS, Azure Database, etc.) ou cluster MySQL répliqué
  - Backups automatiques réguliers
  - Données réelles avec stratégie de migration (Flyway, Liquibase)

#### 🌐 Configuration réseau

- **Développement** :
  - Ports publiés directement (8085, 8086)
  - Service admin (Adminer) accessible
- **Production** :
  - Reverse proxy (Nginx, Traefik) devant l'application
  - HTTPS/TLS obligatoire
  - Adminer supprimé ou protégé derrière VPN

#### 📊 Logs et monitoring

- **Développement** :
  - Logs dans stdout/stderr (visibles avec `docker compose logs`)
  - Mode debug PHP activé
- **Production** :
  - Agrégation des logs (ELK Stack, Datadog, CloudWatch)
  - Mode production PHP (erreurs masquées à l'utilisateur)
  - Monitoring des performances (APM)

#### ⚙️ Configuration PHP

- **Développement** :
  - `php.ini-development` : affiche toutes les erreurs
  - Watch mode pour le hot-reload
- **Production** :
  - `php.ini-production` : erreurs loguées, pas affichées
  - Images optimisées (cache OPcache activé)

#### 🔄 Scalabilité

- **Développement** : Une instance de chaque service
- **Production** :
  - Plusieurs instances du service web (load balancing)
  - Orchestration avec Kubernetes ou Docker Swarm
  - Auto-scaling selon la charge

#### 🛠️ Dépendances

- **Développement** : Image `php:8.2-apache` (~500 MB)
- **Production** : Possibilité d'optimiser avec Alpine Linux (~80 MB) ou multi-stage builds

---

## Liens utiles

Ressources utilisées pour réaliser ce projet :

- [Documentation Docker Compose](https://docs.docker.com/compose/)
- [Compose File Reference](https://docs.docker.com/compose/compose-file/)
- [Image officielle MySQL sur Docker Hub](https://hub.docker.com/_/mysql)
- [Image officielle PHP sur Docker Hub](https://hub.docker.com/_/php)
- [PDO PHP Documentation](https://www.php.net/manual/fr/book.pdo.php)
- [Docker Compose Watch](https://docs.docker.com/compose/file-watch/)

---

## Remarques



### Difficultés rencontrées

- Service admin créant un conflit sur mon poste, je n'ai pas résolu ce souci.
- génération des noms une fois l'appli lancée 
> Résolu en modifiant la requête SQL dans functions.php en utilisant des placeholders distincts (genre1 et genre 2 au lieu de genre)
- désynchronisation des fichiers entre le local et le docker
> Résolu en cherchant dans les logs la taille des fichiers et en révérifiant que chaque dossier était bien passé dans le compose - *le dossier css n'était pas passé*

### Points d'amélioration possibles

- Proposer une fusion des genres, avec les adjectifs métal et noms speedcore etc.
- Ajouter plus de genres et de mots clés dans les tables
- Remettre en place le service admin, ne dérange pas à l'utilisation du site. C'est seulement un ajout de confort.

### Retour d'expérience

- L'exercice était bien, j'ai trouvé cela adapté pour une mise en situation et pour réfléchir à comment concevoir une appli selon le contexte.
