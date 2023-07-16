# This is my package backenddeveloperassessmentcomponent
Make sure you system support `Laravel 10` and meet the requirements.

## Installation

Update you laravel app `composer.json` file and add the path of the library location

```php
"repositories": [
    {
      "type": "path",
      "url": "../BackendDeveloperAssessmentComponent"
    }
  ],

```

add the library to `composer.json` inside the `require`:
```php
 "marjose123/backenddeveloperassessmentcomponent": "dev-main"
```

You can install the package via composer:

```bash
composer update
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
Add the middleware to your `$middlewareAliases` inside your `app/Http/Kernel.php` file.

```php
'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
```
Create a DB Seeder in your app using this
<details> 
  <summary>UserSeeder.php </summary>
    ```php
         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $arrayOfPermissionNames = ['Add Role', 'Delete Role', 'Add User', 'Delete User', 'View User', 'View Role', 'View Profile', 'View Permissions'];
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'api'];
        });
        Permission::insert($permissions->toArray());

        // create roles and assign created permissions

        Role::create(['name' => 'SUPER_USER'])
                        ->givePermissionTo(Permission::all());
        Role::create(['name' => 'USER'])
                    ->givePermissionTo([
                        'View Profile'
                    ]);
       Role::create(['name' => 'ADMIN'])
                    ->givePermissionTo([
                        'Add Role', 'Add User', 'View User', 'View Role', 'View Profile'
                    ]);


        // Create access credential lists for users
        $SuperUserAccess = User::create([
           'name' => 'SUPER USER',
           'email' => 'superuser@mail.com',
           'password' =>  Hash::make('superuser')
        ]);
        $AdminAccess = User::create([
            'name' => 'ADMIN',
            'email' => 'admin@mail.com',
            'password' =>  Hash::make('admin')
        ]);
       $userAccess = User::create([
            'name' => 'USER',
            'email' => 'user@mail.com',
            'password' =>  Hash::make('user')
        ]);

       // Assign the Pre-defined Role to the User
        $SuperUserAccess->assignRole('SUPER_USER');
        $AdminAccess->assignRole('ADMIN');
        $userAccess->assignRole('USER');

    ``` 
</details>


## Usage

Make sure to add `Content-Type` and `Accept` with `application/json` value


## Roles and Permission Notes

- SUPER USER have an ability to take all an action in the system
- ADMIN has an ability almost the same with the `SUPER USER` but doesn't have any ability to `Delete` any record.
- USERs have an ability to view only his profile.

## API Authorization checking login

- The API entry point will check the authenticated user if the user has the right role, or the have an ability to perform the action.

## Testing

```bash
composer test
```
