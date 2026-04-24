# Glow Book — Salon Booking Platform

Laravel 12 web app for salon appointment management. Multi-role: Admin, Salon Owner, Specialist, Client.

## Features

- **Public**: Browse salons, services, specialists; search & filter salons
- **Client**: Book appointments, leave reviews
- **Specialist**: View schedule, update appointment status
- **Salon Owner**: Manage specialists, services, appointments
- **Admin**: Manage all salons, users, appointments

## Roles

| Role | Middleware | Dashboard Route |
|------|------------|-----------------|
| `admin` | `admin` | `/admin/dashboard` |
| `salon_owner` | `owner` | `/owner/dashboard` |
| `specialist` | `specialist` | `/specialist/dashboard` |
| `client` | — | `/client/dashboard` |

Role redirect handled at `/dashboard` after login.

## Tech Stack

- PHP 8.2, Laravel 12
- Blade templates, Tailwind CSS, Vite
- MySQL (via Docker)
- Laravel Breeze (auth scaffolding)

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- Docker & Docker Compose (optional)

## Setup

```bash
git clone <repo-url>
cd glow_book

cp .env.example .env
composer install
npm install

php artisan key:generate
php artisan migrate --seed

npm run dev
php artisan serve
```

### Docker

```bash
docker-compose up -d
docker-compose exec app php artisan migrate --seed
```

## Database Schema

- `users` — name, email, password, role, phone, avatar
- `salons` — name, address, city, description, image, owner_id
- `services` — name, description, price, duration, salon_id
- `specialists` — user_id, salon_id, bio, avatar
- `specialist_service` — pivot
- `appointments` — client_id, specialist_id, service_id, salon_id, date, time, status, notes
- `reviews` — client_id, salon_id, appointment_id, rating, comment

## Key Routes

```
GET  /salons                  # public salon listing (search + filter)
GET  /salons/{salon}          # salon detail
GET  /client/book             # booking form
POST /client/review/{appt}    # submit review
PATCH /specialist/appointments/{appt}/status
CRUD /owner/services
CRUD /admin/salons
```

## Policy / Access Control

Access enforced via middleware:

- `AdminMiddleware` — role must be `admin`
- `OwnerMiddleware` — role must be `salon_owner`
- `SpecialistMiddleware` — role must be `specialist`

Registered in `bootstrap/app.php` as route middleware aliases `admin`, `owner`, `specialist`.

## License

MIT
