<?php
    session_start();
    include("../connect/connect.php");

    if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $t_id = $conn->real_escape_string($_POST['t_id']);         
        $t_prefix = $conn->real_escape_string($_POST['t_prefix']); 
        $t_name = $conn->real_escape_string($_POST['t_name']);    
        $t_surname = $conn->real_escape_string($_POST['t_surname']); 
        $t_username = $conn->real_escape_string($_POST['t_username']); 
        $t_password = $conn->real_escape_string($_POST['t_password']); 
        $t_status = $conn->real_escape_string($_POST['t_status']); 

        

        $sql = "UPDATE teachers 
                SET t_prefix = ?, t_name = ?, t_surname = ?, t_username = ?, t_password = ?, t_status = ?
                WHERE t_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssi", $t_prefix, $t_name, $t_surname, $t_username, $t_password, $t_status, $t_id);

            if ($stmt->execute()) {
                
                    header("Location: ../manage_teacher.php?status=success");
                    exit();
                
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }

        $conn->close();
    } else {
        header("Location: ../manage_teacher.php?status=error");
        exit();
    }
?>
