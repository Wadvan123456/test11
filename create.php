<?php
include 'db.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý upload hình ảnh
    $Hinh = '';
    if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
        $targetDir = "images/";
        $Hinh = $targetDir . basename($_FILES["Hinh"]["name"]);
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $Hinh);
    }

    // Thêm dữ liệu vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh]);

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
    <title>Thêm Sinh Viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">THÊM SINH VIÊN</h1>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="MaSV" class="form-label">MaSV</label>
                <input type="text" class="form-control" id="MaSV" name="MaSV" required>
            </div>
            <div class="mb-3">
                <label for="HoTen" class="form-label">HoTen</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" required>
            </div>
            <div class="mb-3">
                <label for="GioiTinh" class="form-label">GioiTinh</label>
                <input type="text" class="form-control" id="GioiTinh" name="GioiTinh" required>
            </div>
            <div class="mb-3">
                <label for="NgaySinh" class="form-label">NgaySinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required>
            </div>
            <div class="mb-3">
                <label for="Hinh" class="form-label">Hinh</label>
                <input type="file" class="form-control" id="Hinh" name="Hinh" required>
            </div>
            <div class="mb-3">
                <label for="MaNganh" class="form-label">MaNganh</label>
                <input type="text" class="form-control" id="MaNganh" name="MaNganh" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>
