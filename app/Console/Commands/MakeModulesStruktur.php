<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModulesStruktur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name} {--auth}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate module structure for Transmedic';

    /**
     * Execute the console command.
     */
    public function handle() :void
    {
        $name = $this->argument('name');
        $auth = $this->option('auth');
        $baseDir = base_path('modules/' . $name);
        $directories = [
            'Http/Controllers',
            'Models',
            'Relationships',
            'Repositories',
            'Services',
            'Tests',
            'Views'
        ];
        File::makeDirectory($baseDir, 0755, true);
        foreach ($directories as $dir) {
            File::makeDirectory($baseDir . '/' . $dir, 0755, true);
        }
        $stubPath = __DIR__ . '/stubs/module-service-provider.stub';

        $serviceProviderContent = File::get($stubPath);

        $serviceProviderContent = str_replace(
            ['{{name}}'],
            [$name],
            $serviceProviderContent
        );

        File::put($baseDir . "/{$name}ServiceProvider.php", $serviceProviderContent);
        $stubPath = __DIR__ . '/stubs/module-routes.stub';

        $routesContent = File::get($stubPath);

        $routesContent = str_replace(
            ['{{name}}', '{{auth}}'],
            [$name, $auth ? "->middleware('auth:api')" : ''],
            $routesContent
        );

        File::put($baseDir . '/routes.php', $routesContent);
        $this->info("Module $name has been created successfully.");
    }
}
