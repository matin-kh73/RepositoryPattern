<?php


namespace Mtkh\Repo\Tests;


use Mtkh\Repo\RepositoryPackageServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [RepositoryPackageServiceProvider::class];
    }
}