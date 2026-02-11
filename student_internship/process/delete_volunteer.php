<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $v_id = htmlspecialchars($_POST['v_id']?? '');
        $s_id = htmlspecialchars($_POST['s_id']?? '');

        $sql = $conn->prepare("DELETE FROM volunteer WHERE v_id = ? AND s_id = ?");
        $sql->bind_param("ii", $v_id, $s_id);
        if($sql->execute()){
            header("Location:../volunteer.php?status=success");
        }else{
            header("Location:../volunteer.php?status=error");
        }
    }else{
        header("Location:../index.php");
    }

?>