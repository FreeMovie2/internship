<?php
    session_start();
    include(__DIR__ . "/../connect/connect.php");
    include(__DIR__ . "/../component/function.php");

    $allowedRoles = ['head', 'director', 'admin'];
    $role = $_POST['role'] ?? '';
    if (!in_array($role, $allowedRoles, true)) {
        $role = '';
    }
    $roleQuery = $role !== '' ? '&role=' . urlencode($role) : '';

    if(isset($_POST['submit'])){
        $t_username = mysqli_real_escape_string($conn ,$_POST['t_username']);
        $t_password = mysqli_real_escape_string($conn , $_POST['t_password']);
        
        $sql = $conn->prepare("SELECT * FROM teachers WHERE t_username = ?");
        $sql->bind_param("s", $t_username);
        $sql->execute();
        $result = $sql->get_result();
        $fetch = $result->fetch_assoc();

        if($fetch){
            if ($t_password === $fetch['t_password']) {
                session_regenerate_id(true);
                $_SESSION["t_id"] = $fetch["t_id"];
                $_SESSION["t_prefix"] = $fetch["t_prefix"];
                $_SESSION["t_name"] = $fetch["t_name"];
                $_SESSION["t_surname"] = $fetch["t_surname"];
                $_SESSION["t_status"] = $fetch["t_status"];
                $_SESSION["t_role"] = $role;
 

                header("Location:../index.php");
                exit();
            }else{
                header("Location:../login.php?status=error" . $roleQuery);
                exit();
            }


            
        }else{
            header("Location:../login.php?status=error" . $roleQuery);
            exit();
        }
    }
    


?>

