<?php

namespace Thiagoprz\CompositeKey\Tests;

use Orchestra\Testbench\TestCase as BaseTest;

class TestCase extends BaseTest
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $database = require __DIR__ . '/config/database.php';
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', $database['sqlite']);
        $app['config']->set('app.debug', true);
        $app['config']->set('logging.default', 'daily');
        $app['config']->set('logging.channels.daily.path', 'logs/testing.log');
        unlink(__DIR__ . '/database/testing.sqlite');
        touch(__DIR__ . '/database/testing.sqlite');
        require_once __DIR__ . '/database/migrations/create_dummy_table.php';
        (new \CreateDummyTable)->up();
    }
}