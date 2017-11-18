# Captain KORK

Web based game.

## Prerequisite 

- PHP 7.1+
- MySQL
- Composer

## Installation


#### 1) Install Composer dependencies
```
composer install
```

#### 2) Setup your database
```
mysql -u root -p

    CREATE DATABASE kork;
    GRANT ALL PRIVILEGES ON kork.* TO kork_user@localhost IDENTIFIED BY 'kork_password';
    EXIT

php bin/console doctrine:schema:update --force
```

#### 3) Install frontend assets
```bash
php bin/console assets:install # Move bundle assets to web/ directory
```

## Configuration
Once Captain KORK has been installed, you'll have some small things to configure in order to use the application.

### Setup GitHub oAuth login
1. Create a GitHub application with your GitHub account by following this link: https://github.com/settings/developers
2. Fill in needed informations. **Homepage URL** & **Authorization callback URL** should have the same URL, which is your Captain KORK index page (eg. `http://127.0.0.1/`)
3. Once the application created, put your **Client ID** & **Client Secret** tokens in the parameters file of the app:
```yml
# ./app/config/parameters.yml
parameters:
    github_client_id: 123456789
    github_client_secret: abcdef123456789
```
