

# einnar82/larakomersyo
Komersyo - tagalog word for Commerce.

### Prerequisites:

- **Docker**
- **PHP 8.2**
- **Composer**
- **Node.js**

### Tools and Libraries used

- Vue.js - Javascript Framework
- Vuetify - Vue.js UI Library
- Laravel Breeze - a minimal, simple implementation of all of Laravel's [authentication logic features](https://laravel.com/docs/10.x/authentication), including login, registration, password reset, email verification, and password confirmation. In addition, Breeze includes a simple "profile" page where the user may update their name, email address, and password.
- Laravel Passport - provides a full OAuth2 server implementation for your Laravel application in a matter of minutes.
- Laravel Sail - This project uses  [Laravel Sail](https://laravel.com/docs/sail) to manage  its local development stack. For more detailed usage instructions take a look at  
  the [official documentation](https://laravel.com/docs/sail).


### Links

- **Your API Application** http://localhost
- **Your Client Application** http://localhost:5173
- **Your Admin Application** http://localhost:5173
- **Preview Emails via Mailpit** http://localhost:8025

### Start the development server

**Instructions:**
`composer install`
`php artisan migrate --seed`
`php artisan passport:install`
`./vendor/bin/sail up`

You can also use the `-d` option, to start the server in  
the background if you do not care about the logs or still want to use your  
terminal for other things.

### Build frontend assets
`cd client/`
`npm install && npm run dev`
`cd admin/`
`npm install && npm run dev`

### Run Tests

```shell  
./vendor/bin/sail test```
