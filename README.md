[![Continuous Integration](https://github.com/KrivanRaulAdrian/manage-students-api/actions/workflows/continuous-integration.yml/badge.svg?branch=master)](https://github.com/KrivanRaulAdrian/manage-students-api/actions/workflows/continuous-integration.yml)

<p align="center">
  <img align="center" height="200" src=" public/symfony.png">
</p>

<h1 align="center">Manage Students API</h1>

This API allows you to manage students by providing endpoints to perform CRUD operations on a list of students. Each student is defined by a registration number, name, grade, and classroom.

This API requires authentication for user management and student management endpoints. The client must sign up and log in to obtain a token to access the protected routes.

## Requirments <hr/>

- PHP 8.2
- <a href="https://getcomposer.org/" rel="nofollow">Composer</a>
- <a href="https://www.mamp.info/en/mamp/windows/" rel="nofollow">MAMP</a>
- <a href="https://symfony.com/download" rel="nofollow">Symfony CLI</a> (optional)

## Install <hr/>

1. Clone the repository:

```
git clone git@github.com:KrivanRaulAdrian/manage-students-api.git
```

2. Access the directory:

```
cd manage-students-api/
```

3. Install the Composer dependencies:

```
composer install
```

4. Go to MySQL and create the database `job-board-api `
5. Create a file `.env.local` and add your database connection. Example:

```dotenv
DATABASE_URL="mysql://root:@localhost:3306/manage_students_api"
```

6. Create the tables:

```
php bin/console doctrine:migrations:migrate
```

7. Run the application:

```
symfony server:start
# or
php -S localhost:8000 -t public
```

8. Go to http://localhost:8000

**\*Note:** To generate the JWT security [keypair], use a Linux container running the following command: `docker-compose run -it php-fpm php bin/console lexik:jwt:generate-keypair`.\*

## Routes <hr/>

To access the API documentation, go to http://localhost:8000/api/doc.

<p align="center">
  <img align="center" src=" public/manage_students_api.png">
</p>

## Quality Tools <hr/>

You can run PHP CS Fixer to check the code style and PHPStan for static analysis.

## Code Style

Install PHP CodeSniffer:

```
composer require squizlabs/php_codesniffer
```

Run PHP CodeSniffer:

```
./vendor/bin/phpcs --standard=PSR12 src/
```

Run PHP CodeSniffer Fixer:

```
 ./vendor/bin/phpcbf --standard=PSR12 src/
```

## Static Analysis

Install PHPStan:

```
composer require --dev phpstan/phpstan-symfony
```

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```
includes:
    - vendor/phpstan/phpstan-symfony/extension.neon
```

To perform framework-specific checks, include also this file:

```
includes:
    - vendor/phpstan/phpstan-symfony/rules.neon
```

</details>

Run PHPStan:

```
php vendor/bin/phpstan analyze
```
