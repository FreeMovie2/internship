<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
      
        $v_date = htmlspecialchars($_POST['v_date'] ?? '');
        $v_detail = htmlspecialchars($_POST['v_detail'] ?? '');
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
        $v_id = htmlspecialchars($_POST['v_id'] ?? '');

        $sql_volunteer = $conn->prepare("SELECT * FROM volunteer WHERE s_id = ? ");
        $sql_volunteer->bind_param("i", $s_id);
        $sql_volunteer->execute();
        $result_volunteer = $sql_volunteer->get_result();
        $fetch_volunteer = $result_volunteer->fetch_assoc();

        if($v_detail != ""){
            $v_date = htmlspecialchars($_POST['v_date'] ?? '');
        }else{
            $v_date = $fetch_volunteer['v_date'];
        }
       

          

        $sql = $conn->prepare("UPDATE volunteer SET
            `v_date` = ?, 
            `v_detail` = ?, 
            `s_id` = ?
            WHERE v_id = ?");

        $sql->bind_param("ssii",
        $v_date, $v_detail,
        $s_id, $v_id);
        if($sql->execute()){
            header("Location:../volunteer.php?status=success");
        }else{
            header("Location:../volunteer.php?status=error");
        }

        
        
    }else{
        header("Location:../index.php");
    }


?>