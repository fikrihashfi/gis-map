# gis-map
Laravel project with leaflet library map

## Requirements
- PHP >=7.2
- Internet
- More...

## Cara Install
- Install **Laragon**, setting domain ke appspot.com
- Buat sebuah folder baru dan set folder tersebut menjadi root Laragon
- Di folder tadi, jalankan kode ini `git clone https://github.com/fikrihashfi/gis-map.git`
- Rename .env.example menjadi .env
- Lalu jalankan `composer install`, `php artisan migrate`, `php artisan db:seed`, dan `php artisan db:seed --class=DatagempaSeeder`
- Website akan berjalan di halaman `https://gis-map.appspot.com/`, jika gagal silakan buka pada incognito chrome

## Akses Admin
- Lihat pada laman `https://gis-map.appspot.com/login`, login mengunakan akun dengan email `admin@gismap.com` dan password `password@gismap.com`
