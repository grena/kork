## Captain Kork
[![CircleCI](https://circleci.com/gh/grena/kork.svg?style=svg&circle-token=dc532632b2b44cc3bcf847ffcff731b7804c930e)](https://circleci.com/gh/grena/kork)

**Captain Kork is survival & cooperative web based game.**
Based on a not-so-serious Sci-Fi universe, players will have to cooperate (but not that much), and try survive as many days as possible.

## Requirements

- PHP >= 7.2
- MySQL 5.7
- Composer

## Installation

#### 1) Clone this repository:
```bash
git@github.com:grena/kork.git && cd kork
```

#### 2) Install Composer dependencies
```bash
composer install
```

#### 3) Setup your MySQL database
```apacheconfig
mysql -u root -p

    CREATE DATABASE kork;
    GRANT ALL PRIVILEGES ON kork.* TO kork_user@localhost IDENTIFIED BY 'kork_passw0rd';
    EXIT
```

#### 4) Create the application database schema
```
php bin/console doctrine:schema:update --force
php bin/console kork:schema:create --force
```

## Configuration

### Setup GitHub oAuth login
1. Create a GitHub application with your GitHub account by following this link: https://github.com/settings/developers
2. Fill in needed informations. **Homepage URL** & **Authorization callback URL** should have the same URL, which is the Kork index page (eg. `http://kork.example.com/`)
3. Once the application created, put your **Client ID** & **Client Secret** tokens in the parameters file of your Badger app:
```
# ./.env
GITHUB_ID=123456789
GITHUB_SECRET=abcdef123456789
```

## Tests
To run the tests locally, run `./run_tests.sh`

Kork tries to follow the Hexagonal pattern and uses this kind of tests:
- **Unit tests** - _Ensure each class is working as it should behave_
- **Acceptance tests** - _Ensure all classes are working together as they should_
- **Integration tests** - _Ensure classes that interact with infrastructure (Database, File, HTTP...) are doing it well_

