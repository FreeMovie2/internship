<?php
    session_start();
    include("../connect/connect.php");

    if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // รับค่าจากฟอร์ม
        $s_student_id = $conn->real_escape_string($_POST['s_student_id']); // เลขประจำตัว
        $s_prefix = $conn->real_escape_string($_POST['s_prefix']);        // คำนำหน้าชื่อ
        $s_name = $conn->real_escape_string($_POST['s_name']);            // ชื่อ
        $s_surname = $conn->real_escape_string($_POST['s_surname']);      // นามสกุล
        $s_year = $conn->real_escape_string($_POST['s_year']);            // ระดับชั้น
        $s_username = $conn->real_escape_string($_POST['s_username']);    // Username
        $s_password = $conn->real_escape_string($_POST['s_password']);    // Password
        $s_type_edu = '';           // ประเภทการศึกษา (ตัวอย่าง: ว่าง)
        $s_major = '';              // สาขา
        $s_grade = '';              // เกรด
        $s_tel = '';                // เบอร์โทร
        $s_email = '';              // อีเมล
        $s_special = '-,-,-';       // ค่าพิเศษ
        $s_pic = '';                // รูปภาพ
        $s_update_information = 'N';// อัพเดตข้อมูล (สถานะ N)
        $s_last_login = '';         // ข้อมูลล็อกอินล่าสุด

        // ตรวจสอบว่ามีนักเรียนที่มีเลขประจำตัวนี้อยู่ในระบบหรือไม่
        $sql_check = "SELECT COUNT(*) as count FROM students WHERE s_student_id = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $s_student_id);
            $stmt_check->execute();
            $stmt_check->bind_result($count);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($count > 0) {
                // ถ้าเลขประจำตัวซ้ำ
                header("Location: ../manage_student.php?status=duplicate_student_id");
                exit();
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }

        // ตรวจสอบว่า Username ซ้ำหรือไม่
        $sql_check_username = "SELECT COUNT(*) as count FROM students WHERE s_username = ?";
        if ($stmt_check_username = $conn->prepare($sql_check_username)) {
            $stmt_check_username->bind_param("s", $s_username);
            $stmt_check_username->execute();
            $stmt_check_username->bind_result($count_username);
            $stmt_check_username->fetch();
            $stmt_check_username->close();

            if ($count_username > 0) {
                // ถ้า Username ซ้ำ
                header("Location: ../manage_student.php?status=duplicate_username");
                exit();
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }

        // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูลนักเรียน
        $sql_insert = "INSERT INTO students 
                        (s_id, s_student_id, s_prefix, s_name, s_surname, s_year, s_type_edu, 
                        s_major, s_grade, s_tel, s_email, s_special, s_pic, s_update_information, 
                        s_username, s_password, s_last_login) 
                        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql_insert)) {
            // bind_param (ชนิดข้อมูล: s=string, i=integer)
            $stmt->bind_param(
                "ssssssssssssssss", 
                $s_student_id, $s_prefix, $s_name, $s_surname, $s_year, 
                $s_type_edu, $s_major, $s_grade, $s_tel, $s_email, 
                $s_special, $s_pic, $s_update_information, $s_username, 
                $s_password, $s_last_login
            );

            // ดำเนินการ query
            if ($stmt->execute()) {
                $s_id_ref = (int)$conn->insert_id;

                $sql_information = "INSERT INTO `student_information` (`si_id`,`s_id`) VALUES (NULL, $s_id_ref)";
                if($conn->query($sql_information)){
                    $sql_parent = "INSERT INTO `parent_information` (`p_id`, `p_update_status`,`s_id`) VALUES (NULL, 'N' ,$s_id_ref)";
                    if($conn->query($sql_parent)){
                        $sql_company = "INSERT INTO `company`(`c_id`,`c_update_status` ,`s_id`) VALUES (NULL, 'N',$s_id_ref)";
                        if($conn->query($sql_company)){
                            header("Location:../manage_student.php?status=success");
                        }else{
                            echo "Error step 4: " . $sql . "<br>" . $conn->error;
                        }
                    }else{
                        echo "Error step 3: " . $sql . "<br>" . $conn->error;
                    }

                   

                }else{
                    echo "Error step 2: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }

        $conn->close();
    } else {
        header("Location: ../manage_student.php?status=error");
        exit();
    }
?>
