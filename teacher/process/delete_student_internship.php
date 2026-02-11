<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
        $s_update = "";
        $sql = $conn->prepare("UPDATE company SET
        `c_advice2` = ?
        WHERE s_id = ?");
        $sql->bind_param("ss", $s_update, $s_id);
        if($sql->execute()){
            header("location:../manage_student_internship.php?status=success");
        }else{
            header("location:../manage_student_internship.php?status=error");
        }


        
        

      
        
    

    }else{
        header("Location:../index.php");
    }

?>