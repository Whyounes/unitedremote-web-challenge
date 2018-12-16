## UnitedRemote Web Challenge

You can use [Homestead](https://laravel.com/docs/5.7/homestead) or any other VM to run the project.

### Configuration

Copy `.env.example` to `.env` in you root app folder, and update the following environment values.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unitedremote
DB_USERNAME=root
DB_PASSWORD=root
```

After that you create the DB in the specified host.

Run `php artisan key:generate` inside the VM to generate your application key.

### Dependencies

Run the following commands to pull app dependencies inside the app root folder: 

```
composer update
npm i
npm run dev
``` 

### Geolocation Note

For security concerns, Geolocation is denied from untrusted sources. Since I used a custom local domain I couldn't test it properly.
I used a fake location as a fallback in case of error, just to showcase the code implementation.

Reference (https://developer.mozilla.org/en-US/docs/Web/Security/Secure_Contexts)

### Screenshots

[Home Page]()
[Login Page]()
[Preferred Shops Page]()
[Nearby Shops Page]()

