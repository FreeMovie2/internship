<?php
    session_start();
    include("../connect/connect.php");

    if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve and sanitize form inputs
        $s_id = htmlspecialchars($_POST['s_id']);
        
        // Father's Information
        $p_dad = htmlspecialchars($_POST['p_dad']);
        $p_dad_age = htmlspecialchars($_POST['p_dad_age']);
        $p_dad_position = htmlspecialchars($_POST['p_dad_position']);
        $p_dad_tel = htmlspecialchars($_POST['p_dad_tel']);

        // Mother's Information
        $p_mom = htmlspecialchars($_POST['p_mom']);
        $p_mom_age = htmlspecialchars($_POST['p_mom_age']);
        $p_mom_position = htmlspecialchars($_POST['p_mom_position']);
        $p_mom_tel = htmlspecialchars($_POST['p_mom_tel']);

        // Guardian's Information
        $p_parent = htmlspecialchars($_POST['p_parent']);
        $p_parent_age = htmlspecialchars($_POST['p_parent_age']);
        $p_parent_position = htmlspecialchars($_POST['p_parent_position']);
        $p_parent_tel = htmlspecialchars($_POST['p_parent_tel']);

        // Close Friend 1 Information
        $p_friend1 = htmlspecialchars($_POST['p_friend1']);
        $p_friend1_age = htmlspecialchars($_POST['p_friend1_age']);
        $p_friend1_position = htmlspecialchars($_POST['p_friend1_position']);
        $p_friend1_tel = htmlspecialchars($_POST['p_friend1_tel']);

        // Close Friend 2 Information
        $p_friend2 = htmlspecialchars($_POST['p_friend2']);
        $p_friend2_age = htmlspecialchars($_POST['p_friend2_age']);
        $p_friend2_position = htmlspecialchars($_POST['p_friend2_position']);
        $p_friend2_tel = htmlspecialchars($_POST['p_friend2_tel']);

        // Emergency Contact
        $p_close = htmlspecialchars($_POST['p_close']);
        $p_close_age = htmlspecialchars($_POST['p_close_age']);
        $p_close_relation = htmlspecialchars($_POST['p_close_relation']);

        // Address Information
        $p_home = htmlspecialchars($_POST['p_home']);
        $p_moo = htmlspecialchars($_POST['p_moo']);
        $p_soi = htmlspecialchars($_POST['p_soi']);
        $p_road = htmlspecialchars($_POST['p_road']);
        $p_province = htmlspecialchars($_POST['p_province']);
        $p_aumpher = htmlspecialchars($_POST['p_aumpher']);
        $p_tumbon = htmlspecialchars($_POST['p_tumbon']);

        $status = "Y";

        


        $sql = $conn->prepare("UPDATE parent_information SET 
                    p_dad = ?, p_dad_age = ?, p_dad_position = ?, p_dad_tel = ?, 
                    p_mom = ?, p_mom_age = ?, p_mom_position = ?, p_mom_tel = ?, 
                    p_parent = ?, p_parent_age = ?, p_parent_position = ?, p_parent_tel = ?, 
                    p_friend1 = ?, p_friend1_age = ?, p_friend1_position = ?, p_friend1_tel = ?, 
                    p_friend2 = ?, p_friend2_age = ?, p_friend2_position = ?, p_friend2_tel = ?, 
                    p_close = ?, p_close_age = ?, p_close_relation = ?, 
                    p_home = ?, p_moo = ?, p_soi = ?, p_road = ?, p_province = ?, p_aumpher = ?, p_tumbon = ? , p_update_status = ?
        WHERE s_id = ?");

 
            
        $sql->bind_param(
                "ssssssssssssssssssssssssssssssss",
                $p_dad, $p_dad_age, $p_dad_position, $p_dad_tel,
                $p_mom, $p_mom_age, $p_mom_position, $p_mom_tel,
                $p_parent, $p_parent_age, $p_parent_position, $p_parent_tel,
                $p_friend1, $p_friend1_age, $p_friend1_position, $p_friend1_tel,
                $p_friend2, $p_friend2_age, $p_friend2_position, $p_friend2_tel,
                $p_close, $p_close_age, $p_close_relation,
                $p_home, $p_moo, $p_soi, $p_road, $p_province, $p_aumpher, $p_tumbon, $status,
                $s_id
        );

        if($sql->execute()){
            header("Location:../edit_parent.php?student_id=$s_id&status=success");
        }else{
            die("SQL execution failed: " . $sql->error);
            echo($h);
        }

            
    }else{
        header("Location:../index.php");
    }
?>
