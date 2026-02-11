<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
      
        $v_date = htmlspecialchars($_POST['v_date'] ?? '');
        $v_detail = htmlspecialchars($_POST['v_detail'] ?? '');
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
       

          

        $sql = $conn->prepare("INSERT INTO volunteer (`v_id`,
            `v_date`, `v_detail`, 
            `s_id`) 
            VALUES (NULL ,? ,? ,? )");

        $sql->bind_param("ssi",
        $v_date, $v_detail,
        $s_id);
        if($sql->execute()){
            header("Location:../volunteer.php?status=success");
        }else{
            header("Location:../volunteer.php?status=error");
        }

        
        
    }else{
        header("Location:../index.php");
    }


?>