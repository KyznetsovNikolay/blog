## Запуск приложения

- cd docker/ && docker compose up -d
- docker compose exec app composer install
- cp .env.example .env
- docker compose exec app php artisan migrate
- docker compose exec app php artisan db:seed
