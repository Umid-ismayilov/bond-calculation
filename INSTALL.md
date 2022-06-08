
## Projectin Quraşdırmaq üçün

- Compser qurmaq lazımdır
 ``` php 
composer install
```
- .env file-ni yaratmalisiz
- Yeni key generate etmelisiz
 ``` php
php artisan key:generate
```
- Php serveri ayağa qaldırmaq lazımdır
 ``` php 
 php artisan serve
 ```
 
 - Yeni db name yaratmalisiz ve .env-de db parametirlerini qeyd etmelisiz men "laravel" adinda db yaratdim
 - Bu Laravel comandı deyil customize olunub :D
  ``` php
php artisan db:create laravel
```
 - DB migrate et
 ``` php
php artisan migrate
```
 - Seed-leri yukle .
 ``` php
php artisan db:seed
```
