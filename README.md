# Tags
[![Laravel](https://img.shields.io/badge/Laravel-v11.0.0-red.svg)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-v8.0-blue.svg)](https://www.mysql.com/)
[![Paystack](https://img.shields.io/badge/Paystack-blue.svg)](https://paystack.com/)
[![HTML](https://img.shields.io/badge/HTML-5-orange.svg)](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5)

# About
This  project facilitates seamless integration of the Paystack payment gateway into laravel application. It enables users to make payments securely through Paystack, stores payment details in the database, and provides functionality to display payment information on the user interface. Additionally, it simplifies the process of initiating refunds for successful payments through Paystack's API.
# Step to Use
   After installing this Laravel project locally, follow these steps:
1) Get Paystack API Credentials: Obtain key ID and key secret from the Paystack dashboard.
2) Install Dependencies: Run composer install in the project directory via the command line.
3) Configure Environment: Duplicate .env.example to .env and set the following variables: PAYSTACK_PUBLIC_KEY=abc... PAYSTACK_SECRET_KEY=adb.... DB_CONNECTION=mysql 
   DB_DATABASE=paystack
4) Execute php artisan key:generate in the terminal.
5) Execute php artisan migrate to create required database tables.
6) Start the development server using php artisan serve.







