# ShopFlow API

A RESTful e-commerce API built with Laravel. The project includes authentication, role-based authorization, category and product management, shopping cart functionality, order processing, stock validation, and order status workflows.

## Features Implemented

* Authentication with Laravel Sanctum
* Role-based authorization (User / Admin)
* Category management
* Product management
* Shopping cart functionality
* Order creation workflow
* Stock validation and automatic stock deduction
* Order status management
* Soft deactivation of products
* Protected routes with middleware

---

## Tech Stack

* PHP 8+
* Laravel 12
* Laravel Sanctum
* SQLite (development)
* MySQL compatible
* REST API
* Postman

---

## Installation

Clone repository:

```bash
git clone https://github.com/TomasPaulenas/ecommerce-api-laravel.git
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Run migrations:

```bash
php artisan migrate
```

Start development server:

```bash
php artisan serve
```

---

## Environment Variables

Example:

```env
APP_NAME=ShopFlow
APP_ENV=local
APP_KEY=
APP_DEBUG=true

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

---

## Main Endpoints

### Authentication

| Method | Endpoint      |
| ------ | ------------- |
| POST   | /api/register |
| POST   | /api/login    |
| POST   | /api/logout   |
| GET    | /api/me       |

### Categories

| Method | Endpoint             |
| ------ | -------------------- |
| GET    | /api/categories      |
| GET    | /api/categories/{id} |

Admin:

| Method    | Endpoint             |
| --------- | -------------------- |
| POST      | /api/categories      |
| PUT/PATCH | /api/categories/{id} |
| DELETE    | /api/categories/{id} |

### Products

| Method | Endpoint           |
| ------ | ------------------ |
| GET    | /api/products      |
| GET    | /api/products/{id} |

Admin:

| Method    | Endpoint           |
| --------- | ------------------ |
| POST      | /api/products      |
| PUT/PATCH | /api/products/{id} |
| DELETE    | /api/products/{id} |

### Cart

| Method | Endpoint             |
| ------ | -------------------- |
| POST   | /api/cart/items      |
| GET    | /api/cart            |
| PATCH  | /api/cart/items/{id} |
| DELETE | /api/cart/items/{id} |

### Orders

| Method | Endpoint         |
| ------ | ---------------- |
| POST   | /api/orders      |
| GET    | /api/orders      |
| GET    | /api/orders/{id} |

Admin:

| Method | Endpoint                      |
| ------ | ----------------------------- |
| GET    | /api/admin/orders             |
| GET    | /api/admin/orders/{id}        |
| PATCH  | /api/admin/orders/{id}/status |

---

## Project Architecture

```text
Domain/
├── Auth/
│   ├── Actions/
│   ├── Controllers/
│   └── Requests/
├── Categories/
│   └── Controllers/
├── Products/
│   └── Controllers/
├── Cart/
│   └── Controllers/
└── Order/
    └── Controllers/
```

### Controllers

Handle HTTP requests and responses.

### Actions

Contain business logic related to authentication workflows.

### Requests

Handle request validation.

### Models

Represent database entities and relationships.

### Middleware

Protect admin-only routes and authenticated endpoints.

---

## Testing With Postman

1. Register a user
2. Login and obtain token
3. Create categories and products as admin
4. Add products to cart
5. Create an order
6. View order details
7. Login as admin
8. Update order status

Protected routes require:

```http
Authorization: Bearer YOUR_TOKEN
```

---

## What I Learned

* Laravel routing and middleware
* Authentication with Laravel Sanctum
* Eloquent relationships
* Role-based authorization
* Database migrations and schema design
* REST API design principles
* Shopping cart and order workflows
* Stock management logic
* Backend project structure and organization

---

## Future Improvements

* Automated testing
* API Resources
* Service layer
* Docker support
* Product image uploads
* Pagination
* Swagger / OpenAPI documentation
* Frontend application with React

---

## Author

**Tomas Paulenas**

Backend Developer (Laravel / PHP)
