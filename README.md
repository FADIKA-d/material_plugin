
# Module de matériel

Module permettant de gérer le stock de matériel d'une entreprise.

## Prerequis

- PHP ^8.2.*
- Composer
- MySQL ou MariaDB ou Postgre

## Variables d'environnement

Pour exécuter ce projet, vous devez ajouter les variables d'environnement suivantes à votre fichier .env

`DATABASE_URL`

`MAILER_DSN`

## Fonctionnalités

- Light/dark mode toggle
- Live previews
- Fullscreen mode
- Cross platform


## Executer le projet en local

Cloner le projet

```bash
  git clone https://link-to-project
```

Se déplacer dans le répertoire du projet

```bash
  cd material_plugin
```

Installer les dépendances

```bash
  composer install
```

Compiler les assets

```bash
  php bin/console asset-map:compile
```
Configurer la base de données dans le fichier .env
DATABASE_URL=
Création de la base de données

```bash
  php bin/console doctrine:database:create 
```

Appliquer les migrations

```bash
  php bin/console doctrine:migrations:migrate
```

Charger les fixtures

```bash
  php bin/console doctrine:fixture:load  
```

Démarrer le serveur web

```bash
  php -S 127.0.0.1:8000 -t public
```

## Technologies

**Client:** Bootstrap, DataTable

**Server:** Symfony