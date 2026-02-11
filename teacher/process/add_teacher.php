<?php
    session_start();
    include("../connect/connect.php");

    if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $t_prefix = $conn->real_escape_string($_POST['t_prefix']); 
        $t_name = $conn->real_escape_string($_POST['t_name']);     // ชื่อ
        $t_surname = $conn->real_escape_string($_POST['t_surname']); // นามสกุล
        $t_username = $conn->real_escape_string($_POST['t_username']); // Username
        $t_password = $conn->real_escape_string($_POST['t_password']); // Password
        $t_status = $conn->real_escape_string($_POST['t_status']); // สิทธิ์การใช้งาน


        $sql_check = "SELECT COUNT(*) as count FROM teachers WHERE t_username = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $t_username);
            $stmt_check->execute();
            $stmt_check->bind_result($count);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($count > 0) {
                header("Location: ../manage_teacher.php?status=duplicate_username");
                exit();
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }

        $sql_insert = "INSERT INTO teachers (t_prefix, t_name, t_surname, t_username, t_password, t_status) 
                    VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql_insert)) {
            $stmt->bind_param("ssssss", $t_prefix, $t_name, $t_surname, $t_username, $t_password, $t_status);

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
