<?php
ob_start(); // Memulai output buffering
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $simpan = mysqli_query($connect, "INSERT INTO mahasiswa(nim, nama, jk, prodi, alamat)
                VALUES('$_POST[nim]', '$_POST[nama]', '$_POST[jk]', '$_POST[prodi]', '$_POST[alamat]')");
    if ($simpan) {
        header('Location: data_mhs.php');
        exit(); // Menghentikan eksekusi skrip setelah header
    } else {
        // Menyimpan pesan kesalahan dalam variabel
        $error_message = "Gagal Menyimpan Data Mahasiswa !!!";
    }
}
ob_end_flush(); // Menghentikan output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data Mahasiswa</title>
    <style>
        /* CSS untuk mengatur tampilan form dan elemen lainnya */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        h3 {
            color: #333;
        }
        /* (Lanjutkan dengan gaya CSS Anda) */
    </style>
</head>
<body>
    <h3>Input Data Mahasiswa</h3>
    <form method="POST" action="">
        <!-- Form input Anda -->
    </form>
    
    <?php
    // Tampilkan pesan kesalahan jika ada
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
</body>
</html>
