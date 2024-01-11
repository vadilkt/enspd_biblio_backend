## Description

enspd_biblio_backend est une application back-end Laravel qui permet de cataloguer les mémoires de l'École nationale supérieure polytechnique de Douala (ENSPD). Elle fournit une API RESTful qui permet aux utilisateurs de rechercher, de créer, de mettre à jour et de supprimer des mémoires.

## Prérequis

Pour installer enspd_biblio_backend, vous devez disposer des éléments suivants :

* Un ordinateur avec un système d'exploitation Windows, macOS ou Linux
* Un environnement de développement local (par exemple, Vagrant ou Docker)
* Laravel version 9 ou supérieure

## Étapes d'installation

Pour installer enspd_biblio_backend, suivez les étapes suivantes :

1. Clonez le dépôt GitHub :

```
git clone https://github.com/vadilkt/enspd_biblio_backend.git
```

2. Accédez au répertoire du projet :

```
cd enspd_biblio_backend
```

3. Installez les dépendances Laravel :

```
composer install
```

4. Créez la base de données :

```
php artisan migrate
```

5. Générez une clé API :

```
php artisan key:generate
```

6. Démarrez le serveur local :

```
php artisan serve
```

L'application sera accessible à l'adresse http://localhost:8000.

## Étapes de déploiement

Pour déployer enspd_biblio_backend sur un serveur, vous devez suivre les étapes suivantes :

1. Créez un compte sur un fournisseur d'hébergement web.
2. Créez une base de données sur le serveur.
3. Téléchargez le code source de l'application sur le serveur.
4. Installez les dépendances Laravel sur le serveur.
5. Copiez le fichier `.env.example` dans `.env` et modifiez les paramètres en fonction de votre environnement.
6. Exécutez la commande suivante pour créer la base de données :

```
php artisan migrate
```

7. Exécutez la commande suivante pour générer une clé API :

```
php artisan key:generate
```

8. Configurez le serveur pour exécuter l'application.

## Contributions

enspd_biblio_backend est un projet open source. Vous êtes invités à contribuer en soumettant des suggestions, des corrections ou de nouveaux codes. Pour contribuer, suivez les instructions suivantes :

1. Créez un compte GitHub.
2. Forkez le dépôt GitHub.
3. Effectuez vos modifications.
4. Soumettre une pull request.

## Licence

enspd_biblio_backend est distribué sous la licence MIT.


* Les routes pour les mémoires doivent être définies dans le fichier `routes/api.php`. Les routes suivantes sont nécessaires :

```php
Route::get('/books', 'MémoiresController@index');
Route::get('/books/{id}', 'MémoiresController@show');
Route::post('/books', 'MémoiresController@store');
Route::put('/books/{id}', 'MémoiresController@update');
Route::delete('/books/{id}', 'MémoiresController@destroy');
```

**Exemple de requête HTTP**

Voici un exemple de requête HTTP pour récupérer la liste de tous les mémoires :

```
GET /books
```

