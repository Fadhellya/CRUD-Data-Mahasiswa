<?php
    $hostname = getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost';
    $username = getenv('DB_USER') ? getenv('DB_USER') : 'root';
    $password = getenv('DB_PASS') ? getenv('DB_PASS') : '';
    $database = getenv('DB_NAME') ? getenv('DB_NAME') : 'akademik';

    $connect = mysqli_connect($hostname, $username, $password, $database);

    // Cek koneksi
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>

