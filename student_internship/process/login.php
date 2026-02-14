<?php
    session_start();
    include("../connect/connect.php");
    include("../component/function.php");
    if(isset($_POST['submit'])){
        $s_username = mysqli_real_escape_string($conn ,$_POST['s_username']);
        $s_password = mysqli_real_escape_string($conn , $_POST['s_password']);
        
        $sql = $conn->prepare("SELECT * FROM students WHERE s_username = ? AND s_password = ?");
        $sql->bind_param("ss", $s_username, $s_password);
        $sql->execute();
        $result = $sql->get_result();
        $fetch = $result->fetch_assoc();

        if($fetch){
            session_regenerate_id(true);
            $_SESSION["s_id"] = $fetch["s_id"];
            $_SESSION["s_prefix"] = $fetch["s_prefix"];
            $_SESSION["s_name"] = $fetch["s_name"];
            $_SESSION["s_surname"] = $fetch["s_surname"];
            $_SESSION["s_student_id"] = $fetch["s_student_id"];
            $_SESSION["s_special"] = $fetch["s_special"];
            $_SESSION["s_major"] = $fetch["s_major"];
            $_SESSION["s_year"] = $fetch["s_year"];
            $_SESSION["s_type_edu"] = $fetch["s_type_edu"];
            $_SESSION["s_update_information"] = $fetch["s_update_information"];
            $_SESSION["s_grade"] = $fetch["s_grade"];
            $_SESSION["s_tel"] = $fetch["s_tel"];
            $_SESSION["s_line_id"] = $fetch["s_line_id"];
            $_SESSION["s_email"] = $fetch["s_email"];
            $_SESSION["s_special"] = $fetch["s_special"];
            $_SESSION["s_pic"] = $fetch["s_pic"];
            // $_SESSION["s_update_information"] = $fetch["s_update_information"];
            $date_time = ThDate();
            $sql2 = $conn->prepare("UPDATE students SET s_last_login = ? WHERE s_id = ?");
            $sql2->bind_param("si", $date_time, $fetch["s_id"]);
            $sql2->execute();
            header("Location:../index.php");
            exit();

            // if($fetch["s_update_information"] == "N"){
            //     header("Location:../update_information.php");
            //     exit();
            // }else{
            //     header("Location:../index.php");
            //     exit();
            // }
            
        }else{
            header("Location:../login.php?status=error");
            exit();
        }
    }
    


?>

