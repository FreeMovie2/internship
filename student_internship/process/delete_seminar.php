<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $se_id = htmlspecialchars($_POST['se_id']?? '');
        $s_id = htmlspecialchars($_POST['s_id']?? '');

        $sql = $conn->prepare("DELETE FROM seminar WHERE se_id = ? AND s_id = ?");
        $sql->bind_param("ii", $se_id, $s_id);
        if($sql->execute()){
            header("Location:../seminar.php?status=success");
        }else{
            header("Location:../seminar.php?status=error");
        }
    }else{
        header("Location:../index.php");
    }

?>