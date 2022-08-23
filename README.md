# Getting Started with Webased S.A.R.L Code Challange

### 1. Clone the repository using the command:<br/> `git clone <https || ssh>`
### 2. cd into your project<br/>
You will need to be inside that project file to enter all of the rest of the commands in this tutorial. So remember to type `cd projectName` to move your terminal working location to the project file we just barely created. (Of course substitute “projectName” , with the name of the folder you created in the previous step).
### 3. Install Composer Dependencies<br/>
Whenever you clone a new Laravel project you must now install all of the project dependencies. This is what actually installs Laravel itself, among other necessary packages to get started.<br/>
So to install all this source code we run composer with the following command: `composer install`.<br/>
### 4. Install NPM Dependencies<br/>
Just like how we must install composer packages to move forward, we must also install necessary NPM packages to move forward.
Run this command: `npm install || yarn`<br/>
### 5.Create a copy of your .env file<br/>
`.env` files are not generally committed to source control for security reasons. But there is a `.env.example` which is a template of the `.env` file that the project expects us to have. So we will make a copy of the `.env.example` file and create a `.env` file that we can start to fill out to do things like database configuration in the next few steps: `cp .env.example .env`<br/>
This will create a copy of the `.env.example` file in your project and name the copy simply `.env`.<br>
### 6. Generate an app encryption key<br/>
Laravel requires you to have an app encryption key which is generally randomly generated and stored in your `.env` file.<br/>
In the terminal we can run this command to generate that key: `php artisan key:generate`<br/>
### 7. In the .env file, add database information to allow Laravel to connect to the database<br/>
In the `.env` file fill in the `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.
### 8. Migrate the database<br/>
Once your credentials are in the .env file, now you can migrate your database, by run this command: `php artisan migrate`<br/>
### 9. Seed the database<br/>
After the migrations are complete and you have the database structure required, then you can seed the database (which means add dummy data to it).<br/>
`php artisan db:seed`
### 10. Enter the credentials to the login page: <br/>
- Go to 'http://localhost:8000/admin/login'
- Then fill the credentials: 
    - Email address: 'admin@admin.com'
    - Password: 'password'

## Description

It is a Laravel application that allows the user to sign in, view, and CRUD companies and employees. <br/><br/>
It consists of many screens: <br/>
- Login screen where the user enter the valid credentials
- Dashboard screen where the companies and employees display, and you can CRUD any of them
