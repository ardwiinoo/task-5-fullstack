## Laravel-Passport

Package yang dapat digunakan untuk membuat mekanisme JWT (JSON Web Token).

## Laravel-UI

Package integrasi UI (Scaffolding).

## Run This Apps
- Download the master branch
	> git clone https://github.com/ardwiinoo/task-5-fullstack.git

- Install the composer dependencies
	> composer install

- Make a file .env from .env.example and setting your config, database 

- Dont forget generate key from Laravel artisan 
	> php artisan key:generate

- Run composer update 
	> composer update

- Run npm install && npm run build 
	> npm install
	> npm run build

- Run migrate database, before it you must have some database in MYSQL
	> php artisan migrate:fresh --seed

- Install laravel passport 
	> php artisan passport:install

- For unit testing
	> php artisan test

- Run apps 
	> php artisan serve

- Open browser and visit `localhost:8000`
  
## Default Login
 - Email    : arif@example.com
 - Password : password

## API 

this section for explain **API** 

1. User
   - Login User
   - Register User 
   - logout
2. Article
   - Get All Category
   - Get All Post 

|Command	|Method		|Routes		|
|-----------|-----------|-----------|
|User Login|POST|`/api/login`|
|User Register|POST|`/api/register`|
|Get Category|GET|`api/v1/category`|
|Get Post|GET|`api/v1/post`|
|User Logout|POST|`api/logout`|

## If you have some suggestion ||~
Just Contact Me At:
- Email: [ardwiinoo@gmail.com](mailto:ardwiinoo@gmail.com)
- Instagram: [@ardwino_](https://www.instagram.com/ardwino_/)

### License
Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
