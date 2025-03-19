<?php
// Kết nối cơ sở dữ liệu
include 'db.php';

try {
    // Lấy danh sách học phần từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT MaHP, TenHP, SoTinChi FROM HocPhan");
    $stmt->execute();
    $hocPhanList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Học Phần</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table img {
            width: 100px;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="text-center">Danh Sách Học Phần</h1>
        </div>
    </header>

    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Test1</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="sinhvien.php">Sinh Viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="hocphan.php">Học Phần</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dangky.php">Đăng Ký</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Đăng Nhập</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nội dung -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Danh Sách Học Phần</h2>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocPhanList as $hocPhan): ?>
                <tr>
                    <td><?= htmlspecialchars($hocPhan['MaHP']) ?></td>
                    <td><?= htmlspecialchars($hocPhan['TenHP']) ?></td>
                    <td><?= htmlspecialchars($hocPhan['SoTinChi']) ?></td>
                    <td>
                        <a href="dangky.php?MaHP=<?= $hocPhan['MaHP'] ?>" class="btn btn-success btn-sm">Đăng Ký</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

 
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</html>
