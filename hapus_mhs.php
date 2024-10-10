<?php
// Mulai sesi untuk menampung pesan kesalahan jika diperlukan
session_start();

// Sertakan koneksi ke database
include "koneksi.php";

// Sanitasi dan validasi input NIM dari URL
$nim = filter_input(INPUT_GET, 'nim', FILTER_SANITIZE_SPECIAL_CHARS);

if ($nim) {
    // Persiapkan statement untuk menghindari SQL Injection
    $stmt = $connect->prepare("DELETE FROM mahasiswa WHERE nim = ?");
    $stmt->bind_param("s", $nim);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman data mahasiswa
        header('Location: data_mhs.php');
        exit();
    } else {
        // Set pesan kesalahan di sesi dan redirect
        $_SESSION['error'] = "Gagal Menghapus Data Mahasiswa: " . $stmt->error;
        header('Location: data_mhs.php');
        exit();
    }

    // Tutup statement
    $stmt->close();
} else {
    // Set pesan kesalahan jika NIM tidak valid
    $_SESSION['error'] = "NIM tidak valid!";
    header('Location: data_mhs.php');
    exit();
}
?>
