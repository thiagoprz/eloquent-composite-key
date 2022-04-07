# Eloquent Composite Key
Package to enable composite key support on Eloquent Models.

## Installation
Install it with composer:

`composer require thiagoprz/eloquent-composite-key`

## Usage
Define the primaryKey as an array and use the HasCompositeKey trait on your model class.
```
<?php
...
use Thiagoprz\CompositeKey\HasCompositeKey;

class User extends Model 
{
    use HasCompositeKey;
    ...
    protected $primaryKey = ['firstKey', 'secondKey'];
    ...
}
```
Using primary keys to find records:
```
<?php
...
// Returns model instance or null
$user = User::find([
    'key_1' => $key1,
    'key_2' => $key2,
]);
...
// Throws ModelNotFoundException
$user = User::findOrFail([
    'key_1' => $key1,
    'key_2' => $key2,
]);
...
```

The main idea of this package is to allow Laravel projects use composite keys on models despite Eloquent not supporting them officially (see https://laravel.com/docs/8.x/eloquent#composite-primary-keys).  


## License
[MIT](https://github.com/thiagoprz/eloquent-composite-key/blob/master/License.txt)