<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>

<h2>Selamat Datang, Admin!</h2>

<a href="logout.php">Logout</a>

</body>
</html>
