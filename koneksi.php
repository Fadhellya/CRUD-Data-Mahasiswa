<?php
    $hostname = getenv('DB_HOST');
    $username = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $database = getenv('DB_NAME');

    $connect = mysqli_connect($hostname, $username, $password, $database);

    // Cek koneksi
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>

