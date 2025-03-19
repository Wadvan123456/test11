<?php
// Kết nối cơ sở dữ liệu
include 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maSV = $_POST['MaSV'];

    // Kiểm tra MaSV trong cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV = :MaSV");
    $stmt->bindParam(':MaSV', $maSV);
    $stmt->execute();
    $sinhVien = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($sinhVien) {
        // Nếu tồn tại sinh viên, chuyển hướng đến trang chính
        header("Location: sinhvien.php");
        exit;
    } else {
        // Nếu không tồn tại sinh viên, hiển thị thông báo lỗi
        $message = "Mã sinh viên không hợp lệ!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">ĐĂNG NHẬP</h2>

        <!-- Hiển thị thông báo -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>

        <!-- Form Đăng Nhập -->
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="MaSV" class="form-label">MaSV</label>
                <input type="text" name="MaSV" id="MaSV" class="form-control" placeholder="Nhập mã sinh viên" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        </form>
        <a href="sinhvien.php" class="btn btn-link">Back to List</a>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</html>
