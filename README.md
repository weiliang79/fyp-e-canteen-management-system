<h1 align="center">
E-Canteen Management System
</h1>

A modern management system for primary/secondary schools' canteen.

## Installation
### Clone the repository

      git clone https://github.com/weiliang79/fyp-e-canteen-management-system.git

### Install dependencies

Before using it, make sure [Composer](https://getcomposer.org/) and [NPM from Node.js](https://nodejs.org/en/) has installed on the machine.

Install composer dependencies

      cd [projectDirectoryName]
      composer install

Install NPM dependencies

      cd [projectDirectoryName]
      npm install

### Config Environment Variables File
Copy `.env.example` and rename it to `.env`

      copy .env.example .env        //For Windows Command Prompt
      cp .env.example .env          //For Linux Terminal

Generate application key using `artisan` command

      php artisan key:generate

Edit the necessary variables in `.env` file.

      APP_ENV=[choose one local, testing, or production]
      APP_DEBUG=[true if needed to deploy]
      APP_URL=[the app's url address]
      APP_TIMEZONE=[the local timezone]

      DB_CONNECTION=[database type, e.g. mysql, sqlite, etc]
      DB_HOST=[database address]
      DB_PORT=[database port]
      DB_DATABASE=[database schema name]
      DB_USERNAME=[username]
      DB_PASSWORD=[password]

      MAIL_MAILER=[mail hosting type, e.g. smtp, mailgun, etc]
      MAIL_HOST=[mail hosting address]
      MAIL_PORT=[mail hosting port]
      MAIL_USERNAME=[mail username]
      MAIL_PASSWORD=[mail password]
      MAIL_ENCRYPTION=null          //any encryption if needed
      MAIL_FROM_ADDRESS=[mail sender address]
      MAIL_FROM_NAME=[mail sender name]

The timezone can referred to [PHP documentation](https://www.php.net/manual/en/timezones.php). 

Optional: Edit the variables in `.env` file, these can edit in UI after system is finished setup.

      CURRENCY_SYMBOL=[currency symbol that will be used in the system]
      PAYMENT_MAINTENANCE=true            //or false if the payment is configured

      2C2P_ENABLE=true                    //or false if 2c2p payment is configured
      2C2P_SANDBOX_ENABLE=[true/false]    //sandbox mode
      2C2P_MERCHANT_ID=[2c2p merchant id]
      2C2P_CURRENCY_CODE=[2c2p country currency code]
      2C2P_LOCALE_CODE=[2c2p locale code]
      2C2P_SECRET_CODE=[2c2p secret code]

      STRIPE_ENABLE=true
      STRIPE_SANDBOX=[true/false]         //sandbox mode
      STRIPE_KEY=[Stripe public key]
      STRIPE_SECRET=[Stripe secret key]
      CASHIER_CURRENCY=[Stripe country currency code]

### Database Configuration
Migrate and seed the necessary data into tables.

      php artisan migrate:fresh --seed

### symbolic Storage Link for Public

      php artisan storage:link

### Run Server
To run the server in development: 

      php artisan serve

Or run in other server hosts.

Login with admin account: username: `admin1`, password: `password`

## Installation for POS System

### Clone the repository

      git clone https://github.com/weiliang79/fyp-laravel-pos.git
      
### Install dependencies

Install composer dependencies

      cd [projectDirectoryName]
      composer install

Install NPM dependencies

      cd [projectDirectoryName]
      npm install

### Config Environment Variables File
Copy `.env.example` and rename it to `.env`

      copy .env.example .env        //For Windows Command Prompt
      cp .env.example .env          //For Linux Terminal

Generate application key using `artisan` command

      php artisan key:generate

Edit the necessary variables in `.env` file.

      APP_ENV=[choose one local, testing, or production]
      APP_DEBUG=[true if needed to deploy]
      APP_URL=[the app's url address]
      MAIN_SYSTEM_URL=[E-canteen management system's url address]

      DB_CONNECTION=[same db type from main system]
      DB_HOST=[same db host from main system]
      DB_PORT=[same db port from main system]
      DB_DATABASE=[same schema name from main system]
      DB_USERNAME=[same db username from main system]
      DB_PASSWORD=[same db password from main system]

Edit the timezone in `/config/app.php` file. 

      return [
            ...

            'timezone' => '[local timezone]',

            ...
      ]

### Run Server
To run the server in development: 

      php artisan serve

Or run in other server hosts.

### Notice when using POS system
The `MAIN_SYSTEM_URL` in `.env` must matched with the main system's URL, otherwise the images cannot be loaded properly. 

## Extra Command
To delete/reset all the storage's images:

      php artisan storage:clear

## Resources
Favicon from [svgrepo](https://www.svgrepo.com/): https://www.svgrepo.com/svg/156205/cutlery-cross-couple-of-fork-and-spoon

Banner Background from [Freepik](https://www.freepik.com/) by upklyak: https://www.freepik.com/free-vector/school-cafe-university-canteen-empty-dining-room_8308807.htm#query=cafeteria&position=2&from_view=keyword