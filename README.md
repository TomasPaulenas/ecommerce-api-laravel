# ShopFlow API

A RESTful e-commerce API built with Laravel. This project includes authentication, role-based authorization, product and category management, shopping cart functionality, order creation, stock management, and order status workflows.

## Features

### Authentication

* User registration
* User login
* Logout
* Protected routes using Laravel Sanctum

### Roles & Authorization

* User role
* Admin role
* Admin-only endpoints protected by middleware

### Categories

* List categories
* View category details
* Create category (admin)
* Update category (admin)
* Delete category (admin)

### Products

* List active products
* View product details
* Create product (admin)
* Update product (admin)
* Soft deactivate products (admin)

### Shopping Cart

* Add products to cart
* View cart
* Update item quantity
* Remove items from cart

### Orders

* Create order from cart
* Automatic stock validation
* Automatic stock deduction
* View own orders
* View specific order details

### Order Management (Admin)

* View all orders
* View specific order
* Update order status

Supported order statuses:

* pending
* paid
* shipped
* cancelled
* completed

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

| Method | Endpoint             |
| ------ | -------------------- |
| POST   | /api/categories      |
| POST   | /api/categories/{id} |
| DELETE | /api/categories/{id} |

### Products

| Method | Endpoint           |
| ------ | ------------------ |
| GET    | /api/products      |
| GET    | /api/products/{id} |

Admin:

| Method | Endpoint           |
| ------ | ------------------ |
| POST   | /api/products      |
| POST   | /api/products/{id} |
| DELETE | /api/products/{id} |

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

Used to protect admin-only routes.

---

## Testing With Postman

1. Register a user.
2. Login and obtain token.
3. Add products to cart.
4. Create an order.
5. Login as admin.
6. View all orders.
7. Update order status.

Use:

```http
Authorization: Bearer YOUR_TOKEN
```

for protected endpoints.

---

## Future Improvements

* Automated testing
* API Resources
* Service layer
* Docker support
* Product images upload
* Pagination
* API documentation with Swagger/OpenAPI

---

## Author

Tomas Paulenas
Backend Developer (Laravel / PHP)
