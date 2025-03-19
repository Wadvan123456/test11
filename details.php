<?php
include 'db.php';

// Lấy MaSV từ URL
$MaSV = $_GET['MaSV'];

// Lấy thông tin sinh viên từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
$stmt->execute([$MaSV]);
$sinhVien = $stmt->fetch();

if (!$sinhVien) {
    echo "Sinh viên không tồn tại!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Thông tin chi tiết</h1>
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title text-center">Sinh Viên</h5>
                <table class="table">
                    <tr>
                        <th>Họ Tên</th>
                        <td><?= htmlspecialchars($sinhVien['HoTen']) ?></td>
                    </tr>
                    <tr>
                        <th>Giới Tính</th>
                        <td><?= htmlspecialchars($sinhVien['GioiTinh']) ?></td>
                    </tr>
                    <tr>
                        <th>Ngày Sinh</th>
                        <td><?= htmlspecialchars($sinhVien['NgaySinh']) ?></td>
                    </tr>
                    <tr>
                        <th>Hình</th>
                        <td>
                            <?php if (!empty($sinhVien['Hinh'])): ?>
                                <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình Sinh Viên" class="img-thumbnail" width="200">
                            <?php else: ?>
                                <p>Không có hình</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Mã Ngành</th>
                        <td><?= htmlspecialchars($sinhVien['MaNganh']) ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="sinhvien.php" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html>
