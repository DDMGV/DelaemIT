Step by step

1. docker-compose up -d
2. cd example-app
3. composer install
4. cp .env.example .env
5. docker exec -it laravel-php bash
6. php artisan db:seed

7. go to http://localhost:8080
