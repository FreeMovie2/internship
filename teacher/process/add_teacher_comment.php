<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
      
        $tc_week = htmlspecialchars($_POST['tc_week'] ?? '');
        $tc_detail = htmlspecialchars($_POST['tc_detail'] ?? '');
        $t_id = htmlspecialchars($_POST['t_id'] ?? '');
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
       

          

        $sql = $conn->prepare("INSERT INTO teacher_comment (`tc_id`,
            `tc_week`, `tc_detail`, 
            `t_id`,`s_id`) 
            VALUES (NULL ,? ,? ,? ,?)");

        $sql->bind_param("ssss",
        $tc_week, $tc_detail,
        $t_id,$s_id);
        if($sql->execute()){
            header("Location:../view_student_internship.php?student_id=$s_id&status=success");
        }else{
            die("SQL execution failed: " . $sql->error);
            echo($h);
        }
        
    }else{
        header("Location:../index.php");
    }


?>