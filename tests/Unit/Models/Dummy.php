<?php declare(strict_types = 1);

namespace Thiagoprz\CompositeKey\Unit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;
use Thiagoprz\CompositeKey\Tests\Unit\Factories\DummyFactory;

/**
 * @property int $key_1
 * @property int $key_2
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $city
 */
class Dummy extends Model
{
    use HasCompositeKey, HasFactory;

    /**
     * @var string[]
     */
    protected $primaryKey = ['key_1', 'key_2'];

    /**
     * Table name
     * @var string
     */
    protected $table = 'dummy';

    /**
     * @var string[]
     */
    protected $fillable = ['key_1', 'key_2', 'name', 'email', 'phone', 'city'];

    /**
     * @return DummyFactory
     */
    protected static function newFactory()
    {
        return DummyFactory::new();
    }
}