<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
      
        $se_date = htmlspecialchars($_POST['se_date'] ?? '');
        $se_detail = htmlspecialchars($_POST['se_detail'] ?? '');
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
        $se_id = htmlspecialchars($_POST['se_id'] ?? '');

        $sql_seminar = $conn->prepare("SELECT * FROM seminar WHERE s_id = ? ");
        $sql_seminar->bind_param("i", $s_id);
        $sql_seminar->execute();
        $result_seminar = $sql_seminar->get_result();
        $fetch_seminar = $result_seminar->fetch_assoc();
       
        if($se_date != ""){
            $se_date = htmlspecialchars($_POST['se_date'] ?? '');
        }else{
            $se_date =  $fetch_seminar['se_date'];
        }

          

        $sql = $conn->prepare("UPDATE seminar SET
            `se_date` = ?, 
            `se_detail` = ?, 
            `s_id` = ?
            WHERE se_id = ?");

        $sql->bind_param("ssii",
        $se_date, $se_detail,
        $s_id, $se_id);
        if($sql->execute()){
            header("Location:../seminar.php?status=success");
        }else{
            header("Location:../seminar.php?status=error");
        }

        
        
    }else{
        header("Location:../index.php");
    }


?>