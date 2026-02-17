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
        $s_line_id = htmlspecialchars($_POST['s_line_id'] ?? '');
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
        $subject_codes = $_POST['subject_code'] ?? [];
        $subject_names = $_POST['subject_name'] ?? [];

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
            s_line_id = ?,
            s_email = ?,
            s_special = ?,
            s_pic = ?,
            s_update_information = ?
            WHERE s_id = ?");

            $sql_student->bind_param("ssssssssssssssi", 
                $s_prefix, $s_name, $s_surname, $s_year, $s_student_id, 
                $s_type_edu, $s_major, $s_grade, $s_tel, $s_line_id, $s_email, 
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
                    // Some production DBs may not have this table yet.
                    $subject_table_exists = false;
                    $check_subject_table = $conn->query("SHOW TABLES LIKE 'student_internship_subjects'");
                    if ($check_subject_table && $check_subject_table->num_rows > 0) {
                        $subject_table_exists = true;
                    }

                    if ($subject_table_exists) {
                        $delete_subjects = $conn->prepare("DELETE FROM student_internship_subjects WHERE s_id = ?");
                        if ($delete_subjects) {
                            $delete_subjects->bind_param("s", $s_id);
                            $delete_subjects->execute();
                        }

                        $insert_subject = $conn->prepare("INSERT INTO student_internship_subjects (s_id, subject_code, subject_name, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                        if ($insert_subject) {
                            $subject_count = max(count($subject_codes), count($subject_names));
                            for ($i = 0; $i < $subject_count; $i++) {
                                $subject_code = trim((string)($subject_codes[$i] ?? ""));
                                $subject_name = trim((string)($subject_names[$i] ?? ""));
                                if ($subject_code === "" && $subject_name === "") {
                                    continue;
                                }

                                $insert_subject->bind_param("sss", $s_id, $subject_code, $subject_name);
                                $insert_subject->execute();
                            }
                        }
                    }

                    header("Location:../edit_information.php?student_id=$s_id&status=success");
                }else{
                    header("Location:../edit_information.php?student_id=$s_id&status=error");
                }

            }else{
                header("Location:../edit_information.php?student_id=$s_id&status=error");
            }
        }
        





    }else{
        header("Location:../index.php");
    }

?>
