# **Giglyte: Your Next Gig Platform! 🚀**

Giglyte is a robust web application designed to connect clients with freelancers, making it incredibly straightforward to find and post jobs. Built on the powerful Laravel 12 framework and featuring a snappy frontend powered by Vite and Tailwind CSS, this platform offers a seamless experience for managing user accounts and job listings. It’s engineered for efficiency and scalability, providing a solid foundation for any modern gig economy application.

## **Usage**

Getting Giglyte up and running, and then interacting with its features, is quite straightforward!

### **1. Initial Setup**

First, ensure you have PHP, Composer, Node.js, and npm installed on your machine.

1.  **Clone the repository**:
    ```bash
    git clone <your-repo-url>
    cd giglyte-project-directory
    ```
2.  **Install PHP dependencies**:
    ```bash
    composer install
    ```
3.  **Install Node.js dependencies**:
    ```bash
    npm install
    ```
4.  **Copy the environment file**:
    ```bash
    cp .env.example .env
    ```
5.  **Generate application key**:
    ```bash
    php artisan key:generate
    ```
6.  **Set up the database**:
    By default, Giglyte uses SQLite for local development. Ensure the `database/database.sqlite` file exists. If not, create it:
    ```bash
    touch database/database.sqlite
    ```
    Then, run migrations to create the necessary tables:
    ```bash
    php artisan migrate
    ```
7.  **Start the development servers**:
    This command will concurrently run the Laravel development server, queue listener, logs, and Vite for frontend compilation.
    ```bash
    npm run dev
    ```
    You should now be able to access the application at `http://localhost:8000` (or similar, as indicated by the `php artisan serve` output).

### **2. User Workflow (API & Views)**

Giglyte provides both API endpoints and simple web views for basic user interactions.

#### **Registration**
*   **Web View**: Navigate to `http://localhost:8000/user/register` in your browser. Fill out the email and password fields and submit the form.
*   **API Endpoint**: Send a `POST` request to `http://localhost:8000/user/create` with `email` and `password` in the request body.

#### **Email Verification**
*   **Web View**: After registration, you'll need to verify your email. Go to `http://localhost:8000/user/verify`. Enter your registered email and the verification code sent to you (this code is currently stored in the `verification_code` column of the `users` table for local testing, as email sending isn't fully configured).
*   **API Endpoint**: Send a `POST` request to `http://localhost:8000/user/verify` with `email` and `code` in the request body.

#### **Login**
*   **Web View**: Access the login form at `http://localhost:8000/user/login`. Provide your verified email and password.
*   **API Endpoint**: Send a `POST` request to `http://localhost:8000/user/login` with `email` and `password`. On successful login, the API will return a `token` which is essential for authenticated actions like creating jobs.

#### **Finalizing User Profile (Optional)**
*   **Web View**: After successful email verification, you can finalize your profile details at `http://localhost:8000/user/final`.
*   **API Endpoint**: Send a `POST` request to `http://localhost:8000/user/final` with your `email` and additional user data (`first_name`, `last_name`, `username`, `country`, `skills`, `profile_image`, `bio`, `type`). This endpoint also ensures the email is verified first.

### **3. Job Management**

#### **Creating a Job**
Creating a job requires a valid authentication token obtained from the user login.
*   **Web View**: Visit `http://localhost:8000/jobs/create`. This page includes a jQuery script that hardcodes a `Bearer` token for demonstration. **Note**: For a production-ready application, this token should be dynamically retrieved and securely managed after user login.
*   **API Endpoint**: Send a `POST` request to `http://localhost:8000/jobs/create`.
    *   **Headers**: `Authorization: Bearer <Your_Auth_Token>` (the token received from the `/user/login` endpoint).
    *   **Body (JSON)**:
        ```json
        {
            "title": "Your Job Title",
            "delivery_time": "3 days",
            "status": "active",
            "description": "A detailed description of the job.",
            "tags": "web-development, laravel, vuejs",
            "price": 500
        }
        ```
    The `client_id` for the job is automatically associated with the user whose token is provided.

#### **Viewing All Jobs**
*   **API Endpoint**: Send a `GET` request to `http://localhost:8000/jobs/all` to retrieve a list of all available jobs.

## **Features**

Giglyte comes packed with essential features to kickstart your gig platform:

*   **Secure User Authentication**: Robust system for user registration, login, and email verification, ensuring only legitimate users can access services.
*   **Comprehensive Profile Management**: Users can create detailed profiles including personal information, skills, and a bio, enriching their presence on the platform.
*   **Dynamic Job Creation**: Clients can easily post new job listings with essential details like title, description, delivery time, and pricing.
*   **Slug Generation**: Automatically generates unique, SEO-friendly slugs for job listings, improving discoverability.
*   **Token-Based API Security**: All sensitive API endpoints are protected using Bearer tokens, providing secure communication.
*   **Modern Frontend Stack**: Utilizes Vite for blazing-fast development and Tailwind CSS for a highly customizable and responsive user interface.
*   **SQLite Database**: Configured for simple and efficient local development with a lightweight SQLite database.

## **Technologies Used**

| Technology       | Description                        | Link                                          |
| :--------------- | :--------------------------------- | :-------------------------------------------- |
| **Laravel**      | PHP Web Application Framework      | [https://laravel.com/](https://laravel.com/)  |
| **Vite**         | Next Generation Frontend Tooling   | [https://vitejs.dev/](https://vitejs.dev/)    |
| **Tailwind CSS** | Utility-First CSS Framework        | [https://tailwindcss.com/](https://tailwindcss.com/) |
| **PHP**          | Server-Side Scripting Language     | [https://www.php.net/](https://www.php.net/)  |
| **JavaScript**   | Frontend Scripting Language        | [https://developer.mozilla.org/en-US/docs/Web/JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript) |
| **SQLite**       | Lightweight, File-Based Database   | [https://www.sqlite.org/](https://www.sqlite.org/) |
| **Composer**     | PHP Dependency Management          | [https://getcomposer.org/](https://getcomposer.org/) |
| **npm**          | JavaScript Package Manager         | [https://www.npmjs.com/](https://www.npmjs.com/) |

## **License**

This project is open-sourced software licensed under the MIT license.

## **Author Info**

I'm a passionate developer focused on building robust and scalable web applications. If you'd like to connect or see more of my work, feel free to reach out!

*   LinkedIn: [@YourLinkedInProfile](https://www.linkedin.com/in/yourprofile)
*   Twitter: [@YourTwitterHandle](https://twitter.com/yourhandle)
*   Portfolio: [YourPortfolio.com](https://yourportfolio.com)

---

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-07405E?style=for-the-badge&logo=sqlite&logoColor=white)

[![Readme was generated by Dokugen](https://img.shields.io/badge/Readme%20was%20generated%20by-Dokugen-brightgreen)](https://www.npmjs.com/package/dokugen)