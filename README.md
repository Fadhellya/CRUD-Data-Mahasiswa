# Panduan Penggunaan

## 1. Persiapan Database
1. Buat database baru di **phpMyAdmin** dengan nama **`akademik`**.
2. Import file database yang terdapat di folder **`database`** ke dalam database yang telah dibuat.

## 2. Konfigurasi Koneksi Database
Buat file baru dengan nama **`koneksi.php`** untuk mengatur koneksi ke database dengan konfigurasi berikut:

```php
<?php
$connect = mysqli_connect("hostname", "username", "password", "akademik");
?>
Keterangan:
hostname: Default adalah localhost.

username: Biasanya root secara default.

password: Jika ada, isikan; jika tidak, biarkan kosong.

akademik: Nama database yang digunakan.

3. Menjalankan Aplikasi
Pastikan aplikasi dijalankan di local server (XAMPP, WAMP, atau lainnya).

Aplikasi akan berjalan pada port 8080.

4. Konfigurasi Environment Variables (ENV)
Untuk menjalankan aplikasi dengan environment variables, gunakan pengaturan berikut:
DB_HOST=<hostname>
DB_USER=<username>
DB_PASS=<password>
DB_NAME=akademik
DB_PORT=<db-port>

