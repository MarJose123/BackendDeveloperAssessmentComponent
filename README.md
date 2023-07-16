# This is my package backenddeveloperassessmentcomponent
Make sure you system support `Laravel 10` and meet the requirements.

## Installation

You can install the package via composer:

```bash
composer require marjose123/backenddeveloperassessmentcomponent
```

You can publish services publishable with:

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Add the necessary trait to your User model:
```
use HasRoles;
```
Firstly you need to implement the `Tymon\JWTAuth\Contracts\JWTSubject` contract on your User model, which requires that you implement the 2 methods `getJWTIdentifier()` and `getJWTCustomClaims()`.
```php
public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
```

Inside the `config/auth.php` file you will need to make a few changes to configure Laravel to use the jwt guard to power your application authentication.
```php
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

...

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

Run Database Migration
```bash
php artisan migrate
```

Generate new JWT secret key for your application
```bash
php artisan jwt:secret
```

Run Database Seeder to populate the database
```bash
php artisan db:seed
```


## Usage


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Marjose123](https://github.com/MarJose123)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
