<?php


namespace Mtkh\Repo\Tests;


class RepositoryFilterTest extends TestCase
{
    use RefreshDirectories;

    const FILTER_NAME = 'Paginate';

    public function __destruct()
    {
        $this->removeDirectory(app_path('Repositories\Filter'));
    }

    public function test_create_a_new_filter()
    {
        $this->artisan('make:filter', ['name' => self::FILTER_NAME])
            ->expectsOutput(self::FILTER_NAME . ' filter created successfully.')
            ->expectsOutput('Created Filter : ' . self::FILTER_NAME);

        $this->assertFileExists(app_path('Repositories/Filters/'. self::FILTER_NAME.'.php'));
    }

    public function test_create_a_filter_when_exist()
    {
        $this->artisan('make:filter', ['name' => self::FILTER_NAME]);
        $this->assertFileExists(app_path('Repositories/Filters/'. self::FILTER_NAME.'.php'));
        $this->artisan('make:filter', ['name' => self::FILTER_NAME])
            ->expectsOutput(self::FILTER_NAME . ' filter already exists!');
    }
}
