<?php

namespace Mtkh\Repo\Tests;


use Mtkh\Repo\Commands\RepositoryCommand;
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

    public function __destruct()
    {
        $this->removeDirectory(app_path('Repositories'));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelDir = 'Models';
        $this->modelName = 'Test1';
    }

    public function test_prepare_a_repository_with_valid_model()
    {
        $repoService = new RepositoryService($this->modelDir . '\\' . $this->modelName, __NAMESPACE__);
        $repoService->prepareRepository();
        $this->assertEquals($this->modelName . "Repository", $repoService->getProperty('repositoryClass'));
    }

    public function test_prepare_a_repository_with_invalid_model()
    {
        try {
            $repoService = new RepositoryService($this->modelDir . '\\' . $this->modelName, '\\');
            $repoService->prepareRepository();
        } catch (\Exception $exception) {
            $this->assertEquals("Model $this->modelName not found!!", $exception->getMessage());
        }
    }

    public function test_make_a_repository()
    {
        $this->artisan('make:repository', ['name' => $this->modelDir . '\\' . $this->modelName, '--namespace' => __NAMESPACE__])
            ->expectsOutput('Repository created successfully.')
            ->expectsOutput('Created Repository :' . $this->modelName . 'Repository');
    }

    public function test_make_a_repository_when_exist()
    {
        $this->artisan('make:repository', ['name' => 'Models\Test1', '--namespace' => __NAMESPACE__]);
        $this->artisan('make:repository', ['name' => 'Models\Test1', '--namespace' => __NAMESPACE__])
            ->expectsOutput($this->modelName . 'Repository already exists!');
    }

    public function test_make_prerequisite_class()
    {
        $repoService = new RepositoryService($this->modelDir . '\\' . $this->modelName, __NAMESPACE__);
        $repoService->getProperty('prerequisiteClasses');
        $this->assertFileExists(app_path('Repositories/RepositoryServiceProvider.php'));
    }

    public function test_make_repository_contract()
    {
        $repoService = new RepositoryService($this->modelDir . '\\' . $this->modelName, __NAMESPACE__);
        $repositoryCommand = \Mockery::mock(RepositoryCommand::class);
        $repositoryCommand->shouldAllowMockingProtectedMethods()->shouldReceive('buildClass')
        ->withArgs([$repoService->getProperty('repositoryClass'),'RepositoryContract'])
        ->andReturn(file_get_contents(__DIR__ . '/../src/stubs/RepositoryContract.stub'));
    }

    /**
     * remove Repository directory on project
     *
     * @param $path
     */
    protected function removeDirectory($path)
    {
        if (is_dir($path)) {
            $files = glob($path . '/*');
            foreach ($files as $file) {
                is_dir($file) ? $this->removeDirectory($file) : unlink($file);
            }
            rmdir($path);
            return;
        }
    }
}