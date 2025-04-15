<?php
include 'db.php';

$nama = $_POST['nama'];
$kepuasan = $_POST['kepuasan'];

$stmt = $conn->prepare("INSERT INTO survei (nama, kepuasan) VALUES (?, ?)");
$stmt->bind_param("ss", $nama, $kepuasan);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit();
