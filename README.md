project created by laravel and Vue Js 

cron the project to your einnvoriment

run composer install and after completion type npm install

create your msql database and connect using .env

migrate table by php artisan migrate, this will add all tables and neccesssary data into your tables, such as admin and 5000 books

start application by php artisan serve and in other tab npm run hot for development or npm run product for production enviroment

admin user email is admin@admin.com.com passowrd ia 123456789.

API for user authentication are in http://127.0.0.1:8000/api/login  http://127.0.0.1:8000/api/register

get all books paginated http://127.0.0.1:8000/api/book/list?paginate=10&current_page=1

get all popular books paginated http://127.0.0.1:8000/api/book/list?paginate=10&current_page=1&popular=true
