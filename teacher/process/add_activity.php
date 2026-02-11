<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $a_purpose1 = $_POST['a_purpose1'] ?? '-';
        $a_purpose2 = $_POST['a_purpose2'] ?? '-';
        $a_purpose3 = $_POST['a_purpose3'] ?? '-';
        $a_purpose4 = $_POST['a_purpose4'] ?? '-';
        $a_purpose5 = $_POST['a_purpose5'] ?? '-';
        $a_purpose6 = $_POST['a_purpose6'] ?? '-';
        $a_purpose7 = $_POST['a_purpose7'] ?? '-';
        $a_purpose8 = $_POST['a_purpose8'] ?? '-';
        $a_purpose9 = $_POST['a_purpose9'] ?? '-';
        $a_purpose10 = $_POST['a_purpose10'] ?? '-';
        $split = ",";
        $a_purpose = $a_purpose1.$split.$a_purpose2.$split.$a_purpose3.$split.$a_purpose4.$split.$a_purpose5.$split.$a_purpose6.$split.$a_purpose7.$split.$a_purpose8.$split.$a_purpose9.$split.$a_purpose10;
        $a_name = htmlspecialchars($_POST['a_name'] ?? '');
        $a_date = htmlspecialchars($_POST['a_date'] ?? '');
        $a_place = htmlspecialchars($_POST['a_place'] ?? '');
        $a_detail = htmlspecialchars($_POST['a_detail'] ?? '');
        $a_count = htmlspecialchars($_POST['a_count'] ?? 'starter');
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
        $s_student_id = htmlspecialchars($_POST['s_student_id'] ?? '');
        $a_img_file_name = $_FILES['a_img']['name'];
        $count_0 = 0;

        $allowed = array('png', 'jpeg', 'jpg', 'heic', "HEIC"); 
        $ext = pathinfo($a_img_file_name, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            header("location:../activity.php?status=error_img");
        }else{
            $f = 'Image-Activity-';
            $br = '_';
            $temp1 = explode('.',$_FILES['a_img']['name']);
            $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            $s = substr(str_shuffle(str_repeat($chars, 8)), 0, 8);
            $time =  date ('H:i:s');
            $uploadDir = "../uploaded/activity_img/"; 
           
           

            $fileName1 = $f.$br.$time.$br.$s.$br.$s_id.$br.$s_student_id.'.'.end($temp1) ;
            $uploadFilePath1 = $uploadDir.$fileName1; 

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
            }

            move_uploaded_file($_FILES['a_img']['tmp_name'], $uploadFilePath1);     

            $sql = $conn->prepare("INSERT INTO activity (`a_id`,
            `a_purpose`, `a_name`, 
            `a_date`, `a_place`,
            `a_detail`, `a_img`, 
            `s_id`) 
            VALUES (NULL ,? ,? ,? ,? ,? ,? ,?)");

            $sql->bind_param("ssssssi",
            $a_purpose, $a_name,
            $a_date, $a_place,
            $a_detail, $fileName1, 
            $s_id);
            if($sql->execute()){
                header("Location:../activity.php?status=success");
            }else{
                die("SQL execution failed: " . $sql->error);
                echo($h);
            }

        }
        
    }else{
        header("Location:../index.php");
    }


?>