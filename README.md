# Giglyte: Modern Freelance Marketplace 🤝

Giglyte is a dynamic and intuitive freelance marketplace platform designed to connect clients with talented freelancers seamlessly. This project provides a robust backend API built with Laravel, paired with a modern frontend workflow powered by Vite and Tailwind CSS. It empowers users to register, manage their profiles, post jobs, apply for opportunities, and efficiently track applications. Whether you're a client seeking expertise or a freelancer looking for your next gig, Giglyte aims to streamline the process.

## Usage

Getting Giglyte up and running is straightforward. Follow these steps to set up the development environment and explore its features.

### Prerequisites

Before you begin, ensure you have the following installed on your system:

*   **PHP 8.2+**: The core language for the Laravel backend.
*   **Composer**: PHP dependency manager.
*   **Node.js (LTS recommended)**: Required for Vite and frontend tooling.
*   **npm or Yarn**: JavaScript package manager.
*   **SQLite**: The default database used in this setup (no external server needed for local development).

### Setup and Local Development

1.  **Clone the repository:**

    ```bash
    git clone [your-repo-link]
    cd giglyte # or whatever your project directory is named
    ```

2.  **Install PHP Dependencies:**

    ```bash
    composer install
    ```

3.  **Install Node.js Dependencies:**

    ```bash
    npm install
    # or yarn install
    ```

4.  **Configure Environment Variables:**

    Copy the example environment file and generate an application key:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Ensure your `.env` file uses `DB_CONNECTION=sqlite` and `DB_DATABASE=giglyte` (or another path to your SQLite file, e.g., `database/database.sqlite`). The `giglyte` file provided seems to be a pre-populated SQLite database, but it's good practice to ensure migrations are run.

5.  **Run Database Migrations:**

    This will set up the necessary tables for users, jobs, and applications.

    ```bash
    php artisan migrate
    ```

    *(Optional: If you want to seed the database with dummy data, you would run `php artisan db:seed` here, assuming seeders are implemented.)*

6.  **Link Storage (for public assets like profile images):**

    ```bash
    php artisan storage:link
    ```

7.  **Start the Development Servers:**

    Open two separate terminal windows.

    **Terminal 1 (Laravel Development Server):**

    ```bash
    php artisan serve
    ```

    This will typically run on `http://127.0.0.1:8000`.

    **Terminal 2 (Vite Development Server):**

    ```bash
    npm run dev
    # or yarn dev
    ```

    This compiles and serves your frontend assets with hot module reloading.

Now, your application should be accessible via `http://127.0.0.1:8000`. You can interact with the API or browse the Blade views directly.

### API Endpoints

Giglyte exposes a set of API endpoints for user and job management. Here are some key examples:

*   **User Registration**
    *   `POST /user/create`
    *   Payload: `{ email: "user@example.com", password: "yourpassword" }`
*   **Email Verification**
    *   `POST /user/verify`
    *   Payload: `{ email: "user@example.com", code: "1234" }`
*   **Complete User Profile**
    *   `POST /user/final`
    *   Payload: `{ email: "user@example.com", username: "john.doe", first_name: "John", last_name: "Doe", country: "USA", skills: "PHP, Laravel", bio: "Experienced developer", type: "freelancer" }`
*   **User Login**
    *   `POST /user/login`
    *   Payload: `{ email: "user@example.com", password: "yourpassword" }`
    *   Response includes a `token` for subsequent authenticated requests.
*   **Update User Profile (Authenticated)**
    *   `POST /user/update`
    *   Headers: `Authorization: Bearer [YOUR_AUTH_TOKEN]`
    *   Payload: `{ first_name: "New Name", username: "new_username" }`
*   **Get All Jobs**
    *   `GET /jobs/all`
*   **Create a New Job (Authenticated - Client User Type)**
    *   `POST /jobs/create`
    *   Headers: `Authorization: Bearer [YOUR_AUTH_TOKEN]` (where token belongs to a client user)
    *   Payload: `{ title: "Web Developer Needed", slug: "web-developer-needed", delivery_time: "2 weeks", status: "active", description: "Build a cool website.", tags: "web,php,js", price: 1500 }`
*   **Apply for a Job**
    *   `POST /apply`
    *   Payload: `{ job_id: 1, freelancer_id: 2, cover_letter: "I am perfect for this job!" }`
*   **View Job Applications for a Specific Job**
    *   `GET /job/{job_id}/applications`
*   **Update Job Application Status**
    *   `PUT /application/{id}/status`
    *   Payload: `{ status: "accepted" }` or `{ status: "rejected" }`

### Frontend Views

The project also includes a few basic Blade views (`resources/views/`) for user interaction:

*   `/user/register`: Registration form.
*   `/user/verify`: Email verification form.
*   `/user/login`: Login form.
*   `/user/final`: Form to complete user profile details.
*   `/jobs/create`: Form for clients to create new job listings.
*   `/user/edit`: Form to update an existing user's profile.

## Features

*   **Comprehensive User Management**: Seamless registration, secure login, email verification, and dynamic profile updates.
*   **Robust Job Posting System**: Clients can create detailed job listings, including title, description, delivery time, tags, and price.
*   **Efficient Job Application Workflow**: Freelancers can easily apply to jobs with their cover letters, and clients can track and manage applications.
*   **API-First Architecture**: Clean, well-structured API endpoints facilitate interaction with the backend, perfect for integration with various frontend applications.
*   **Modern Development Stack**: Leverages Laravel 12, Vite, and Tailwind CSS for a streamlined and enjoyable development experience.
*   **Secure Authentication**: Implements token-based authentication for API routes, ensuring secure interactions.
*   **Email Notifications**: Integrated email service for critical actions like account verification.

## Technologies Used

| Technology         | Category           |
| :----------------- | :----------------- |
| **Laravel 12**     | PHP Web Framework  |
| **PHP 8.2+**       | Backend Language   |
| **Vite 6**         | Frontend Tooling   |
| **Tailwind CSS 4** | CSS Framework      |
| **JavaScript**     | Frontend Scripting |
| **SQLite**         | Database           |
| **Composer**       | PHP Package Manager|
| **npm**            | JS Package Manager |
| **Axios**          | HTTP Client        |
| **jQuery**         | JS Library         |

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author Info

Feel free to connect or learn more about my work!

*   **Portfolio**: [Your Portfolio Link Here]
*   **LinkedIn**: [Your LinkedIn Profile]
*   **Twitter**: [@YourTwitterHandle]

---

[![Readme was generated by Dokugen](https://img.shields.io/badge/Readme%20was%20generated%20by-Dokugen-brightgreen)](https://www.npmjs.com/package/dokugen)