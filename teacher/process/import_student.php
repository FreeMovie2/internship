<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){

    // ตรวจสอบไฟล์ที่อัปโหลด
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExtension === 'csv') {  
            if (($handle = fopen($fileTmpPath, "r")) !== false) {
                $header = array_map(function($col) {
                    return preg_replace('/\xEF\xBB\xBF/', '', trim($col)); // ลบ BOM และ trim ช่องว่าง
                }, fgetcsv($handle));

                
                // จับคู่ชื่อคอลัมน์ในไฟล์ CSV กับคอลัมน์ในฐานข้อมูล
                $dbColumns = ['s_student_id', 's_prefix', 's_name', 's_surname', 's_year', 's_username', 's_password']; // ชื่อคอลัมน์ในฐานข้อมูล
                $columnMap = array_flip($header); // สร้างแผนที่ระหว่าง header กับ index
         

                // ตรวจสอบว่าคอลัมน์ใน CSV มีตรงกับฐานข้อมูลหรือไม่
                foreach ($dbColumns as $column) {
                    if (!isset($columnMap[$column])) {
                        die("Error: Missing column '$column' in the CSV file.");
                    }
                }
                
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    // ตรวจสอบและดึงข้อมูลตามคอลัมน์ในฐานข้อมูล
                    $s_student_id = isset($columnMap['s_student_id']) ? $conn->real_escape_string($data[$columnMap['s_student_id']]) : null;
                    $s_prefix = isset($columnMap['s_prefix']) ? $conn->real_escape_string($data[$columnMap['s_prefix']]) : null;
                    $s_name = isset($columnMap['s_name']) ? $conn->real_escape_string($data[$columnMap['s_name']]) : null;
                    $s_surname = isset($columnMap['s_surname']) ? $conn->real_escape_string($data[$columnMap['s_surname']]) : null;
                    $s_year = isset($columnMap['s_year']) ? $conn->real_escape_string($data[$columnMap['s_year']]) : null;
                    $s_username = isset($columnMap['s_username']) ? $conn->real_escape_string($data[$columnMap['s_username']]) : null;
                    $s_password = isset($columnMap['s_password']) ? $conn->real_escape_string($data[$columnMap['s_password']]) : null;
                    $s_type_edu = '';           // ประเภทการศึกษา (ตัวอย่าง: ว่าง)
                    $s_major = '';              // สาขา
                    $s_grade = '';              // เกรด
                    $s_tel = '';                // เบอร์โทร
                    $s_line_id = '';
                    $s_email = '';              // อีเมล
                    $s_special = '-,-,-';       // ค่าพิเศษ
                    $s_pic = '';                // รูปภาพ
                    $s_update_information = 'N';// อัพเดตข้อมูล (สถานะ N)
                    $s_last_login = '';         // ข้อมูลล็อกอินล่าสุด
                    

                    $sql_student = "INSERT INTO students 
                        (s_id, s_student_id, s_prefix, s_name, s_surname, s_year, s_type_edu, 
                        s_major, s_grade, s_tel, s_line_id, s_email, s_special, s_pic, s_update_information, 
                        s_username, s_password, s_last_login) 
                        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt_student = $conn->prepare($sql_student);

                    $stmt_student->bind_param(
                        "sssssssssssssssss", 
                        $s_student_id, $s_prefix, $s_name, $s_surname, $s_year, 
                        $s_type_edu, $s_major, $s_grade, $s_tel, $s_line_id, $s_email, 
                        $s_special, $s_pic, $s_update_information, $s_username, 
                        $s_password, $s_last_login
                    );
                    if ($stmt_student->execute()) {
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
                       
                    }else{
                        echo "Error step 1: " . $sql . "<br>" . $conn->error;
                    }
                }

                fclose($handle);
                
            } else {
                echo "Error opening the file.";
            }
        } else {
            header("Location:../manage_student.php?status=error_import");
        }
    } else {
        echo "File upload error: " . $_FILES['file']['error'];
    }

    $conn->close();      
        
        
    }else{
        header("Location:../index.php");
    }


?>
