<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $n_id = htmlspecialchars($_POST['n_id'] ?? '');
        $sql = $conn->prepare("DELETE FROM news_teacher
        WHERE n_id = ?");
        $sql->bind_param("s", $n_id);
        if($sql->execute()){
            header("location:../manage_news_teacher.php?status=success");
        }else{
            header("location:../manage_news_teacher.php?status=error");
        }


        
        

      
        
        





    }else{
        header("Location:../index.php");
    }

?>