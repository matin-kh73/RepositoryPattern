<?php
namespace Mtkh\Repo\Tests;


use Mtkh\Repo\Services\RepositoryService;

class RepositoryServiceTest extends TestCase
{
    /**
     * @var string
     */
    private $modelName;

    /**
     * @var string
     */
    private $modelDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->removeDirectory(app_path('Repositories'));
        $this->modelDir = 'Models';
        $this->modelName = 'Test1';
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->removeDirectory(app_path('Repositories'));
    }

    public function test_prepare_a_repository_with_valid_model()
    {
        $repoService = new RepositoryService($this->modelDir . '\\' . $this->modelName, __NAMESPACE__);
        list($storage, $repoClass) = $repoService->prepareRepository();
//        $this->assertEquals("Repositories\\$this->modelName\\Test1Repository", $storage);
        $this->assertEquals($this->modelName."Repository", $repoClass);
    }

    public function test_prepare_a_repository_with_invalid_model()
    {
        $repoService = new RepositoryService($this->modelDir . '\\' . $this->modelName, '\\');
        try {
            $response = $repoService->prepareRepository();
        } catch (\Exception $exception){
            $this->assertEquals("Model $this->modelName not found!!", $exception->getMessage());
        }
    }

    public function test_make_a_repository()
    {
        $this->artisan('make:repository', ['name' => $this->modelDir . '\\' . $this->modelName, '--namespace' => __NAMESPACE__])
        ->expectsOutput('Repository created successfully.')
        ->expectsOutput('Created Repository :' . $this->modelName.'Repository');
    }

    public function test_make_a_repository_when_exist()
    {
        $this->artisan('make:repository', ['name' => 'Models\Test1', '--namespace' => __NAMESPACE__]);
        $this->artisan('make:repository', ['name' => 'Models\Test1', '--namespace' => __NAMESPACE__])
            ->expectsOutput($this->modelName.'Repository already exists!');
    }

    /**
     * remove Repository directory on project
     *
     * @param $path
     */
    protected function removeDirectory($path) {
        if (is_dir($path)){
            $files = glob($path . '/*');
            foreach ($files as $file) {
                is_dir($file) ? $this->removeDirectory($file) : unlink($file);
            }
            rmdir($path);
            return;
        }
    }
}