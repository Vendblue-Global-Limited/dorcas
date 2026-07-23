# Laravel API Interview Challenge

Welcome. This is a deliberately incomplete Laravel API project for a live coding interview. The goal is not to finish everything; the goal is to show how you read unfamiliar code, reason about trade-offs, communicate, and improve the most important parts first.

You may inspect the project files, run the application, call the API, and run tests. Please think aloud as you work. Clarifying questions are welcome. Correctness, security, readability, and reasoning matter more than speed.

Please do not install unnecessary dependencies. This project uses Laravel Sail, PostgreSQL, and API routes only. The host machine does not need PHP, Composer, or PostgreSQL installed directly.

## Getting Started

Start the app:

```bash
./vendor/bin/sail up -d
```

Check services:

```bash
./vendor/bin/sail ps
```

Reset the database:

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

Run tests:

```bash
./vendor/bin/sail artisan test
```

View logs:

```bash
./vendor/bin/sail logs
```

Stop services:

```bash
./vendor/bin/sail stop
```

Remove services:

```bash
./vendor/bin/sail down
```

The application is configured for:

```text
http://localhost:8000
```

## API Routes

```http
GET /api/products
POST /api/products
PATCH /api/products/{product}
```

Your first priority is `GET /api/products`.

Useful query parameters to consider:

```text
search
status
sort
direction
per_page
```

Supported product statuses are:

```text
draft
published
archived
```

Supported sort fields should be:

```text
name
price
quantity
created_at
```

## Tasks

### Task 1

Run the application and review the existing product-index endpoint. Explain the most important concerns before changing code.

### Task 2

Improve the endpoint to support database pagination, search, status filtering, safe sorting, direction validation, bounded page size, product owner information, and consistent API Resource output.

### Task 3

Improve query efficiency and explain how the endpoint should scale.

### Task 4

Find and fix at least one security or authorization issue elsewhere in the project.

### Task 5

Add or improve tests for your changes.

## Bonus Discussion

Explain what should change if the products table contains 8-10 million rows, PostgreSQL is used in production, Redis is available, search must support partial or typo-tolerant names, and the endpoint receives high concurrent traffic.
