<?php
require_once "db_connection.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "معرّف المنتج غير صالح.";
    exit();
}

$product_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "المنتج غير موجود.";
    exit();
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['product_name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <a href="index.php" class="btn btn-secondary mb-3">العودة إلى القائمة</a>

    <div class="card mb-3">
        <?php if (!empty($product['image'])): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="صورة المنتج">
        <?php endif; ?>
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h3>
            <p class="card-text"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            <p class="text-success fw-bold">السعر: <?= number_format($product['price'], 2) ?> $</p>
        </div>
    </div>
</div>
</body>
</html>
