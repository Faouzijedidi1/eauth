# Outdare Authentication Package

## Instalation
- add `"etnos/eauth": "dev-auth-v5@dev"` in the `require` property located in your projecy composer.json file.
- run `composer update`.
- add `Outdare\Auth\AuthServiceProvider::class` in `config/app.php` file.
- run `composer update`.
- run `php artisan vendor:publish`, when prompt to select the provider select the number corresponding to `Outdare\Auth\AuthServiceProvider`.
- add `$this->call(UsersSeeder::class);` to `run()` method located in `database/DatabaseSeeder.php` file.
- run `php artisan migrate --path=/vendor/etnos/eauth/src/migrations`.
- run `php artisan db:seed`.

## Configurations
- It is required to change the `guest` middleware in `app/Http/Kernel.php` file to `\Outdare\Auth\Middleware\RedirectIfAuthenticated::class`.
- enable_register_routes: Boolean => defines whether or not to enables registration routes/views
- redirect_path: String => defines the redirect url to use after login/register ("/home")
- seed_users: Array => list of default users to add
- enable_roles: Boolean => defines whether or not to use roles
- seed_roles: Array => list of roles to add (if enable_roles==false, it will be ignored)
- add `'isAdmin' => \Outdare\Auth\Middleware\IsAdmin::class` middleware in `app/Http/Kernel.php` if `enable_roles`is true.


#### Details
This package perform the following actions:
- publishes a folder `auth` to `resources/views` where you can customise the views for the authentication (login).
- run migrations to create `users` table.
- run seeds to create the users specicied by seed_users option in the configuration file.
- if enable_roles is true, it creates `roles` and `role_user` tables and corresponding models
- if enable_roles is true, it published a middleware `isAdmin` to check if the authenticated user is an admin

#### Routes
Available routes provided for authentication.

| Method   | URI        | Name     | Action                                                               | Middleware   |
|----------|------------|----------|----------------------------------------------------------------------|--------------|
| GET 	   | login      | login    | Outdare\Auth\Controllers\Auth\LoginController@showLoginForm           | web,guest   |
| POST     | login      | login    | Outdare\Auth\Controllers\Auth\LoginController@login                   | web,guest   |
| POST     | logout     | logout   | Outdare\Auth\Controllers\Auth\LoginController@logout                  | web         |
| POST     | user/login |          | Outdare\Auth\Controllers\Auth\LoginController@userLogin               | web,guest   |
| POST     | user/register |       | Outdare\Auth\Controllers\Auth\LoginController@userRegister               | web,guest   |

The method `POST: user/login` provides a route to authenticate a user through a HTTP request. The following block illustrates an example:

```javascript
	$.ajax({
        url: '/user/login',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {email: "user_email", password: "user_password"},
    })
    .done(function() {
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    });
```

The method `POST: user/register` provides a route to authenticate a user through a HTTP request. The following block illustrates an example (the role is required only if the `enable_roles` is true on the config);

```javascript
function register(){
    $.ajax({
        url: '/user/register',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {name: "name", email: "email", password: "password", role: "rolename"},
    })
    .done(function(data) {
        console.log(data);
    })
    .fail(function(data) {
        console.log(data);
    });
}
```