<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "simple_store"; // أو اسم قاعدة البيانات التي أنشأتها
$conn = new mysqli($servername, $username, $password, $database);

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// --- إضافة منتج ---
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['description']]);
}

// --- تعديل منتج ---
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['description'], $_POST['id']]);
}

// --- حذف منتج ---
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$_GET['delete']]);
}

// --- جلب المنتجات ---
$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>إدارة المنتجات</title>
</head>
<body>
    <h1>قائمة المنتجات</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>الاسم</th>
            <th>السعر</th>
            <th>الوصف</th>
            <th>إجراءات</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <td><input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"></td>
                    <td><input type="text" name="price" value="<?= $product['price'] ?>"></td>
                    <td><input type="text" name="description" value="<?= htmlspecialchars($product['description']) ?>"></td>
                    <td>
                        <button type="submit" name="update">تعديل</button>
                        <a href="?delete=<?= $product['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>إضافة منتج جديد</h2>
    <form method="post">
        <input type="text" name="name" placeholder="اسم المنتج" required>
        <input type="text" name="price" placeholder="السعر" required>
        <input type="text" name="description" placeholder="الوصف">
        <button type="submit" name="add">إضافة</button>
    </form>
</body>
</html>
