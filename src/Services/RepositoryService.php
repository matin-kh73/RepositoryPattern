<?php


namespace Mtkh\Repo\Services;


use http\Exception\InvalidArgumentException;
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

    private $hasContract;

    /**
     * @var string
     */
    private $repositoryContract;

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
        $this->prepareRepository();
    }

    /**
     * Prepare repository class for creating
     */
    public function prepareRepository()
    {
        $this->setModelPath()->checkModelExist()->setRepositoryClass();
    }

    /**
     * Make repository class
     *
     * @param $fileContent
     * @return bool
     * @throws FileNotFoundException
     */
    public function makeRepository($fileContent)
    {
        $storage = $this->getRepositoryDirectory();
        $path = $this->getPath($storage);
        $this->makeDirectory($path);
        return (boolean) $this->createClass($path, '', $fileContent);
    }

    /**
     * Make prerequisite class
     *
     * @throws FileNotFoundException
     */
    public function makePrerequisiteClass()
    {
        foreach ($this->getProperty('prerequisiteClasses') as $class) {
            $path = $this->getPath(self::MAIN_REPO_DIR . $class);

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
        $path = $this->getPath(self::MAIN_REPO_DIR . 'RepositoryServiceProvider');
        $this->createClass($path, 'RepositoryServiceProvider');
    }

    /**
     * @param string $fileContent
     * @throws FileNotFoundException
     */
    public function makeRepositoryContract(string $fileContent)
    {
        $this->setContractPath();
        $storage = $this->getContractDir();
        $path = $this->getPath($storage);
        $this->makeDirectory($path);
        $this->createClass($path, '', $fileContent);
    }

    /**
     * @return string
     */
    public function getContractDir()
    {
        return str_replace($this->getProperty('repositoryClass'), 'Contracts', $this->getRepositoryDirectory()) . '\\' . $this->getProperty('repositoryContract');
    }

    /**
     * Set the storage of repo class
     */
    protected function getRepositoryDirectory()
    {
        return self::MAIN_REPO_DIR . $this->getProperty('modelName') . DIRECTORY_SEPARATOR . $this->getProperty('repositoryClass');
    }

    /**
     * @return string|string[]
     */
    protected function setContractPath()
    {
        $this->repositoryContract = $this->getProperty('repositoryClass') . 'Contract';
    }


    /**
     * Set the model path
     *
     * @return $this
     */
    protected function setModelPath()
    {
        $arg = explode('\\', $this->arg);
        $this->modelPath = $this->getProperty('rootNamespace') . $this->arg;
        $this->modelName = ucwords(end($arg));
        return $this;
    }


    /**
     * Check if exists model or not
     *
     * @return RepositoryService
     */
    protected function checkModelExist(): RepositoryService
    {
        if (!class_exists($this->getProperty('modelPath'))) {
            throw new ClassNotFoundException("Model {$this->getProperty('modelName')} not found!!", $this->getProperty('modelName'));
        }
        return $this;
    }

    /**
     * Set the repository class through model name
     *
     * @return $this
     */
    protected function setRepositoryClass()
    {
        $this->repositoryClass = $this->getProperty('modelName') . self::TYPE;
        return $this;
    }

    /**
     * Get property based on name
     *
     * @param $propertyName
     * @return mixed
     */
    public function getProperty($propertyName)
    {
        if (!isset($this->$propertyName)){
            throw new InvalidArgumentException("Property with the name : $propertyName does not exist!");
        }
        return $this->$propertyName;
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
        $name = Str::replaceFirst($this->getProperty('rootNamespace'), '', $name);

        return app()->basePath('app') . '/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * @param string $path
     * @param string $name
     * @param null $content
     * @return bool
     * @throws FileNotFoundException
     */
    protected function createClass(string $path, string $name = '', $content = null): bool
    {
        if (!file_exists($path)) {
            $this->files->put($path, $content ?: $this->files->get($this->getStub($name)));
            return true;
        }
        return false;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }
}
