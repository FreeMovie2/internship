<?php
    session_start();
    include("../connect/connect.php");
    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $uploadDir = "../../student_internship/information_file/company/"; 
        $s_id = htmlspecialchars($_POST['s_id']);
        $c_name = htmlspecialchars($_POST['p_dad']);
        $c_home = htmlspecialchars($_POST['c_home']);
        $c_moo = htmlspecialchars($_POST['c_moo']);
        $c_soi = htmlspecialchars($_POST['c_soi']);
        $c_road = htmlspecialchars($_POST['c_road']);
        $c_province = htmlspecialchars($_POST['c_province']);
        $c_aumpher = htmlspecialchars($_POST['c_aumpher']);
        $c_tumbon = htmlspecialchars($_POST['c_tumbon']);
        $c_tel = htmlspecialchars($_POST['c_tel']);
        $c_tel2 = htmlspecialchars($_POST['c_tel2']);
        $c_website = htmlspecialchars($_POST['c_website']);
        $c_similar = htmlspecialchars($_POST['c_similar']);
        $c_head = htmlspecialchars($_POST['c_head']);
        $c_advice = htmlspecialchars($_POST['c_advice']);
        $c_advice2 = htmlspecialchars($_POST['c_advice2']);
        $c_start = htmlspecialchars($_POST['c_start']);
        $c_end = htmlspecialchars($_POST['c_end']);
        $status = "Y";
        


        $sql_check = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
        $sql_check->bind_param("s", $s_id);
        $sql_check->execute();
        $result_check = $sql_check->get_result();
        $fetch_check = $result_check->fetch_assoc();

        if($c_advice != ""){
            $c_advice = htmlspecialchars($_POST['c_advice']);
        }else{
            $c_advice = $fetch_check["c_advice"];
        }

        if($c_advice2 != ""){
            $c_advice2 = htmlspecialchars($_POST['c_advice2']);
        }else{
            $c_advice2 = $fetch_check["c_advice2"];
        }

        if($c_start != ""){
            $c_start = htmlspecialchars($_POST['c_start']);
        }else{
            $c_start = $fetch_check["c_start"];
        }

        if($c_end != ""){
            $c_end = htmlspecialchars($_POST['c_end']);
        }else{
            $c_end = $fetch_check["c_end"];
        }


        $c_map = $_FILES['c_map']['name'];
        $c_org = $_FILES['c_org']['name'];

        
        

        if($c_map != ""){
            $c_map = $_FILES['c_map']['name'];
            if (is_file($uploadDir.$fetch_check["c_map"])){
                unlink($uploadDir.$fetch_check["c_map"]);
            }else{
                $c_map = $_FILES['c_map']['name'];;
            }
        }else{
            $c_map = $fetch_check["c_map"];
        }

        if($c_org != ""){
            $c_org = $_FILES['c_org']['name'];
            if (is_file($uploadDir.$fetch_check["c_org"])){
                unlink($uploadDir.$fetch_check["c_org"]);
            }else{
                $c_map = $_FILES['c_map']['name'];;
            }
        }else{
            $c_org = $fetch_check["c_org"];
        }



        

        $allowed = array('png', 'jpeg', 'jpg', 'heic', "HEIC"); 
        $ext = pathinfo($c_map, PATHINFO_EXTENSION);
        $ext2 = pathinfo($c_org, PATHINFO_EXTENSION);

        
        
        if(!in_array($ext, $allowed) && !in_array($ext2, $allowed)){
            header("location:../edit_company.php?status=error_img");
        }else{
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
            }
            $f1 = 'Image-map-';
            $f2 = 'Image-org-';
            $temp1 = explode('.',$c_org);
            $temp2 = explode('.',$c_org);
            
            $fileName1 = $f1.$s_id.'.'.end($temp1);
            $fileName2 = $f2.$s_id.'.'.end($temp2);
            $uploadFilePath1 = $uploadDir.$fileName1; 
            $uploadFilePath2 = $uploadDir.$fileName2; 
            
            move_uploaded_file($_FILES['c_map']['tmp_name'], $uploadFilePath1);
            move_uploaded_file($_FILES['c_org']['tmp_name'], $uploadFilePath2);       

            $sql = $conn->prepare("UPDATE company SET c_name = ?, c_home = ?, c_moo = ?, c_soi = ?, c_road = ?, c_province = ?, c_aumpher = ?, c_tumbon = ?, c_tel = ?, c_tel2 = ?, c_website = ?, c_similar = ?, c_map = ?, c_org = ?, c_head = ?, c_advice = ?, c_advice2 = ?, c_start = ?, c_end = ?, c_update_status = ? WHERE s_id = ?");
            $sql->bind_param("sssssssssssssssssssss", $c_name, $c_home, $c_moo, $c_soi, $c_road, $c_province, $c_aumpher, $c_tumbon, $c_tel, $c_tel2, $c_website, $c_similar, $fileName1, $fileName2, $c_head, $c_advice, $c_advice2, $c_start, $c_end, $status ,$s_id);
            if($sql->execute()) {
                header("location:../edit_company.php?student_id=$s_id&status=success");
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด: " . $sql->error . "'); window.history.back();</script>";
            }
                
            
        }

       

      
    }else{
        header("Location:../index.php");
    }
?>
