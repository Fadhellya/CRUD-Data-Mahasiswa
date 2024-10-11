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
        /* CSS untuk mengatur tampilan form dan elemen lainnya */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        h3 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Tambahkan ruang di bawah elemen */
        .form-group {
            margin-bottom: 15px;
        }

        /* Styling untuk pesan kesalahan */
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Input Data Mahasiswui</h3>
    <form method="POST" action="">
        <table>
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim" size="18" required></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama" size="18" required></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>
                    <input type="radio" name="jk" value="L" required> Laki-Laki
                    <input type="radio" name="jk" value="P" required> Perempuan
                </td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>
                    <select name="prodi" required>
                        <option value="">- Pilih -</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Manajemen Informatika">Manajemen Informatika</option>
                        <option value="Teknik Komputer">Teknik Komputer</option>
                        <option value="Komputer Akuntansi">Komputer Akuntansi</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><input type="text" name="alamat" size="18" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Simpan"></td>
            </tr>
        </table>
    </form>

    <?php
    // Tampilkan pesan kesalahan jika ada
    if (!empty($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>
</body>
</html>
