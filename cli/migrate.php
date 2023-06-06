<?php

$projectRoot = __DIR__ . '/../';

require $projectRoot . 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Filesystem\Filesystem;

loadEnvConfig($projectRoot);

$capsule = new Capsule;
$capsule->addConnection([
    'driver'   => 'mysql',
    'host'     => getenv('DB_HOST'),
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset'  => 'utf8',
    'collation'=> 'utf8_unicode_ci',
    'prefix'   => '',
]);

$capsule->bootEloquent();
$capsule->setAsGlobal();

$migrationsPath = $projectRoot . 'database/migrations';

if(!Capsule::schema()->hasTable('migrations')) {
    Capsule::schema()->create('migrations', function (Blueprint $table) {
        $table->increments('id');
        $table->string('migration');
        $table->integer('batch');
    });
}

$repository = new DatabaseMigrationRepository($capsule->getDatabaseManager(), 'migrations');
$migrator = new Migrator($repository, $capsule->getDatabaseManager(), new Filesystem());

$migrator->run($migrationsPath);

echo "Migrations completed successfully.\n";