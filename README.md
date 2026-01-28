# Social — Laravel Social Network

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="280" alt="Laravel Logo">
</p>

A Laravel-based social application skeleton. This repository provides a foundation for building social features such as user authentication, profiles, posts, comments, likes, and follower relationships. The README below gives an overview of typical setup steps, common commands, and development notes. Adjust any section to match the exact implementation and requirements of this repository.

## Table of Contents

- [Features](#features)
- [Tech stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Local setup](#local-setup)
- [Docker / Sail (optional)](#docker--sail-optional)
- [Running tests](#running-tests)
- [Environment variables](#environment-variables)
- [Seeding and demo data](#seeding-and-demo-data)
- [Common tasks](#common-tasks)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features

(Adjust this list to reflect what this project actually implements.)

- User authentication (registration, login, password reset)
- User profiles and avatars
- Create, edit, delete posts (text, images)
- Likes and comments
- Follow/unfollow users and basic feed
- Notifications
- File uploads (storage link and S3-ready)
- API endpoints (if applicable)

## Tech stack

- Laravel (PHP framework)
- MySQL / MariaDB (or any DB supported by Laravel)
- Composer for PHP dependencies
- Node.js + npm (or yarn) for frontend tooling (Vite / Mix)
- Optional: Laravel Sail / Docker for containerized environment

## Prerequisites

- PHP 8.1+ (or the version required by the Laravel version used)
- Composer
- Node.js 16+ and npm (or yarn)
- MySQL or PostgreSQL (or SQLite for quick testing)

## Local setup

1. Clone the repository

```bash
git clone https://github.com/mahmood2002reda/social.git
cd social
```

2. Install PHP dependencies

```bash
composer install
```

3. Copy the environment file and generate app key

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your .env for database and other services
   - Set DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
   - Configure MAIL_ settings if you need email functionality
   - Configure any third-party credentials (e.g., S3, Pusher)

5. Run database migrations (and optionally seeders)

```bash
php artisan migrate
php artisan db:seed   # optional, if seeders exist
```

6. Create the storage symlink to make uploaded files publicly accessible

```bash
php artisan storage:link
```

7. Install frontend dependencies and build assets

```bash
npm install
npm run dev    # development
# or
npm run build  # production
```

8. Serve the app

```bash
php artisan serve
# The app will be available at http://127.0.0.1:8000
```

## Docker / Sail (optional)

If you prefer using Laravel Sail (Docker), and Sail is configured in the repository:

```bash
# Start Sail (first time you may need to build)
./vendor/bin/sail up -d

# Install composer dependencies inside the container (if not already baked into the image)
./vendor/bin/sail composer install

# Copy env, generate key, migrate and seed inside container
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

# NPM
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

Adjust commands to your project's specific docker/sail setup.

## Running tests

Run the PHP unit tests:

```bash
php artisan test
# or
vendor/bin/phpunit
```

If using Sail:

```bash
./vendor/bin/sail php artisan test
```

## Environment variables (example)

Add or verify these entries in your `.env`:

```
APP_NAME=Social
APP_ENV=local
APP_KEY=base64:...
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=social
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Add other service credentials (S3, Pusher, etc.) as required by the project.

## Seeding and demo data

If the repository includes seeders that generate demo users and posts:

```bash
php artisan db:seed
```

Or run a specific seeder:

```bash
php artisan db:seed --class=DemoSeeder
```

## Common tasks

- Clear caches:

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

- Queue worker (if using queues):

```bash
php artisan queue:work
```

- Run scheduled tasks locally:

```bash
php artisan schedule:run
```

## Contributing

Contributions are welcome. Typical workflow:

1. Fork the repository
2. Create a feature branch: `git checkout -b feat/my-feature`
3. Make your changes and tests
4. Submit a pull request describing your change

Please follow any coding standards or guidelines present in the repo.

## License

Specify the license used by the project (e.g., MIT). If no license exists, add one to clarify reuse terms.

## Contact

For questions or help, open an issue in this repository or contact the maintainer.

---

If you'd like, I can:
- Tailor this README to match the exact implemented features of your repo (I can scan the code and list real features and commands).
- Create and commit this README to the repository for you (I can do that if you want; tell me to push to a branch and provide any commit message).
```
