<?php
include 'db.php';

// Lấy MaSV từ URL
$MaSV = $_GET['MaSV'];

// Lấy thông tin sinh viên từ CSDL
$stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
$stmt->execute([$MaSV]);
$sinhVien = $stmt->fetch();

if (!$sinhVien) {
    echo "Sinh viên không tồn tại!";
    exit();
}

// Xử lý khi nhấn nút xác nhận xóa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xóa bản ghi trong CSDL
    $stmt = $conn->prepare("DELETE FROM SinhVien WHERE MaSV = ?");
    $stmt->execute([$MaSV]);

    // Xóa hình ảnh khỏi thư mục nếu tồn tại
    if (!empty($sinhVien['Hinh']) && file_exists($sinhVien['Hinh'])) {
        unlink($sinhVien['Hinh']);
    }

    // Chuyển hướng về trang danh sách sinh viên
    header("Location: sinhvien.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa Sinh Viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">XÓA THÔNG TIN</h1>
        <p class="text-center">Are you sure you want to delete this?</p>
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <p><strong>Họ Tên:</strong> <?= htmlspecialchars($sinhVien['HoTen']) ?></p>
                <p><strong>Giới Tính:</strong> <?= htmlspecialchars($sinhVien['GioiTinh']) ?></p>
                <p><strong>Ngày Sinh:</strong> <?= htmlspecialchars($sinhVien['NgaySinh']) ?></p>
                <p><strong>Hình:</strong></p>
                <?php if (!empty($sinhVien['Hinh'])): ?>
                    <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình Sinh Viên" class="img-thumbnail" width="200">
                <?php else: ?>
                    <p>Không có hình</p>
                <?php endif; ?>
                <p><strong>Mã Ngành:</strong> <?= htmlspecialchars($sinhVien['MaNganh']) ?></p>
            </div>
            <div class="card-footer text-center">
                <form action="delete.php?MaSV=<?= htmlspecialchars($MaSV) ?>" method="POST">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a href="index.php" class="btn btn-secondary">Back to List</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
