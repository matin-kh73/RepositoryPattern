<?php

namespace Mtkh\Repo\Commands;

use Illuminate\Console\GeneratorCommand;

class FilterCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filter class for using in the repository class';

    const MAIN_DIR = 'Repositories\Filters';


    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $className = ucfirst($this->argument('name'));
        $classDir = self::MAIN_DIR . DIRECTORY_SEPARATOR . $className;
        $path = $this->getPath($classDir);
        if ($this->alreadyExists($classDir)){
            $this->error($className . ' filter already exists!');
            return;
        }
        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($className));

        $this->info($className . ' filter created successfully.');
        $this->line("<info>Created Filter : </info>" . $className);
    }


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  __DIR__ . "/../stubs/Filter.stub";
    }
}
