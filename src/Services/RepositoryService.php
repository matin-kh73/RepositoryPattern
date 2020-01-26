<?php


namespace Mtkh\Repo\Services;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class RepositoryService
{
    /**
     * @var array
     */
    protected $prerequisiteClasses = ['BaseRepository', 'BaseRepositoryInterface'];

    /**
     * @var string
     */
    private $arg;

    /**
     * @var string
     */
    private $rootNamespace;

    /**
     * @var Filesystem
     */
    private $files;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    const TYPE = 'Repository';

    /**
     * The direction of storage classes
     */
    const MAIN_REPO_DIR = 'Repositories\\';

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $repositoryClass;

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $modelName;

    /**
     * path of the generated class
     *
     * @var string
     */
    private $modelPath;

    const ROOT_NAMESPACE = 'App';

    /**
     * RepositoryService constructor.
     *
     * @param string $arg
     * @param string $rootNamespace
     */
    public function __construct(string $arg, string $rootNamespace = null)
    {
        $this->files = new Filesystem();
        $this->arg = $arg;
        $this->rootNamespace = empty($rootNamespace) ? self::ROOT_NAMESPACE . '\\' : $rootNamespace . '\\';
    }

    /**
     * Prepare repository class for creating
     *
     * @return array
     */
    public function prepareRepository(): array
    {
        $this->setModelPath()->checkModelExist();
        return array($this->setRepositoryClass()->setRepositoryDirectory(), $this->getRepositoryClass());
    }

    /**
     * Make repository class
     *
     * @param string $path
     * @param $fileContent
     * @return bool
     */
    public function makeRepository(string $path, $fileContent)
    {
        if (!file_exists($path)) {
            $this->files->put(dd($path), $fileContent);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Make prerequisite class
     *
     * @throws FileNotFoundException
     */
    public function makePrerequisiteClass()
    {
        foreach ($this->getPrerequisiteClasses() as $class) {
            $path = $this->makePath($class);

            $this->createClass($path, $class);
        }
    }

    /**
     * Make repository service provider
     *
     * @throws FileNotFoundException
     */
    public function makeRepoServiceProvider()
    {
        $path = $this->makePath('RepositoryServiceProvider');
        $this->createClass($path, 'RepositoryServiceProvider');
    }

    /**
     * Set the model path
     *
     * @return $this
     */
    protected function setModelPath()
    {
        $arg = explode('\\', $this->arg);
        $this->modelPath = $this->rootNamespace . $this->arg;
        $this->modelName = ucwords(end($arg));
        return $this;
    }


    /**
     * Check if exists model or not
     *
     * @return void
     */
    protected function checkModelExist(): void
    {
        if (!class_exists($this->getModelPath())) {
            throw new ClassNotFoundException("Model {$this->getModelName()} not found!!", $this->getModelName());
        }
    }

    /**
     * Set the repository class through model name
     *
     * @return $this
     */
    protected function setRepositoryClass()
    {
        $this->repositoryClass = $this->getModelName() . self::TYPE;
        return $this;
    }

    /**
     * Set the storage of repo class
     */
    protected function setRepositoryDirectory()
    {
        return self::MAIN_REPO_DIR . $this->getModelName() . DIRECTORY_SEPARATOR . $this->repositoryClass;
    }

    /**
     * Get the path of the model
     *
     * @return string
     */
    public function getModelPath()
    {
        return $this->modelPath;
    }

    /**
     * Get the name of the model
     *
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * Get the repository class name
     *
     * @return string
     */
    public function getRepositoryClass()
    {
        return $this->repositoryClass;
    }

    /**
     * @return array
     */
    public function getPrerequisiteClasses()
    {
        return $this->prerequisiteClasses;
    }

    /**
     * Get the stub file for the generator.
     *
     * @param string|null $name
     * @return string
     */
    protected function getStub(string $name)
    {
        return __DIR__ . "/../stubs/{$name}.stub";
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace, '', $name);

        return app()->basePath('app') . '/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * @param string $path
     * @param string $name
     * @throws FileNotFoundException
     */
    protected function createClass(string $path, string $name): void
    {
        if (!file_exists($path)) {
            $this->files->put($path, $this->files->get($this->getStub($name)));
        }
    }

    /**
     * @param $className
     * @return string
     */
    protected function makePath($className): string
    {
        return $this->getPath($this->rootNamespace . self::MAIN_REPO_DIR . $className);
    }
}
