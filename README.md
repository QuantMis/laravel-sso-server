# SSO Server Laravel

This repository contains a Single Sign-On (SSO) server built using Laravel Passport.

## Installation

1. Clone the repository.
2. Run `composer install` to install the dependencies.
3. Rename the `.env.example` file to `.env` and update the necessary configuration.
4. Generate the application key by running `php artisan key:generate`.
5. Run the database migrations using `php artisan migrate`.
6. Start the server with `php artisan serve`.

## Usage

To use the SSO server, follow these steps:

1. Register your application with the SSO server by providing the necessary details.
2. Obtain an access token by authenticating with the SSO server.
3. Use the access token to make API requests to the SSO server for user information and authentication.

For detailed documentation, please refer to the [official Laravel Passport documentation](https://laravel.com/docs/passport).

## Contributing

Contributions are welcome! Please follow the [contribution guidelines](CONTRIBUTING.md) when making pull requests.

## License

This project is licensed under the [MIT License](LICENSE).
