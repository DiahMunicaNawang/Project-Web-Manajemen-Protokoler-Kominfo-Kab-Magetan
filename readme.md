menggunakan docker untuk deploy

Tambahkan file .env
Sesuaikan konfigurasi koneksi database dengan config mariadb pada file docker-compose.yml
Jalanakan docker compose up -d --build
Jalankan docker-compose exec laravel composer install
Jalankan docker-compose exec laravel php artisan migrate - untuk migrasi database
Jalankan docker-compose exec laravel php artisan db:seed - untuk mengisi data initial pada database
jalankan pada browser localhost:8080 - atau sesuakan port pada docker-compose.yml