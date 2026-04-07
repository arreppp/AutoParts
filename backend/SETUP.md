# AutoParts MY — Laravel Backend Setup

## Requirements
- PHP 8.2+
- Composer
- Node.js 18+ (for frontend)

## Quick Start

```bash
# 1. Install PHP dependencies
cd backend
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Run migrations
php artisan migrate

# 5. Seed with categories and products
php artisan db:seed

# 6. Start the API server (port 8000)
php artisan serve
```

## Frontend (separate terminal)

```bash
# From project root
npm install
npm run dev
```

The Vite dev server proxies `/api` → `http://localhost:8000`, so both run seamlessly.

---

## API Reference

All endpoints are prefixed with `/api`.

### Authentication (Public)

| Method | Endpoint       | Description                          |
|--------|---------------|--------------------------------------|
| POST   | `/register`    | Create account (returns token)       |
| POST   | `/login`       | Sign in (returns token)              |

**Register body:**
```json
{ "name": "Ahmad", "email": "ahmad@example.com", "password": "secret", "password_confirmation": "secret" }
```

**Login body:**
```json
{ "email": "ahmad@example.com", "password": "secret" }
```

Both return: `{ user, token }` — store token as `Authorization: Bearer <token>`.

---

### Products & Categories (Public)

| Method | Endpoint              | Query params                                    |
|--------|-----------------------|-------------------------------------------------|
| GET    | `/categories`         | —                                               |
| GET    | `/products`           | `search`, `category`, `sort`, `max_price`, `per_page` |
| GET    | `/products/{id}`      | —                                               |

**Sort values:** `featured` (default), `price_asc`, `price_desc`, `rating`

---

### User Profile (Auth required)

| Method | Endpoint  | Description        |
|--------|-----------|--------------------|
| GET    | `/user`   | Get profile        |
| PUT    | `/user`   | Update profile     |
| POST   | `/logout` | Revoke token       |

---

### Shopping Cart (Auth required)

| Method | Endpoint                    | Description                  |
|--------|-----------------------------|------------------------------|
| GET    | `/cart`                     | Get cart with totals         |
| POST   | `/cart/add`                 | Add product to cart          |
| PUT    | `/cart/items/{cartItemId}`  | Update item quantity (0 = remove) |
| DELETE | `/cart/items/{cartItemId}`  | Remove item                  |
| DELETE | `/cart/clear`               | Empty cart                   |

**Add to cart body:** `{ "product_id": 1, "quantity": 1 }`

**Cart response:**
```json
{
  "items": [{ "id": 1, "product_id": 1, "qty": 2, "name": "...", "brand": "...", "emoji": "⚡", "price": 38.50, "subtotal": 77.00 }],
  "count": 2,
  "subtotal": 77.00,
  "shipping": 15.00,
  "tax": 6.16,
  "total": 98.16
}
```

---

### Orders (Auth required)

| Method | Endpoint        | Description               |
|--------|-----------------|---------------------------|
| GET    | `/orders`       | List orders (paginated)   |
| POST   | `/orders`       | Place order from cart     |
| GET    | `/orders/{id}`  | Get order details         |

**Place order body:**
```json
{
  "shipping_name": "Ahmad bin Abdullah",
  "shipping_phone": "012-3456789",
  "shipping_address1": "No. 12, Jalan Bunga Raya",
  "shipping_address2": "Taman Maju",
  "shipping_city": "Petaling Jaya",
  "shipping_postcode": "47500",
  "shipping_state": "Selangor",
  "delivery_notes": "Leave at guardhouse",
  "payment_method": "fpx"
}
```

**Payment methods:** `fpx`, `card`, `ewallet`, `cod`

---

## Database Schema

| Table         | Description                          |
|---------------|--------------------------------------|
| `users`       | User accounts                        |
| `categories`  | Part categories (Engine, Brakes …)   |
| `products`    | Auto parts catalog (12 seeded)       |
| `carts`       | One cart per user                    |
| `cart_items`  | Line items in cart                   |
| `orders`      | Placed orders with shipping/payment  |
| `order_items` | Snapshot of items at order time      |
