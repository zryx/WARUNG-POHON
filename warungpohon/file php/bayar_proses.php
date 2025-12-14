<?php
include "db.php";

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) die("ID tidak valid.");

// cek error upload
if (!isset($_FILES['bukti']) || $_FILES['bukti']['error'] !== 0) {
    header("Location: bayar.php?id=$id&status=error");
    exit;
}

$folder = "uploads/";
if (!is_dir($folder)) mkdir($folder);

$ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
$file_name = "bukti_" . time() . "_" . rand(1000,9999) . "." . $ext;

$path = $folder . $file_name;

// upload file
move_uploaded_file($_FILES['bukti']['tmp_name'], $path);

// simpan nama file ke database
$koneksi->query("UPDATE pesanan SET bukti='$file_name' WHERE id_pesanan=$id");

// kembali ke bayar.php untuk trigger Swal success
header("Location: bayar.php?id=$id&status=success");
exit;
?>
