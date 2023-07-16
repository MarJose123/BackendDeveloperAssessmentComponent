<?php

namespace MarJose123\BackendDeveloperAssessmentComponent\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use MarJose123\BackendDeveloperAssessmentComponent\BackendDeveloperAssessmentComponentServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'MarJose123\\BackendDeveloperAssessmentComponent\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            BackendDeveloperAssessmentComponentServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_backenddeveloperassessmentcomponent_table.php.stub';
        $migration->up();
        */
    }
}
