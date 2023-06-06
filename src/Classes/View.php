<?php

namespace App\Classes;

use App\Classes\Http\Response;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class View
{

    public static function make($viewFile, $data = []) {
        global $projectRoot;

        // Instantiate the Blade compiler
        $filesystem = new Filesystem();
        $compiler = new BladeCompiler($filesystem, $projectRoot . 'cache');

        // Set up the engine resolver
        $engineResolver = new EngineResolver();
        $engineResolver->register('blade', function () use ($compiler) {
            return new CompilerEngine($compiler);
        });
        $engineResolver->register('php', function () use ($filesystem) {
            return new PhpEngine($filesystem);
        });

        // Set the path to your template files
        $viewFinder = new FileViewFinder($filesystem, [$projectRoot . 'src/Views']);

        // Instantiate the View Factory
        $viewFactory = new Factory($engineResolver, $viewFinder, new Dispatcher());

        // Render the Blade template with data
        return new Response(200, $viewFactory->make($viewFile, $data)->render());
    }

}