
---

# Job Board Project Setup Guide

This guide will walk you through the process of setting up the Job Board project locally on your machine for development and testing purposes.

## Prerequisites

Before you begin, ensure you have the following installed on your local machine:

- PHP (>= 8.2)
- Composer
- MySQL or any other preferred database management system

## Installation Steps

Follow these steps to set up the Job Board project:

### 1. Clone the Repository

Clone the Job Board project repository from GitHub:

```bash
git clone https://github.com/xentixar/job-board.git
```

### 2. Navigate to the Project Directory

Change into the project directory:

```bash
cd job-board
```

### 3. Install PHP Dependencies

Install PHP dependencies using Composer:

```bash
composer install
```

### 4. Create Environment File

Create a copy of the `.env.example` file and name it `.env`:

```bash
cp .env.example .env
```

### 5. Generate Application Key

Generate an application key for Laravel:

```bash
php artisan key:generate
```

### 6. Configure Database

Update the `.env` file with your database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_board
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migrations

Run database migrations to create the necessary tables:

```bash
php artisan migrate
```

### 8. Serve the Application

Serve the application using the built-in PHP development server:

```bash
php artisan serve
```

### 9. Access the Application

Open your web browser and visit [http://localhost:8000](http://localhost:8000) to access the Job Board application.


## API Documentation

For detailed documentation on the Job Board API endpoints, refer to the [API Documentation](docs/index.md).


## Running Tests

To run tests, execute the following command:

```bash
php artisan test
```

---