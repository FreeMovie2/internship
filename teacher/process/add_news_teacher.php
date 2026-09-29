<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $n_name = $_POST['n_name'] ?? '-';
        $n_detail = $_POST['n_detail'];
        $n_author = $_POST['n_author'] ?? '-';
        $n_date = $_POST['n_date'] ?? '-';
        $n_pic = $_FILES['n_pic']['name'];

        if (in_array($_FILES['n_pic']['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE])) {
            header("location:../manage_news_teacher.php?status=error_size");
            exit();
        }

        if($n_pic == ""){
            $fileName1 = "default.pdf";
            $sql = $conn->prepare("INSERT INTO news_teacher (`n_id`,
                `n_name`, `n_date`, 
                `n_author`, `n_detail`,
                `n_pic`) 
                VALUES (NULL ,? ,? ,? ,? ,? )");
    
            $sql->bind_param("sssss",
            $n_name, $n_date,
            $n_author, $n_detail,
            $fileName1);
            if($sql->execute()){
                header("Location:../manage_news_teacher.php?status=success");
            }else{
                header("Location:../manage_news_teacher.php?status=error");
            }
            exit();

        }else{
            $allowed = array('png', 'jpeg', 'jpg', 'heic', "HEIC", "pdf");
            $ext = pathinfo($n_pic, PATHINFO_EXTENSION);

            if (!in_array($ext, $allowed)) {
                header("location:../manage_news_teacher.php?status=error_file");
                exit();
            }else{
                $f = 'Resource-File-';
                $br = '_';
                $temp1 = explode('.',$_FILES['n_pic']['name']);
                $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                $s = substr(str_shuffle(str_repeat($chars, 8)), 0, 8);
                $time =  date ('H:i:s');
                $uploadDir = "../uploaded/news_resources/";
                $authorSafe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $n_author);

                $fileName1 = $f.$br.$time.$br.$s.$br.$authorSafe.'.'.end($temp1) ;
                $uploadFilePath1 = $uploadDir.$fileName1;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
                }

                if (!move_uploaded_file($_FILES['n_pic']['tmp_name'], $uploadFilePath1)) {
                    header("location:../manage_news_teacher.php?status=error_file");
                    exit();
                }

                $sql = $conn->prepare("INSERT INTO news_teacher (`n_id`,
                `n_name`, `n_date`,
                `n_author`, `n_detail`,
                `n_pic`)
                VALUES (NULL ,? ,? ,? ,? ,? )");

                $sql->bind_param("sssss",
                $n_name, $n_date,
                $n_author, $n_detail,
                $fileName1);
                if($sql->execute()){
                    header("Location:../manage_news_teacher.php?status=success");
                }else{
                    header("Location:../manage_news_teacher.php?status=error");
                }
                exit();

            }
        }



    }else{
        header("Location:../index.php");
        exit();
    }


?>