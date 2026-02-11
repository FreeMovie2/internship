<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $t_password = htmlspecialchars($_POST['t_password'] ?? '');
        $t_id = htmlspecialchars($_POST['t_id'] ?? '');

        $sql_teacher = $conn->prepare("SELECT * FROM teachers where t_id = ?");
        $sql_teacher->bind_param("i",$t_id);
        $sql_teacher->execute();
        $result_teacher = $sql_teacher->get_result();
        $fetch_teacher = $result_teacher->fetch_assoc();

        if($fetch_teacher['t_password'] == $t_password){
            $sql = $conn->prepare("DELETE FROM teachers WHERE t_id != 1");
            if($sql->execute()){
                $sql_2 = $conn->prepare("UPDATE company SET
                c_advice = '',
                c_advice2 = ''");
                
                if($sql_2->execute()){
                    $sql_3 = $conn->prepare("DELETE FROM teacher_comment WHERE t_id != 1");
                    if($sql_3->execute()){
                        header("location:../manage_teacher.php?status=success");
                    }else{
                        header("location:../manage_teacher.php?status=error");
                    }
                    
                }else{
                    header("location:../manage_teacher.php?status=error");
                }
            }else{
                header("location:../manage_teacher.php?status=error");
            }
        }else{
            header("location:../manage_teacher.php?status=error_password");
        }


       



        
        

      
        
        





    }else{
        header("Location:../index.php");
    }

?>