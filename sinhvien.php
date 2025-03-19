<?php
// Kết nối cơ sở dữ liệu
include 'db.php';

try {
    // Lấy danh sách sinh viên từ bảng SinhVien
    $stmt = $conn->prepare("SELECT MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh FROM SinhVien");
    $stmt->execute();
    $sinhVienList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sinh Viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        img {
            width: 100px;
            height: auto;
            object-fit: cover;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="text-center">Quản Lý Sinh Viên</h1>
        </div>
    </header>

    <!-- Thanh Điều Hướng -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Trang Chủ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="sinhvien.php">Sinh Viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hocphan.php">Học Phần</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dangky.php">Đăng Ký</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dangnhap.php">Đăng Nhập</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <div class="container mt-4">
        <h2 class="text-center">Danh Sách Sinh Viên</h2>
        <a href="create.php" class="btn btn-primary mb-3">Thêm Sinh Viên</a>

        <?php if (empty($sinhVienList)): ?>
            <p class="no-data">Không có dữ liệu sinh viên.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Mã Sinh Viên</th>
                        <th>Họ Tên</th>
                        <th>Giới Tính</th>
                        <th>Ngày Sinh</th>
                        <th>Hình Ảnh</th>
                        <th>Mã Ngành</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sinhVienList as $sinhVien): ?>
                    <tr>
                        <td><?= htmlspecialchars($sinhVien['MaSV']) ?></td>
                        <td><?= htmlspecialchars($sinhVien['HoTen']) ?></td>
                        <td><?= htmlspecialchars($sinhVien['GioiTinh']) ?></td>
                        <td><?= date("d/m/Y", strtotime($sinhVien['NgaySinh'])) ?></td>
                        <td>
                            <?php if (!empty($sinhVien['Hinh'])): ?>
                                <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình ảnh">
                            <?php else: ?>
                                <span>Không có hình</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($sinhVien['MaNganh']) ?></td>
                        <td>
                            <a href="details.php?MaSV=<?= urlencode($sinhVien['MaSV']) ?>" class="btn btn-info btn-sm">Chi Tiết</a>
                            <a href="edit.php?MaSV=<?= urlencode($sinhVien['MaSV']) ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="delete.php?MaSV=<?= urlencode($sinhVien['MaSV']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
