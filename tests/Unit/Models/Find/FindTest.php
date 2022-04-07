<?php

namespace Thiagoprz\CompositeKey\Tests\Unit\Models\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Thiagoprz\CompositeKey\Tests\TestCase;
use Thiagoprz\CompositeKey\Unit\Models\Dummy;

class FindTest extends TestCase
{

    /**
     * @var Dummy[]
     */
    private $dummies;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dummies = Dummy::factory()->count(2)->create();
    }

    /**
     * @return void
     */
    public function test_find_model_success()
    {
        $model = Dummy::find([
            $this->dummies[0]->key_1,
            $this->dummies[0]->key_2,
        ]);
        $this->assertEquals($this->dummies[0]->getAttributes(), $model->getAttributes());
    }

    /**
     * @return void
     */
    public function test_find_wrong_arguments_failure()
    {
        $this->expectException(\TypeError::class);
        Dummy::find($this->dummies[0]->key_1);
    }

    /**
     * @return void
     */
    public function test_find_or_fail_success()
    {
        $model = Dummy::findOrFail([
            $this->dummies[0]->key_1,
            $this->dummies[0]->key_2,
        ]);
        $this->assertEquals($this->dummies[0]->getAttributes(), $model->getAttributes());
    }

    /**
     * @return void
     */
    public function test_find_or_fail_model_not_found_exception_failure()
    {
        $this->expectException(ModelNotFoundException::class);
        Dummy::findOrFail([
            1234,
            21341,
        ]);
    }
}