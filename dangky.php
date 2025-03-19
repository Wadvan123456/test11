<?php
// Kết nối cơ sở dữ liệu
include 'db.php';

$message = '';

try {
    // Lấy danh sách sinh viên
    $stmt = $conn->prepare("SELECT MaSV, HoTen FROM SinhVien");
    $stmt->execute();
    $sinhVienList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Lấy danh sách học phần
    $stmt = $conn->prepare("SELECT MaHP, TenHP FROM HocPhan");
    $stmt->execute();
    $hocPhanList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý khi gửi form đăng ký
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form và dọn dẹp giá trị đầu vào
        $maSV = htmlspecialchars(trim($_POST['MaSV']));
        $maHP = htmlspecialchars(trim($_POST['MaHP']));

        // Kiểm tra các trường dữ liệu không để trống
        if (!empty($maSV) && !empty($maHP)) {
            // Kiểm tra sinh viên đã đăng ký học phần chưa
            $stmt = $conn->prepare("SELECT * FROM DangKy WHERE MaSV = :MaSV AND MaHP = :MaHP");
            $stmt->bindParam(':MaSV', $maSV);
            $stmt->bindParam(':MaHP', $maHP);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $message = "⚠️ Sinh viên đã đăng ký học phần này!";
            } else {
                // Thêm vào bảng đăng ký
                $stmt = $conn->prepare("INSERT INTO DangKy (MaSV, MaHP) VALUES (:MaSV, :MaHP)");
                $stmt->bindParam(':MaSV', $maSV);
                $stmt->bindParam(':MaHP', $maHP);
                $stmt->execute();

                // Chuyển hướng về trang danh sách
                header("Location: danhsach.php");
                exit; // Dừng xử lý sau khi chuyển hướng
            }
        } else {
            $message = "⚠️ Vui lòng chọn sinh viên và học phần!";
        }
    }
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Học Phần</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Đăng Ký Học Phần</h2>

        <!-- Hiển thị thông báo -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"><?= $message ?></div>
        <?php endif; ?>

        <!-- Form Đăng Ký -->
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="MaSV" class="form-label">Sinh Viên</label>
                <select name="MaSV" id="MaSV" class="form-select" required>
                    <option value="">-- Chọn Sinh Viên --</option>
                    <?php foreach ($sinhVienList as $sinhVien): ?>
                        <option value="<?= $sinhVien['MaSV'] ?>"><?= $sinhVien['HoTen'] ?> (<?= $sinhVien['MaSV'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="MaHP" class="form-label">Học Phần</label>
                <select name="MaHP" id="MaHP" class="form-select" required>
                    <option value="">-- Chọn Học Phần --</option>
                    <?php foreach ($hocPhanList as $hocPhan): ?>
                        <option value="<?= $hocPhan['MaHP'] ?>"><?= $hocPhan['TenHP'] ?> (<?= $hocPhan['MaHP'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
            <a href="sinhvien.php" class="btn btn-secondary w-100 mt-2">Trở Về</a>
        </form>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</html>
