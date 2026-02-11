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
                $dbColumns = ['t_prefix', 't_name', 't_surname', 't_username', 't_password', 't_status']; // ชื่อคอลัมน์ในฐานข้อมูล
                $columnMap = array_flip($header); // สร้างแผนที่ระหว่าง header กับ index
         

                // ตรวจสอบว่าคอลัมน์ใน CSV มีตรงกับฐานข้อมูลหรือไม่
                foreach ($dbColumns as $column) {
                    if (!isset($columnMap[$column])) {
                        die("Error: Missing column '$column' in the CSV file.");
                    }
                }
                
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    // ตรวจสอบและดึงข้อมูลตามคอลัมน์ในฐานข้อมูล
                    $t_prefix = isset($columnMap['t_prefix']) ? $conn->real_escape_string($data[$columnMap['t_prefix']]) : null;
                    $t_name = isset($columnMap['t_name']) ? $conn->real_escape_string($data[$columnMap['t_name']]) : null;
                    $t_surname = isset($columnMap['t_surname']) ? $conn->real_escape_string($data[$columnMap['t_surname']]) : null;
                    $t_username = isset($columnMap['t_username']) ? $conn->real_escape_string($data[$columnMap['t_username']]) : null;
                    $t_password = isset($columnMap['t_password']) ? $conn->real_escape_string($data[$columnMap['t_password']]) : null;
                    $t_status = isset($columnMap['t_status']) ? $conn->real_escape_string($data[$columnMap['t_status']]) : null;

                    

                    $sql_teacher = "INSERT INTO teachers 
                        (t_id, t_prefix, t_name, t_surname, t_username, t_password, t_status) 
                        VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                    $stmt_teacher = $conn->prepare($sql_teacher);

                    $stmt_teacher->bind_param(
                        "ssssss", 
                        $t_prefix, $t_name, $t_surname, $t_username, 
                        $t_password, $t_status
                    );
                    if ($stmt_teacher->execute()) {
                        header("Location:../manage_teacher.php?status=success");
                       
                    }else{
                        echo "Error step 1: " . $sql . "<br>" . $conn->error;
                    }
                }

                fclose($handle);
                
            } else {
                echo "Error opening the file.";
            }
        } else {
            header("Location:../manage_teacher.php?status=error_import");
        }
    } else {
        echo "File upload error: " . $_FILES['file']['error'];
    }

    $conn->close();      
        
        
    }else{
        header("Location:../index.php");
    }


?>