# larapiauth
An authentication API + CoreUI Admin panel boilerplate built from Laravel that can be used for starting any new app.

# Demo
- Demo: http://larapiauth.rakuyomi.net/
- Admin account: admin@larapiauth.test / admin
- Member account: member@larapiauth.test / member

Admin has the access to the panel, while normal member can only see his/her info.
You can go to http://larapiauth.rakuyomi.net/api/documentation to play with the API.

# Features
- Built using Laravel 5.8.3
- API Documentation with L5-Swagger 5.8.x (Swagger)
- Authentication API using tymondesigns/jwt-auth
- CoreUI Admin panel with authorization system
- Vuex for managing states easily
- Bootstrap 4.x

# Notes
- Use features/admin_panel_coreui_sample branch for showing all the CoreUI sample components
- Master branch has the clean empty admin panel, so you can start putting your own things there.

# APIs
- Register
- Activate user (after registration)
- Login
- Logout
- Get user
- Reset password (forgot password)
- Change password

# Installing
- Run "composer install"
- Run "npm install"
- Create a new database
- Clone the .env.example file and rename it to .env
- Config database information and mail server information in .env
- Run "php artisan migrate" to generate DB schema
- Run "php artisan db:seed" to seed db
- Run "php artisan jwt:secret" to update your .env file with something like JWT_SECRET=xxxxxxxxxx
- Run "php artisan key:generate" to generate application key
- Run "sudo chmod -R 777 storage" (on mac or linux) or "chmod -R 777 storage" (on windows) to grant permission for the app to access/modify storage folder
- Run "php artisan l5-swagger:generate" to generate API documentations
- If you're deploying it to real server, copy everything inside vendor\swagger-api\swagger-ui\dist to public\docs\asset on your server. You need to create docs\asset if it's not existing.
- Run "php artisan serve" to start the server then go to localhost:8000 and enjoy

# Run with docker
- Run "docker-compose up -d" to build and start the container
- Go to http://localhost:8888 then create a new database (name it same with in .env file - here "larapiauth")
- Run "docker exec -it core bash" to to start interacting with the core php-nginx container
- Run "php artisan migrate:fresh --seed" to run fresh migrations and seeders
- Run the app at http://localhost:9999

# Donation
If this project help you reduce time to develop, you can give me a cup of coffee :)

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7CXCQS83WU9EY)
