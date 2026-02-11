<?php
session_start();
include("../connect/connect.php");

if (!isset($_POST['submit'])) {
    header("Location:../index.php");
    exit;
}

// รวม a_purpose1..10
$a_purpose_arr = [];
for ($i = 1; $i <= 10; $i++) {
    $a_purpose_arr[] = $_POST['a_purpose'.$i] ?? '-';
}
$a_purpose = implode(",", $a_purpose_arr);

// รับค่าฟอร์มอื่น ๆ
$a_name       = htmlspecialchars($_POST['a_name'] ?? '');
$a_id         = intval($_POST['a_id'] ?? 0);
$a_date       = htmlspecialchars($_POST['a_date'] ?? '');
$a_place      = htmlspecialchars($_POST['a_place'] ?? '');
$a_detail     = htmlspecialchars($_POST['a_detail'] ?? '');
$a_count      = htmlspecialchars($_POST['a_count'] ?? '');
$s_id         = intval($_POST['s_id'] ?? 0);
$s_student_id = htmlspecialchars($_POST['s_student_id'] ?? '');

// ตรวจสอบไฟล์อัปโหลด
$a_img_file_name = $_FILES['a_img']['name'] ?? '';

if (empty($a_img_file_name)) {
    // ไม่มีการอัปโหลดรูป
    $sql = $conn->prepare("UPDATE activity SET
        a_purpose = ?, 
        a_name = ?, 
        a_date = ?, 
        a_place = ?,
        a_detail = ?,
        s_id = ?
        WHERE a_id = ?");
    $sql->bind_param("sssssii", $a_purpose, $a_name, $a_date, $a_place, $a_detail, $s_id, $a_id);
} else {
    // อัปโหลดรูป
    $allowed = ['png','jpeg','jpg','heic'];
    $ext = strtolower(pathinfo($a_img_file_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        header("Location:../activity.php?status=error_img");
        exit;
    }

    $uploadDir = "../uploaded/activity_img/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $randomStr = substr(str_shuffle(str_repeat($chars, 8)), 0, 8);
    $time = date('His'); // ใช้ His แทน H:i:s เพื่อไม่ให้มี :
    $fileName1 = "Image-Activity_{$time}_{$randomStr}_{$s_id}_{$s_student_id}.{$ext}";
    $uploadFilePath1 = $uploadDir . $fileName1;

    if (!move_uploaded_file($_FILES['a_img']['tmp_name'], $uploadFilePath1)) {
        header("Location:../activity.php?status=upload_fail");
        exit;
    }

    $sql = $conn->prepare("UPDATE activity SET
        a_purpose = ?, 
        a_name = ?, 
        a_date = ?, 
        a_place = ?,
        a_detail = ?,
        a_img = ?,
        s_id = ?
        WHERE a_id = ?");
    $sql->bind_param("ssssssii", $a_purpose, $a_name, $a_date, $a_place, $a_detail, $fileName1, $s_id, $a_id);
}

// รันคำสั่ง SQL
if ($sql->execute()) {
    header("Location:../activity.php?status=success");
} else {
    header("Location:../activity.php?status=error");
}
exit;
?>
