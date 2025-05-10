<?php
session_start();
require_once "db_connection.php";

// التحقق من تسجيل الدخول
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// التحقق من وجود معرف المنتج
if (!isset($_GET['id'])) {
    echo "معرف المنتج غير موجود.";
    exit;
}

$product_id = intval($_GET['id']);
$username = $_SESSION['username'];

// التحقق من أن المنتج موجود فعلاً
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "المنتج غير موجود.";
    exit;
}

// إدخال الطلب في قاعدة البيانات
$order_sql = "INSERT INTO orders (user, product_id) VALUES (?, ?)";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("si", $username, $product_id);

if ($order_stmt->execute()) {
    echo "<h3>✅ تم طلب المنتج بنجاح!</h3>";
    echo "<a href='index.php'>العودة إلى قائمة المنتجات</a>";
} else {
    echo "حدث خطأ أثناء تسجيل الطلب.";
}

?>
