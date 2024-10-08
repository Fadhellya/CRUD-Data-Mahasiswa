<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        /* CSS untuk mengatur tampilan */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }

        h3 {
            color: #333;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
        }

        a:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        td {
            background-color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Tombol Edit dan Hapus */
        .action-links a {
            color: #007bff;
            margin-right: 10px;
            text-decoration: none;
        }

        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h3>Data Mahasiswa yang Berhasil Disimpan</h3>
    <a href="index.php">Tambah Data Mahasiswa</a>
    <table>
        <tr>
            <th>No.</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>L/P</th>
            <th>Jurusan</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php
        include "koneksi.php";
        $No = 1;
        $sqlMhs = mysqli_query($connect, "SELECT * FROM mahasiswa ORDER BY nim ASC");
        while ($a = mysqli_fetch_array($sqlMhs)) {
            echo "<tr>
                            <td align='center'>$No</td>
                            <td>$a[nim]</td>
                            <td>$a[nama]</td>
                            <td align='center'>$a[jk]</td>
                            <td>$a[prodi]</td>
                            <td>$a[alamat]</td>
                            <td align='center' class='action-links'>
                                <a href='edit_mhs.php?nim=$a[nim]'>Edit</a> | 
                                <a href='hapus_mhs.php?nim=$a[nim]'>Hapus</a>
                            </td>
                        </tr>";
            $No++;
        }
        ?>
    </table>
</body>

</html>
