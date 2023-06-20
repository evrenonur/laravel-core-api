<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CreateServices extends Command
{
    protected $signature = 'service:generate {namespace} {controllerName} {--nm}';

    protected $description = 'Generate a controller, service, and request objects';

    public function handle()
    {
        $namespace = $this->argument('namespace');
        $controllerName = $this->argument('controllerName');
        $createModel = !$this->option('nm');

        if ($createModel) {
            Artisan::call('make:model', [
                'name' => $controllerName,
                '-m' => true,
            ]);
        }

        // Controller Oluşturma
        $controllerPath = app_path("Http/Controllers/{$namespace}/{$controllerName}Controller.php");
        $this->createDirectoryIfNotExists(dirname($controllerPath));
        $this->generateController($controllerPath, $namespace, $controllerName);

        // Request Klasörü Oluşturma
        $requestFolderPath = app_path("Http/Requests/{$namespace}/{$controllerName}");
        $this->createDirectoryIfNotExists($requestFolderPath);

        // Request Nesneleri Oluşturma
        $requestClasses = ['GetByIdRequest', 'GetAllRequest', 'CreateRequest', 'DeleteRequest', 'UpdateRequest'];
        foreach ($requestClasses as $requestClass) {
            $requestPath = "{$requestFolderPath}/{$requestClass}.php";
            $this->generateRequest($requestPath, $namespace, $controllerName, $requestClass);
        }

        // Interface Oluşturma
        $interfacePath = app_path("Interfaces/Eloquent/I{$controllerName}Service.php");
        $this->createDirectoryIfNotExists(dirname($interfacePath));
        $this->generateInterface($interfacePath, $controllerName);

        // Service Oluşturma
        $servicePath = app_path("Services/Eloquent/{$controllerName}Service.php");
        $this->createDirectoryIfNotExists(dirname($servicePath));
        $this->generateService($servicePath, $controllerName);

        $this->info('Controller, Service, and Request objects generated successfully!');

    }

    private function createDirectoryIfNotExists($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            $this->info("Directory created: $path");
        }
    }

    private function generateController($path, $namespace, $controllerName)
    {
        $stub = <<<EOD
<?php

namespace App\Http\Controllers\\{$namespace};

use App\Http\Controllers\Controller;

class {$controllerName}Controller extends Controller
{
    // Controller işlemleri buraya gelecek
}
EOD;

        File::put($path, $stub);
        $this->info("Controller created: $path");
    }

    private function generateRequest($path, $namespace, $controllerName, $requestClass)
    {
        $stub = <<<EOD
<?php

namespace App\Http\Requests\\{$namespace}\\{$controllerName};

use Illuminate\Foundation\Http\FormRequest;

class {$requestClass} extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Validation kuralları buraya gelecek
        ];
    }
}
EOD;

        File::put($path, $stub);
        $this->info("Request created: $path");
    }

    private function generateInterface($path, $controllerName)
    {
        $stub = <<<EOD
<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IEloquentService;


interface I{$controllerName}Service extends IEloquentService
{
    //
}
EOD;

        File::put($path, $stub);
        $this->info("Interface created: $path");
    }

    private function generateService($path, $controllerName)
    {
        $stub = <<<EOD
<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\I{$controllerName}Service;

class {$controllerName}Service implements I{$controllerName}Service
{
    //
}
EOD;

        File::put($path, $stub);
        $this->info("Service created: $path");
    }
}
