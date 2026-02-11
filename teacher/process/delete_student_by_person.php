<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $s_id = htmlspecialchars($_POST['s_id'] ?? '');
        $sql = $conn->prepare("DELETE FROM students WHERE s_id = ?");
        $sql->bind_param("s", $s_id);
        if($sql->execute()){
                $sql_2 = $conn->prepare("DELETE FROM student_information WHERE s_id = ?");
                $sql_2->bind_param("s", $s_id);
                if($sql_2->execute()){
                    $sql_3 = $conn->prepare("DELETE FROM parent_information WHERE s_id = ?");
                    $sql_3->bind_param("s", $s_id);
                    if($sql_3->execute()){
                        $sql_4 = $conn->prepare("DELETE FROM company WHERE s_id = ?");
                        $sql_4->bind_param("s", $s_id);
                    if($sql_4->execute()){
                        header("location:../manage_student.php?status=success");
                    }else{
                        header("location:../manage_student.php?status=error");
                    }

                }else{
                    header("location:../manage_student.php?status=error");
                }

            }else{
                header("location:../manage_student.php?status=error");
            }
        }else{
            header("location:../manage_student.php?status=error");
        }
        


       



        
        

      
        
        





    }else{
        header("Location:../index.php");
    }

?>