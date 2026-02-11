<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
      
        $se_date = htmlspecialchars($_POST['se_date'] ?? '');
        $se_detail = htmlspecialchars($_POST['se_detail'] ?? '');
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
       

          

        $sql = $conn->prepare("INSERT INTO seminar (`se_id`,
            `se_date`, `se_detail`, 
            `s_id`) 
            VALUES (NULL ,? ,? ,? )");

        $sql->bind_param("ssi",
        $se_date, $se_detail,
        $s_id);
        if($sql->execute()){
            header("Location:../seminar.php?status=success");
        }else{
            header("Location:../seminar.php?status=error");
        }
        
    }else{
        header("Location:../index.php");
    }


?>