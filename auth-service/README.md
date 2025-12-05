# Auth Service

1. copy .env.example -> .env and set USERS_SERVICE_URL and JWT_SECRET
2. composer install
3. php artisan key:generate
4. php artisan serve --port=8001

Endpoints:
POST /api/login -> { email, password }
POST /api/validate -> Authorization: Bearer <token>
POST /api/refresh -> Authorization: Bearer <token>
POST /api/register -> proxied to users-service

hiii from mengthong CI/CD
