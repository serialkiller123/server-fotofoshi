# Server-Fotofoshi

Server-Fotofoshi is the backend API for a social networking platform for sharing photos. It allows users to create an account, upload photos, view and interact with other user's photos.

## Features

-   User registration and login
-   Photo uploads
-   Photo feed displaying photos uploaded by users

## Tech Stack

-   Laravel 11 backend
-   MySQL database

## Installation

1. Clone the repository : [gh repo clone serialkiller123/server-fotofoshi](https://github.com/serialkiller123/server-fotofoshi.git)
2. Run `composer install` to install dependencies
3. Copy the `.env.example` file to `.env` and configure the database connection
4. Run `php artisan key:generate` to generate an application key
5. Run `php artisan storage:link`
6. Run `php artisan migrate` to create the database tables
7. Run `php artisan serve`

## Contributing

If you want to contribute to this project, please fork the repository, create a new branch, and submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
