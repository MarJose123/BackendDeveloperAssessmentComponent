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

Run Database Seeder to populate the database
```bash
php artisan db:seed
```

# Credentials

###### SUPER USER
```
superuser@mail.com
superuser
```
###### ADMIN
```
admin@mail.com
admin
```
###### USER
```
user@mail.com
user
```


## Usage

Make sure to add `Content-Type` and `Accept` with `application/json` value


## Roles and Permission Notes

- SUPER USER have an ability to take all an action in the system
- ADMIN has an ability almost the same with the `SUPER USER` but doesn't have any ability to `Delete` any record.
- USERs have an ability to view only his profile.
- The best practice approach is to check the permissions not the role, as the Roles stand only for the sets of permissions you've created and not the actual user ability on the system. By doing the Role checking only it will make our system vulnerable.
- When creating a new `Role`, you need to supply an `id` of the `Permissions` you want to associate with the Role that you will be creating.
- The API route will be checked if the request is authorized, and if the authorized user has the required role or ability to perform an action of the specific API route.
- When associating a `Role` to newly created user, use the name of the `Role`.

## API Authorization checking login

- The API entry point will check the authenticated user if the user has the right role, or the have an ability to perform the action.

## API Entry Point documentation

----

###### User Authentication
- http://{SERVER_IP}/auth/login
  - Method: POST
  - Body (JSON)
    - Email
    - Password
  - Headers:
    - Content-type : application/json
    - Accept : application/json
###### Roles and Permissions
- http://{SERVER_IP}/security/role
    - Method: POST
  - Body (JSON)
      - role_name
      - permissions
    - Headers:
        - Content-type : application/json
        - Accept : application/json
- http://{SERVER_IP}/security/roles
    - Method: GET
    - Headers:
        - Content-type : application/json
        - Accept : application/json
- http://{SERVER_IP}/security/permissions
    - Method: GET
    - Headers:
        - Content-type : application/json
        - Accept : application/json
###### View/Add Users
- http://{SERVER_IP}/account/users
    - Method: GET
    - Headers:
        - Content-type : application/json
        - Accept : application/json
- http://{SERVER_IP}/account/users
    - Method: POST
    - Body (JSON)
        - name
        - email
        - password
    - Headers:
        - Content-type : application/json
        - Accept : application/json



---
###### API Response structure For Authentication
```json
{
  "status": "success",
  "code": 200,
  "message": "Successfully Logged in",
  "data": {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXV0aC9sb2dpbiIsImlhdCI6MTY4OTQ4MzE0MiwiZXhwIjoxNjg5NDg2NzQyLCJuYmYiOjE2ODk0ODMxNDIsImp0aSI6IjQ2bXFCTWpnT3Q3WEVWekwiLCJzdWIiOiIzIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.fApPnuL4idWR_ytkofk_VURoleXZegyl-ywIU_RkAvQ",
    "token_type": "bearer",
    "expires_in": 3600
  }
}
```
###### API Response structure For Retrieve
```json
{
  "status": "success",
  "code": 200,
  "message": "List of all User",
  "count": 3,
  "data": [
    {
      "id": 1,
      "name": "SUPER USER",
      "email": "superuser@mail.com",
      "email_verified_at": null,
      "created_at": "2023-07-15T08:51:05.000000Z",
      "updated_at": "2023-07-15T08:51:05.000000Z"
    },
    {
      "id": 2,
      "name": "ADMIN",
      "email": "admin@mail.com",
      "email_verified_at": null,
      "created_at": "2023-07-15T08:51:05.000000Z",
      "updated_at": "2023-07-15T08:51:05.000000Z"
    },
    {
      "id": 3,
      "name": "USER",
      "email": "user@mail.com",
      "email_verified_at": null,
      "created_at": "2023-07-15T08:51:05.000000Z",
      "updated_at": "2023-07-15T08:51:05.000000Z"
    }
  ]
}
```

## Testing

```bash
composer test
```
