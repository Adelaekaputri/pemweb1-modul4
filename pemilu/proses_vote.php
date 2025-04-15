<?php
include 'db.php';

// Ambil data dari form
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$id_calon = $_POST['calon'];

// Cek apakah NIK sudah digunakan
$cek = $conn->prepare("SELECT COUNT(*) FROM suara WHERE nik = ?");
$cek->bind_param("s", $nik);
$cek->execute();
$cek->bind_result($jumlah);
$cek->fetch();
$cek->close();

function tampilkanPesan($judul, $pesan, $warna, $link_teks, $link_href) {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>$judul</title>
        <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap' rel='stylesheet'>
        <style>
            body {
                font-family: 'Roboto', sans-serif;
                background: linear-gradient(to bottom, #d32f2f, #ffffff);
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                background: #fff;
                margin: 80px auto;
                padding: 40px;
                text-align: center;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }
            h2 {
                color: $warna;
                margin-bottom: 20px;
            }
            p {
                font-size: 18px;
                color: #555;
                margin-bottom: 30px;
            }
            a {
                background: $warna;
                color: white;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 8px;
                font-weight: bold;
                transition: background 0.3s ease;
            }
            a:hover {
                background: #7f0000;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>$judul</h2>
            <p>$pesan</p>
            <a href='$link_href'>$link_teks</a>
        </div>
    </body>
    </html>
    ";
    exit;
}

if ($jumlah > 0) {
    tampilkanPesan("Anda Sudah Memilih", "NIK Anda telah digunakan untuk memilih. Anda tidak dapat memilih lebih dari sekali.", "#c62828", "Kembali ke Halaman Pemilu", "index.php");
}

// Simpan suara baru
$stmt = $conn->prepare("INSERT INTO suara (nama, nik, tanggal_lahir, id_calon) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $nama, $nik, $tanggal_lahir, $id_calon);
$stmt->execute();
$stmt->close();

// Tambah suara ke calon
$conn->query("UPDATE calon SET jumlah_suara = jumlah_suara + 1 WHERE id = $id_calon");

// Tampilkan pesan sukses
tampilkanPesan("Terima Kasih Telah Memilih!", "Suara Anda telah berhasil direkam. Mari kita sukseskan Pemilu Indonesia 2025!", "#2e7d32", "Lihat Hasil Pemilu", "hasil.php");
?>
