# IT7744 Assignment 3 - Laravel Simple CMS

## Project Overview

This project is a Laravel Simple CMS built for IT7744 Assignment 3.

The app allows users to register, log in, create image posts, edit their own posts, delete their own posts, and update their profile with an avatar. It also includes an admin panel where an admin can manage users and posts.

A JavaScript CMS page has also been added. This page uses JavaScript `fetch()` requests to work with REST-style JSON API routes. It can load posts, create posts, delete posts, and show validation messages without needing a full page reload.

## Admin Login

Email: `admin@example.com`
Password: `admin`

The admin username is:

Username: `admin`

## Setup

After downloading the project, run the following commands:

```bash
composer install
npm install
```

Copy the environment file:

```bash
copy .env.example .env
```

Generate the app key:

```bash
php artisan key:generate
```

Import the included database file into MySQL/phpMyAdmin:

```text
database.sql
```

Then run:

```bash
php artisan storage:link
```

Start the Laravel server:

```bash
php artisan serve
```

Start Vite in a second terminal:

```bash
npm run dev
```

The app should then run at:

```text
http://127.0.0.1:8000
```

## Main URLs

```text
/posts
/register
/login
/dashboard
/profile
/cms-app
/admin/dashboard
```

## Main Features

* User registration and login
* User dashboard
* Create image posts
* View latest posts
* View single post pages
* Edit and delete own posts
* Profile editing
* Avatar upload
* Admin-only dashboard
* Admin user management
* Admin post management
* Post image upload
* REST-style JSON API routes
* JavaScript CMS page using fetch requests
* Client-side JavaScript validation
* Server-side Laravel validation
* CSRF protection
* JavaScript unit tests
* Playwright browser test

## JavaScript CMS App

The JavaScript CMS app can be found at:

```text
/cms-app
```

This page uses JavaScript to:

* load latest posts
* load the logged-in user's posts
* validate post input
* create a post through the API
* delete posts through the API
* display success and error messages

## Testing

Run the JavaScript unit tests with:

```bash
npm run test
```

Run the Playwright end-to-end test with:

```bash
npm run test:e2e
```

For the Playwright test, make sure both Laravel and Vite are already running:

```bash
php artisan serve
npm run dev
```

## Notes

The uploaded images are stored using Laravel public storage.

Avatar uploads are stored in:

```text
storage/app/public/avatars
```

Post images are stored in:

```text
storage/app/public/post_images
```

The public storage link is created with:

```bash
php artisan storage:link
```

## Database

The project includes an exported database file:

```text
database.sql
```

This should be imported through phpMyAdmin before running the app.

## Technologies Used

* Laravel
* Blade
* PHP
* MySQL
* JavaScript
* Vite
* Tailwind CSS
* Vitest
* Playwright
