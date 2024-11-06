<?php
ob_start(); // Memulai output buffering
include "koneksi.php"; // Pastikan koneksi ke database sudah benar

$error_message = ''; // Inisialisasi variabel untuk pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $prodi = $_POST['prodi'];
    $alamat = $_POST['alamat'];

    // Query untuk menyimpan data ke database
    $simpan = mysqli_query($connect, "INSERT INTO mahasiswa(nim, nama, jk, prodi, alamat)
                VALUES('$nim', '$nama', '$jk', '$prodi', '$alamat')");
    
    // Cek apakah query berhasil
    if ($simpan) {
        header('Location: data_mhs.php'); // Redirect jika sukses
        exit(); // Menghentikan eksekusi skrip setelah header
    } else {
        // Menyimpan pesan kesalahan dalam variabel
        $error_message = "Gagal Menyimpan Data Mahasiswa: " . mysqli_error($connect);
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
        /* Reset CSS */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        h3 {
            color: #495057;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }

        input[type="text"],
        select,
        input[type="radio"] + label {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #f8f9fa;
            margin-bottom: 10px;
            font-size: 14px;
        }

        input[type="radio"] {
            width: auto;
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h3>Input Data Mahasiswa</h3>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" name="nim" id="nim" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" required>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <input type="radio" name="jk" id="jk-l" value="L" required>
            <label for="jk-l">Laki-Laki</label>
            <input type="radio" name="jk" id="jk-p" value="P" required>
            <label for="jk-p">Perempuan</label>
        </div>

        <div class="form-group">
            <label for="prodi">Jurusan</label>
            <select name="prodi" id="prodi" required>
                <option value="">- Pilih -</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Manajemen Informatika">Manajemen Informatika</option>
                <option value="Teknik Komputer">Teknik Komputer</option>
                <option value="Komputer Akuntansi">Komputer Akuntansi</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" required>
        </div>

        <input type="submit" value="Simpan">

        <?php
        // Tampilkan pesan kesalahan jika ada
        if (!empty($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
    </form>
</body>
</html>
