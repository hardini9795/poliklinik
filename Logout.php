<?php
session_start();
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi
header("Location: login.php"); // Redirect ke halaman login atau halaman lain setelah logout
exit();
?>

