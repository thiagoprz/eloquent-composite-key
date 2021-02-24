# Eloquent Composite Key
Package to enable composite key support on Eloquent Models.


## Installation
Install it with composer:

`composer require thiagoprz/eloquent-composite-key`

## Usage
Define the primaryKey as an array and use the HasCompositeKey trait on your model.

```
class User extends Model 
{
    use HasCompositeKey;
    ...
    protected $primaryKey = ['firstKey', 'secondKey'];
    ...
}
```

The idea of this package is to allow eloquent models to use composite keys despite that Eloquent doesn't support it officially (see https://laravel.com/docs/8.x/eloquent#composite-primary-keys).  
