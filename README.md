# UTS Pemrograman Sisi Server
## Project Aplikasi Manajemen Inventory w/ Docker
Vent adalah sebuah aplikasi manajemen inventaris berbasis web yang dirancang untuk membantu perusahaan dalam mengelola dan memantau inventaris barang secara efektif. Aplikasi ini dibangun menggunakan Laravel, framework PHP yang tangguh dan populer, yang memastikan aplikasi berjalan dengan cepat, aman, dan mudah dikembangkan lebih lanjut. Untuk meningkatkan fungsionalitas dan interaktivitas, Vent mengintegrasikan Filament, sebuah library khusus yang mempermudah pembuatan halaman dashboard admin yang dinamis, intuitif, dan kaya fitur. Dengan Filament, administrator dapat mengakses berbagai data inventaris, melakukan pemantauan, serta mendapatkan informasi yang real-time dalam tampilan yang user-friendly.

Tidak hanya fokus pada sisi administrasi, Vent juga menawarkan landing page yang menarik dan responsif dengan memanfaatkan DaisyUI – salah satu library dari Tailwind CSS. DaisyUI memberikan komponen antarmuka yang modern dan konsisten, sehingga tampilan aplikasi tidak hanya fungsional, tetapi juga memiliki desain yang estetis dan nyaman bagi pengguna.

Dibuatnya aplikasi ini bertujuan untuk memberikan kemudahan bagi perusahaan dalam memonitor, mengelola, dan mengatur inventaris barang secara efisien. Vent memungkinkan pengelolaan inventaris menjadi lebih terstruktur, mulai dari pencatatan masuk dan keluarnya barang, hingga pelacakan ketersediaan stok secara akurat. Dengan demikian, Vent mendukung perusahaan dalam menjaga ketersediaan barang, meminimalisir kesalahan manusia dalam pengelolaan, serta meningkatkan produktivitas melalui pengelolaan inventaris yang lebih terpusat dan terdigitalisasi.

## Fitur
- CRUD untuk data item
- CRUD untuk data kategori
- CRUD untuk data supplier
- CRUD User Admin
- Tabel ringkasan stok barang termasuk stok total, total nilai stok dan rata-rata harga barang.
- Tabel daftar barang yang stoknya di bawah ambang batas tertentu.
- Laporan barang berdasarkan kategori tertentu.
- Tabel ringkasan per kategori, termasuk jumlah barang per kategori, total nilai stok tiap kategori, dan rata-rata harga barang dalam kategori tersebut.
- Tabel ringkasan barang yang disuplai oleh masing-masing pemasok, termasuk jumlah barang per pemasok dan total nilai barang yang disuplai.
- Tabel ringkasan dari keseluruhan sistem, termasuk total jumlah barang, nilai stok keseluruhan, jumlah kategori, dan jumlah pemasok.

## Technology Stack
- Laravel - Framework PHP
- MySQL - Relational Database Management System
- Nginx - Web server
- Docker - Container platform

## Developer
1. Primavieri Rhesa Ardana - A11.2022.14557
2. Fadhil Firmansyah - A11.2022.14560
3. Bagas Satria - A11.2022.14565

## Prerequisite
Pada sistem operasi user telah terinstal `Docker Desktop` atau package `docker` & `docker-compose`

## Guide / Step-by-step
### 1. Clone Project
```shell
git clone https://github.com/FadhilFirmansyah/container-inventory.git
```
Clonning project manajemen inventory ke directory yang sedang anda akses saat ini
### 2. Change Directory
```shell
cd container-inventory
```
Berpindah menuju directory / folder hasil dari project yang telah di clone
### 3. Install Project
#### 3.1. Linux & MacOS (UNIX)
```shell
./setup.sh
```
Melakukan setup installasi dari awal hingga akhir (container-frontend-backend), scripting yang membantu dengan menghindari serimonial setup ;)
#### 3.2. Windows 
Sayangnya scripting `setup.sh` tidak bisa berjalan kecuali user menggunakan wsl dengan mounting yang sesuai maka bisa apabila menggunakan cara reguler pada Windows sayangnya tidak bisa, user harus melakukan kegiatan seremonial setup :(
##### 3.2.1. Compose Up
```shell
docker-compose up -d --build
```
Bertujuan untuk inisialisasi awal seperti pembuatan `Dockerfile` dan `docker-compose.yml` menjadi suatu container
##### 3.2.2. Change Modifier
```shell
docker-compose exec app chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
```
Direcotry `/storage` dan `/bootstrap/cache` akan memiliki semua akses (Write, Read, Execute)
##### 3.2.3. NPM Install
```shell
docker exec laravel_app npm i
```
Menginstall segala dependency untuk frontend yang bersumber dari `package.json`
##### 3.2.4. NPM Build
```shell
docker exec laravel_app npm run build
```
Perintah yang menjalankan skrip `build` yang terdefinisi di file `package.json` dalam container `laravel_app`
##### 3.2.5. Composer Scope Install
```shell
docker exec laravel_app composer install
```
Menginstal dependensi PHP yang terdaftar di file `composer.json` dalam container `laravel_app`
##### 3.2.6. Duplicate .ENV File
```shell
docker exec laravel_app cp .env.example .env
```
Menyalin file `.env.example` menjadi file `.env` di dalam container `laravel_app`, yang digunakan untuk konfigurasi aplikasi
##### 3.2.7. Activate .ENV File
```shell
docker exec laravel_app php artisan key:generate
```
Menghasilkan dan mengatur kunci aplikasi baru untuk Laravel di dalam container `laravel_app`, yang digunakan untuk keamanan aplikasi
##### 3.2.8. Formatting .ENV File
Ubah file `.env` yang terletak di `/inventory-project`
```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=
```
Menjadi
```.env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=root
```
##### 3.2.9. Database
```shell
docker exec laravel_app php artisan migrate --seed
```
Migrasi database untuk memperbarui struktur tabel dan mengisi data awal (seeding) di dalam container `laravel_app`

#### Credential Login
```
Username : admin
Email    : admin@gmail.com
Password : sudo
```

## TROUBLESHOOT
Menemui masalah berupa tidak bisa menjalankan perintah
```
docker exec laravel_app php artisan migrate --seed
```

Hal ini terjadi karena  Kredensial database dalam konfigurasi container MySQL tidak benar. Mencoba membuat user root dengan MYSQL_USER yang tidak diizinkan - user root sudah dibuat secara otomatis dengan MYSQL_ROOT_PASSWORD, maka langkah yang perlu dilakukan adalah merubah `.env` nya menjadi berikut
```.env
DB_CONNECTION=mysql
DB_HOST=mysql_db
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=root
```

lalu menambahkan config berikut di `docker-compose.yml` 
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
    healthcheck:   # Adding healthcheck for monitoring (Optional)
      test: ["CMD", "mysqladmin", "ping", "-proot"]
      interval: 10s
      timeout: 5s
      retries: 5
    networks:
      - app-network
```
Lalu jalankan ulang migrate seed nya , maka akan bisa menjalankannya

## Arsitektur Aplikasi
- **docker-compose.yml** - Konfigurasi yang digunakan oleh Docker Compose untuk mendefinisikan dan menjalankan multi-container Docker aplikasi, termasuk pengaturan layanan, jaringan, volume, dan penghubung antar container
- **Dockerfile** - File teks yang berisi serangkaian instruksi untuk membangun image Docker, termasuk pengaturan sistem, instalasi aplikasi, dan konfigurasi yang diperlukan
- **inventory-project** - Source code project aplikasi manajemen inventory 
- **nginx.conf** - File konfigurasi utama Nginx yang mengatur pengaturan server, rute trafik, dan interaksi dengan aplikasi 
- **setup.sh** - Script installasi setup untuk membuat container, frontend, backend, dan database
