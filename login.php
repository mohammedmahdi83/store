<?php
session_start();
require_once "db_connection.php"; // تأكد من وجود ملف يحتوي على بيانات الاتصال بقاعدة البيانات

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // التحقق من المدخلات
    if (empty($email) || empty($password)) {
        $errors[] = "جميع الحقول مطلوبة.";
    } else {
        // الاستعلام من قاعدة البيانات
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // تحقق من كلمة المرور
            if (password_verify($password, $user['password'])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "كلمة المرور غير صحيحة.";
            }
        } else {
            $errors[] = "لا يوجد حساب بهذا البريد الإلكتروني.";
        }
    }
}
?>
<?php

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">
    <?php if (!empty($message)): ?>
    <div class="alert alert-info text-center"><?= $message ?></div>
<?php endif; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">تسجيل الدخول</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): echo "<p>$error</p>"; endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" class="form-control" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
    </form>
</div>
</body>
</html>
