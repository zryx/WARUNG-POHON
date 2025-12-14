<?php
session_start();
include "db.php";

$username = $_POST['username'];
$password = md5($_POST['password']);  // karena di database juga MD5

$sql = $koneksi->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");

if ($sql->num_rows == 1) {
    // login sukses
    $_SESSION['admin'] = $username;
    header("Location: nota2.php");  
} else {
    echo "<script>alert('Username atau password salah!'); window.location='login.php';</script>";
}
?>
