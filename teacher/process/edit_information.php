<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $uploadDir = "../../student_internship/information_file/profile/"; 
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
        $s_prefix = htmlspecialchars($_POST['s_prefix'] ?? '');
        $s_name = htmlspecialchars($_POST['s_name'] ?? '');
        $s_surname = htmlspecialchars($_POST['s_surname'] ?? '');
        $s_year = htmlspecialchars($_POST['s_year'] ?? '');
        $s_student_id = htmlspecialchars($_POST['s_student_id'] ?? '');
        $s_type_edu = htmlspecialchars($_POST['s_type_edu'] ?? '');
        $s_major = htmlspecialchars($_POST['s_major'] ?? '');
        $s_grade = htmlspecialchars($_POST['s_grade'] ?? '');
        $s_birthday = htmlspecialchars($_POST['s_birthday'] ?? '');
        $s_age = htmlspecialchars($_POST['s_age'] ?? '');
        $s_height = htmlspecialchars($_POST['s_height'] ?? '');
        $s_weight = htmlspecialchars($_POST['s_weight'] ?? '');
        $s_nation1 = htmlspecialchars($_POST['s_nation1'] ?? '');
        $s_nation2 = htmlspecialchars($_POST['s_nation2'] ?? '');
        $s_region = htmlspecialchars($_POST['s_region'] ?? '');
        $s_hospital = htmlspecialchars($_POST['s_hospital'] ?? '');
        $s_medicine = htmlspecialchars($_POST['s_medicine'] ?? '');
        $s_blood = htmlspecialchars($_POST['s_blood'] ?? '');
        $s_tel = htmlspecialchars($_POST['s_tel'] ?? '');
        $s_email = htmlspecialchars($_POST['s_email'] ?? '');
        $specials = [];
        for ($i = 0; isset($_POST["s_special$i"]); $i++) {
            $specials[] = htmlspecialchars($_POST["s_special$i"] ?? '');
        }

        $s_special = implode(",", $specials);
        $s_home1 = htmlspecialchars($_POST['s_home1'] ?? '');
        $s_moo1 = htmlspecialchars($_POST['s_moo1'] ?? '');
        $s_soi1 = htmlspecialchars($_POST['s_soi1'] ?? '');
        $s_road1 = htmlspecialchars($_POST['s_road1'] ?? '');
        $s_province1 = htmlspecialchars($_POST['s_province1'] ?? '');
        $s_aumpher1 = htmlspecialchars($_POST['s_aumpher1'] ?? '');
        $s_tumbon1 = htmlspecialchars($_POST['s_tumbon1'] ?? '');
        $s_home2 = htmlspecialchars($_POST['s_home2'] ?? '');
        $s_moo2 = htmlspecialchars($_POST['s_moo2'] ?? '');
        $s_soi2 = htmlspecialchars($_POST['s_soi2'] ?? '');
        $s_road2 = htmlspecialchars($_POST['s_road2'] ?? '');
        $s_province2 = htmlspecialchars($_POST['s_province2'] ?? '');
        $s_aumpher2 = htmlspecialchars($_POST['s_aumpher2'] ?? '');
        $s_tumbon2 = htmlspecialchars($_POST['s_tumbon2'] ?? '');
        $s_update_information = "Y";

        $sql_student_2  = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
        $sql_student_2->bind_param("s", $s_id);
        $sql_student_2->execute();
        $result_student_2 = $sql_student_2->get_result();
        $fetch_student = $result_student_2->fetch_assoc();

        $s_pic = $_FILES['s_pic']['name'];

        
        

        if($s_pic != ""){
            $s_pic = $_FILES['s_pic']['name'];
            if (is_file($uploadDir.$fetch_student["s_pic"])){
                unlink($uploadDir.$fetch_student["s_pic"]);
            }else{
                $s_pic = $_FILES['s_pic']['name'];;
            }
        }else{
            $s_pic = $fetch_student["s_pic"];
        }

        $allowed = array('png', 'jpeg', 'jpg', 'heic', "HEIC"); 
        $ext = pathinfo($s_pic, PATHINFO_EXTENSION);

        if(!in_array($ext, $allowed)){
            header("location:../edit_information.php?student_id=$s_id&status=error_img");
        }else{
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
            }
            $f1 = 'Image-profile-';
            $temp1 = explode('.',$s_pic);
            
            $fileName1 = $f1.$s_id.'.'.end($temp1);
            $uploadFilePath1 = $uploadDir.$fileName1; 
            
            move_uploaded_file($_FILES['s_pic']['tmp_name'], $uploadFilePath1);





            $sql_student = $conn->prepare("UPDATE students SET 
            s_prefix = ?, 
            s_name = ?,
            s_surname = ?, 
            s_year = ?, 
            s_student_id = ?, 
            s_type_edu = ?,
            s_major = ?, 
            s_grade = ?,
            s_tel = ?, 
            s_email = ?,
            s_special = ?,
            s_pic = ?,
            s_update_information = ?
            WHERE s_id = ?");

            $sql_student->bind_param("sssssssssssssi", 
                $s_prefix, $s_name, $s_surname, $s_year, $s_student_id, 
                $s_type_edu, $s_major, $s_grade, $s_tel, $s_email, 
                $s_special, $fileName1, $s_update_information, $s_id);
            
                
            if($sql_student->execute()){
                $sql_student_information = $conn->prepare("UPDATE student_information SET 
                s_birthday = ?, 
                s_age = ?, 
                s_height = ?, 
                s_weight = ?, 
                s_nation1 = ?, 
                s_nation2 = ?, 
                s_region = ?, 
                s_hospital = ?, 
                s_medicine = ?, 
                s_blood = ?, 
                s_home1 = ?, 
                s_moo1 = ?, 
                s_soi1 = ?, 
                s_road1 = ?, 
                s_province1 = ?, 
                s_aumpher1 = ?, 
                s_tumbon1 = ?, 
                s_home2 = ?, 
                s_moo2 = ?, 
                s_soi2 = ?, 
                s_road2 = ?, 
                s_province2 = ?, 
                s_aumpher2 = ?, 
                s_tumbon2 = ?
                WHERE s_id = ?");
        
                $sql_student_information->bind_param("ssssssssssssssssssssssssi",
                    $s_birthday, 
                    $s_age,
                    $s_height, 
                    $s_weight,
                    $s_nation1,
                    $s_nation2,
                    $s_region,
                    $s_hospital,
                    $s_medicine,
                    $s_blood,
                    $s_home1,
                    $s_moo1,
                    $s_soi1,
                    $s_road1,
                    $s_province1,
                    $s_aumpher1,
                    $s_tumbon1,
                    $s_home2,
                    $s_moo2,
                    $s_soi2,
                    $s_road2,
                    $s_province2,
                    $s_aumpher2,
                    $s_tumbon2,
                    $s_id);
                    
                if($sql_student_information->execute()){
                    header("Location:../edit_information.php?student_id=$s_id&status=success");
                }else{
                    die("SQL execution failed 2: " . $sql_student_information->error);
                    echo($h);
                }

            }else{
                die("SQL execution failed 1: " . $sql_student->error);
                echo($h);
            }
        }
        





    }else{
        header("Location:../index.php");
    }

?>