# UTS Pemrograman Sisi Server
## Aplikasi Manajemen Inventaris dengan Docker
AMBA adalah aplikasi berbasis web untuk mengelola inventaris barang yang dirancang untuk membantu perusahaan dalam memonitor dan mengelola stok barang dengan lebih efisien. Aplikasi ini dibangun dengan Laravel, sebuah framework PHP yang kuat dan banyak digunakan, menjadikannya cepat, aman, dan mudah untuk pengembangan lebih lanjut. Untuk meningkatkan fungsionalitas dan kemudahan penggunaan, AMBA juga mengintegrasikan Filament, sebuah library yang mempermudah pembuatan dashboard admin yang dinamis, intuitif, dan penuh fitur. Dengan Filament, admin dapat memantau data inventaris dan mendapatkan informasi real-time dalam tampilan yang ramah pengguna.

Selain untuk administrasi, AMBA juga dilengkapi dengan landing page responsif yang menggunakan DaisyUI, library dari Tailwind CSS. DaisyUI menyediakan komponen antarmuka yang modern dan seragam, sehingga tampilan aplikasi tidak hanya praktis, tetapi juga menarik dan mudah digunakan.

Aplikasi ini dirancang untuk memudahkan perusahaan dalam mengelola dan memantau inventaris, mulai dari pencatatan barang masuk dan keluar hingga pelacakan stok secara akurat. Dengan AMBA, pengelolaan inventaris menjadi lebih terorganisir, mengurangi kesalahan manusia, dan meningkatkan produktivitas dengan sistem yang lebih terpusat dan terdigitalisasi.

## Fitur
- CRUD untuk data item
- CRUD untuk data kategori
- CRUD untuk data pemasok
- CRUD untuk User Admin
- Tabel ringkasan stok barang, termasuk total stok, total nilai stok, dan rata-rata harga barang.
- Daftar barang dengan stok di bawah ambang batas.
- Laporan barang berdasarkan kategori tertentu.
- Tabel ringkasan per kategori, termasuk jumlah barang per kategori, total nilai stok per kategori, dan rata-rata harga barang dalam kategori tersebut.
- Ringkasan barang yang disuplai oleh pemasok, termasuk jumlah barang dan total nilai yang disuplai.
- Ringkasan sistem secara keseluruhan, termasuk total jumlah barang, nilai stok keseluruhan, jumlah kategori, dan jumlah pemasok.

## Teknologi yang Digunakan
- Laravel - Framework PHP
- MySQL - Sistem Manajemen Basis Data Relasional
- Nginx - Web server
- Docker - Platform Kontainer

## Developer
1. Angga Nurwahyu Utomo - A11.2022.14575
2. Gary Kristevian Antoni - A11.2022.14564
3. Rangga Aristianto - A11.2022.14568

## Prasyarat
Pastikan `Docker Desktop` atau paket `docker` dan `docker-compose` terinstal pada sistem operasi pengguna.

## Panduan Instalasi / Langkah demi Langkah
### 1. Clone Proyek
```shell
git clone https://github.com/garykristevian/uts-inventory.git
```
Clone repositori manajemen inventaris ke direktori aktif saat ini.
### 2. Masuk ke Direktori Proyek
```shell
cd uts-inventory
```
Masuk ke direktori tempat proyek yang telah di-clone.
### 3. Instal Proyek
#### 3.1. Linux & MacOS (UNIX)
```shell
./setup.sh
```
Proses instalasi otomatis dari awal hingga selesai (frontend-backend container), menghindari setup manual.
#### 3.2. Windows
Skrip `setup.sh` tidak bisa berjalan di Windows kecuali menggunakan WSL dengan konfigurasi yang sesuai. Jika menggunakan Windows biasa, proses setup manual diperlukan:
##### 3.2.1. Compose Up
```shell
docker-compose up -d --build
```
Inisialisasi awal untuk pembuatan `Dockerfile` dan `docker-compose.yml` menjadi kontainer.
##### 3.2.2. Ubah Modifier
```shell
docker-compose exec app chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
```
Memberikan akses penuh (Read, Write, Execute) pada direktori `/storage` dan `/bootstrap/cache`.
##### 3.2.3. Instal NPM
```shell
docker exec laravel_app npm i
```
Instal semua dependensi frontend dari `package.json`.
##### 3.2.4. Build NPM
```shell
docker exec laravel_app npm run build
```
Jalankan skrip `build` yang terdefinisi di `package.json` dalam kontainer `laravel_app`.
##### 3.2.5. Instal Composer
```shell
docker exec laravel_app composer install
```
Instal dependensi PHP yang terdaftar dalam `composer.json` di kontainer `laravel_app`.
##### 3.2.6. Duplikat File .ENV
```shell
docker exec laravel_app cp .env.example .env
```
Salin file `.env.example` ke `.env` di dalam kontainer `laravel_app` untuk konfigurasi aplikasi.
##### 3.2.7. Aktivasi File .ENV
```shell
docker exec laravel_app php artisan key:generate
```
Buat dan atur kunci aplikasi baru untuk Laravel dalam kontainer `laravel_app`.
##### 3.2.8. Format File .ENV
Ubah konfigurasi database dalam file `.env` seperti berikut:
```.env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=root
```
##### 3.2.9. Migrasi Database
```shell
docker exec laravel_app php artisan migrate --seed
```
Migrasi dan lakukan seeding untuk memperbarui struktur tabel dan mengisi data awal di dalam kontainer `laravel_app`.

#### Kredensial Login
```
Username : admin
Email    : admin@gmail.com
Password : sudo
```

## Pemecahan Masalah
Jika menemui masalah dengan perintah:
```
docker exec laravel_app php artisan migrate --seed
```
Hal ini disebabkan kredensial database yang salah dalam konfigurasi MySQL. Perbaiki dengan mengubah file `.env` menjadi:
```.env
DB_CONNECTION=mysql
DB_HOST=mysql_db
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=root
```
Kemudian tambahkan konfigurasi berikut pada `docker-compose.yml`:
```yml
app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_app
    restart: always
    working_dir: /var/www/html
    volumes:
      - ./inventory-project:/var/www/html
    depends_on:
      - db
    networks:
      - app-network

  db:
    image: mysql:8.0
    container_name: mysql_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: inventory
    ports:
      - "3307:3306"
    volumes:
      - db_data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-proot"]
      interval: 10s
      timeout: 5s
      retries: 5
    networks:
      - app-network
```
Lalu jalankan kembali perintah migrasi.

## Arsitektur Aplikasi
- **docker-compose.yml** - Konfigurasi untuk menjalankan aplikasi multi-kontainer dengan Docker Compose.
- **Dockerfile** - Instruksi untuk membangun image Docker.
- **inventory-project** - Kode sumber aplikasi manajemen inventaris.
- **nginx.conf** - Konfigurasi server Nginx untuk mengatur trafik dan interaksi dengan aplikasi.
- **setup.sh** - Skrip untuk setup otomatis frontend, backend, dan database.

🐷