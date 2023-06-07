# minimalist-mvc-framework
This is a side project I started building a minimalist framework that supports validation, migrations, routing, templates, autoloading, etc.

## How to set up
- create the mysql database
- open .env file in project and add the correct database credentials
- from the command line run 'php cli/migrate.php' to migrate the database
- the project root must be the public directory
- you can start the project by running `php -S localhost:8080 -t public public/index.php`
- Access the app from the browser by visiting http://localhost:8080
