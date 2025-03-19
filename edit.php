<?php
include 'db.php';

// Lấy dữ liệu sinh viên theo MaSV
$MaSV = $_GET['MaSV'];
$stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
$stmt->execute([$MaSV]);
$sinhVien = $stmt->fetch();

if (!$sinhVien) {
    echo "Sinh viên không tồn tại!";
    exit();
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý upload hình ảnh
    $Hinh = $sinhVien['Hinh'];
    if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
        $targetDir = "images/";
        $Hinh = $targetDir . basename($_FILES["Hinh"]["name"]);
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $Hinh);
    }

    // Cập nhật dữ liệu
    $stmt = $conn->prepare("UPDATE SinhVien SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? WHERE MaSV = ?");
    $stmt->execute([$HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh, $MaSV]);

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
    <title>Chỉnh Sửa Sinh Viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">CHỈNH SỬA SINH VIÊN</h1>
        <form action="edit.php?MaSV=<?= htmlspecialchars($MaSV) ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="HoTen" class="form-label">HoTen</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?= htmlspecialchars($sinhVien['HoTen']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="GioiTinh" class="form-label">GioiTinh</label>
                <input type="text" class="form-control" id="GioiTinh" name="GioiTinh" value="<?= htmlspecialchars($sinhVien['GioiTinh']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="NgaySinh" class="form-label">NgaySinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?= htmlspecialchars($sinhVien['NgaySinh']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="Hinh" class="form-label">Hinh</label>
                <input type="file" class="form-control" id="Hinh" name="Hinh">
                <?php if (!empty($sinhVien['Hinh'])): ?>
                    <img src="<?= htmlspecialchars($sinhVien['Hinh']) ?>" alt="Hình hiện tại" class="img-thumbnail mt-2" width="150">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="MaNganh" class="form-label">MaNganh</label>
                <input type="text" class="form-control" id="MaNganh" name="MaNganh" value="<?= htmlspecialchars($sinhVien['MaNganh']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>
