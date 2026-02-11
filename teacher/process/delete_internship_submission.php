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
            $sql = $conn->prepare("DELETE FROM internship WHERE i_s_id != 2");
            if($sql->execute()){
                $sql_2 = $conn->prepare("DELETE FROM activity WHERE s_id != 2");
                if($sql_2->execute()){
                    $sql_3 = $conn->prepare("DELETE FROM seminar WHERE s_id != 2");
                    if($sql_3->execute()){
                        $sql_4 = $conn->prepare("DELETE FROM volunteer WHERE s_id != 2");
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
            header("location:../manage_student.php?status=error_password");
        }


       



        
        

      
        
        





    }else{
        header("Location:../index.php");
    }

?>