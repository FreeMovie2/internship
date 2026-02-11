<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit'])){
        $a_id = htmlspecialchars($_POST['a_id']?? '');
        $s_id = htmlspecialchars($_POST['s_id']?? '');

        $sql = $conn->prepare("DELETE FROM activity WHERE a_id = ? AND s_id = ?");
        $sql->bind_param("ii", $a_id, $s_id);
        if($sql->execute()){
            header("Location:../activity.php?status=success");
        }else{
            header("Location:../activity.php?status=error");
        }
    }else{
        header("Location:../index.php");
    }

?>