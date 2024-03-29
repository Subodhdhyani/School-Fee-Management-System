# School Fee Management System

## Tags

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/subodhdhyani/School-Fee-Management-System/blob/master/LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-v11.0.0-red.svg)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-v8.0-blue.svg)](https://www.mysql.com/)
[![Razorpay](https://img.shields.io/badge/Razorpay-v2.9.0-green.svg)](https://razorpay.com/)
[![HTML](https://img.shields.io/badge/HTML-5-orange.svg)](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-v5.2.3-purple.svg)](https://getbootstrap.com/)

## Ethereal Echoes School Fees Portal

Ethereal Echoes School Fees Portal is a comprehensive fee management system designed for educational institutions. It allows students to conveniently make fee payments via a payment gateway (Razorpay) and download fee receipts. Additionally, administrators can log in to the portal and manage refunds and fees.

## Features

- **Student Fee Payment**: Students can make fee payments securely through an integrated payment gateway (Razorpay).
- **Fee Receipt Download**: Students can download fee receipts instantly after successful payment.
- **Admin Panel**: Administrators can log in and efficiently manage refunds and fees.


## Technologies Used

- **Laravel**: PHP framework for building the application.
- **Razorpay API**: Payment gateway integration for handling fee transactions.
- **MySQL**: Database management system for storing application data.
- **Bootstrap**: Frontend framework for building responsive and mobile-first web pages.
- **Blade Templating Engine**: Laravel's powerful templating engine for building UI components.

## Requirements
- PHP v>=8.0 => wamp
- Laravel v11
- Composer
- MySQL v>=8.0
- Razorpay Account


## Installation

1. **Clone the repository:**
    ```sh
    https://github.com/Subodhdhyani/School-Fee-Management-System.git
    ```

2. **Install Composer dependencies:**
    ```sh
    composer install
    ```

3. **Copy `.env.example` to `.env` and update the environment variables:**
    ```sh
    cp .env.example .env
    ```


4. **Generate application key:**
    ```sh
    php artisan key:generate
    ```

5. **Update `.env` with your database and Razorpay API keys.**

6. **Run database migrations:**
    ```sh
    php artisan migrate
    ```

7. **Run Seeder for admin credentials set:**
    ```sh
    php artisan db:seed
    ```

8. **Serve the application:**
    ```sh
    php artisan serve
    ```

9. **Access the application in your browser at [http://localhost:8000](http://localhost:8000).**
10. **Login into the admin dashboard in your browser at [http://localhost:8000/admin/login](http://localhost:8000/admin/login).**


## Changes in Project:
- Set the Razorpay key inside `.env`. RAZORPAY_KEY_ID=... and RAZORPAY_KEY_SECRET=........
- Create Database(mysql) and named it `schoolfeesportal`.

## Credentials for admin login:
- Email : admin@ethereal.edu.in
- Password : admin@12345


## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributors
- [Subodh Dhyani](https://github.com/subodhdhyani)

## Disclaimer
The project school name used in this repository are purely hypothetical and do not represent real entities. These names are chosen solely for demonstration and project purposes. Any resemblance to actual schools or organizations, is purely coincidental. Similarly, any logos or trademarks used are for illustrative purposes only and do not imply endorsement or affiliation with any real entities.As of the repository publication date, "Ethereal Echoes School" is not found online. 


## Snapshot
- [Image 1](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/8d54924e-c216-4453-8fba-4a60aae11295)
- [Image 2](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/20a7e0c5-004a-44d1-b1e1-bc6689a4855d)
- [Image 3](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/d684ad82-61b7-425a-be2a-1d15e37f7e40)
- [Image 4](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/6f141110-79f8-4891-9e69-fbfff40e8eff)
- [Image 5](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/411e4934-abcb-4a98-b561-83d6709de1dd)
- [Image 6](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/386cc337-3f4f-4640-8b21-48e3b474686d)
- [Image 7](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/2ffddbc1-6add-408f-9676-dbf005f567f3)
- [Image 8](https://github.com/Subodhdhyani/School-Fee-Management-System/assets/84286795/720ff4ee-cc08-4b63-a0fd-afceca7146a9)



