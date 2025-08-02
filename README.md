# Inventory Management API

A simplified RESTful API for managing inventory across multiple warehouses using Laravel.

---

## 🔧 Setup Instructions

1. **Clone the repository**
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure DB
4. Run `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Install Sanctum:
   ```bash
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```
7. Create test user and authenticate with Sanctum.

---

## 📦 API Endpoints

### Public:
- `GET /api/inventory`
  - Query params: `name`, `min_price`, `max_price`
- `GET /api/warehouses/{id}/inventory`

### Protected:
- `POST /api/stock-transfers`
  - Requires authentication via Sanctum

Request body:
```json
{
  "inventory_item_id": 1,
  "from_warehouse_id": 1,
  "to_warehouse_id": 2,
  "quantity": 5
}
```

---

## 🧪 Tests

Run all tests using:
```bash
php artisan test
```
Tests included:
- ✅ Unit test for over-transfer error
- ✅ Feature test for successful transfer
- ✅ Event test for low-stock detection

---
