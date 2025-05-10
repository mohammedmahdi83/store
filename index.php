<?php
session_start();
require_once "db_connection.php"; // الاتصال بقاعدة البيانات

// جلب جميع المنتجات
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الرئيسية - المنتجات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container mt-4 bg-primary-subtle text-primary-emphasis">
    

    <?php if (isset($_SESSION['username'])): ?>
        <div class="alert alert-success text-center"> 
             <h1>مرحبا بك في الصيدلية الالكترونية</h1>
             <br>
             <h2 class="mb-4 text-center">قائمة المنتجات</h2>
            
        </div>
    <?php else: ?>
        <div class="text-center mb-3">
            <a href="login.php" class="btn btn-primary">تسجيل الدخول</a>
            <a href="register.php" class="btn btn-secondary">إنشاء حساب</a>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($row['image'])): ?>
                            <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="صورة المنتج">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                            <p class="text-success fw-bold">السعر: <?= number_format($row['price'], 2) ?> $</p>
                            <a href="product.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary">عرض التفاصيل</a>
                            <a href="order.php?id=<?= $row['id'] ?>" class="btn btn-success mt-2">طلب المنتج</a>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">لا توجد منتجات حالياً.</p>
        <?php endif; ?>
    </div>
    <a href="logout.php" class="btn btn-sm btn-danger">تسجيل الخروج</a>
</div>
</body>
</html>
