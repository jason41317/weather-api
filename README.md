# Weather API (Laravel) — Installation Guide

## Architectural Approach

This project follows a simple but scalable service-oriented approach:

* Controller Layer → Handles HTTP requests and formats API responses (no business logic)
* Service Layer → Contains all business logic, including API calls to OpenWeather
* DTO (Data Transfer Object) → Ensures structured and consistent weather data across the app
* Separation of Concerns → Each layer has a single responsibility to keep the code maintainable and testable

This approach ensures the system is clean, testable, and safe for both Docker and production environments.

# Requirements

## Local (Without Docker)

* PHP 8.3+
* Composer
* Redis (recommended)

## Docker Setup

* Docker Desktop
* Docker Compose

---

# Installation (Without Docker)

## 1. Clone the repository

```bash
git clone https://github.com/your-repo/weather-api.git
cd weather-api
```

## 2. Install dependencies

```bash
composer install
```

## 3. Setup environment

```bash
cp .env.example .env
```

## 4. Configure `.env`

### App Settings

```env
APP_NAME=WeatherAPI
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
```

### OpenWeather API

```env
OPENWEATHER_BASE_URL=https://api.openweathermap.org/data/2.5
OPENWEATHER_API_KEY=your_api_key_here
```

### Cache (Recommended: Redis)

#### Redis

```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## 5. Generate app key

```bash
php artisan key:generate
```

## 6. Run the application

```bash
php artisan serve
```

App will be available at:

```
http://localhost:8000
```

---

# Installation (With Docker)

## 1. Clone repository

```bash
git clone https://github.com/your-repo/weather-api.git
cd weather-api
```

## 2. Copy environment file

```bash
cp .env.example .env
```

## 3. Configure `.env` for Docker

### App URL

```env
APP_URL=http://localhost
```

### Redis (Docker service name)

```env
CACHE_DRIVER=redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### OpenWeather API

```env
OPENWEATHER_BASE_URL=https://api.openweathermap.org/data/2.5
OPENWEATHER_API_KEY=your_api_key_here
```

## 4. Build containers

```bash
docker-compose up -d --build
```

## 5. Install dependencies inside container

```bash
docker exec -it app composer install
```

## 6. Generate app key

```bash
docker exec -it app php artisan key:generate
```

## 7. Run migrations (if needed)

```bash
docker exec -it app php artisan migrate
```

## 8. Clear config cache

```bash
docker exec -it app php artisan config:clear
```

## 9. Access app

```
http://localhost
```

---

## OpenWeather SSL error (dev only fix when running without Docker)

```php
Http::withoutVerifying()
```