<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $t_password = htmlspecialchars($_POST['t_password'] ?? '');
        $t_id = htmlspecialchars($_POST['t_id'] ?? '');


        if($t_id != 1){
            $sql = $conn->prepare("DELETE FROM teachers WHERE t_id = ?");
            $sql->bind_param("s", $t_id);
            if($sql->execute()){
                $sql_2 = $conn->prepare("UPDATE company SET
                c_advice = ''
                WHERE c_advice = ?");
                $sql_2->bind_param("s", $t_id);
                if($sql_2->execute()){
                    $sql_3 = $conn->prepare("UPDATE company SET
                    c_advice2 = ''
                    WHERE c_advice2 = ?");
                    $sql_3->bind_param("s", $t_id);
                    if($sql_3->execute()){
                        $sql_4 = $conn->prepare("DELETE FROM teacher_comment WHERE t_id = $t_id");
                        if($sql_4->execute()){
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
                header("location:../manage_teacher.php?status=error");
            }
        }else{
            header("location:../manage_teacher.php?status=error_del");
        }


       



        
        

      
        
        





    }else{
        header("Location:../index.php");
    }

?>