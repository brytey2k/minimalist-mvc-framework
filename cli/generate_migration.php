<?php

$projectRoot = __DIR__ . '/../';

require $projectRoot . 'vendor/autoload.php';

use Illuminate\Support\Str;

// Function to generate migration file
function generateMigrationFile()
{
    $tableName = 'table_name';
    $timestamp = date('Y_m_d_His');
    $className = 'Create' . Str::studly($tableName) . 'Table' . Str::random(8);
    $fileName = $timestamp . '_' . Str::snake($className) . '.php';

    $migrationContent = <<<EOT
<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class $className extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('$tableName', function (Blueprint \$table) {
            \$table->id();
            // Define your table columns here
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('$tableName');
    }
}
EOT;

    file_put_contents('database/migrations/' . $fileName, $migrationContent);

    echo "Migration file generated: " . $fileName . PHP_EOL;
}

// Generate migration file
generateMigrationFile();
