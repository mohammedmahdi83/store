<?php
session_start();
require_once "db_connection.php"; // الاتصال بقاعدة البيانات

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // تحقق من تعبئة الحقول
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "جميع الحقول مطلوبة.";
    }

    // تحقق من صحة البريد الإلكتروني
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "البريد الإلكتروني غير صالح.";
    }

    // تحقق من طول كلمة المرور
    if (strlen($password) < 6) {
        $errors[] = "كلمة المرور يجب أن تكون 6 أحرف أو أكثر.";
    }

    // تطابق كلمة المرور
    if ($password !== $confirm_password) {
        $errors[] = "كلمتا المرور غير متطابقتين.";
    }

    // التحقق من أن البريد الإلكتروني غير مستخدم
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "هذا البريد الإلكتروني مستخدم بالفعل.";
    }

    // إذا لم توجد أخطاء، قم بإضافة المستخدم
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user'; // تعيين الدور الافتراضي للمستخدم

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            $success = "تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.";
        } else {
            $errors[] = "حدث خطأ أثناء إنشاء الحساب.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل حساب جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">تسجيل حساب جديد</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): echo "<p>$error</p>"; endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php">
        <div class="mb-3">
            <label class="form-label">اسم المستخدم</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($username ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">تأكيد كلمة المرور</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">إنشاء حساب</button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php">لديك حساب؟ تسجيل الدخول</a>
    </div>
</div>
</body>
</html>
