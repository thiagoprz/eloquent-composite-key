<?php

namespace Thiagoprz\CompositeKey\Tests\Unit\Models\Create;

use Thiagoprz\CompositeKey\Tests\TestCase;
use Thiagoprz\CompositeKey\Unit\Models\Dummy;

class CreateTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return void
     * @testdox Test create model success
     */
    public function test_create_success()
    {
        $model = Dummy::factory()->make();
        $success = $model->save();
        $this->assertTrue($success);
    }
}