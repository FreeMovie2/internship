<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $n_id = $_POST['n_id'] ?? '-';
        $n_name = $_POST['n_name'] ?? '-';
        $n_detail = $_POST['n_detail'];
        $n_author = $_POST['n_author'] ?? '-';
        $n_date = $_POST['n_date'] ?? '-';
        $n_pic = $_FILES['n_pic']['name'];

        if($n_pic == ""){
            $sql_news = $conn->prepare("SELECT * FROM news WHERE n_id = ?");
            $sql_news->bind_param("s", $n_id);
            $sql_news->execute();
            $result_news = $sql_news->get_result(); 
            $fetch_news = $result_news->fetch_assoc();

            if($fetch_news['n_pic'] == "default.php"){
                $fileName1 = "default.pdf";
                $sql = $conn->prepare("UPDATE news SET
                    n_name  = ?,
                    n_detail = ?,
                    n_author = ?,
                    n_date = ?,
                    n_pic = ?
                WHERE n_id = ?");
        
                $sql->bind_param("sssssi",
                $n_name, $n_detail,
                $n_author, $n_date,
                $n_pic, $n_id);
                if($sql->execute()){
                    header("Location:../manage_news_student.php?status=success");
                }else{
                    die("SQL execution failed: " . $sql->error);
                    echo($h);
                }
            }else{
                $fileName1 = $fetch_news['n_pic'];
                $sql = $conn->prepare("UPDATE news SET
                    n_name  = ?,
                    n_detail = ?,
                    n_author = ?,
                    n_date = ?,
                    n_pic = ?
                WHERE n_id = ?");
        
                $sql->bind_param("sssssi",
                $n_name, $n_detail,
                $n_author, $n_date,
                $n_pic, $n_id);
                if($sql->execute()){
                    header("Location:../manage_news_student.php?status=success");
                }else{
                    die("SQL execution failed: " . $sql->error);
                    echo($h);
                }
            }


    
        }else{
            $allowed = array('png', 'jpeg', 'jpg', 'heic', "HEIC", "pdf"); 
            $ext = pathinfo($n_pic, PATHINFO_EXTENSION);
    
            if (!in_array($ext, $allowed)) {
                header("location:../manage_news_student.php?status=error_file");
            }else{
                $f = 'Resource-File-';
                $br = '_';
                $temp1 = explode('.',$_FILES['n_pic']['name']);
                $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                $s = substr(str_shuffle(str_repeat($chars, 8)), 0, 8);
                $time =  date ('H:i:s');
                $uploadDir = "../../student_internship/uploaded/news_resources/"; 
               
                $fileName1 = $f.$br.$time.$br.$s.$br.$n_author.'.'.end($temp1) ;
                $uploadFilePath1 = $uploadDir.$fileName1; 
    
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
                }
    
                move_uploaded_file($_FILES['n_pic']['tmp_name'], $uploadFilePath1);     
    
                $sql = $conn->prepare("UPDATE news SET
                n_name  = ?,
                n_detail = ?,
                n_author = ?,
                n_date = ?,
                n_pic = ?
                WHERE n_id = ?");
    
                $sql->bind_param("sssssi",
                $n_name, $n_detail,
                $n_author, $n_date,
                $n_pic, $n_id);

                if($sql->execute()){
                    header("Location:../manage_news_student.php?status=success");
                }else{
                    die("SQL execution failed: " . $sql->error);
                    echo($h);
                }
    
            }
        }


        
    }else{
        header("Location:../index.php");
    }


?>