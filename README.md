
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

- Envoi de mails quantité à zéro pour informer l'admin
- Génération du PDF du détail du produit
- Affichage de la liste avec dataTable serveur side rendering
- Recherche sur le nom du produit dans la liste
- Pagination
- Création produit
- Modification avec calcul automatique du prix TTC/prix HT en fonction prix TTC, prix HT, TVA
- Affichage des détails d'un produit
- Décrémentation de la quantité produit
- Affichage d'une notification toast lors de l'envoi du mail


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

Installer et Compiler les assets

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
  php bin/console importmap:install   
```

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

## Envoi de mails

Démarrer le service intercepteur mail 

```bash
  docker compose up -d 
```

Configurer la variable d'environnement 

**MAILER_DSN=smtp://mailpit:@127.0.0.1:1025**

Démarrer le bus messenger pour le traitement asynchrone des messages

```bash
  php bin/console messenger:consume -vv
```
 
## Technologies

**Client:** Bootstrap, DataTable

**Server:** Symfony

**Docker** Docker