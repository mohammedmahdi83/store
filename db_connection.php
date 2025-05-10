<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "simple_store"; // أو اسم قاعدة البيانات التي أنشأتها
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
