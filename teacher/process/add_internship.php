<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $i_date = $_POST["i_date"];
        $i_start = $_POST["i_start"];
        $i_end = $_POST["i_end"];
        $i_detail = $_POST["i_detail"];
        $i_img1_detail = htmlspecialchars($_POST["i_img1_detail"]);
        $i_img2_detail = htmlspecialchars($_POST["i_img2_detail"]);
        $i_s_id = $_POST["i_s_id"];
        $i_week = $_POST["i_week"];
        $i_day = $_POST["i_day"];
        $s_student_id = $_POST["s_student_id"];
        $startTime = new DateTime($i_start);
        $endTime = new DateTime($i_end);

        $interval = $startTime->diff($endTime);
        $hours = $interval->h;
        $days_eng = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

        $allowed = array('png', 'jpeg', 'jpg', 'heic', "HEIC");
        $uploadDir = "../uploaded/internship_img/";
        $f = 'Image-Internship-';
        $f2 = 'Image-Internship2-';
        $br = '_';

        // ==========
        // จัดการรูปภาพ 1
        // ==========
        $fileName1 = "no_img.jpg";
        if (isset($_FILES['i_img1']) && $_FILES['i_img1']['error'] != UPLOAD_ERR_NO_FILE) {
            if (in_array($_FILES['i_img1']['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE])) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_size");
                exit();
            }
            if ($_FILES['i_img1']['error'] != UPLOAD_ERR_OK) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
                exit();
            }
            $ext = strtolower(pathinfo($_FILES['i_img1']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
                exit();
            }
            $fileName1 = $f.$i_week.$br.$i_day.$br.$i_s_id.$br.$s_student_id.'.'.$ext;
            $uploadFilePath1 = $uploadDir.$fileName1;
            if (!move_uploaded_file($_FILES['i_img1']['tmp_name'], $uploadFilePath1)) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
                exit();
            }
        }

        // ==========
        // จัดการรูปภาพ 2
        // ==========
        $fileName2 = "no_img.jpg";
        if (isset($_FILES['i_img2']) && $_FILES['i_img2']['error'] != UPLOAD_ERR_NO_FILE) {
            if (in_array($_FILES['i_img2']['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE])) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_size");
                exit();
            }
            if ($_FILES['i_img2']['error'] != UPLOAD_ERR_OK) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
                exit();
            }
            $ext2 = strtolower(pathinfo($_FILES['i_img2']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext2, $allowed)) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
                exit();
            }
            $fileName2 = $f2.$i_week.$br.$i_day.$br.$i_s_id.$br.$s_student_id.'.'.$ext2;
            $uploadFilePath2 = $uploadDir.$fileName2;
            if (!move_uploaded_file($_FILES['i_img2']['tmp_name'], $uploadFilePath2)) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
                exit();
            }
        }

        $sql = $conn->prepare("INSERT INTO internship (`i_id`,
        `i_img1`, `i_img2`,
        `i_img1_detail`, `i_img2_detail`,
        `i_date`, `i_detail`,
        `i_week`, `i_day`,
        `i_start`, `i_end`,
        `i_count` ,`i_s_id`)
        VALUES (NULL ,? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $sql->bind_param("ssssssisssii",
        $fileName1, $fileName2,
        $i_img1_detail, $i_img2_detail,
        $i_date, $i_detail,
        $i_week, $i_day,
        $i_start, $i_end,
        $hours, $i_s_id);
        if($sql->execute()){
            header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=success");
        }else{
            header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error");
        }
        exit();

    }else{
        header("Location:../index.php");
        exit();
    }


?>
