<?php
// Kết nối cơ sở dữ liệu
include 'db.php';

try {
    // Lấy danh sách học phần đã đăng ký
    $stmt = $conn->prepare("
        SELECT dk.MaHP, hp.TenHP, hp.SoTinChi 
        FROM DangKy dk
        JOIN HocPhan hp ON dk.MaHP = hp.MaHP
    ");
    $stmt->execute();
    $dangKyList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý xóa một học phần
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $maHP = htmlspecialchars(trim($_GET['delete']));
        $stmt = $conn->prepare("DELETE FROM DangKy WHERE MaHP = :MaHP");
        $stmt->bindParam(':MaHP', $maHP);
        $stmt->execute();
        header("Location: danhsach.php"); // Quay về trang danh sách
        exit;
    }

    // Xử lý xóa toàn bộ đăng ký
    if (isset($_GET['clear_all']) && $_GET['clear_all'] === '1') {
        $stmt = $conn->prepare("DELETE FROM DangKy");
        $stmt->execute();
        header("Location: danhsach.php"); // Quay về trang danh sách
        exit;
    }

    // Tính tổng số học phần và tín chỉ
    $soHocPhan = count($dangKyList);
    $tongTinChi = array_sum(array_column($dangKyList, 'SoTinChi'));
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Đăng Ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Danh Sách Đăng Ký Học Phần</h2>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dangKyList as $dangKy): ?>
                    <tr>
                        <td><?= $dangKy['MaHP'] ?></td>
                        <td><?= $dangKy['TenHP'] ?></td>
                        <td><?= $dangKy['SoTinChi'] ?></td>
                        <td>
                            <a href="danhsach.php?delete=<?= $dangKy['MaHP'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="text-danger">Số học phần: <?= $soHocPhan ?></p>
        <p class="text-danger">Tổng số tín chỉ: <?= $tongTinChi ?></p>
        <a href="danhsach.php?clear_all=1" class="btn btn-danger">Xóa Đăng Ký</a>
        <a href="dangky.php" class="btn btn-primary">Lưu Đăng Ký</a>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</html>
