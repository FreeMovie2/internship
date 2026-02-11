<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])&& $_SERVER['REQUEST_METHOD'] == 'POST'){
      
        $tc_id = htmlspecialchars($_POST['tc_id'] ?? '');
        $tc_detail = htmlspecialchars($_POST['tc_detail'] ?? '');
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');

          

        $sql = $conn->prepare("UPDATE teacher_comment SET
        tc_detail = ?
        WHERE tc_id = ?");

        $sql->bind_param("ss", $tc_detail,$tc_id);
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