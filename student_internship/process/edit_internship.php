<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $i_id = $_POST["i_id"];
        $i_date = $_POST["i_date"];
        $i_start = $_POST["i_start"];
        $i_end = $_POST["i_end"];
        $i_detail = $_POST["i_detail"];
        $i_img1_detail = $_POST["i_img1_detail"];
        $i_img2_detail = $_POST["i_img2_detail"];
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
        $i_img1_file_name = $_FILES['i_img1']['name'];
        $i_img2_file_name = $_FILES['i_img2']['name'];

        if($i_img1_file_name == '' && $i_img2_file_name == ''){
            $sql = $conn->prepare("UPDATE internship SET 
            `i_img1_detail` = ?,
            `i_img2_detail` = ?,
            `i_date` = ?, 
            `i_detail` = ?, 
            `i_week` = ?, 
            `i_day` = ?, 
            `i_start` = ?, 
            `i_end` = ?,
            `i_count` = ?,
            `i_s_id` = ?
            WHERE `i_id` = ?");

            $sql->bind_param("ssssisssiii",
            $i_img1_detail, $i_img2_detail,
            $i_date, $i_detail, 
            $i_week, $i_day, 
            $i_start, $i_end,
            $hours, $i_s_id, $i_id);
            if($sql->execute()){
                header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=success");
            }else{
                header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error");
            }
        }elseif($i_img1_file_name == '' && $i_img2_file_name != ''){
            $ext2 = pathinfo($i_img2_file_name, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed) || !in_array($ext2, $allowed)) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
            }else{
               
                $f2 = 'Image-Internship2-';
                $br = '_';
              
                $temp2 = explode('.',$_FILES['i_img2']['name']);
                $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                $uploadDir = "../uploaded/internship_img/"; 
               
                $fileName2 = $f2.$i_week.$br.$i_day.$br.$i_s_id.$br.$s_student_id.'.'.end($temp2) ;
                
                $uploadFilePath2 = $uploadDir.$fileName2; 
               
                move_uploaded_file($_FILES['i_img2']['tmp_name'], $uploadFilePath2);    
    
                $sql = $conn->prepare("UPDATE internship SET 
                `i_img2` = ?, 
                `i_img1_detail` = ?,
                `i_img2_detail` = ?,
                `i_date` = ?, 
                `i_detail` = ?, 
                `i_week` = ?, 
                `i_day` = ?, 
                `i_start` = ?, 
                `i_end` = ?,
                `i_count` = ?,
                `i_s_id` = ?
                WHERE `i_id` = ?");
    
                $sql->bind_param("sssssisssiii",
                $fileName2,
                $i_img1_detail, $i_img2_detail,
                $i_date, $i_detail, 
                $i_week, $i_day, 
                $i_start, $i_end,
                $hours, $i_s_id, $i_id);
                if($sql->execute()){
                    header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=success");
                }else{
                    die("SQL execution failed: " . $sql->error);
                    echo($h);
                }      
    
            }
      

        }elseif($i_img1_file_name != '' && $i_img2_file_name == ''){
            $ext = pathinfo($i_img1_file_name, PATHINFO_EXTENSION);
          
            if (!in_array($ext, $allowed) || !in_array($ext2, $allowed)) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
            }else{
                $f = 'Image-Internship-';
                $br = '_';
                $temp1 = explode('.',$_FILES['i_img1']['name']);
               
                $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                $uploadDir = "../uploaded/internship_img/"; 
                $fileName1 = $f.$i_week.$br.$i_day.$br.$i_s_id.$br.$s_student_id.'.'.end($temp1) ;
               
                $uploadFilePath1 = $uploadDir.$fileName1; 
                move_uploaded_file($_FILES['i_img1']['tmp_name'], $uploadFilePath1);    
             
    
                $sql = $conn->prepare("UPDATE internship SET 
                `i_img1` = ?,
                `i_img1_detail` = ?,
                `i_img2_detail` = ?,  
                `i_date` = ?, 
                `i_detail` = ?, 
                `i_week` = ?, 
                `i_day` = ?, 
                `i_start` = ?, 
                `i_end` = ?,
                `i_count` = ?,
                `i_s_id` = ?
                WHERE `i_id` = ?");
    
                $sql->bind_param("ssssisssiii",
                $fileName1,
                $i_img1_detail, $i_img2_detail, 
                $i_date, $i_detail, 
                $i_week, $i_day, 
                $i_start, $i_end,
                $hours, $i_s_id, $i_id);
                if($sql->execute()){
                    header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=success");
                }else{
                    header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error");
                }         
    
            }

               
        }else{
            $ext = pathinfo($i_img1_file_name, PATHINFO_EXTENSION);
            $ext2 = pathinfo($i_img2_file_name, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed) || !in_array($ext2, $allowed)) {
                header("location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error_img");
            }else{
                $f = 'Image-Internship-';
                $f2 = 'Image-Internship2-';
                $br = '_';
                $n = '_new';
                $temp1 = explode('.',$_FILES['i_img1']['name']);
                $temp2 = explode('.',$_FILES['i_img2']['name']);
                $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                $uploadDir = "../uploaded/internship_img/";
                $fileName1 = $f.$i_week.$br.$i_day.$br.$i_s_id.$br.$s_student_id.'.'.end($temp1) ;
                $fileName2 = $f2.$i_week.$br.$i_day.$br.$i_s_id.$br.$s_student_id.'.'.end($temp2) ;
                $uploadFilePath1 = $uploadDir.$fileName1; 
                $uploadFilePath2 = $uploadDir.$fileName2; 
                move_uploaded_file($_FILES['i_img1']['tmp_name'], $uploadFilePath1);    
                move_uploaded_file($_FILES['i_img2']['tmp_name'], $uploadFilePath2);    
    
                $sql = $conn->prepare("UPDATE internship SET 
                `i_img1` = ?, 
                `i_img2` = ?,
                `i_img1_detail` = ?,
                `i_img2_detail` = ?,   
                `i_date` = ?, 
                `i_detail` = ?, 
                `i_week` = ?, 
                `i_day` = ?, 
                `i_start` = ?, 
                `i_end` = ?,
                `i_count` = ?,
                `i_s_id` = ?
                WHERE `i_id` = ?");
    
                $sql->bind_param("ssssssisssiii",
                $fileName1, $fileName2,
                $i_img1_detail, $i_img2_detail,
                $i_date, $i_detail, 
                $i_week, $i_day, 
                $i_start, $i_end,
                $hours, $i_s_id, $i_id);
                if($sql->execute()){
                    header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=success");
                }else{
                    header("Location:../internship_submission_daily.php?week=$i_week&day=$i_day&status=error");
                }
    
            }
        }

        

        
    }else{
        header("Location:../index.php");
    }


?>